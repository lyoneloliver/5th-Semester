<?php

namespace App\Libraries;

use App\Models\UserModel;
use App\Models\TokenIngatModel;
use App\Models\LogMasukModel;

class Autentikasi
{
    private UserModel $users;
    private TokenIngatModel $tokens;
    private LogMasukModel $logs;

    private string $cookieName;
    private int $rememberDays;
    private int $maxAttempts;
    private int $decaySeconds;
    public function __construct()
    {
        $config = config('Akun');

        $this->cookieName = $config->cookieName;
        $this->rememberDays = $config->rememberDays;
        $this->maxAttempts = $config->maxAttempts;
        $this->decaySeconds = $config->decaySeconds;

        $this->users = new UserModel();
        $this->tokens = new TokenIngatModel();
        $this->logs = new LogMasukModel();
    }

    private function now(): string
    {
        return gmdate('Y-m-d H:i:s');
    }

    private function ipAddress(): string
    {
        return service('request')->getIPAddress();
    }

    private function userAgent(): string
    {
        return substr(
            service('request')->getUserAgent()->getAgentString(),
            0,
            255
        );
    }

    private function setRememberCookie(string $value, int $expires): void
    {
        setcookie($this->cookieName, $value, [
            'expires' => $expires,
            'path' => '/',
            'secure' => service('request')->isSecure(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    private function deleteRememberCookie(): void
    {
        $this->setRememberCookie('', time() - 3600);
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function user(): ?array
    {
        if (!session()->get('logged_in')) {
            return null;
        }

        $user = $this->users->find(session()->get('user_id'));

        if (
            !$user ||
            !$user['is_active'] ||
            (int) $user['session_version'] !== (int) session()->get('session_version')
        ) {
            session()->destroy();
            return null;
        }

        return $user;
    }

    public function login(string $email, string $password, bool $remember = false): array
    {
        $email = strtolower(trim($email));
        $ip = $this->ipAddress();

        if ($this->isThrottled($email, $ip)) {
            $this->logAttempt($email, 'throttled', 'too_many_attempts');

            return [
                'success' => false,
                'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam satu menit.',
            ];
        }

        $user = $this->users->where('email', $email)->first();

        static $dummyHash = null;

        if ($dummyHash === null) {
            $dummyHash = password_hash(bin2hex(random_bytes(32)), PASSWORD_BCRYPT);
        }

        $hash = $user ? $user['password_hash'] : $dummyHash;
        $validPassword = password_verify($password, $hash);

        if (!$user || !$validPassword || !$user['is_active']) {
            $this->logAttempt(
                $email,
                'failed',
                !$user ? 'user_not_found' : (!$user['is_active'] ? 'account_inactive' : 'invalid_password'),
                $user['id'] ?? null
            );

            return [
                'success' => false,
                'message' => 'Email atau password tidak valid.',
            ];
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_BCRYPT)) {
            $newHash = password_hash($password, PASSWORD_BCRYPT);

            $this->users->db->table('users')
                ->where('id', $user['id'])
                ->update(['password_hash' => $newHash]);
        }

        session()->regenerate(true);

        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_role' => $user['role'],
            'session_version' => $user['session_version'],
            'logged_in' => true,
        ]);

        $this->users->update($user['id'], [
            'last_login_at' => $this->now(),
        ]);

        if ($remember) {
            $this->createRememberToken($user['id']);
        }

        $this->logAttempt($email, 'success', null, $user['id']);

        return [
            'success' => true,
            'message' => 'Login berhasil.',
        ];
    }

    public function logout(): void
    {
        $cookie = service('request')->getCookie($this->cookieName);

        if ($cookie) {
            $parts = explode(':', $cookie, 2);

            if (count($parts) === 2) {
                $this->tokens->where('selector', $parts[0])->delete();
            }
        }

        $this->deleteRememberCookie();
        session()->destroy();
    }

    public function createRememberToken(int $userId): void
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));
        $expires = time() + ($this->rememberDays * 86400);

        $this->tokens->insert([
            'user_id' => $userId,
            'selector' => $selector,
            'validator_hash' => hash('sha256', $validator),
            'device_name' => substr($this->userAgent(), 0, 100),
            'user_agent' => $this->userAgent(),
            'ip_address' => $this->ipAddress(),
            'expires_at' => gmdate('Y-m-d H:i:s', $expires),
            'created_at' => $this->now(),
        ]);

        $this->setRememberCookie($selector . ':' . $validator, $expires);
    }

    public function attemptRemember(): bool
    {
        $cookie = service('request')->getCookie($this->cookieName);

        if (!$cookie) {
            return false;
        }

        $parts = explode(':', $cookie, 2);

        if (
            count($parts) !== 2 ||
            !preg_match('/^[a-f0-9]{32}$/', $parts[0]) ||
            !preg_match('/^[a-f0-9]{64}$/', $parts[1])
        ) {
            $this->deleteRememberCookie();
            return false;
        }

        [$selector, $validator] = $parts;

        $token = $this->tokens->where('selector', $selector)->first();

        if (!$token) {
            $this->deleteRememberCookie();
            return false;
        }

        if (
            strtotime($token['expires_at']) <= time() ||
            !hash_equals($token['validator_hash'], hash('sha256', $validator))
        ) {
            $this->tokens->delete($token['id']);
            $this->deleteRememberCookie();
            return false;
        }

        $user = $this->users->find($token['user_id']);

        if (!$user || !$user['is_active']) {
            $this->tokens->delete($token['id']);
            $this->deleteRememberCookie();
            return false;
        }

        $this->tokens->delete($token['id']);

        session()->regenerate(true);

        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_role' => $user['role'],
            'session_version' => $user['session_version'],
            'logged_in' => true,
        ]);

        $this->createRememberToken($user['id']);

        return true;
    }

    public function revokeRememberToken(int $tokenId, int $userId): void
    {
        $this->tokens
            ->where('id', $tokenId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function revokeAllTokens(int $userId): void
    {
        $this->tokens->where('user_id', $userId)->delete();
    }

    public function isThrottled(string $email, string $ip): bool
    {
        $since = gmdate('Y-m-d H:i:s', time() - $this->decaySeconds);

        $attempts = $this->logs
            ->where('email', $email)
            ->where('ip_address', $ip)
            ->where('created_at >=', $since)
            ->countAllResults();

        return $attempts >= $this->maxAttempts;
    }

    public function logAttempt(
        string $email,
        string $status,
        ?string $reason = null,
        ?int $userId = null
    ): void {
        $this->logs->insert([
            'user_id' => $userId,
            'email' => $email,
            'ip_address' => $this->ipAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'status' => $status,
            'reason' => $reason,
            'created_at' => $this->now(),
        ]);
    }
}

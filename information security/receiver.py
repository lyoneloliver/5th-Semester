import socket
import threading
from des import encrypt, decrypt

KEY = b"KEY1234"
PORT = 5000

def terima(conn):
    buffer = ""
    while True:
        data = conn.recv(1024)
        if not data:
            break

        buffer += data.decode()

        while "\n" in buffer:
            pesan, buffer = buffer.split("\n", 1)
            ciphertext = bytes.fromhex(pesan)
            plaintext = decrypt(ciphertext, KEY)
            print("HP:", plaintext.decode())

server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server.bind(("0.0.0.0", PORT))
server.listen(1)

print("menunggu")
conn, addr = server.accept()
print("terhubung")

threading.Thread(target=terima, args=(conn,), daemon=True).start()

while True:
    pesan = input("Laptop: ")
    ciphertext = encrypt(pesan.encode(), KEY)

    print("Ciphertext:", ciphertext.hex())

    conn.sendall((ciphertext.hex() + "\n").encode())
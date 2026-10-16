import socket
import threading
from des import encrypt, decrypt

KEY = b"KEY1234"
HOST = "192.168.18.14"
PORT = 5000

def terima():
    buffer = ""
    while True:
        data = client.recv(1024)
        if not data:
            break

        buffer += data.decode()

        while "\n" in buffer:
            pesan, buffer = buffer.split("\n", 1)
            ciphertext = bytes.fromhex(pesan)
            plaintext = decrypt(ciphertext, KEY)
            print("Laptop:", plaintext.decode())

client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client.connect((HOST, PORT))

print("terhubung")

threading.Thread(target=terima, daemon=True).start()

while True:
    pesan = input("HP: ")
    ciphertext = encrypt(pesan.encode(), KEY)

    print("Ciphertext:", ciphertext.hex())

    client.sendall((ciphertext.hex() + "\n").encode())
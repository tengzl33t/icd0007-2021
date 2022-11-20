import socket

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, True)
s.bind(('localhost', 8080))
s.listen()

data = b'''
HTTP/1.1 200
Content-Type: text/plain

Browser sent the following:

'''

while True:
    connection, address = s.accept()

    buf = connection.recv(2048)  # loe sisend

    connection.send(data + buf)

    connection.close()

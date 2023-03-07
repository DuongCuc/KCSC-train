data = b"xakgK\x5cNs((j:l9<mimk?:k;9;8=8?=0?>jnn:j=lu\x00\x00"
for xor in range(17):    
    flag = ""
    for i in range(0,len(data)):
        flag += chr(data[i] ^ xor)
    print(xor, flag, '\n')
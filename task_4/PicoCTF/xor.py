data = b"xakgK\5cNs>j:<?m8>m;>k110<j?=88lj0l11:n;nmu\00\00"
for j in range(1,17):    
    flag = ""
    for i in range(len(data)):
        flag += chr(data[i] ^ j)
    print(j, flag)

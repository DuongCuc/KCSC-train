# HTTP - IP restriction bypass
### Challenge 
Link: http://challenge01.root-me.org/web-serveur/ch68/
### Hint
Dear colleagues,

We’re now managing connections to the intranet using private IP addresses, so it’s no longer necessary to login with a username / password when you are already connected to the internal company network.

Regards,

The network admin
### Solution
Ở trang chủ ta thấy có 2 đoạn sau:
> Your IP ::ffff:113.185.47.202 do not belong to the LAN.

> You should authenticate because you're not on the LAN.

Vậy để đăng nhập vào mạng này, ta cần request với một địa chỉ IP local.
Sau khi search, em tìm thấy một header cho phép thực hiện việc fake IP đó là X-Forwarded-For.
Em thêm header này với các địa chỉ IP local. Khi thử với 192.168.0.1 thì em thu được flag.

![](https://i.imgur.com/baBJCuz.png)

### Flag
Ip_$po0Fing
___
# HTTP - User-agent
### Challenge 
Link: http://challenge01.root-me.org/web-serveur/ch2/
### Hint
Admin is really dumb...
### Solution
Vào challenge, ta thấy đoạn sau:
> Wrong user-agent: you are not the "admin" browser!

Ngoài ra ta thấy request như sau:

![](https://i.imgur.com/0XeQzUR.png)

Với những dữ liệu trên, em sửa header User-Agent thành *admin* thì thu được flag:

![](https://i.imgur.com/ZtUyqEp.png)

### Flag
rr$Li9%L34qd1AAe27
___
# HTTP - Headers
### Challenge
Link: http://challenge01.root-me.org/web-serveur/ch5/
### Hint
> HTTP response give informations

> Get an administrator access to the webpage.

### Solution
Vào challenge, ta thấy đoạn sau:
> Content is not the only part of an HTTP response!

Tại response, em chú ý đến dòng sau `Header-RootMe-Admin: none`, cộng với hint nên em thêm header Header-RootMe-Admin vào request và thu được flag:

![](https://i.imgur.com/O5KkOkL.png)

Về sau thì em phát hiện là mình thêm giá trị nào vào header kia cũng đều thu được flag :>>

![](https://i.imgur.com/psEDgiG.png)

![](https://i.imgur.com/BY9HOzr.png)

### Flag
HeadersMayBeUseful
___
# HTTP - POST
### Challenge
http://challenge01.root-me.org/web-serveur/ch56/
### Hint
> Do you know HTTP?

> Find a way to beat the top score!

### Solution
Vào challenge ta thấy:

![](https://i.imgur.com/TS1CwO6.png)

Với mỗi lần chọn nút `Give a try!` ta được một điểm số random. Và để tìm ra flag, ta phải đạt được điểm số lớn hơn 999999.
Ta thấy request và response như sau:

![](https://i.imgur.com/FMSbWg4.png)

Để thắng game, em sửa giá trị của `score` thành một số lớn hơn 999999, ở đây em chọn 1000000 và thu được flag:

![](https://i.imgur.com/pAhe3bF.png)

### Flag
H7tp_h4s_N0_s3Cr37S_F0r_y0U









# Insp3ct0r
### Challenge
Link: https://jupiter.challenges.picoctf.org/problem/44924/
### Hint
> How do you inspect web code on a browser?

> There's 3 parts
### Solution
View source code, em thấy 

![](https://i.imgur.com/dWbykQR.png)

![](https://i.imgur.com/Vx2FScT.png)

![](https://i.imgur.com/OJcpcEY.png)

Chú ý 3 dòng comment, ta có 3 phần của flag.

### Flag
picoCTF{tru3_d3t3ct1ve_0r_ju5t_lucky?f10be399}

# Scarvenger Hunt
### Challenge
Link: http://mercury.picoctf.net:27393/
### Hint
> You should have enough hints to find the files, don't run a brute forcer.
### Solution
View source code, em tìm được 2 phần của flag:

![](https://i.imgur.com/IIVSU4I.png)

![](https://i.imgur.com/GV3NEh8.png)

Ở file `myjs.js`, ta thấy dòng comment `/* How can I keep Google from indexing my website? */`

![](https://i.imgur.com/s46OabE.png)

Search với nội dung tương tự dòng comment, em tìm được cách ngăn google lập chỉ mục website với file `robots.txt`. Chuyển hướng trang đến file này, em được phần 3 của flag.

![](https://i.imgur.com/LCczPyg.png)

Tương tự như vậy, với gợi ý tiếp theo, em tìm được `file.htaccess `. Chuyển hướng đến file này sẽ thu được phần 4 của flag.

![](https://i.imgur.com/dAbNcb0.png)

>File .htaccess là một file website mạnh mẽ, kiểm soát cấu hình cấp cao của trang web của bạn. Trên các server chạy Apache (một phần mềm web server), file .htaccess cho phép bạn thực hiện các thay đổi cấu hình trang web của mình mà không cần phải chỉnh sửa file cấu hình server.

Theo gợi ý, em tiếp tục search và tìm được file dùng để lưu trữ thông tin chỉ có trên Mac là file `.DS_Store`. Chuyển hướng trang em thu được phần cuối cùng của flag.

![](https://i.imgur.com/mGJiRWQ.png)

> .DS_Store (Desktop Services Store) là một tệp vô hình được tạo tự động trên hệ điều hành macOS. Tệp này lưu trữ các thuộc tính/siêu dữ liệu tùy chỉnh của thư mục chứa nó và tên của các tệp khác xung quanh nó. Việc tiết lộ thông tin này có khả năng cho phép tin tặc thực hiện các hành vi xấu như xem các tệp riêng tư.
### Flag
picoCTF{th4ts_4_l0t_0f_pl4c3s_2_lO0k_d375c750}
____
# Who are you?
### Challenge
Link: http://mercury.picoctf.net:52362/
### Hint
> It ain't much, but it's an RFC https://tools.ietf.org/html/rfc2616
### Solution
Vào challenge ta thấy màn hình thông báo như sau:

![](https://i.imgur.com/cWs2fKx.png)

Như vậy ta cần truy cập vào trang web bằng PicoBrowser. Em thay đổi header `User-Agent` ở request thì thấy có sự thay đổi như sau:

![](https://i.imgur.com/ZPNKUwY.png)

Ở đây, ta cần cho website thấy request không đến từ các trang bên ngoài bằng cách thêm header `Referer` với đường dẫn chính là url của trang này. Sau đó thu được màn hình response như sau:

![](https://i.imgur.com/j06BeIE.png)

Đến đây, em tiếp tục thêm header `Date` với value là 2018.

![](https://i.imgur.com/YgMrY8K.png)

Để website thấy ta không bị theo dõi, em thêm header `DNT` với value 1.
>  DNT header (Do Not Track) cho biết tùy chọn theo dõi của người dùng. Nó cho phép người dùng cho biết họ có muốn để quyền riêng tư hay không.
> - DNT: 0 ⇒ người dùng cho phép theo dõi 
> - DNT: 1 ⇒ người dùng không muốn bị theo dõi
> - DNT: null ⇒ không xác định

![](https://i.imgur.com/LgJxOoP.png)

Để website biết request đến từ một máy ở Sweden, em thêm header `X-Forwarded-For` với một địa chỉ IP của Sweden mà em search được.

![](https://i.imgur.com/dvRvwva.png)

Em thêm header `Accept-Language` với language tag là `sv` cho Swedish, cuối cùng thu được flag.

![](https://i.imgur.com/7kQ5Ii7.png)

### Flag
picoCTF{http_h34d3rs_v3ry_c0Ol_much_w0w_0c0db339}
___
# Logon
### Challenge
> The factory is hiding things from all of its users. Can you login as Joe and find what they've been looking at? https://jupiter.challenges.picoctf.org/problem/15796/ (link) or http://jupiter.challenges.picoctf.org:15796

### Hint
Hmm it doesn't seem to check anyone's password, except for Joe's?
### Solution
Đâu tiên khi vào challenge, ta thấy trang đăng nhập:

![](https://i.imgur.com/n05RO2e.png)

Theo như hint, em đăng nhập với username bất kỳ thấy: ta sẽ luôn nhận được thông báo đăng nhập thành công với Username bất kỳ, trừ Username là Joe.

![](https://i.imgur.com/2D6bGj7.png)

![](https://i.imgur.com/1rrsZfM.png)

Tuy nhiên em vẫn không thấy flag.
Ở Burpsuite, em để ý thấy có một request với URL là `/problem/15796/flag`. Trong header `Cookie` của request này có thuộc tính `admin: False`. 

![](https://i.imgur.com/CWSJHBG.png)

Đây chính là lý do ngăn chúng ta nhận flag. Em đổi thành `admin: True` thì nhận được flag như sau:

![](https://i.imgur.com/3BIexYv.png)

### Flag
picoCTF{th3_c0nsp1r4cy_l1v3s_6edb3f5f}
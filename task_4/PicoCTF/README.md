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
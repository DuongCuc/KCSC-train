# HTTP - Open redirect
### Challenge
Link: http://challenge01.root-me.org/web-serveur/ch52/
### Hint
> Internet is so big

> Find a way to make a redirection to a domain other than those showed on the web page.
### Solution
Vào challenge ta thấy:

![](https://i.imgur.com/pGlgC4x.png)

Nhiệm vụ ở đây là chuyển hướng trang tới một trang khác 3 trang được show trên màn hình.
Vào Burpsuite, chọn nút `Facebook`, ta sẽ được chuyển đến trang `https://facebook.com`, tuy nhiên request lại có đoạn chuyển hướng như sau:
```
GET /web-serveur/ch52/?url=https://facebook.com&h=a023cfbf5f1c39bdf8407f28b60cd134 HTTP/1.1
```
Ở đây, `url` chính là url của trang, còn h có thể là hash của trang web đó.
Sau khi kiểm tra, em thấy h chính là chuỗi url của trang được hash ở dạng MD5:

![](https://i.imgur.com/Q3viwvP.png)

Vậy để chuyển hướng tới một trang khác thì ta cần một request tương tự với 2 param là `url` và `h` là chuỗi url đó được md5. Thử với `https://www.root-me.org` em được kết quả như sau:

![](https://i.imgur.com/OI8wYt2.png)

![](https://i.imgur.com/GzQHQmr.png)

### Flag
e6f8a530811d5a479812d7b82fc1a5c5
___
# HTTP - Improper redirect
### Challenge
Link: http://challenge01.root-me.org/web-serveur/ch32/login.php?redirect
### Hint
> Don’t trust your browser

> Get access to index
### Solution
Vào challenge ta thấy:

![](https://i.imgur.com/rmGpQVh.png)

Theo đề bài gợi ý, em chuyển hướng trang tới file `index.php` bằng cách thay đổi url, nhưng kết quả trang được chuyển đến vẫn là trang login ban đầu.
Vậy phải burpsuite chuyển hướng ở request thì mới thu được kết quả:

![](https://i.imgur.com/p97tEmy.png)

Đến đây ta đã thu được flag và biết tại sao không thể chuyển hướng bằng cách thay đổi url trên thanh tìm kiếm. Lý do được đưa ra là sau `header('Location: ...')` không có lệnh `exit()` nên đoạn code phía sau vẫn được thực thi, chuyển người dùng đến trang login ban đầu.
### Flag
ExecutionAfterRedirectIsBad
___
# HTML - disabled buttons
### Challenge
Link: http://challenge01.root-me.org/web-client/ch25/
### Hint
> HTML protection?

> This form is disabled and can not be used. It’s up to you to find a way to use it.
### Solution
Vào challenge, ta thấy các ô input và submit đã bị vô hiệu hoá, nhiệm vụ ở đây là tìm cách giúp người dùng có thể nhập nội dung vào ô input và submit chúng.

![](https://i.imgur.com/I0bQwIg.png)

View source code, em thấy ở input có thuộc tính `disabled type`. Đây chính là lý do khiến 2 ô input bị vô hiệu hoá.

![](https://i.imgur.com/UWfyhfO.png)

Em vào Element để sửa thuộc tính thì 2 ô input đã có thể hoạt động.

![](https://i.imgur.com/ySLz8o2.png)

Nhập nội dung bất kỳ ô trống thì thu được flag như sau:

![](https://i.imgur.com/gq8MMGi.png)


### Flag
HTMLCantStopYou
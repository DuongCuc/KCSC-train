# GET aHEAD
### Challenge Description
Find the flag being held on this server to get ahead of the competition http://mercury.picoctf.net:15931/
### Hint
1. Maybe you have more than 2 choices
2. Check out tools like Burpsuite to modify your requests and look at the responses
### Solution
Em chọn Choose Red, nhận thấy method ở đây là GET; chọn Choose Blue thấy method là POST.
Mà hint đưa ra là có nhiều hơn 2 sự lựa chọn. Mặt khác, đề bài là GET aHEAD nên em thử thay đổi method của request Choose Red từ GET thành HEAD. 
Sau đó, send request thì em nhận được flag :>>
![](https://i.imgur.com/AjcR0a7.png)
### Flag
picoCTF{r3j3ct_th3_du4l1ty_82880908}
___
# Cookies
### Challenge Description
Who doesn't love cookies? Try to figure out the best one. http://mercury.picoctf.net:21485/
### Solution
Ở trang chủ, em nhập một giá trị bất kỳ rồi chọn Search thì được kết quả như sau:

![](https://i.imgur.com/p4pbO5J.png)

![](https://i.imgur.com/esZBYON.png)

Trong header Cookie ở Request, em thấy value của nó là -1 (một giá trị false) nên thử thay đổi value này thành 1 (một giá trị true) rồi send request thì được kết quả như sau:

![](https://i.imgur.com/SAwYXRZ.png)

Ta chú ý ở Response có dòng code:
```
You should be redirected automatically to target URL: <a href="/check"> 
```
Vì vậy, em sửa đường dẫn ở request thành `GET /check HTTP/1.1` thì thu được như sau: 

![](https://i.imgur.com/jb9AXJs.png)

Thử tăng giá trị cookie lên 2:

![](https://i.imgur.com/PNMKhM8.png)

Tiếp tục tăng giá trị của cookie bằng cách Send to Intruder

![](https://i.imgur.com/moyGsPs.png)

Vì trang chủ đã có 1 chuỗi "picoCTF", flag sẽ có định dạng "picoCTF{}" nên ở Grep-Match, em add "PICOCTF" để kiểm tra số lần xuất hiện của chuỗi này. Số lần xuất hiện lớn hơn 1 thì rất có thể đó là một phần của flag.

![](https://i.imgur.com/ESAiTlS.png)

Start attack em thu được kết quả như sau:

![](https://i.imgur.com/qNMR6Mq.png)

Ta thấy, với value là 18 thì sẽ có 2 chuỗi "PICOCTF" xuất hiện. Vì vậy, em sửa value thành 18 thì thu được flag như sau:
![](https://i.imgur.com/kYtDrlh.png)
### Flag
picoCTF{3v3ry1_l0v3s_c00k135_94190c8a}







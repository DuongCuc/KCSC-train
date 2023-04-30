# Lý thuyết
### 1. File upload vulnerability là gì?
Lỗ hổng file upload là lỗ hổng được khai thác dựa trên chức năng upload file của trang web. Lỗ hổng này cho phép kẻ tấn công tải lên những tệp độc hại, thực thi mã nhằm mục đích xấu.
### 2. Nguyên nhân
File upload vulnerability thường xảy ra khi server cho phép người dùng upload files mà không có xác thực đầy đủ (name, type, contents, size). Từ đó, kẻ tấn công có thể tải lên các tệp chứa mã độc để thực thi nhằm mục đích xấu.
### 3. Hậu quả
Nhìn chung, hậu quả của file upload vulnerabilities sẽ tùy thuộc vào 2 yếu tố chính: 
* Hệ thống thất bại trong việc xác thực yếu tố nào (name/content/size/type...)?
* Hệ thống có giải pháp gì trong trường hợp kẻ tấn công tải thành công các tệp độc hại? 

Các trường hợp phổ biến như:
* Không xác thực `file's type`: Đây là trường hợp xấu nhất của file upload vulnerabilities. Hệ thống cho phép tải lên tệp với định dạng bất kỳ. Trong trường hợp này, kẻ tấn công có thể tải lên các tệp độc hại (`.php`, `.jsp`) hoạt động như webshell, từ đó toàn quyền kiểm soát server. 
* Không xác thực `file's name`: Kẻ tấn công có thể ghi đè lên các tệp quan trọng của hệ thống bằng cách tải lên các tệp cùng tên.
* Không xác thực `file's size`: Kẻ tấn công có thể chiếm dụng hết disk space, từ đó tấn công DoS.

### 4. Các dạng bypass
#### 4.1. Client side
Client Side Filters là một kiểu xác thực các yêu cầu khi được gửi lên máy chủ. Nó ngăn chặn việc người dùng upload những file độc hại lên phía server. 
Tuy nhiên, người ta có thể bypass client side filter bằng cách tắt JavaScript của trình duyệt hay giả mạo request trước khi nó được gửi tới server.
#### 4.2. Extension
Đây là kiểu xác thực bằng cách kiểm tra phần extension trong tên tệp. Qúa trình xác thực này diễn ra dựa trên hai phương pháp là `Blacklisting File Extensions` và `Whitelisting File Extensions`. Trên cơ sở đó, ta có hai cách bypass là `Blacklisting Bypass` và `Whitelisting Bypass`.
* **Blacklisting Bypass:** Black list là một danh sách các extension bị các nhà phát triển chặn nhằm chống việc tải các tệp độc hại lên trang web. Tuy nhiên nó sẽ không thể lọc được hết các extension. 
    * Hacker có thể đổi thành các extension không phổ biến như `.php1`, `.php2`, `.php3`,...
    * Nếu tất cả các đuôi bạn thử đều đã nằm trong danh sách đen thì có thể check xem bộ lọc có phân biệt chữ hoa chữ thường không. VD: `.Php1`, `.PHP2`,...
    * Chồng extension. VD: `.jpg.php`
* **Whitelisting Bypass:** Trái ngược với black list, có một số trang web lại yêu cầu bạn bắt buộc phải sử dụng những extension được liệt kê trong white list. Để vượt qua white list, ta có thể sử dụng một số cách sau:
    * Null Byte Injection: Đây là một kỹ thuật khai thác trong đó sử dụng các ký tự null byte URL-encoded (ví dụ: %00, hoặc 0x00 trong hex). Phần sau các ký tự này sẽ được hiểu là giá trị null. Ví dụ như tệp `shell.php%00.jpg`, sau khi được upload thành công với `.jpg` thì sẽ được hiểu và thực thi với tên tệp chỉ là `shell.php`. 
    * Sử dụng Double Extension: `shell.php.jpg`,`shell.php;.jpg`,`shell.php:jpg`, ...
    * Invalid Extension Bypass: Nếu server gặp lỗi này thì khi chúng ta sử dụng extension `.test`, hệ điều hành sẽ không nhận ra . Cho nên hacker có thể tải lên tệp `shell.php.test`, khi đó `shell.php` sẽ được thực thi.
#### 4.3. Content type
Đây là kiểu xác thực mà trang web sẽ kiểm tra content-type của tệp tải lên có đúng với yêu cầu hay không. Trong trường hợp này, hacker có thể bypass bằng cách sửa content-type phù hợp trước khi request được gửi lên server.

### 5. Cách phòng chống File Upload Vulnerabilities
* Xác thực và kiểm soát các tệp được tải lên
* Kiểm tra định dạng tệp tin và ngăn chặn các tệp tin có định dạng gây nguy hiểm như mã độc
* Sử dụng các kỹ thuật mã hoá để bảo vệ dữ liệu trước khi tải lên
* Giới hạn dung lượng tệp tin được tải lên.

___
# Thực hành

### 1. File upload - Double extensions
#### Challenge
Link: http://challenge01.root-me.org/web-serveur/ch20/?galerie=upload
#### Statement
> Your goal is to hack this photo galery by uploading PHP code.
Retrieve the validation password in the file .passwd at the root of the application.

#### Solution
Đầu tiên, em vào trang `upload`, thử upload 1 file đúng định dạng và 1 file không đúng định dạng yêu cầu.

![](https://i.imgur.com/0FJzfDY.png)

![](https://i.imgur.com/AFlPkTZ.png)

Mục đích của ta là đọc được file `.passwd`. Để đạt được điều này, em sẽ thực hiện upload một webshell như sau:

![](https://i.imgur.com/2eTWZwQ.png)

Đoạn code trên sử dụng hàm `system` của PHP để thực thi một lệnh được truyền vào thông qua tham số `cmd` trên URL của trang web bằng phương thức GET.
Tuy nhiên, file này có extension là `.php` nên khi upload, em sẽ nhận được thông báo `Wrong file extension!`.
Tên challenge đã gợi ý cách bypass là sử dụng `double extension` nên em rename tên file thành `shell.php.png` thì upload thành công.
Việc còn lại là gửi các command line phù hợp thông qua biến `cmd` trên URL.
Em thêm `cmd=ls -la` để xem các file có trong đường dẫn hiện hành.

![](https://i.imgur.com/9Qk2hvO.png)

Lần lượt thêm `../` để tìm ra thư mục cha của các file này.

![](https://i.imgur.com/ruACLZv.png)

Khi thêm `../../../` thì em thấy `.passwd`.

![](https://i.imgur.com/T9mYxFy.png)

Để xem nội dung file này, em dùng command line `?cmd=cat ../../../.passwd`.

![](https://i.imgur.com/fXMFROU.png)

#### Flag

`Gg9LRz-hWSxqqUKd77-_q-6G8`

### 2. File upload - MIME type

#### Challenge
Link: http://challenge01.root-me.org/web-serveur/ch21/
#### Statement
>Your goal is to hack this photo galery by uploading PHP code.
Retrieve the validation password in the file .passwd.
#### Solution
Mục đích của bài này vẫn là upload webshell để đọc file `.passwd`. Tuy nhiên, nó khác bài trước ở chỗ không thể thực thi file khi upload bằng cách double extension.
Với tên challenge `MIME type`, em nghĩ đến việc thay đổi `content-type` ở request trước khi gửi tới server.
Lúc đầu, content-type của file `shell.php` là `application/octet-stream`. Vì server chỉ cho phép upload `GIF, JPEG or PNG` nên em đổi content-type thành `image/png` thì đã upload thành công.
Đến đây, em gửi command line tương tự như bài trước thì thu được flag.

![](https://i.imgur.com/lkSjVCE.png)

#### Flag

`a7n4nizpgQgnPERy89uanf6T4`

### 3. File upload - Null byte
#### Challenge
Link: http://challenge01.root-me.org/web-serveur/ch22/?galerie=upload
#### Statement
> Your goal is to hack this photo galery by uploading PHP code.
#### Solution
Với bài này, nhiệm vụ đơn giản hơn hai bài trước là ta chỉ cần upload file PHP thành công thì sẽ thu được flag. Tuy nhiên, các cách trên đều không có hiệu quả.
Với tên challenge `Null byte`, em rename file thành `shell.php%00.png` thì đã upload thành công.

![](https://i.imgur.com/m4k3mUS.png)

Quay lại trang `upload`, em chọn vào file đã upload thành công. Lúc này, server sẽ thực thi file đó nhưng vì các ký tự `%00.png` được tính là ký tự `null` nên file được thực thi là `shell.php`. Vậy khi chọn file PHP đã upload, file được thực thi, em nhận được flag.

![](https://i.imgur.com/wfWWLVb.png)

#### Flag

`YPNchi2NmTwygr2dgCCF`










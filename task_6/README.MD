# Cấu trúc một câu truy vấn 
```sql=
SELECT column_name(s)
FROM table_name
WHERE condition
GROUP BY column_name(s)
HAVING condition
ORDER BY column_name(s);
```
# Một số câu lệnh phổ biến
## SELECT
`SELECT` dùng để truy xuất dữ liệu từ cơ sở dữ liệu 
Dữ liệu trả về được lưu trữ trong một bảng, được gọi là result-set.
#### Syntax
```sql=
SELECT column1, column2, ...
FROM table_name;
```
#### Ví dụ
- Ví dụ 1:
```sql=
SELECT * FROM Customers;
```
> Trả về tất cả các cột trong từ bảng `Customers`
![](https://i.imgur.com/8ljzAZD.png)


- Ví dụ 2:
```sql=
SELECT CustomerName,City FROM Customers;
```
> Trả về cột `CustomerName` và `City` từ bảng `Customers`
![](https://i.imgur.com/lbXYfSa.png)

## SELECT DISTINCT
`SELECT DISTINCT` dùng để truy xuất dữ liệu khác nhau từ cơ sở dữ liệu (chỉ trả về một hàng trong trường hợp các hàng có cùng giá trị)
#### Syntax
```sql=
SELECT DISTINCT column1, column2, ...
FROM table_name;
```
#### Ví dụ
```sql=
SELECT DISTINCT Country FROM Customers;
```
> Trả về các giá trị khác nhau trong cột `Country` từ bảng `Customers`
![](https://i.imgur.com/rU0sl5a.png)

## Mệnh đề WHERE
`WHERE` được sử dụng để lọc dữ liệu, chỉ truy vấn dữ liệu thoả mãn điều kiện trong mệnh đề `WHERE`
#### Syntax
```sql=
SELECT column1, column2, ...
FROM table_name
WHERE condition;
```
#### Ví dụ
```sql=
SELECT * FROM Customers
WHERE Country='Mexico';
```
> Trả về các hàng có giá trị của cột `Country` là 'Mexico' từ bảng `Customers`
![](https://i.imgur.com/SG3Hnpi.png)

## ORDER BY
`ORDER BY` dùng để sắp xếp result-set theo thứ tự tăng dần hoặc giảm dần, mặc định là tăng dần.

Syntax:
```sql=
SELECT column1, column2, ...
FROM table_name
ORDER BY column1, column2, ... ASC|DESC;
```

Ví dụ 1:
```sql=
SELECT * FROM Customers
ORDER BY Country;
```
> SELECT tất cả các cột trong bảng Customers theo thứ tự tăng dần.
![](https://i.imgur.com/oYC88Fc.png)

Ví dụ 2:
```sql=
SELECT * FROM Customers
ORDER BY Country ASC, CustomerName DESC;
```
> SELECT tất cả các cột trong bảng Customers the thứ tự tăng dần của cột Country, nếu giá trị Country giống nhau, sắp xếp theo thứ tự giảm dần của CustomerName
![](https://i.imgur.com/DZter9l.png)

## Toán tử
#### Toán tử bằng '='
```sql=
SELECT * FROM Products
WHERE Price = 10;
```
![](https://i.imgur.com/x0igxNO.png)

#### Toán tử lớn hơn '>'
```sql=
SELECT * FROM Products
WHERE Price = 18;
```
![](https://i.imgur.com/hSTWyQK.png)

#### Toán tử nhỏ hơn '<'
```sql=
SELECT * FROM Products
WHERE Price < 5;
```
![](https://i.imgur.com/0eXVwpL.png)

#### Toán tử ">="
```sql=
SELECT * FROM Products
WHERE Price >= 53;
```
![](https://i.imgur.com/bL2OkUK.png)

#### Toán tử '<='
```sql=
SELECT * FROM Products
WHERE Price <= 7;
```
![](https://i.imgur.com/1UdEOi2.png)

#### Toán tử không bằng '<>', '!='
```sql=
SELECT * FROM Products
WHERE Price <> 18;
```
![](https://i.imgur.com/91p1kl0.png)

#### Toán tử AND, OR, NOT
`AND` chọn bản ghi nếu các điều kiện là TRUE
`OR` chọn bản ghi nếu một trong các điều kiện là TRUE
`NOT` chọn bản ghi nếu điều kiện là FALSE

AND Syntax:
```sql=
SELECT column1, column2, ...
FROM table_name
WHERE condition1 AND condition2 AND condition3 ...;
```
OR Syntax:
```sql=
SELECT column1, column2, ...
FROM table_name
WHERE condition1 OR condition2 OR condition3 ...;
```
NOT Syntax:
```sql=
SELECT column1, column2, ...
FROM table_name
WHERE NOT condition;
```
Ví dụ 1:
```sql=
SELECT * FROM Customers
WHERE Country='Germany' AND (City='Berlin' OR City='München');
```
> SELECT các bản ghi có giá trị Country là 'Germeny' và giá trị City là 'Berlin' hoặc 'München'.
![](https://i.imgur.com/QJF6Hlo.png)

Ví dụ 2:
```sql=
SELECT * FROM Customers
WHERE NOT Country='Germany' AND NOT Country='USA';
```
> SELECT các bản ghi có giá trị Country khác 'Germany' và 'USA'
![](https://i.imgur.com/HXmeXFY.png)

#### Toán tử BETWEEN
`BETWEEN` cho phép lấy các giá trị trong phạm vi nhất định, có thể là số, văn bản hoặc ngày tháng.

Syntax:
```sql=
SELECT column_name(s)
FROM table_name
WHERE column_name BETWEEN value1 AND value2;
```
Ví dụ 1:
```sql=
SELECT * FROM Products
WHERE Price BETWEEN 50 AND 60;
```
> SELECT sản phẩm có giá từ 50 đến 60
![](https://i.imgur.com/V0GQ5dm.png)

Ví dụ 2:
```sql=
SELECT * FROM Products
WHERE ProductName BETWEEN 'Carnarvon Tigers' AND 'Chocolade'
ORDER BY ProductName;
```
> SELECT các sản phẩm có ProductName trong đoạn 'Carnarvon Tigers' và 'Chocolate'
![](https://i.imgur.com/dFu01KZ.png)

Ví dụ 3:
```sql=
SELECT * FROM Orders
WHERE OrderDate BETWEEN '1996-07-01' AND '1996-07-05';
```
> SELECT các đơn hàng có OrderDate từ ngày 01/07/1996 đến 05/07/1996
![](https://i.imgur.com/qZUWQnC.png)

#### Toán tử LIKE

`LIKE` được dùng trong mệnh đề WHERE, dùng để tìm kiếm mẫu được chỉ định trong cột
2 ký tự thường được sử dụng trong toán tử `LIKE`

- `%`: đại diện cho 0, 1 hoặc nhiều ký tự
- `_`: đại diện cho 1 ký tự

Syntax:
```sql=
SELECT column1, column2, ...
FROM table_name
WHERE columnN LIKE pattern;
```
Ví dụ 1:
```sql=
SELECT * FROM Customers
WHERE CustomerName LIKE 'a%';
```
> SELECT khách hàng với CustomerName bắt đầu bằng 'a'
![](https://i.imgur.com/nweG7Pu.png)

Ví dụ 2:
```sql=
SELECT * FROM Customers
WHERE CustomerName LIKE '%a';
```
>SELECT khách hàng với CustomerName kết thúc bằng 'a'
![](https://i.imgur.com/7T1vdIf.png)

Ví dụ 3:
```sql=
SELECT * FROM Customers
WHERE CustomerName LIKE '%ort%'
```
>SELECT khách hàng với CustomerName chứa 'ort'
![](https://i.imgur.com/iebFXBp.png)

Ví dụ 4:
```sql=
SELECT * FROM Customers
WHERE CustomerName LIKE '_n%';
```
> SELECT khách hàng với CustomerName có ký tự thứ hai là 'n'
![](https://i.imgur.com/mR9vFY7.png)

Ví dụ 5:
```sql=
SELECT * FROM Customers
WHERE CustomerName LIKE 'a__%';
```
> SELECT khách hàng với CustomerName bắt đầu bằng 'a' và có độ dài ít nhất 3 ký tự
![](https://i.imgur.com/CONK1vw.png)

Ví dụ 6:
```sql=
SELECT * FROM Customers
WHERE ContactName LIKE 'a%o';
```
> SELECT khách hàng với CustomerName bắt đầu bằng 'a' và kết thúc bằng 'o'
![](https://i.imgur.com/9sr9mHc.png)

Ví dụ 7:
```sql=
SELECT * FROM Customers
WHERE CustomerName NOT LIKE 'a%';
```
> SELECT khách hàng với CustomerName không bắt đầu bằng 'a'
![](https://i.imgur.com/fsHttef.png)

#### Toán tử IN
`IN` được dùng trong mệnh đề WHERE, dùng để chỉ định nhiều giá trị trong cột, tương tự toán tử `OR`.

Syntax:
```sql=
SELECT column_name(s)
FROM table_name
WHERE column_name IN (value1, value2, ...);
```
Ví dụ 1:
```sql=
SELECT * FROM Customers
WHERE Country IN ('Germany', 'France', 'UK');
```
> SELECT khách hàng với Country là 'Germany', 'France' hay 'UK'
![](https://i.imgur.com/jT7qWCI.png)

Ví dụ 2:
```sql=
SELECT * FROM Customers
WHERE Country IN (SELECT Country FROM Suppliers);
```
> SELECT khách hàng có cùng Country với nhà cung cấp
![](https://i.imgur.com/OmdjXAE.png)

## INSERT INTO
`INSERT INTO` dùng để chèn bản ghi mới vào bảng
Có 2 cách sử dụng `INSERT INTO`:
- Chỉ định tên cột được chèn
    Syntax:
    ```sql=
    INSERT INTO table_name (column1, column2, column3, ...)
    VALUES (value1, value2, value3, ...);
    ```

- Trong trường hợp thêm giá trị cho tất cả các cột thì không cần chỉ định tên cột
    Syntax:
    ```sql=
    INSERT INTO table_name
    VALUES (value1, value2, value3, ...);
    ```
Ví dụ:
```sql=
INSERT INTO Customers (CustomerName, City, Country)
VALUES ('Cardinal', 'Stavanger', 'Norway');
```
![](https://i.imgur.com/P1fyvRb.png)

## DELETE
`DELETE` dùng để xoá bản ghi hiện có trong bảng

Syntax:
```sql=
DELETE FROM table_name WHERE condition;
```
- Xoá tất cả bản ghi, giữ nguyên cấu trúc bảng
    Syntax: `DELETE FROM table_name;`
    
Ví dụ:
Bảng ban đầu
![](https://i.imgur.com/waQeF0d.png)
```sql=
DELETE FROM Customers WHERE CustomerName='Alfreds Futterkiste';
```
> Xoá bản ghi chứa CustomerName là 'Alfreds Futterkiste'
![](https://i.imgur.com/v08L3uK.png)

## Join
`JOIN` dùng để kết hợp các hàng có liên quan từ 2 bảng thành một bảng
#### INNER JOIN
![](https://i.imgur.com/E0jFCzv.png)
Syntax:
```sql=
SELECT column_name(s)
FROM table1
INNER JOIN table2
ON table1.column_name = table2.column_name;
```
Ví dụ:
`Orders` table
![](https://i.imgur.com/kyErck4.png)

`Customers` table
![](https://i.imgur.com/4NsUTKm.png)

```sql=
SELECT Orders.OrderID, Customers.CustomerName
FROM Orders
INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID;
```
> Kết hợp những hàng có chung CustomerID thành một bảng (những hàng không liên quan sẽ được bỏ qua), sau đó SELECT OrderID và CustomersName
![](https://i.imgur.com/IRCk9Nv.png)

#### LEFT JOIN
![](https://i.imgur.com/IMYbWMo.png)
Syntax:
```sql=
SELECT column_name(s)
FROM table1
LEFT JOIN table2
```
Ví dụ:
```sql=
SELECT Customers.CustomerName, Orders.OrderID
FROM Customers
LEFT JOIN Orders
ON Customers.CustomerID=Orders.CustomerID
ORDER BY Customers.CustomerName;
```
> Trả về CustomerName của toàn bộ bảng bên trái (Customers), và OrderID của bản ghi phù hợp từ bảng bên phải (Oders). nếu bảng bên phải không có bản ghi phù hợp với bảng bên trái, OrderID là null
![](https://i.imgur.com/XzKnIdH.png)

#### RIGHT JOIN
![](https://i.imgur.com/0ytdZ3U.png)
Syntax:
```sql=
SELECT column_name(s)
FROM table1
RIGHT JOIN table2
ON table1.column_name = table2.column_name;
```
Ví dụ:
`Orders` table
![](https://i.imgur.com/4qyWrDR.png)
`Employees` table
![](https://i.imgur.com/GDGZjm6.png)

```sql=
SELECT Orders.OrderID, Employees.LastName, Employees.FirstName
FROM Orders
RIGHT JOIN Employees ON Orders.EmployeeID = Employees.EmployeeID
ORDER BY Orders.OrderID;
```
> Trả về LastName, FirstName của toàn bộ bảng bên phải (Employees) và OrderID của bản ghi phù hợp từ bảng bên trái (Oders). nếu bảng bên trái không có bản ghi phù hợp với bảng bên phải, OrderID là null
![](https://i.imgur.com/UPnQPk5.png)

#### FULL OUTER JOIN
![](https://i.imgur.com/PlSbBbQ.png)
Syntax:
```sql=
SELECT column_name(s)
FROM table1
FULL OUTER JOIN table2
ON table1.column_name = table2.column_name
WHERE condition;
```
Ví dụ:
`Customers`
![](https://i.imgur.com/EqwZ5Sf.png)
`Orders`
![](https://i.imgur.com/wgcEo1F.png)
```sql=
SELECT Customers.CustomerName, Orders.OrderID
FROM Customers
FULL OUTER JOIN Orders ON Customers.CustomerID=Orders.CustomerID
ORDER BY Customers.CustomerName;
```
> Trả về tất cả các bản ghi từ cả hai bảng, các bản ghi không liên quan với nhau được trả về giá trị null phù hợp
![](https://i.imgur.com/qiBVLFu.png)

#### SELF JOIN
`SELF JOIN` dùng để kết hợp một bảng với chính nó
Syntax:
```sql=
SELECT column_name(s)
FROM table1 T1, table1 T2
WHERE condition;
```
> T1, T2 là hai aliases của bảng, có thể coi như kết hợp 2 bảng có tên khác nhau nhưng dữ liệu giống nhau để dễ hình dung.
Ví dụ:
`Customers` table
![](https://i.imgur.com/dEsa1m4.png)
```sql=
SELECT A.CustomerName AS CustomerName1, B.CustomerName AS CustomerName2, A.City
FROM Customers A, Customers B
WHERE A.CustomerID <> B.CustomerID
AND A.City = B.City
ORDER BY A.City;

```
> ![](https://i.imgur.com/kRuZYRp.png)

## UNION
`UNION` là toán tử dùng để kết hợp result-set của hai hay nhiều câu lệnh `SELECT`
- Các result-set phải có cùng số cột
- Các cột phải có kiểu dữ liệu giống nhau
- Các cột trong result-set phải có cùng thứ tự
Syntax:
```sql=
SELECT column_name(s) FROM table1
UNION
SELECT column_name(s) FROM table2;
```
Ví dụ:
`Customers` table
![](https://i.imgur.com/mB6oN4G.png)
`Suppliers` table
![](https://i.imgur.com/QsSAbBg.png)
```sql=
SELECT City FROM Customers
UNION
SELECT City FROM Suppliers
ORDER BY City;
```
> Nếu customer và suppliers đến từ cùng một thành phố thì thành phố chỉ được liệt kê một lần. 
![](https://i.imgur.com/fcBJY3H.png)
Nếu muốn in các giá trị trùng nhau nhiều lần, sử dụng `UNION ALL`
Ví dụ:
```sql=
SELECT City FROM Customers
UNION ALL
SELECT City FROM Suppliers
ORDER BY City;
```
![](https://i.imgur.com/Ya7HFMI.png)

## GROUP
`GROUP` dùng để kết hợp các hàng có cùng giá trị thành một hàng
`GROUP` thường được sử dụng cùng các function như `COUNT()`, `MAX()`, `MIN()`, `SUM()`, `AVG()`
Syntax:
```sql=
SELECT column_name(s)
FROM table_name
WHERE condition
GROUP BY column_name(s)
ORDER BY column_name(s);
```
Ví dụ:
![](https://i.imgur.com/Yx40TFC.png)
```sql=
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country;
```
> Đếm số khách hàng (thông qua CustomerID) đến từ mỗi nước
![](https://i.imgur.com/iCcApGN.png)

## HAVING
`HAVING` có chức năng như `WHERE` nhưng vì `WHERE` không thể dùng được với các hàm kết hợp nên cần `HAVING`
Syntax:
```sql=
SELECT column_name(s)
FROM table_name
WHERE condition
GROUP BY column_name(s)
HAVING condition
ORDER BY column_name(s);
```
Ví dụ:
![](https://i.imgur.com/O57o3Aq.png)
```sql=
SELECT COUNT(CustomerID), Country
FROM Customers
GROUP BY Country
HAVING COUNT(CustomerID) > 5;
```
> SELECT các nước có số khách hàng lớn hơn 5
![](https://i.imgur.com/Chksxz7.png)

# Một số function phổ biến
## MIN(), MAX()
`MIN()` trả về giá trị nhỏ nhất của cột đã chọn
`MAX()` trả về giá trị lơn nhất của cột đã chọn
Syntax:
```sql=
SELECT MIN(column_name)
FROM table_name
WHERE condition;
```
```sql=
SELECT MAX(column_name)
FROM table_name
WHERE condition;
```
Ví dụ:
![](https://i.imgur.com/hvVMEBZ.png)
```sql=
SELECT MIN(Price) AS SmallestPrice
FROM Products;
```
> Tìm giá rẻ nhất của các sản phẩm
![](https://i.imgur.com/lTLnL8q.png)

## COUNT(),AVG(), SUM()
`COUNT()` trả về số hàng phù hợp
`AVG()` trả về giá trị trung bình của một cột có giá trị là số
`SUM()` trả về tổng của một cột có giá trị là số
Syntax:
```sql=
SELECT COUNT(column_name)
FROM table_name
WHERE condition;
```
```sql=
SELECT AVG(column_name)
FROM table_name
WHERE condition;
```
```sql=
SELECT SUM(column_name)
FROM table_name
WHERE condition;
```
Ví dụ:
![](https://i.imgur.com/qULHSK3.png)
- COUNT()
    ```sql=
    SELECT COUNT(ProductID)
    FROM Products;
    ```
    ![](https://i.imgur.com/sehOOb3.png)
    
- AVG()
    ```sql=
    SELECT AVG(Price)
    FROM Products;
    ```
    ![](https://i.imgur.com/EniKUV9.png)
    
- SUM()
    ```sql=
    SELECT SUM(Price)
    FROM Products;
    ```
    ![](https://i.imgur.com/hzTEEiI.png)











# XSS là gì?
XSS (Cross Site Scripting) là một lỗi bảo mật cho phép hacker nhúng mã độc (javascript) vào một trang web khác. Hacker có thể lợi dụng lỗ hổng này để tấn công trang web; dụ dỗ người dùng tải virus về máy; giả dạng, chiếm quyền điều khiển của người dùng.
XSS xảy ra khi các trang web không kiểm tra và sàng lọc đầu vào của người dùng đúng cách. Điều này tạo cơ hội cho kẻ tấn công chèn các đoạn mã độc thông qua request gửi tới trình duyệt. Khi người dùng vô ý làm những đoạn mã này sẽ được thực thi, kẻ tấn công  có thể tiếp cận các thông tin của người dùng và chiếm quyền điều khiển trang web.
XSS có thể xảy ra dưới nhiều hình thức:
- Trên tập lệnh độc hại được thực hiện ở phía client
- Trang web hoặc form giả mạo hiển thị cho người dùng (nơi nạn nhân nhập thông tin hoặc nhấp vào liên kết độc hại)
- Trên các trang web quảng cáo được hiển thị
- Email độc hại được gửi tới nạn nhân
- …
___
# Các loại XSS
## Reflected XSS
Reflected XSS là dạng XSS đơn giản nhất. Nó xảy ra khi hacker chèn mã độc vào URL dưới dạng query string. Khi người dùng nhấp vào URL này, server sẽ phản hồi lại với dữ liệu chứa đoạn javascript đã được chèn. Trình duyệt của nạn nhân nhận phản hồi và thực thi đoạn mã độc. 
Hướng khai thác phổ biến nhất thông qua lỗi Reflected XSS là chiếm session của người dùng, từ đó có thể truy cập dữ liệu và chiếm quyền của họ trên trang web.

![](https://i.imgur.com/b50UsNc.png)

## Stored XSS
Stored XSS (Persistent XSS) xảy ra khi server nhận dữ liệu chứa mã độc và lưu trữ lại, sau đó hiển thị ra với toàn bộ người dùng tiếp theo. 
Đầu tiên, hacker thông qua các input (form, input…) không được kiểm tra để chèn vào CSDL các đoạn mã nguy hiểm. Khi người dùng truy cập vào trang web, đoạn mã sẽ được thực thi trên trình duyệt của người dùng.

![](https://i.imgur.com/tlRFifp.png)

Stored XSS nguy hiểm hơn Reflected XSS ở chỗ hacker không cần dụ dỗ người dùng nhấp vào link nào cả, chỉ cần người dùng truy cập trang web thì mã độc đã được thực thi. Vì vậy đối tượng của Stored XSS sẽ rộng hơn nhiều và người dùng sẽ không thể nhận ra được sự khác thường khi truy cập trang web.

## DOM Based XSS
DOM Based XSS là kỹ thuật khai thác XSS dựa trên việc thay đổi cấu trúc DOM của tài liệu HTML. 

![](https://i.imgur.com/OqCnxqS.png)

Điểm khác biệt của **DOM based XSS** là mã độc được thực thi do đoạn Javascript phía client mà không cần server xử lý request. Kết quả là response trả về không hề chứa đoạn script của hacker.
Google Chrome có một tính năng bảo mật được bật mặc định là XSS Auditor, nó là 1 filter của browser, có chức năng ngăn chặn cuộc tấn công XSS. Browser sẽ kiểm tra xem trong request mà client gửi lên có chứa mã độc không, nó sẽ so sánh script này với nội dung response từ server. Nếu script từ request giống với response, XSS Auditor sẽ nhận biết đây là một cuộc tấn công XSS và block đoạn script này. Như vậy XSS Auditor chỉ ngăn chặn được Reflected XSS mà không ngăn chặn được DOM based XSS, vì script của hacker không được copy vào response từ server.
___
# Cách phòng tránh
1. **Kiểm tra và sàng lọc đầu vào của người dùng:** Ứng dụng web cần kiểm tra và sàng lọc tất cả các đầu vào của người dùng, bao gồm kiểm tra định dạng, giá trị và kích thước của đầu vào, đồng thời sàng lọc các ký tự đặc biệt.
2. **Mã hóa dữ liệu trên trang web:** Các ứng dụng web cần mã hóa tất cả các dữ liệu trên trang web, bao gồm các thông tin nhạy cảm như tên người dùng, mật khẩu và thông tin tài khoản. 
3. **Sử dụng các thư viện mã hóa và chống giả mạo thông tin:** Các ứng dụng web có thể sử dụng các thư viện mã hóa và chống giả mạo thông tin để đảm bảo an toàn cho dữ liệu của người dùng. Các thư viện này bao gồm các công cụ để xác thực dữ liệu, mã hóa dữ liệu và kiểm tra các ký tự đặc biệt và mã độc.
4. **Sử dụng các response header thích hợp:** Để ngăn XSS trong các response HTTP chứa mã HTML hoặc JavaScript nào, có thể sử dụng các tiêu đề Content-Type và X-Content-Type-Options để đảm bảo rằng các trình duyệt diễn giải các response theo cách bạn muốn.
5. **Sử dụng CSP (Content Security Policy):** CSP là một cơ chế bảo mật cho phép các quản trị viên cấu hình chính sách bảo mật trên trang web để hạn chế hoặc ngăn chặn việc chèn vào các đoạn mã độc và các trang web có nguồn gốc không an toàn.





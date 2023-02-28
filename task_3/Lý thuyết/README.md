# KCSC Train
# WEBSITE

Website là một tập hợp nhiều trang web (webpage) bao gồm văn bản, hình ảnh, video… có liên kết với nhau, được gói gọn trong một tên miền.
### Cách thức hoạt động của một website
1. Người dùng nhập vào thành tìm kiếm của trình duyệt web một địa chỉ (domain name). VD: facebook.com
2. Trình duyệt gửi yêu cầu đến DNS.
    DNS phân giải domain name thành IP của web server chứa source code ứng với domain đó. Dễ hiểu hơn là DNS đã lưu lại IP của server từ lúc đăng ký domain, lúc cần thì sẽ đưa ra.
3. Trình duyệt tiếp tục gửi yêu cầu tới web server thông qua IP đã nhận được.
4. Khi nhận được yêu cầu, web server sẽ xử lý thông tin và trả về nội dung website được yêu cầu (dưới dạng file bao gồm HTML/CSS, hình ảnh, video…)
5. Sau khi nhận được tài nguyên từ web server, trình duyệt sẽ render thành giao diện website chúng ta nhìn thấy.
![](https://i.imgur.com/RHU2j6m.jpg)

___

# URL
URL (Uniform Resource Locator - Định vị tài nguyên thống nhất) là một định danh duy nhất cho tài nguyên web mà qua đó có thể truy xuất đến nó.

Cấu trúc đầy đủ của một URL như sau:
![](https://i.imgur.com/jKE8mCk.png)
1. Scheme: xác định giao thức được sử dụng để truy cập tài nguyên
2. Indicator of a hierachical: cố định 
3. Credentials to access to resource: có thể chỉ ra username, thậm chí là password, phần này có thể có hoặc không
4. Server address: xác đinh địa chỉ của server
5. Server port: có thể có hoặc không, thường được thêm vào nếu nó khác với số cổng mặc định của giao thức
6. Hierarchical file path: ánh xạ để xác định vị trí tài nguyên sẽ được lấy về từ server
7. Query string: có thể có hoặc không, cung cấp thêm các thông tin truy vấn cho server
8. Fragment ID: có vai trò tương tự như query string nhưng cung cấp các tuỳ chọn cho client, giá trị này không được gửi đến server

Các ký tự đặc biệt như :, /, #, [, ], @ có thể phá vỡ cấu trúc, làm mất tính hợp lệ của URL nên người ta sẽ mã hoá các ký tự đặc biệt thành %_số đại diện cho ký tự trong bảng mã ASCII. Việc mã hoá này khiến các ký tự đặc biệt không ảnh hưởng đến cấu trúc url, đồng thời giúp phòng tránh một số kiểu tấn công phổ biến.

___
# HTTP/HTTPs
HTTP (HyperText Transfer Protocol - giao thức truyền tải siêu văn bản) là giao thức được sử dụng trong World Wide Web, dùng để liên hệ thông tin giữa web server và web client.
HTTP hoạt động dựa trên mô hình client-server, tương tác HTTP gồm request và response.
HTTP là stateless, có nghĩa là sau khi client gửi dữ liệu lên server ⇒ server thực thi, trả kết quả cho client ⇒ quan hệ client - server bị cắt đứt, server không lưu dữ liệu của client. Trong trường hợp này, nếu server muốn lưu dữ liệu của client thì thì có thể sử dụng cookie, session…
### HTTP Requests
Tất cả các thông điệp HTTP (request, response) đều gồm một dòng trạng thái, một hoặc nhiều header, một dòng trống thông báo kết thúc trường header, sau đó là phần body chứa dữ liệu được gửi cùng request hoặc dữ liệu được nhận cùng response.

![](https://i.imgur.com/kMHjHZI.png)

Dòng đầu tiên của một request gồm 3 phần:

- Phương thức đang được sử dụng, phổ biến nhất là GET.
- URL được request
- Phiên bản HTTP đang được sử dụng, phổ biến nhất là phiên bản 1.1

Một số header điển hình trong request:

- Referer: cho biết URL mà từ đó request bắt nguồn
- User-Agent: thông tin về trình duyệt được sử dụng để tạo request
- Host: cho biết tên host (được xác định duy nhất), cần thiết khi nhiều trang web được lưu trữ trên cùng một server
- Cookie: gửi các thông số bổ sung mà server cấp cho client trước đó
### HTTP Response
![](https://i.imgur.com/WhzhvVc.png)

Dòng đầu tiên của một response gồm 3 phần:

- Phương thức đang được sử dụng
- Status code: cho biết mã số thể hiện trạng thái kết quả request
- Diễn giải status code bằng text

Một số header điển hình trong response:

- Server: thông tin về phần mềm máy chủ đang được sử dụng, đôi khi là mô-đun đã cài đặt hay hệ điều hành máy chủ.
- Set-Cookie: cung cấp cho trình duyệt một cookie khác, lưu vào header Cookie của request tiếp theo.
- Pragma: chỉ dẫn trình duyệt không lưu response trong bộ nhớ đệm.
- Expires: cho biết nội dung response đã hết hạn, do đó không nên được lưu trữ.
- Content-Type: chuẩn chung của một HTTP response có bao gồm message body, header này cho biết loại nội dung thực tế trong message body. VD: HTML, gif, png, mp4…
- Content-Length: cho biết kích thước của message body tính bằng byte.
### HTTP Methods
- GET: sử dụng để lấy thông tin từ server, request sử dụng GET chỉ nhận dữ liệu, không làm thay đổi dữ liệu
    - GET có thể được lưu trữ
    - GET được lưu lại trong lịch sử trình duyệt
    - GET có thể được đánh dấu
    - Không nên sử dụng GET khi xử lý dữ liệu nhạy cảm
    - GET giới hạn độ dài
- HEAD: tương tự GET nhưng không trả về phần body trong response mà truyền tải dòng trạng thái và phần header.
- POST: được sử dụng để gửi dữ liệu lên server để tạo/cập nhật tài nguyên
    - POST không được lưu trữ
    - POST không được lưu lại trong lịch sử trình duyệt
    - POST không thể được đánh dấu
    - POST không giới hạn độ dài
- PUT: được dùng để gửi dữ liệu lên server để tạo/cập nhật tài nguyên nhưng khác POST ở chỗ sẽ làm thay đổi thông tin nếu tài nguyên đã tồn tại
- DELETE: xoá tài nguyên được chỉ định
- CONNECT: thiết lập một tunnel từ client tới server, thông qua proxy
- OPTIONS: cho biết methods khả dụng cho tài nguyên cụ thể
- TRACE: thực hiện lặp lại thông báo kiểm tra cho tài nguyên đích, hữu ích cho việc gỡ lỗi
### Status Code
Status code nằm trong response, cho biết kết quả response

5 nhóm status code:

- 1xx: request đã được nhận
    - 100 (continue): server đã nhận được một phần request, client nên tiếp tục gửi request
    - 101 (switching protocols): phản hồi header Upgrade từ client, chấp nhận yêu cầu chuyển đổi giao thức
    - 102 (processing): cho biết máy chủ đã nhận và đang xử lý yêu cầu nhưng chưa có phản hồi
    - 103 (early hint): cho phép người dùng tải trước tài nguyên trong khi máy chủ chuẩn bị phản hồi
- 2xx: xử lý request thành công
    - 200 (OK): request thành công, kết quả phụ thuộc vào method
    - 201 (created): request thành công, kết quả là một tài nguyên mới được tạo ra. Đây thường là response của request POST hoặc PUT
    - 204 (no content): máy chủ xử lý yêu cầu thành công nhưng không có nội dung nào được trả lại
    - 206 (partial content): phản hồi header Range, xử lý thành công một phần request
- 3xx: điều hướng lại
    - 301 (moved permanently): trang web được yêu cầu đã di chuyển vĩnh viễn tới URL mới
    - 302 (found): trang web được yêu cầu di chuyển tạm thời tới một URL mới
    - 304 (not modified): trang yêu cầu không được sửa đổi từ request cuối cùng, client có thể tiếp tuc sử dụng response được lưu trong catch
- 4xx: lỗi ở phía client
    - 400 (bad request): máy chủ không hiểu request do lỗi của client
    - 401 (unauthorized): yêu cầu xác thực từ client, thường xuất hiện nếu client gửi request một trang đăng nhập
    - 403 (forbidden): máy chủ từ chối yêu cầu do client không có quyền truy cập vào nội dung đã yêu cầu, thường trả về nếu đăng nhập không thành công
    - 404 (not found): không thể tìm thấy trang yêu cầu
    - 405 (method not allowed): phương thức trong request không được hỗ trợ
    - 408 (request timeout): request tốn thời gian hơn response
    - 411 (length required): content-length không được xác định rõ
    - 413 (payload too large): máy chủ không thể xử lý do yêu cầu quá lớn
    - 414 (URI too long): URI do client yêu cầu dài hơn độ dài máy chủ có thể diễn giải
- 5xx: lỗi ở phía server
    - 500 (internal server error): máy chủ gặp lỗi, không thể thực hiện request
    - 501 (no implemented): máy chủ không có chức năng thực hiện yêu cầu
    - 503 (service unavailable): máy chủ hiện không có sẵn (do quá tải hoặc bảo trì), đây là trạng thái tạm thời
### HTTP Headers
HTTP hỗ trợ một lượng lớn header, hỗ trợ nhiều mục đích. Có header được sử dụng trong cả request và response, cũng có header chỉ có ở một trong hai. Header chứa thông tin chủ yếu về client và server như thông tin trình duyệt, cấu hình server, ngày tháng request…

Có thể chia header thành 4 kiểu:

- General Header: áp dụng cho cả request và response
    - Connection: cho biết có nên đóng kết nối TCP sau khi quá trình truyền HTTP hoàn tất hay vẫn mở cho các message tiếp theo
    - Content-Encoding: chỉ ra loại mã hoá đang được sử dụng cho nội dung message
    - Content-Length: chỉ ra độ dài message tính bằng byte
    - Content-Type: huẩn chung của một HTTP response có bao gồm message body, header này cho biết loại nội dung thực tế trong message body. VD: HTML, gif, png, mp4…
    - Transfer-Encoding: chỉ định hình thức mã hoá để truyền tải nội dung một cách an toàn tới người dùng
- Request header: chứa thông tin của request
    - Accept: cho server biết những loại nội dung nào được client chấp nhận. VD: image type, office document fomat…
    - Accept-Encoding: cho server biết loại mã hoá được client chấp nhận
    - Authorization: gửi đến server thông tin xác thực
    - Cookie: gửi cookie đến server
    - Host: cho biết tên host (được xác định duy nhất), cần thiết khi nhiều trang web được lưu trữ trên cùng một server
    - If-Modified-Since: chỉ định thời điểm trình duyệt nhận request lần cuối. Nếu tài nguyên không thay đổi kể từ thời điểm đó, server hướng dẫn client sử dụng bản sao lưu trong bộ nhớ đệm bằng response có status code là 304
    - • If-None-Match*:* yêu cầu server trình bày method được yêu cầu chỉ khi một trong số giá trị đã cho của thẻ này kết nối với các thẻ đối tượng đã được cung cấp biểu diễn bởi *Etag*.
    - Origin: chỉ ra nguồn gốc request
    - Referer: cho biết nguồn gốc, đường dẫn, chuỗi truy vấn… của request
    - User-Agent: thông tin về trình duyệt được sử dụng để tạo request
- Response header: chứa thông tin của response
    - Access-Control-Allow-Origin: chỉ ra liệu tài nguyên có thể được truy xuất thông qua request Ajax Cross-domain
    - Catch-Control: chuyển các chỉ thị bộ nhớ đệm đến trình duyệt
    - ETag: được sử dụng để Client có thể gửi số nhận dạng này trong các request tương tự trong tương lai đối với cùng một tài nguyên trong Header *If-None-Match*
     để thống báo cho Server phiên bản tài nguyên nào mà trình duyệt hiệ nđang giữ trong bộ nhớ cache của nó
    - Expires: cho biết nội dung của message có giá trị trong bao lâu, trình duyệt có thể sử dụng bản sao được lưu trong bộ nhớ cache của tài nguyên cho đến thời điểm đó
    - Location: được sử dụng trong các response chuyển hướng (những response có mã trạng thái bắt đầu bằng 3) để chỉ định mục tiêu của chuyển hướng
    - Pragma: chuyển các chỉ thị bộ nhớ đệm đến trình duyệt
    - Server: cung cấp thông tin về phền mềm web server đang sử dụng
    - Set-Cookie: cấp cookie cho trình duyệt mà nó sẽ được gửi lại server trong các request tiếp theo
    - WWW-Authenticate: được sử dụng trong response có mã trạng thái là 401 để cung cấp chi tiết về các loại xác thực mà Server hỗ trợ
    - X-Frame-Options: chỉ ra liệu response hiện tại có thể tải trong khung trình duyệt hay không và như thế nào
- Entity header: chứa thông tin của body message
### Cookies
Cookies là phần dữ liệu được server gửi tới trình duyệt vào lần đầu truy cập website hoặc không tìm thấy request của trình duyệt gửi lên. Sau đó cookies được lưu lại trên trình duyệt của client và được gửi lại server trong lần request tiếp theo.

Server phát hành cookies gửi response có header Set-Cookie.

Sau đó, trình duyệt của client sẽ tự động thêm header Cookie vào request tiếp theo.

Cookie thường bao gồm một cặp name/value. Ngoài giá trị thực của cookie, Set-Cookie có thể bao gồm các thuộc tính tuỳ chọn:

- Expire: đặt ngày cookie hết hiệu lực. Nếu thuộc tính này không được đặt, cookie chỉ được sử dụng trong phiên trình duyệt hiện tại
- Domain: chỉ định miền mà cookie hợp lệ. Tên miền này phải giống hoặc là tên miền mà từ đó cookie được nhận
- Path: được sử dụng để chỉ định đường dẫn URL mà cookie hợp lệ
- Secure: nếu thuộc tính này được đặt, cookie sẽ chỉ được gửi trong HTTPS request
- HttpOnly: nếu thuộc tính này được đặt, cookie không thể được truy cập trực tiếp qua JavaScript phía client
### HTTPs
HTTPS(Hypertext Transfer Protocol Secue) là phiên bản an toàn của HTTP, trong đó tất cả giao tiếp giữa trình truyệt và website đều được mã hoá.

Các trang HTTPS thường sử dụng một trong hai giao thức bảo mật để mã hoá thông tin:

- SSL - Secure Sockets Layer
- TLS - Transport Layer Security

Cả hai giao thức này đều sử dụng hệ thống PKI (Public Key Infrastructure - hạ tầng khoá công khai) không đối xứng.
### HTTP Proxies
Proxy là một máy chủ trung gian truy cập giữa trình duyệt của client và web server. 

Khi sử dụng proxy, trình duyệt sẽ gửi toàn bộ request tới proxy server. Proxy chuyển tiếp các request đến web server, sau đó web server gửi response trở lại proxy rồi tới trình duyệt.

![](https://i.imgur.com/7ShOlen.png)


Hầu hết các proxy đều cung cấp các dịch vụ bổ sung như bộ nhớ đệm, xác thực và kiểm soát truy cập.

Lợi ích của HTTP Proxy:

- Riêng tư: có thể dùng máy chủ proxy để truy cập Internet một cách riêng tư. Một số máy chủ Proxy còn có thể thay đổi IP cùng thông tin nhận dạng mà request gửi lên. Vì vậy, máy chủ đích không thể biết ai đã đưa ra yêu cầu. Điều này giúp thông tin cá nhân được giữ kín.
- Trên Internet luôn tiềm ẩn rất nhiều nguy cơ. Khi sử dụng proxy, các nội dung được chọn lọc nên an toàn hơn.
- Tăng tốc và tiết kiệm băng thông: Việc sử dụng proxy server một cách hiệu quả giúp cho mạng tổng có hiệu suất tốt hơn. Ngoài ra, nó còn lưu trữ các trang web phổ biến giúp tiết kiệm băng thông.
- Truy cập vào nội dung bị chặn: proxy cho phép hạn chế người dùng truy cập một số nội dung nội bộ. Tuy nhiên, ta có thể sử dụng một proxy có thể thay đổi địa chỉ IP để thay đổi vị trí địa lý, từ đó truy cập vào các nội dung bị chặn một cách dễ dàng.
### HTTP Authentication
Là giao thức HTTP bao gồm các cơ chế riêng để xác thực người dùng bằng cách sử dụng lược đồ xác thực khác nhau, bao gồm các cơ chế sau:

- Basic: cơ chế xác thực đơn giản bằng cách gửi thông tin đăng nhập của người dùng dưới dạng chuỗi được mã hoá Base64 trong phần header của request
- NTLM: cơ chế challenge-response, sử dụng một phiên bản của giao thức Windows NTLM
- Digest: là một cơ chế challenge-response, sử dụng MD5 để kiểm tra thông tin đăng nhập của người dùng
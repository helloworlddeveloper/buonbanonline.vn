<!-- BEGIN: main -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đăng ký tài khoản thành công!</title>
</head>

<body>
    <div style="width: 600px; height: auto; box-shadow: 0px -1px 3px grey;margin:0 auto;background:#dcdcdc;padding:20px">
        <header style="width: 100% ; text-align: center">
            <img src="{LOGO_SRC}" style=" width: 150px; height: 150px;">
            <p style="font-size: 25px;">Tài khoản bạn đã được tạo</p>
        </header>
        <section style="font-size: 14px; line-height: 24px; padding-left: 10px; padding-right: 10px;">
            <h4 style="font-size: 18px; line-height: 24px;">Xin chào {USER.last_name} ,</h4>
            <p>Tài khoản của bạn tại website ECNG | Sàn Thương Mại Điện Tử Chợ Nhà Giàu đã được kích hoạt. Dưới đây là thông tin đăng nhập:</p>
            <p style="font-size: 18px; line-height: 24px;">Tên tài khoản: <b>{USER.email}</b></p>
            <p>Bạn hãy click vào đường dẫn dưới đây để đăng nhập và đổi mật khẩu:</p>
            <div style="text-align: center;">
                <a title="{SITE_NAME}" alt="{SITE_NAME}" href="{LOGIN}" style="width: 150px; height: 50px; background-color: #E1A208; color: #000000; border-radius: 10px; margin-top: 10px; font-size: 18px;
                line-height: 24px;padding: 10px 20px;text-decoration:none">Đăng nhập</a>
            </div>
            <p style=" margin-top: 28px;">Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website ECNG | Sàn Thương Mại Điện Tử Chợ Nhà Giàu. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.</p>
            <p style="margin-top: 0;">Trân trọng, <br> Quản trị Chợ Nhà Giàu</p>
            <p style="margin-top: 0;">Bạn thắc mắc ? Vui lòng liên hệ chúng tôi <a href="{CONTACT}" style="color: #E1A208;">tại đây</a></p>
        </section>
    </div>

</body>

</html>
<!-- END: main -->
<!-- BEGIN: main -->

<!DOCTYPE html>
<html lang="en">

<body style="background:#DADADA">
    <div style="width: 600px; padding: 16px; margin: 0 auto;">
        <div style="background: #FFFFFF;
        border-radius: 4px;padding: 24px 16px;">
            <div style="border-bottom: 1px solid #E1A208;">
                <a href="https://chonhagiau.com" title="Chợ nhà giàu"><img src="https://chonhagiau.com/uploads/logo.png"
                        alt="" style="width: 20%;"></a>
            </div>
            <h1
                style="font-family: Roboto;font-style: normal;font-weight: bold;font-size: 24px;line-height: 28px;text-align: center;text-transform: uppercase;color: #E1A208;">
                THÔNG báo đơn hàng đã hủy</h1>
            <div>
                <p>Chào shop <span style="font-weight: 700;">{SHOP_NAME},</span> </p>
                <p style="margin: 0;">Đơn hàng #{DATA.order_code} đã được hủy </p>
                <span>Lý do hủy: {info_order.lydohuy}</span>
            </div>
            <div style="border-top:1px solid #DADADA;margin-top: 20px;">
                <p style="font-size:16px">Thông tin đơn hàng <span style="font-weight: 700;color: #E1A208;">#{DATA.order_code}</span></p>
                <div style="width: 100%;display: flex;">
                    <div style="width: 50%;">
                        <p>Thời gian đặt hàng:</p>
                        <p>Phương thức vận chuyển:</p>
                        <p>Phương thức thanh toán:</p>
                        <p>Tên người nhận:</p>
                        <p>Số điện thoại:</p>
                        <p>Địa chỉ:</p>
                    </div>
                    <div style="width: 50%;text-align: end;">
                        <p>{info_order.time_add}</p>
                        <p>{info_order.name_transporters}</p>
                        <p>VNPAY</p>
                        <p>{info_order.order_name}</p>
                        <p>{info_order.phone}</p>
                        <span>{info_order.address}</span>
                    </div>
                </div>
            </div>
            <!-- BEGIN: data_product -->
            <div style="width: 100%;background: #DADADA;
        border-radius: 4px 4px 0px 0px;display:flex;padding: 15px 1px;margin-top: 25px;">
                <div style="width: 50%;padding-left: 10px;">Sản phẩm</div>
                <div style="width: 20%; text-align: center;">Số lượng</div>
                <div style="width: 30%;text-align: end;padding-right: 10px;">Đơn giá</div>
            </div>
            <div id="border_bt" style="width: 100%;border-right: 1px solid #dadada;
        border-left: 1px solid #dadada;
        border-top: 1px solid #dadada;">
                <!-- BEGIN: loop -->
                <div class="border_bt" style="display: flex;border-bottom: 1px solid #dadada;">
                    <div style="width: 50%;display:flex;padding: 10px 0;">
                        <img style="width: 50px;
                    height: 50px;border-radius: 4px;margin: 0px 8px;" src="{image}">
                        <span style="padding-top: 5px;">{product_name}</span>
                    </div>
                    <div style="width: 20%;text-align:center;padding-top:15px">{product_number}</div>
                    <div style="width: 30%;
                text-align:end;padding-right: 10px;padding-top:15px">{product_price}đ</div>
                </div>
                <!-- END: loop -->
            </div>
            <div style="width: 100%;text-align:end">
                <div style="display: flex;width:100%;">
                    <div style="width: 60%;">
                        <p>Tiền hàng (tạm tính) :</p>
                        <p>Phí vân chuyển:</p>
						<!-- BEGIN: voucher_title -->
					<p>Voucher:</p>
					<!-- END: voucher_title -->
                        <p>Tổng tiền:</p>
                    </div>
                    <div style="width: 40%;text-align: end;padding-right: 10px;">
                        <p>{info_order.total_product}đ</p>
                        <p>{info_order.fee_transport}</p>
						<!-- BEGIN: voucher -->
					<p>-{info_order.voucher_price}đ</p>
					<!-- END: voucher -->
                        <p>{info_order.total}đ</p>
                    </div>
                </div>
            </div>
            
            <!-- END: data_product -->
           
            <div style="text-align: center;margin-top: 15px;padding: 0 20px;">
                <span>Đây là email tự động, vui lòng không trả lời. Nếu có bất kỳ thắc mắc hay cần giúp đỡ, bạn vui lòng
                    liên hệ <a style="text-decoration: none;" href="https://chonhagiau.com/contact/">Trung tâm hỗ
                        trợ</a> của Chợ Nhà Giàu.</span>
            </div>

        </div>
        <div style="display: flex;padding: 20px 10px;">
            <div style="display: flex;width: 50%;">
                <img src="https://chonhagiau.com/uploads/logo.png" alt="" style="width: 22%;">
                <div style="padding-left: 8px;">
                    <p style="margin: 0;font-size: 10px;font-weight: 500;line-height: 16px">Công ty Cổ phần thương mại điện
                        tử CHỢ NHÀ GIÀU</p>
                    <span style="font-size: 10px;line-height: 16px;color: #444444;">Tầng 5, 99A Cộng Hòa, Phường 4, Quận Tân
                        Bình,<br> Thành phố Hồ Chí Minh. </span>
                </div>
            </div>
            <div style="width: 50%;text-align: end;"><img
                    src="https://chonhagiau.com/themes/default/chonhagiau/images/icon/logoCCDV.png" alt=""
                    style="width:150px;height:56px"></div>
        </div>
    </div>
    </div>
</body>

</html>
<!-- END: main -->
<!-- BEGIN: main -->

<style type="text/css">
    .full input {
        width: 100% !important;
    }
</style>
<form class="form-inline" action="{NV_BASE_ADMINURL}index.php" method="post">
    <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
    <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover full">
            <colgroup>
                <col style="width:380px" />
                <col />
            </colgroup>
            <tbody>
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            Cấu hình chung
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Cách hiển thị trang chủ
                        </strong>
                    </td>
                    <td>
                        <select class="form-control" name="inhome_viewcat">
                            <!-- BEGIN: inhome_viewcat -->
                            <option value="{inhome_viewcat.id}" {inhome_viewcat.selected}>{inhome_viewcat.text}</option>
                            <!-- END: inhome_viewcat -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Số lượng sản phẩm được đẩy trong một khoảng thời gian
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.number_product_push}"
                            name="number_product_push" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Khoảng thời gian được đẩy sản phẩm tiếp theo
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.time_push_product}"
                            name="time_push_product" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Số sản phẩm trên 1 trang
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.number_product}" name="number_product" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Tiền tố sản phẩm
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.raw_product_prefix}"
                            name="raw_product_prefix" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Tiền tố đơn hàng
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.raw_order_prefix}"
                            name="raw_order_prefix" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Tiền tố nhập kho sản phẩm
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.raw_import_product_prefix}"
                            name="raw_import_product_prefix" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Phần trăm chiết khấu thanh toán đơn hàng (%)
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.percent_of_order_payment_discount}"
                            name="percent_of_order_payment_discount" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Phần trăm phí vận chuyển (%)
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.percent_of_ship}" name="percent_of_ship" />
                    </td>
                </tr>


                <tr>
                    <td>
                        <strong>
                            Chọn tỉnh thành ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <select id="province_id" name="province_ecng" required="required" class="form-control">
                            <!-- BEGIN: province_id -->
                            <option value="{STATUS.provinceid}" {STATUS.selected}>
                                {STATUS.title}
                            </option>
                            <!-- END: province_id -->
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Chọn quận, huyện ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <select id="district_id" name="district_ecng" required="required" class="form-control" {DIS}>
                            <!-- BEGIN: district_id -->
                            <option value="{STATUS.districtid}" {STATUS.selected}>
                                {STATUS.title}
                            </option>
                            <!-- END: district_id -->
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Chọn phường, xã ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <select id="ward_id" name="ward_ecng" required="required" class="form-control" {DIS}>
                            <!-- BEGIN: ward_id -->
                            <option value="{STATUS.wardid}" {STATUS.selected}>
                                {STATUS.title}
                            </option>
                            <!-- END: ward_id -->
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Địa chỉ cụ thể kho ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="address_ecng" placeholder="Nhập địa chỉ" value="{DATA.address_ecng}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Tên kho ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="name_ecng" placeholder="Nhập Tên kho ECNG" value="{DATA.name_ecng}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Số điện thoại kho ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="phone_ecng" placeholder="Nhập Số điện thoại" value="{DATA.phone_ecng}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Email kho ECNG (<span class="text_red">*</span>)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="email_ecng" placeholder="Nhập Email kho ECNG" value="{DATA.email_ecng}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Bảo hiểm hàng hóa (%)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="insurance" value="{DATA.insurance}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Voucher % giảm tối đa
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="voucher_maximum_percent" value="{DATA.voucher_maximum_percent}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Quỹ trẻ em
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="children_fund" value="{DATA.children_fund}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Email nhận khiếu nại (Khách chưa nhận hàng)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="email_get_not_received" value="{DATA.email_get_not_received}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Email nhận khiếu nại (Seller giao hàng thất bại)
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="email_order_seller_delivery_failed"
                            value="{DATA.email_order_seller_delivery_failed}" class="form-control bg-none border-0 "
                            required="required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Email nhận thông tin Seller đăng ký bán hàng
                        </strong>
                    </td>
                    <td>
                        <input type="text" name="email_seller_register" value="{DATA.email_seller_register}"
                            class="form-control bg-none border-0 " required="required">
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>
                            Điều khoản sử dụng & Quy chế hoạt động
                        </strong>
                    </td>
                    <td>
                        {DATA.terms_of_use}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            VNPost
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Tên đăng nhập
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.username_vnpost}" name="username_vnpost" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Mật khẩu
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="password" value="{DATA.password_vnpost}"
                            name="password_vnpost" />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            Viettel Post
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Tên đăng nhập
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.username_vtpost}" name="username_vtpost" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Mật khẩu
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.password_vtpost}" name="password_vtpost" />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            GHN
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Shop_id (Giao lại đơn)
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.shop_id_ghn}" name="shop_id_ghn" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Phí khai giá tối đa
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.max_price_ghn}" name="max_price_ghn" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Mã token
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="password" value="{DATA.token_ghn}" name="token_ghn" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            <p>Địa chỉ kết nối </p>
                            <p>(live: https://online-gateway.ghn.vn/shiip/public-api)</p>
                            <p>(test: https://dev-online-gateway.ghn.vn/shiip/public-api)</p>
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.url_ghn}" name="url_ghn" />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            Ahamove
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Mã Api Key
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="password" value="{DATA.token_ahamove}" name="token_ahamove" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            <p>Địa chỉ kết nối </p>
                            <p>(live: https://api.ahamove.com)</p>
                            <p>(test: https://apistg.ahamove.com)</p>
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.url_ahamove}" name="url_ahamove" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            GHTK
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Mã token
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="password" value="{DATA.token_ghtk}" name="token_ghtk" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            <p>Địa chỉ kết nối </p>
                            <p>(test: https://services.ghtklab.com)</p>
                            <p>(live: https://services.giaohangtietkiem.vn)</p>
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="text" value="{DATA.url_ghtk}" name="url_ghtk" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            VNPAY
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Mã website
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="password" value="{DATA.website_code_vnpay}"
                            name="website_code_vnpay" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Chuỗi bí mật tạo checksum (VNPAY)
                        </strong>
                    </td>
                    <td>
                        <input class="form-control" type="password" value="{DATA.checksum_vnpay}"
                            name="checksum_vnpay" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Chọn giao diện gửi mail cho khách hàng
                        </strong>
                    </td>
                    <td>
                        <p>
                            <select class="form-control" onchange="get_form()" id="form_khach" name="form_khach">
                                <!-- BEGIN: form_khach -->
                                <option value="{FORM.id}" {FORM.check}>
                                    {FORM.text}
                                </option>
                                <!-- END: form_khach -->
                            </select>
                        </p>
                        <h2 class="review_class text-center" style="font-weight: 600;">

                        </h2>
                        <div class="review" style="padding: 10px;background: #eeeeee;">

                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Chọn giao diện gửi mail cho nhà bán hàng
                        </strong>
                    </td>
                    <td>
                        <p>
                            <select class="form-control" onchange="get_form_nha_ban()" id="form_nha_ban"
                                name="form_nha_ban">
                                <!-- BEGIN: form_nhaban -->
                                <option value="{FORM1.id}" {FORM1.check}>
                                    {FORM1.text}
                                </option>
                                <!-- END: form_nhaban -->
                            </select>
                        </p>
                        <h2 class="review_class_nha_ban text-center" style="font-weight: 600;">

                        </h2>
                        <div class="review_nha_ban" style="padding: 10px;background: #eeeeee;">

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript">
            $('#province_id').select2({
                placeholder: 'Chọn tỉnh thành',
                ajax: {
                    url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' +
                        nv_fc_variable + '=address&mod=province_id',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            q: params.term
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on('change', function(e) {
                document.getElementById("district_id").disabled = false;
                document.getElementById("ward_id").disabled = false;
                var province_id = $('#province_id').val();
                $('#district_id').empty();
                $('#ward_id').empty();
                $('#district_id').select2({
                    placeholder: 'Chọn quận huyện',
                    ajax: {
                        url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name +
                            '&' + nv_fc_variable + '=address&mod=district_id&province_id=' +
                            province_id,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var query = {
                                q: params.term
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                }).on('change', function(e) {
                    var district_id = $('#district_id').val();
                    $('#ward_id').empty();
                    $('#ward_id').select2({
                        placeholder: 'Chọn xã phường',
                        ajax: {
                            url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' +
                                nv_module_name + '&' + nv_fc_variable +
                                '=address&mod=ward_id&district_id=' + district_id,
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                var query = {
                                    q: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            },
                            cache: true
                        }
                    })
                })
            });

            $('#district_id').select2({

            }).on('change', function(e) {
                var district_id = $('#district_id').val();
                $('#ward_id').empty();
                $('#ward_id').select2({
                    placeholder: 'Chọn xã phường',
                    ajax: {
                        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=ward_id&district_id=' + district_id,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var query = {
                                q: params.term
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                })
            })

            $(document).ready(function() {
                get_form();
                get_form_nha_ban();
            });

            function get_form() {
                var id = $('#form_khach').val();
                $.ajax({
                    type: 'POST',
                    url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=getform&id=' + id,
                    success: function(res) {
                        res2 = JSON.parse(res);
                        if (res2.status == "OK") {
                            $('.review').html(res2.text);
                            $('.review_class').html('Xem trước');

                        } else {
                            alert('Có lỗi xảy ra!');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });


            }

            function get_form_nha_ban() {
                var id = $('#form_nha_ban').val();
                $.ajax({
                    type: 'POST',
                    url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=getformnhaban&id=' + id,
                    success: function(res) {
                        res2 = JSON.parse(res);
                        if (res2.status == "OK") {
                            $('.review_nha_ban').html(res2.text);
                            $('.review_class_nha_ban').html('Xem trước');

                        } else {
                            alert('Có lỗi xảy ra!');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });


            }
        </script>
        <div style="text-align: center;">
            <input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" id="save_214" />

            <input type="hidden" value="1" name="saveconfig" />
        </div>
    </div>
</form>
<script type="text/javascript">
    $('#save_214').click(function() {
        alert("Lưu thành công");
    });
</script>

<style>
    .select2 {
        width: 100% !important;
    }

    select#ward_id {
        width: 100%;
    }
</style>
<!-- END: main -->
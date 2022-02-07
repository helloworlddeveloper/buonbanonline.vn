<!-- BEGIN: main -->
<div class="mt-3">
    <form id="form_tracking" method="get">
        <div class="row p-3 rounded">
            <div class="col-9 mb-3">
                <div class="py-1 bg-light rounded rounded-lg shadow-sm mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i
                                    class="fa fa-search"></i></button>
                        </div>
                        <input type="text" name="q" value="{Q}" placeholder="Tìm kiếm theo"
                            aria-describedby="button-addon2"
                            class="form-control border-0 bg-light input_search_order" />
                    </div>
                </div>
            </div>

            <div class="col-2 pt-1">
                <input type='submit' class="btn_ecng p-2 mr-3" value="Tìm kiếm" />
            </div>
        </div>
    </form>
</div>


<div id="tracking_order" class="tabcontent rounded" style="min-height: 400px">
    <div id="all" class="active ">
        <div class="content_detail_order">
            <div class="info_order bg_white p-3">
                <div class=" d-flex justify-content-between">
                    <p class="fs_18 "><span class="text_gray_color">Chi tiết đơn hàng ECNG0000646</span></p>
                    <p>Ngày mua: 123</p>
                </div>
                <div class="primary_text">Bạn vừa ủng hộ <span style="color:#1358B9">{children_fund}</span> tổng giá trị
                    đơn hàng này vào quỹ “ <span class="secondary_text">QUỸ BẢO TRỢ TRẺ EM VIỆT NAM</span> ”</div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="status_vnpost">
                            <ul class="timeline">
                                <li>
                                    <span class="secondary_text">{LOOP_TRACUU.addtime}:</span>
                                    <span class="pt-2">{LOOP_TRACUU.status_vnpost}</span>
                                </li>
                                <li>
                                    <span class="secondary_text">{LOOP_GHN.status_ghn}</span>
                                    <span class="float-right">{LOOP_GHN.time_add}</span>
                                    <p class="pt-2">{LOOP_GHN.warehouse} {LOOP_GHN.status_error_ghn}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pb-2">Địa chỉ nhận hàng</div>
                <div class="row px-2">
                    <div class="col-md-7 p-4 border">
                        <p><span class="pr-2">Tên: </span> {info_order.order_name}</p>
                        <p><span class="pr-2">Địa chỉ: </span> {info_order.address}</p>
                        <p class="mb-0"><span class="pr-2">Điện thoại: </span> {info_order.phone}</p>
                    </div>
                    <div class="col-md-5 p-4 border">
                        <p class="">Phương Thức Thanh Toán: {info_order.status_payment_vnpay_title}</p>
                        <p>Giao Hàng: {info_order.transporters_name} {info_order.shipping_code}</p>
                        <p>Phí vận chuyển: {info_order.fee_transport}đ</p>

                    </div>
                </div>
            </div>
            <div class="viewOrder bg_white px-3 my-3">
                <div class="viewOrder_header d-flex justify-content-between border-bottom  py-2 mb-3">
                    <div class="viewOrder_header_shop">
                        <a href="{info_store.alias_shop}">
                            <img src="{info_store.avatar_image}" class="rounded-circle"
                                style="width: 25px; height: 25px;object-fit: contain;" alt="">
                            <span class="ml-3"> {info_store.company_name}</span>
                        </a>
                    </div>
                </div>
                <div class="history_product border-bottom pb-2">
                    <div class="row d-flex align-items-center py-2">
                        <div class="col-md-2 col-xl-1">
                            <a class="width_80 beauty_img" href="{VIEW.alias_product}"><img src="{VIEW.image}"
                                    class="max_w_h" alt=""></a>
                        </div>
                        <div class="col-md-7">
                            <div class="cartName px-3">
                                <a href="{VIEW.alias_product}">
                                    <p class="mb-0">{VIEW.name_product}</p>
                                </a>
                                <p class="text_gray_color mb-0">{VIEW.name_group}</p>
                            </div>
                        </div>
                        <div class="col-md-1 col-xl-2 text-center">
                            x {VIEW.quantity}
                        </div>
                        <div class="col-md-2 secondary_text text-center">{VIEW.price}đ</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 offset-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text_gray_color">Tạm tính</td>
                                    <td class="float-right">{tamtinh}đ</td>
                                </tr>
                                <tr>
                                    <td class="text_gray_color">Phí vận chuyển</td>
                                    <td class="float-right">{info_order.fee_transport}đ</td>
                                </tr>
                                <tr id="row_voucher">
                                    <td class="text_gray_color">Voucher</td>
                                    <td class="float-right" id="tongvoucher">
                                        {info_order.voucher_price}đ
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0">Tổng thanh toán</td>
                                    <td class="float-right fs_20 secondary_text mb-0">
                                        {info_order.total}đ
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    $(document).ready(function() {
        $("form").submit(function(e) {
            var q = $('input[name=q]').val();
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name +
                    '&' + nv_fc_variable +
                    '=tracking-order&mod=tracking_order',
                data: $('form#form_tracking').serialize(),
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(res) {
                    $('#tab_product').html(res);
                },
                error: function(xhr, ajaxOptions, thrownError) {

                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr
                        .responseText);
                }
            });

        });

    });
</script>
<!-- END: main -->
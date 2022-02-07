/**
 * @Project TMS HOLDINGS
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 2' + id_next +' Dec 2020 09:08:' + id_next +'9 GMT
 */

$('select.select2').select2();



//xử lý đơn hàng khách chưa nhận được - lên đơn lại
function renew_order_not_received_khach(id) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order_not_received&renew_order_not_received=1',
        dataType: 'json',
        data: {
            order_id: id
        },
        beforeSend: function() {
            $('button.btn_ecng').prop('disabled', true);
        },
        complete: function() {
            $('button.btn_ecng').prop('disabled', false);
        },
        success: function(res) {

            if (res.status == 'OK') {

                alert('Lên lại đơn hàng thành công!');
            } else {
                alert('Lên lại đơn hàng thất bại!');
            }

            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//xử lý đơn hàng khách chưa nhận được - hủy đơn
function cancel_order_not_received_khach(id) {
    var content = prompt("Lý do hủy", '');
    if (content != null) {
        if (content == '') {
            alert('Vui lòng nhập lý do hủy');
        } else {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order_not_received&cancel_order_not_received=1',
                dataType: 'json',
                data: {
                    order_id: id,
                    content: content
                },
                beforeSend: function() {
                    $('button.btn_ecng').prop('disabled', true);
                },
                complete: function() {
                    $('button.btn_ecng').prop('disabled', false);
                },
                success: function(res) {

                    if (res.status == 'OK') {

                        alert('Hủy đơn hàng thành công!');
                    } else {
                        alert('Hủy đơn hàng thất bại!');
                    }

                    location.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }
}

function shipping(id) {
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=shipping',
        dataType: 'json',
        data: {
            order_id: id
        },
        beforeSend: function() {
            $('button.btn_ecng').prop('disabled', true);
        },
        complete: function() {
            $('button.btn_ecng').prop('disabled', false);
        },
        success: function(res) {

            if (res.status == 'OK') {

                alert('Cập nhật trạng thái đơn hàng thành công!');
            } else {
                alert('Cập nhật trạng thái đơn hàng thất bại!');
            }

            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function delivered(id) {
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=delivered',
        dataType: 'json',
        data: {
            order_id: id
        },
        beforeSend: function() {
            $('button.btn_ecng').prop('disabled', true);
        },
        complete: function() {
            $('button.btn_ecng').prop('disabled', false);
        },
        success: function(res) {

            if (res.status == 'OK') {

                alert('Cập nhật trạng thái đơn hàng thành công!');
            } else {
                alert('Cập nhật trạng thái đơn hàng thất bại!');
            }

            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function popup_vanchuyen(id, store_id, transporters_id) {
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=listorder&popup_vanchuyen=1',
        data: {
            'order_id': id,
            store_id: store_id
        },
        success: function(res) {
            $("#idmodals .modal-content").html(res);
            $("#idmodals").modal({
                backdrop: "static"
            });
            if (transporters_id == 4 || transporters_id == 5) {
                check_khaigia(id);
            } else if (transporters_id == 3) {
                check_khaigia_ghn(id, store_id);
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function check_khaigia_ghn(id, store_id) {
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=check_khaigia_ghn',

        dataType: 'json',
        data: {
            order_id: id,
            store_id: store_id
        },
        beforeSend: function() {

        },
        complete: function() {

        },
        success: function(res) {

            $('#check_khaigia').html('Phí khai giá: ' + format_number(res.insurance_fee));
            if (res.ship > 0) {
                $('#check_ship').html('Phí ship: ' + format_number(res.ship));
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

}

function sendghn(id, store_id) {

    var hinhthucthugom = $("input[name='hinhthucthugom']:checked").val();
    var khaigia = $("input[name='khaigia']").is(':checked');

    if (khaigia == true) {
        khaigia = 1;
    } else {
        khaigia = 0;
    }
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=send_ghn',
        dataType: 'json',
        data: {
            order_id: id,
            store_id: store_id,
            hinhthucthugom: hinhthucthugom,
            khaigia: khaigia
        },
        beforeSend: function() {
            $('button.btn_ecng').prop('disabled', true);
        },
        complete: function() {
            $('button.btn_ecng').prop('disabled', false);
        },
        success: function(res) {
            if (res.status == 'OK') {
                alert('Gửi hàng thành công!');
            } else {
                alert('Gửi hàng thất bại!');
            }

            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function ghn_cancel(id, store_id) {
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=ghn_cancel',
        dataType: 'json',
        data: {
            order_id: id,
            store_id: store_id
        },
        beforeSend: function() {
            $('button.btn_ecng').prop('disabled', true);
        },
        complete: function() {
            $('button.btn_ecng').prop('disabled', false);
        },
        success: function(res) {
            if (res.status == 'OK') {
                alert('Hủy gửi hàng thành công!');
            } else {
                alert('Hủy gửi hàng thất bại!');
            }

            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}


function view_popup_vanchuyen(id, store_id) {
    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=listorder&view_popup_vanchuyen=1',
        data: {
            'order_id': id,
            store_id: store_id
        },
        success: function(res) {
            $("#idmodals .modal-content").html(res);
            $("#idmodals").modal({
                backdrop: "static"
            });

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
        return false;
    return true;
}

function loading() {
    var $elie = $(".icon_loading");
    rotate(0);

    function rotate(degree) {
        $elie.css({
            WebkitTransform: 'rotate(' + degree + 'deg)'
        });
        $elie.css({
            '-moz-transform': 'rotate(' + degree + 'deg)'
        });
        setTimeout(
            function() {
                rotate(++degree);
            },
            10
        );
    }
    $(".no_load").addClass("load");
    $(".no_load").removeClass("no_load");
}

function removeloading() {
    $(".load").addClass("no_load");
    $(".load").removeClass("load");

}

function sendahamomve(id, module) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + module + '&mod=send_ahamove',
        data: {
            'order_id': id
        },
        success: function(res) {
            res2 = JSON.parse(res);
            console.log(res2);
            if (res2.status == 'OK') {
                alert('Gửi hàng thành công')
                location.reload();
            } else {
                alert(res2.mess)
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function sendghtk(id, module) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + module + '&mod=send_ghtk',
        data: {
            'order_id': id
        },
        success: function(res) {
            res2 = JSON.parse(res);
            alert('Gửi hàng thành công')
            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function sendviettelpost(id, module) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + module + '&mod=send_viettelpost',
        data: {
            'order_id': id
        },
        success: function(res) {
            res2 = JSON.parse(res);
            alert('Gửi hàng thành công')
            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function sendvnpost(id, module) {

    $.ajax({
        type: 'GET',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + module + '&mod=send_vnpost',
        dataType: 'json',
        data: {
            'order_id': id
        },
        beforeSend: function() {
            $('button.btn_ecng').prop('disabled', true);
            $('#loading_modal').modal('show');
        },
        complete: function() {
            $('button.btn_ecng').prop('disabled', false);
            $('#loading_modal').modal('hidden');
        },
        success: function(res) {
            console.log(res);
            if (res.status == 'OK') {
                alert('Gửi hàng thành công!');
            } else {
                alert('Gửi hàng thật bại!');
            }

            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function remove_warehouse_list(id) {
    $('#group_list_' + id).remove();
}

function plus_money(id, money, store_id) {
    var check = confirm("Bạn có chắc là sẽ thanh toàn tiền hàng " + format_number(money) + ' cho chủ shop không?');
    if (check) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=plus_money&nocache=' + new Date().getTime(), '&order_id=' + id + '&money=' + money + '&store_id=' + store_id, function(res) {
            res2 = JSON.parse(res);
            if (res2.status == 'OK') {
                alert('Thanh toán tiền hàng thành công');
                location.reload();
            }
        });
    }
}

// function hoàn tiền đơn hàng khi đã hủy và kh đã thanh toán đơn hàng
function order_hoantien(order_id) {
    var check = confirm("Bạn có chắc là hoàn tiền đơn hàng không?");
    if (check) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), '&order_id=' + order_id + '&mod=order_hoantien', function(res) {
            res2 = JSON.parse(res);
            if (res2.status == 'OK') {
                alert(res2.mess);
                location.reload();
            } else {
                alert(res2.mess);
            }
        });
    }
}

function change_status_cancel(order_id) {
    var content = prompt("Lý do hủy", '');
    if (content != null) {
        if (content == '') {
            alert('Vui lòng nhập lý do hủy');
        } else {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&order_id=' + order_id + '&mod=change_status_cancel' + '&content=' + content, function(res) {
                res2 = JSON.parse(res);
                if (res2.status == 'OK') {
                    alert('Hủy thành công');
                    location.reload();
                } else {
                    alert('Hủy đơn hàng thất bại!');
                }
            });
        }
    }
}

function change_status_cancel_tranpost_ahamove(order_id, status_new, status_old) {
    var content = prompt("Lý do hủy", '');
    if (content != null) {
        if (content == '') {
            alert('Vui lòng nhập lý do hủy');
        } else {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), '&order_id=' + order_id + '&status_new=' + status_new + '&mod=change_status_cancel_tranpost_ahamove' + '&status_old=' + status_old + '&content=' + content, function(res) {
                res2 = JSON.parse(res);
                if (res2.status == 'OK') {
                    alert('Hủy thành công');
                    location.reload();
                }
            });
        }
    }
}


// xử lý hủy đơn vận chuyển vnpost vnpost_cancel
function vnpost_cancel(order_id) {
    var check = confirm("Bạn có chắc là hủy đơn vận chuyển VNPOST không? ");
    if (check) {
        $.get(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), '&order_id=' + order_id + '&mod=vnpost_cancel', function(res) {
            res2 = JSON.parse(res);
            console.log(res2);
            if (res2.status == 'OK') {
                alert(res2.mess);
                location.reload();
            } else {
                alert(res2.mess);
            }
        });
    }
}


function change_status_success(order_id, status_new, status_old) {
    var check = confirm("Bạn có chắc là sẽ chuyển trạng thái đơn hàng này sang thành công không? ");
    if (check) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), '&order_id=' + order_id + '&status_new=' + status_new + '&mod=change_status_success' + '&status_old=' + status_old, function(res) {
            res2 = JSON.parse(res);
            if (res2.status == 'OK') {
                alert('Chuyển trạng thái thành công');
                location.reload();
            }
        });
    }
}

function change_status(order_id, status_new, status_old) {
    if (status_old == 0) {
        var check = confirm("Bạn có chắc là sẽ chuyển trạng thái đơn hàng này sang đã xác nhận không? ");
    }
    if (check) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), '&order_id=' + order_id + '&status_new=' + status_new + '&mod=change_status' + '&status_old=' + status_old, function(res) {
            res2 = JSON.parse(res);
            if (res2.status == 'OK') {
                alert('Chuyển trạng thái thành công');
                location.reload();
            } else {
                alert('Chuyển trạng thái thất bại. Đơn hàng chưa thanh toán');
            }
        });
    }
}

function FormatNumber(str) {

    var strTemp = GetNumber(str);
    if (strTemp.length <= 3) {
        return strTemp;
    }

    strResult = "";
    for (var i = 0; i < strTemp.length; i++) {
        strTemp = strTemp.replace(",", "");
    }

    var m = strTemp.lastIndexOf(".");
    if (m == -1) {
        for (var i = strTemp.length; i >= 0; i--) {
            if (strResult.length > 0 && (strTemp.length - i - 1) % 3 == 0) {
                strResult = "," + strResult;
            }
            strResult = strTemp.substring(i, i + 1) + strResult;
        }
    } else {
        var strphannguyen = strTemp.substring(0, strTemp.lastIndexOf("."));
        var strphanthapphan = strTemp.substring(strTemp.lastIndexOf("."), strTemp.length);
        var tam = 0;
        for (var i = strphannguyen.length; i >= 0; i--) {

            if (strResult.length > 0 && tam == 4) {
                strResult = "," + strResult;
                tam = 1;
            }

            strResult = strphannguyen.substring(i, i + 1) + strResult;
            tam = tam + 1;
        }
        strResult = strResult + strphanthapphan;
    }
    return strResult;
}

function GetNumber(str) {
    var count = 0;
    for (var i = 0; i < str.length; i++) {
        var temp = str.substring(i, i + 1);
        if (!(temp == "," || temp == "." || (temp >= 0 && temp <= 9))) {
            return str.substring(0, i);
        }
        if (temp == " ") {
            return str.substring(0, i);
        }

        if (temp == ".") {
            if (count > 0) {
                return str.substring(0, ipubl_date);
            }
            count++;
        }
    }
    return str;
}

function IsNumberInt(str) {
    for (var i = 0; i < str.length; i++) {
        var temp = str.substring(i, i + 1);
        if (!(temp == "." || (temp >= 0 && temp <= 9))) {
            alert(inputnumber);
            return str.substring(0, i);
        }
        if (temp == ",") {
            return str.substring(0, i);
        }
    }
    return str;
}


function remove_other_image(id) {
    $('#other_image_tr_' + id).remove();
    other_image.splice(Number(id) - 1, 1);
}

function remove_group_list(id) {
    $('#group_' + id).remove();
    group_list.splice(Number(id) - 1, 1);
}

function format_number(amount) {
    var delimiter = ","; // replace comma if desired
    var i = parseInt(amount);
    if (isNaN(i)) {
        return '';
    }
    var minus = '';
    if (i < 0) {
        minus = '-';
    }
    i = Math.abs(i);
    var n = new String(i);
    var a = [];
    while (n.length > 3) {
        var nn = n.substr(n.length - 3);
        a.unshift(nn);
        n = n.substr(0, n.length - 3);
    }
    if (n.length > 0) {
        a.unshift(n);
    }
    amount = a.join(delimiter);
    amount = minus + amount;
    return amount;
}

function generateCardNo(x) {
    if (!x) {
        x = 16;
    }
    chars = "1234567890";
    no = "";
    for (var i = 0; i < x; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        no += chars.substring(rnum, rnum + 1);
    }
    return no;
}

function nv_chang_cat(catid, mod) {
    var nv_timer = nv_settimeout_disable('id_' + mod + '_' + catid, 5000);
    var new_vid = $('#id_' + mod + '_' + catid).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' +
        new Date().getTime(), 'id=' + catid + '&mod=' + mod + '&new_vid=' + new_vid,
        function(res) {
            res2 = JSON.parse(res)
            if (res2.status != 'OK') {
                alert(nv_is_change_act_confirm[2]);
                clearTimeout(nv_timer);
            } else {
                clearTimeout(nv_timer);
                location.reload();
            }


        });
    return;
}

//address
$('.province_id').select2({
    placeholder: "Mời bạn chọn thành phố",
    ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
            '=ajax&mod=get_province',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            var query = {
                q: params.term
            }
            return query;
        },
        method: 'post',
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
})
$('.district_id').select2({
    placeholder: "Mời bạn chọn quận"
})
$('.ward_id').select2({
    placeholder: "Mời bạn chọn phường xã"
})
$('.branch_id').select2({
    placeholder: "Mời bạn chọn chi nhánh"
})
$('select[name=province_id]').change(function() {
    var provinceid = $(this).find('option:selected').val();
    $('.district_id').empty();
    $('.district_id').select2({
        placeholder: "Mời bạn chọn quận",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_district',
            dataType: 'json',
            delay: 250,
            data: function(params) {

                var query = {
                    q: params.term,
                    provinceid: provinceid
                }

                return query;
            },
            method: 'post',
            processResults: function(data) {

                return {
                    results: data
                };
            },
            cache: true
        }
    });

})
$('select[name=district_id]').change(function() {
        var districtid = $(this).find('option:selected').val();

        $('.ward_id').empty();
        $('.ward_id').select2({
            placeholder: "Mời bạn chọn phường xã",
            ajax: {
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                    '=ajax&mod=get_ward',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var query = {
                        q: params.term,
                        districtid: districtid
                    }
                    return query;
                },
                method: 'post',
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

    })
    // thông tin nhà bán
$('.province_id_shop').select2({
    placeholder: "Mời bạn chọn thành phố",
    ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
            '=ajax&mod=get_province',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            var query = {
                q: params.term
            }
            return query;
        },
        method: 'post',
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
})
$('.district_id_shop').select2({
    placeholder: "Mời bạn chọn quận"
})
$('.ward_id_shop').select2({
    placeholder: "Mời bạn chọn phường xã"
})
$('.branch_id').select2({
    placeholder: "Mời bạn chọn chi nhánh"
})
$('select[name=province_id_shop]').change(function() {
    var provinceid = $(this).find('option:selected').val();
    $('.district_id_shop').empty();
    $('.district_id_shop').select2({
        placeholder: "Mời bạn chọn quận",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_district',
            dataType: 'json',
            delay: 250,
            data: function(params) {

                var query = {
                    q: params.term,
                    provinceid: provinceid
                }

                return query;
            },
            method: 'post',
            processResults: function(data) {

                return {
                    results: data
                };
            },
            cache: true
        }
    });

})
$('select[name=district_id_shop]').change(function() {
        var districtid = $(this).find('option:selected').val();

        $('.ward_id_shop').empty();
        $('.ward_id_shop').select2({
            placeholder: "Mời bạn chọn phường xã",
            ajax: {
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                    '=ajax&mod=get_ward',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var query = {
                        q: params.term,
                        districtid: districtid
                    }
                    return query;
                },
                method: 'post',
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

    })
    //address

$('select[name=bank_id]').change(function() {
    var bank_id = $(this).find('option:selected').val();

    $('.branch_id').empty();
    $('.branch_id').select2({
        placeholder: "Mời bạn chọn chi nhánh",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_branch',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    q: params.term,
                    bank_id: bank_id
                }
                return query;
            },
            method: 'post',
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

})

function add_warehouse(validate_name_warehouse, validate_name_send, validate_phone, validate_province_id, validate_district_id, validate_ward_id, validate_address) {
    var id_next = warehouse[warehouse.length - 1]['id'] + 1
    $('.warehouse').append('<tr id="warehouse_list_' + id_next + '">' +
        '<td>' +
        '<input class="form-control hidden" type="text" name="store_list[' + id_next + '][warehouse_id]" value="0" /><input class="form-control" type="text" name="store_list[' + id_next + '][name_warehouse]" value="" required="required" placeholder="Tên kho hàng" onclick="setCustomValidity(\'' + '\')"  oninput="setCustomValidity(\'' + '\')" />' +
        '</td>' +
        '<td>' +
        '<input class="form-control" type="text" name="store_list[' + id_next + '][name_send]" placeholder="Tên người gởi" value="" required="required" pattern=".+" oninvalid="setCustomValidity(\'' + validate_name_send + '\')" oninput="setCustomValidity(\'' + '\')" />' +
        '</td>' +
        '<td>' +
        '<input class="form-control" type="tel" name="store_list[' + id_next + '][phone_send]" placeholder="Số điện thoại người gởi" value="" required="required" pattern="^\\d{4}-\\d{3}-\\d{3}$" oninput="setCustomValidity(\'' + '\')" oninvalid="setCustomValidity(\'' + validate_phone + '\')" />' +
        '</td>' +
        '<td>' +
        '<div class="col-md-6">' +
        '<select class="form-control province_id_' + id_next + '"  required oninvalid="setCustomValidity(\'' + validate_province_id + '\')" oninput="setCustomValidity(\'' + '\')" onchange="change_province(' + id_next + ')" name="store_list[' + id_next + '][province_id]" ></select>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<select class="form-control district_id_' + id_next + '" required oninvalid="setCustomValidity("' + validate_district_id + '")" oninput="setCustomValidity(\'' + '\')" onchange="change_district(' + id_next + ')" name="store_list[' + id_next + '][district_id]"></select>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<select class="form-control ward_id_' + id_next + '" required oninvalid="setCustomValidity(\'' + validate_ward_id + '\')" oninput="setCustomValidity(\'' + '\')"  onchange="change_ward(' + id_next + ')"  name="store_list[' + id_next + '][ward_id]"></select>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<input class="form-control address_' + id_next + '" type="text" name="store_list[' + id_next + '][address]" value="" placeholder="Địa chỉ ngắn gọn" onchange="change_address(' + id_next + ')"   required="required" pattern=".+" oninvalid="setCustomValidity(\'' + validate_address + '\')" oninput="setCustomValidity(\'' + '\')" />' +
        '<input hidden name="store_list[' + id_next + '][lat]" value=""  id="lat_' + id_next + '" /><input hidden value=""  name="store_list[' + id_next + '][lng]" id="lng_' + id_next + '" />' +
        '</div>' +
        '</td>' +
        '<td><button type="button" class="btn btn-primary" onclick="remove_warehouse(' + id_next + ')">Xóa</button></td></tr><script type="text/javascript">location_warehouse_add(' + id_next + '); <\/script>')
    warehouse.push({
        "id": id_next
    })
}

function remove_warehouse(id) {
    $('#warehouse_list_' + id).remove();
    warehouse.splice(Number(id) - 1, 1);
}

function location_warehouse_add(id) {
    $('.province_id_' + id).select2({
        placeholder: "Mời bạn chọn thành phố",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_province',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    q: params.term
                }
                return query;
            },
            method: 'post',
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    })

    $('.district_id_' + id).select2({
        placeholder: "Mời bạn chọn quận"
    })

    $('.ward_id_' + id).select2({
        placeholder: "Mời bạn chọn phường xã"
    })
}
var address_full = ''

function initMap() {}

function change_ward(id) {
    var province_name = $('.province_id_' + id).find('option:selected').text();
    var district_name = $('.district_id_' + id).find('option:selected').text();
    var ward_name = $('.ward_id_' + id).find('option:selected').text();
    var address = $('.address_' + id).val();
    if (address != '') {
        address_full = address + ', ' + ward_name + ',' + district_name + ',' + province_name
    } else {
        address_full = ward_name + ',' + district_name + ',' + province_name
    }

}

function change_address(id) {
    var province_name = $('.province_id_' + id).find('option:selected').text();
    var district_name = $('.district_id_' + id).find('option:selected').text();
    var ward_name = $('.ward_id_' + id).find('option:selected').text();
    var address = $('.address_' + id).val();
}

function change_province(id) {
    var provinceid = $('.province_id_' + id).find('option:selected').val();
    $('.district_id_' + id).empty();
    $('.district_id_' + id).select2({
        placeholder: "Mời bạn chọn quận",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_district',
            dataType: 'json',
            delay: 250,
            data: function(params) {

                var query = {
                    q: params.term,
                    provinceid: provinceid
                }

                return query;
            },
            method: 'post',
            processResults: function(data) {

                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function change_district(id) {
    var districtid = $('.district_id_' + id).find('option:selected').val();

    $('.ward_id_' + id).empty();
    $('.ward_id_' + id).select2({
        placeholder: "Mời bạn chọn phường xã",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_ward',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    q: params.term,
                    districtid: districtid
                }
                return query;
            },
            method: 'post',
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function change_district(id) {
    var districtid = $('.district_id_' + id).find('option:selected').val();

    $('.ward_id_' + id).empty();
    $('.ward_id_' + id).select2({
        placeholder: "Mời bạn chọn phường xã",
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=ajax&mod=get_ward',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                var query = {
                    q: params.term,
                    districtid: districtid
                }
                return query;
            },
            method: 'post',
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function nv_chang_pays(payid, object, url_change, url_back) {
    var value = $(object).val();
    $.ajax({
        type: 'POST',
        url: url_change,
        data: 'oid=' + payid + '&w=' + value,
        success: function(data) {
            window.location = url_back;
        }
    });
    return;
}
function ChangeDefault(payid, object, url_setdefault, url_back) {
    var value = $(object).val();
    $.ajax({
        type: 'POST',
        url: url_setdefault,
        data: 'oid=' + payid + '&w=' + value,
        success: function(data) {
            window.location = url_back;
        }
    });
    return;
}

function ChangeActive(idobject, url_active) {
    var id = $(idobject).attr('id');
    $.ajax({
        type: 'POST',
        url: url_active,
        data: 'id=' + id,
        success: function(data) {
            alert(data);
        }
    });
}
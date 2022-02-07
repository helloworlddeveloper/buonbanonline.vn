/**
 * @Project WALLET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2018 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Friday, March 9, 2018 6:24:54 AM
 */

function nv_check_pay_send_gamebank(lengthcapchar) {
    var txtCode = $("#txtCode").val();
    var txtSeri = $("#txtSeri").val();
    var capchar_iavim = $("#capchar_iavim").val();
    if (txtCode == "") {
        $("#txtCode").focus();
        return false;
    } else if (txtSeri == "") {
        $("#txtSeri").focus();
        return false;
    } else if (capchar_iavim == "" || capchar_iavim.length < lengthcapchar) {
        $("#capchar_iavim").focus();
        return false;
    }
    return true;
}
function password_wallet(){
	var password_wallet=$('input[name=password_wallet]').val();
	 $.post(
		nv_base_siteurl + 'index.php?nocache=' + new Date().getTime(),
        nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=check_password_wallet&password_wallet=' + password_wallet,
            function(res) {
				res=JSON.parse(res);
				if(res.status=='OK'){
					alert(res.mess)
					location.reload();
				}else{
					alert(res.mess)
				}
			}
	)
}
$(document).ready(function() {
    // Thay đổi loại tiền thì load ra số dư
    $('#exchangeMoneyFrom,#exchangeMoneyTo').change(function() {
        var money1 = $('#exchangeMoneyFrom').val();
        var money2 = $('#exchangeMoneyTo').val();
        $('#mExchangeFBalance,#mExchangeTBalance').html('<i class="fa fa-spin fa-spinner"></i>');
        $('#exchangeMoneyFrom,#exchangeMoneyTo').prop('disabled', true);
        $.post(
            nv_base_siteurl + 'index.php?nocache=' + new Date().getTime(),
            nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=loadinfomoney&money1=' + money1 + '&money2=' + money2,
            function(res) {
                resArray = res.split('|');
                if (resArray.length > 1) {
                    $('#mExchangeFBalance').html(resArray[0]);
                    $('#mExchangeTBalance').html(resArray[1]);
                } else {
                    alert(res);
                    $('#mExchangeFBalance,#mExchangeTBalance').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
                }
                $('#exchangeMoneyFrom,#exchangeMoneyTo').prop('disabled', false);
            }
        );
    });
    $('#exchangeMoneyFrom').trigger('change');
    // Kiểm tra tỉ giá
    $('[name="exchangeCheckRate"]').click(function(e) {
        e.preventDefault();
        var money1 = $('#exchangeMoneyFrom').val();
        var money2 = $('#exchangeMoneyTo').val();
        $.post(
            nv_base_siteurl + 'index.php?nocache=' + new Date().getTime(),
            nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=loadinfomoney&type=checkrate&money1=' + money1 + '&money2=' + money2,
            function(res) {
                modalShow('', '<div class="text-center"><h1 class="text-danger">' + res + '</h1></div>');
            }
        );
    });
    // Tính toán số tiền
    $('[name="exchangeCalculate"]').click(function(e) {
        e.preventDefault();
        var money1 = $('#exchangeMoneyFrom').val();
        var money2 = $('#exchangeMoneyTo').val();
        var totalmoneyexchange = document.getElementById('totalmoneyexchange').value;
        if (isNaN(totalmoneyexchange) || totalmoneyexchange == '') {
            $('#totalmoneyexchange').focus();
            alert(isnumber);
            return;
        }
        $.post(
            nv_base_siteurl + 'index.php?nocache=' + new Date().getTime(),
            nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=loadinfomoney&type=tinhtoan&money1=' + money1 + '&money2=' + money2 + '&totalmoneyexchange=' + totalmoneyexchange,
            function(res) {
                modalShow('', '<div class="text-center"><h1 class="text-danger">' + res + '</h1></div>');
            }
        );
    });
    // Thực hiện quy đổi
    $('[name="exchangeAction"]').click(function(e) {
        e.preventDefault();
        var money1 = $('#exchangeMoneyFrom').val();
        var money2 = $('#exchangeMoneyTo').val();
        var totalmoneyexchange = document.getElementById('totalmoneyexchange').value;
        if (isNaN(totalmoneyexchange) || totalmoneyexchange == '') {
            $('#totalmoneyexchange').focus();
            alert(isnumber);
            return;
        }
        if (confirm(isexchange)) {
            $.post(
                nv_base_siteurl + 'index.php?nocache=' + new Date().getTime(),
                nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=loadinfomoney&type=exchange&money1=' + money1 + '&money2=' + money2 + '&totalmoneyexchange=' + totalmoneyexchange,
                function(res) {
                    if (res != 'OK') {
                        alert(res);
                    } else {
                        alert(okexchange);
                        window.location.href = urlbackexchange;
                    }
                }
            );
        }
    });
    // Xác nhận thanh toán
    $('[data-toggle="wpay"]').click(function(e) {
        if (!confirm($(this).data('msg'))) {
            e.preventDefault();
        }
    });
    // Nạp tiền
    $(document).delegate('[data-toggle="rechargeAmount"]', 'change', function() {
        if ($(this).val() == '0') {
            $('#rechargeMoneyOther').show();
        } else {
            $('#rechargeAmountOther').val('');
            $('#rechargeMoneyOther').hide();
        }
    });
    $('[data-toggle="rechargeMUnit"]').change(function() {
        $('#rechargeAmountOther').val('');
        $('#rechargeMoneyOther').hide();
        var munit = $(this).val();
        $('#rechargeAmountControl').html($('#moneyUnitAmountTmp' + munit).html());
        if ($('#moneyUnitAmountTmp' + munit).data('minimum') == false) {
            $('#rechargeAmountMin').find('strong').html('');
            $('#rechargeAmountMin').hide();
        } else {
            $('#rechargeAmountMin').find('strong').html($('#moneyUnitAmountTmp' + munit).data('minimum') + ' ' + munit);
            $('#rechargeAmountMin').show();
        }
    });
    // Chọn cổng thanh toán => Xem hướng dẫn thực hiện
    $('[data-toggle="paymentsel"]').on('click', function(e) {
        e.preventDefault();
        $('.payment-guide-item').addClass('hidden');
        $('#payment-guide-' + $(this).data('payment')).removeClass('hidden');
        $('html, body').animate({
            scrollTop: ($('#payment-guide-ctn').offset().top) - 10
        }, 200);
    });
    // Đổi các file đính kèm cổng thanh toán ATM
    $('[data-toggle="changeAtmFile"]').on('click', function(e) {
        e.preventDefault();
        $('[name="' + $(this).data('ipt') + '"]').val('');
        $('[name="' + $(this).data('file') + '"]').removeClass('hidden');
        $(this).parent().hide();
    });
    // Reload lại trang
    $('[data-toggle="locreload"]').on('click', function(e) {
        e.preventDefault();
        location.reload();
    });
});

function FormatNumber(str) {
    var strTemp = GetNumber(str);
    if (strTemp.length <= 3)
        return strTemp;
    strResult = "";
    for (var i = 0; i < strTemp.length; i++)
        strTemp = strTemp.replace(",", "");
    var m = strTemp.lastIndexOf(".");
    if (m == -1) {
        for (var i = strTemp.length; i >= 0; i--) {
            if (strResult.length > 0 && (strTemp.length - i - 1) % 3 == 0)
                strResult = "," + strResult;
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
            alert(inputnumber);
            return str.substring(0, i);
        }
        if (temp == " ")
            return str.substring(0, i);
        if (temp == ".") {
            if (count > 0)
                return str.substring(0, ipubl_date);
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

<!-- BEGIN: signed -->
<div class="item_signed">
                <div class="infoUser text-center border-bottom">
                    <img src="{AVATA}" class="rounded-circle" style="width: 48px; height: 48px;" alt="">
                    <p class="fs_18 my-3">{USER.last_name}</p>
                    <button onclick="{URL_LOGOUT}(this);" class="btn_none text_gray_color">Đăng xuất</button>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {active_user} " href="{URL_MODULE}"><i class="fa fa-user-circle-o mr-2" aria-hidden="true"></i>Tài khoản của tôi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-4 {active_address}" href="{ADDRESS}">Địa Chỉ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-4 {active_changepassword}" href="{PASSWORD}">Mật Khẩu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {active_love}" href="{LOVE}"><i class="fa fa-heart mr-2" aria-hidden="true"></i>Sản phẩm yêu thích</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {active_ordercustomer}" href="{HISTORY}"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i>Lịch sử mua hàng</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link {active_repayment}" href="{REPAYMENT}"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i>Thanh toán thất bại</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link {active_complain}" href="{COMPLAIN}"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i>Đơn hàng khiếu nại</a>
                    </li>
                </ul>
</div>
            
<!-- END: signed -->

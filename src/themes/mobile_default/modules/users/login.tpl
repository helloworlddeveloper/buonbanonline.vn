	<!-- BEGIN: main -->

        <header class=" pb-2 bd_b_1 bg_white">
            <div class="login text-center">
                <p class="fs_18 py-3 mb-0">Đăng nhập</p>
            </div>
        </header>
        <section>
			
            <div class="form_login bg_white">
                <div class="text-center ">
                    <img class="mt-3" src="images/logo_dangnhap.png" alt="" style="width: 100px">
                </div>

                <form class="middle px-3" id="login" action="">
                    <div class="input-group mb-4 bd_b_1 h-50 p-1 d-flex align-items-center">
                        <div class="input-group-append border-0 pr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
								<path d="M8 8.63635C10.21 8.63635 12 6.80567 12 4.54544C12 2.28521 10.21 0.454529 8 0.454529C5.79 0.454529 4 2.28521 4 4.54544C4 6.80567 5.79 8.63635 8 8.63635ZM8 10.6818C5.33 10.6818 0 12.0523 0 14.7727V16.8182H16V14.7727C16 12.0523 10.67 10.6818 8 10.6818Z" fill="#E1A208"/>
								</svg>
                        </div>
                        <div class="input_error">
                            <input type="text" placeholder="Email hoặc số điện thoại" name="email" class="form-control bg-none border-0 p-4">
                        </div>
                    </div>
                    <div class="input-group mb-4 bd_b_1 p-1 d-flex align-items-center">
                        <div class="input-group-append border-0 pr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 14 19" fill="none">
								<path d="M12.0002 6.66665H11.1668V4.99998C11.1668 2.69998 9.30016 0.833313 7.00016 0.833313C4.70016 0.833313 2.8335 2.69998 2.8335 4.99998V6.66665H2.00016C1.0835 6.66665 0.333496 7.41665 0.333496 8.33331V16.6666C0.333496 17.5833 1.0835 18.3333 2.00016 18.3333H12.0002C12.9168 18.3333 13.6668 17.5833 13.6668 16.6666V8.33331C13.6668 7.41665 12.9168 6.66665 12.0002 6.66665ZM7.00016 14.1666C6.0835 14.1666 5.3335 13.4166 5.3335 12.5C5.3335 11.5833 6.0835 10.8333 7.00016 10.8333C7.91683 10.8333 8.66683 11.5833 8.66683 12.5C8.66683 13.4166 7.91683 14.1666 7.00016 14.1666ZM9.5835 6.66665H4.41683V4.99998C4.41683 3.57498 5.57516 2.41665 7.00016 2.41665C8.42516 2.41665 9.5835 3.57498 9.5835 4.99998V6.66665Z" fill="#E1A208"/>
								</svg>
                        </div>
                        <div class="input_error">
                            <input type="password" placeholder="Mật khẩu" name="password" class="form-control bg-none border-0 p-4">
                        </div>
                    </div>
					<div class="notifi_error"></div>
                    
                        <button type="submit" class="btn_ecng d-block w-100 p-3">Đăng nhập</button>
                    
                </form>

                <div class="mx-4 mt-4 d-flex justify-content-between pb-4">
                    <a class="text_blue fs_14 secondary_text" href="{REGISTER}">Đăng ký</a>
                    <a class="text_blue fs_14 secondary_text" href="{USER_LOSTPASS}">Quên mật khẩu</a>
                </div>
            </div>
        </section>


<!-- END: main -->

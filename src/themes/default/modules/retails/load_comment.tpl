<!-- BEGIN: main -->
<!-- BEGIN: info_rate_content -->
<div class="tms_review_list">
  <div class="container">
    <div class="col-xs-24 col-sm-8 col-md-6 col-lg-6">
      <div class="tms_review_user">
        <div class="tms_review_img">
          <img src="{INFO_RATE_CONTENT.info_user.photo}" title="{INFO_RATE_CONTENT.info_user.first_name} {INFO_RATE_CONTENT.info_user.last_name}" alt="{INFO_RATE_CONTENT.info_user.first_name} {INFO_RATE_CONTENT.info_user.last_name}" style="height: 60px;width: 60px;">
      </div>
      <div class="tms_review_rating">
          <strong></strong>

          <i class="fa fa-star" aria-hidden="true"></i>

          <i class="fa fa-star" aria-hidden="true"></i>

          <i class="fa fa-star" aria-hidden="true"></i>

          <i class="fa fa-star" aria-hidden="true"></i>

          <i class="fa fa-star" aria-hidden="true"></i>

          <br>
          {INFO_RATE_CONTENT.time_add}
      </div>
  </div>
</div>
<div class="col-xs-24 col-sm-16 col-md-18 col-lg-18 tms_review_list_right">
  <div class="tms_review_detail">
    <h3>
      {INFO_RATE_CONTENT.info_user.first_name} {INFO_RATE_CONTENT.info_user.last_name}
  </h3>
  <p>
      {INFO_RATE_CONTENT.content}
  </p>
  <div class="tms_review_detail_body">
      <!-- BEGIN: image -->
      <a href="{INFO_RATE_IMAGE}" title="{INFO_RATE_CONTENT.info_user.first_name} {INFO_RATE_CONTENT.info_user.last_name}">
        <img src="{INFO_RATE_IMAGE}" alt="{INFO_RATE_CONTENT.info_user.first_name} {INFO_RATE_CONTENT.info_user.last_name}" style="width:80px; height:80px" title="{INFO_RATE_CONTENT.info_user.first_name} {INFO_RATE_CONTENT.info_user.last_name}">
    </a>
    <!-- END: image -->
    <!-- BEGIN: no_image -->
    <div style="color: blue;">
        Không có hình ảnh đánh giá
    </div>
    
    <!-- END: no_image -->
</div>
</div>
</div>
</div>
</div>

<!-- END: info_rate_content -->
<!-- BEGIN: generate_page -->
<div class="text-center">
  {NV_GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->
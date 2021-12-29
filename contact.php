<?php include 'inc/header.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  $addFeedback = $feedback->addFeedback($_POST, null);
}
?>
<!-- Header End====================================================================== -->
<div id="mainBody">
  <div class="container">
    <hr class="soften">
    <h1>Visit us</h1>
    <hr class="soften" />
    <div class="row">
      <div class="span4">
        <h4>Contact Details</h4>
        <p> 18 Fresno,<br /> CA 93727, USA
          <br /><br />
          info@bootsshop.com<br />
          ﻿Tel 123-456-6780<br />
          Fax 123-456-5679<br />
          web:bootsshop.com
        </p>
      </div>

      <div class="span3">
        <h4>Opening Hours</h4>
        <h5> Monday - Friday</h5>
        <p>09:00am - 09:00pm<br /><br /></p>
        <h5>Saturday</h5>
        <p>09:00am - 07:00pm<br /><br /></p>
        <h5>Sunday</h5>
        <p>12:30pm - 06:00pm<br /><br /></p>
      </div>
      <div class="span5">
        <h4>Liên hệ với chúng tôi</h4>
        <?php
        if (isset($addFeedback))
          echo $addFeedback;
        ?>
        <form class="form-horizontal" method="POST" id="formFeedback">
          <fieldset>
            <div class="control-group">

              <input name="fullname" type="text" placeholder="họ tên" class="input-xlarge" />

            </div>
            <div class="control-group">

              <input name="phone_number" type="number" placeholder="số điện thoại" class="input-xlarge" />

            </div>
            <div class="control-group">

              <input name="email" type="email" placeholder="email" class="input-xlarge" />

            </div>
            <div class="control-group">

              <input name="subject_name" type="text" placeholder="chủ đề" class="input-xlarge" />

            </div>
            <div class="control-group">
              <textarea name="note" rows="4" id="textarea" class="input-xlarge"></textarea>

            </div>

            <button class="btn btn-large" name="submit" type="submit">Gửi phản hồi</button>

          </fieldset>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="span12">
        <iframe style="width:100%; height:300; border: 0px" scrolling="no" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14&amp;output=embed"></iframe><br />
        <small><a href="https://maps.google.co.uk/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14" style="color:#0000FF;text-align:left">View Larger Map</a></small>
      </div>
    </div>
  </div>
</div>
</div>
<script src="admin/js/jquery.validate.js"></script>

<script>
  $("#formFeedback").validate({
    rules: {
      fullname: {
        required: true,
        url: true,
      },
      email: {
        required: true,
        email: true
      },
      phone_number: {
        required: true,
        minlength: 10,
        maxlength: 10
      },
      subject_name: {
        required: true,
        url: true
      },
      note: {
        required: true,
        url: true
      },
    },
    messages: {
      fullname: {
        required: "Hãy nhập họ tên!",
        url: "Hãy nhập họ tên!",
        words_check: "Họ tên chỉ được nhập chữ!"
      },
      email: {
        required: "email không được để trống",
        email: "email không hợp lệ"
      },
      phone_number: {
        required: "Số điện thoại không được để trống",
        minlength: "Số điện thoại không hợp lệ",
        maxlength: "Số điện thoại không hợp lệ"
      },
      subject_name: {
        required: "Hãy nhập tiêu đề!",
        url: "Hãy nhập tiêu đề!",
      },
      note: {
        required: "Hãy nhập nội dung!",
        url: "Hãy nhập nội dung!",
      },
    },
    submitHandler: function(form) {
      $(form).submit();
    }
  });
</script>
<style>
  .error {
    color: red;
  }
</style>
<?php
include 'inc/footer.php';
?>
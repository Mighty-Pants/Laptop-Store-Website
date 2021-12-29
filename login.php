<?php include 'inc/header.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  $addUser = $user->addUserGuest($_POST);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  $login_ = $user->login($_POST);
}
?>
<!-- Header End====================================================================== -->
<div id="mainBody">
  <div class="container">
    <div class="row">
      <!-- Sidebar ================================================== -->

      <!-- Sidebar end=============================================== -->
      <div class="span9">
        <ul class="breadcrumb">
          <li><a href="index.html">Home</a> <span class="divider">/</span></li>
          <li class="active">Login</li>
        </ul>
        <h3> Đăng nhập / Đăng kí</h3>
        <hr class="soft" />
        <div class="row">
          <div class="span4">
            <div class="well">
              <h4>Đăng nhập</h4>
              <?php
              if (isset($login_))
                echo $login_;
              ?>
              <form method="POST" id="form_login">
                <div class="control-group">
                  <label class="control-label" for="inputEmail">Số điện thoại</label>
                  <div class="controls">
                    <span class="form-message" style="color: red;"></span>
                    <input name="taikhoan" class="span3" type="text" id="inputPhone" placeholder="Nhập số điện thoại...">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputPassword1">Mật khẩu</label>
                  <div class="controls">
                    <span class="form-message" style="color: red;"></span>
                    <input id="inputPwd" name="password" type="password" class="span3" placeholder="Nhập mật khẩu...">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                    <button name="login" type="submit" class="btn btn-success">Đăng nhập</button> <a href="forgetpass.html">Forget password?</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="span5">
            <div class="well">
              <form class="form-horizontal" method="POST" id="form_register">
                <h4>Thông tin cá nhân</h4>
                <?php
                if (isset($addUser)) {
                  echo $addUser;
                }
                ?>
                <div class="control-group">
                  <label class="control-label" for="inputFname1">Họ tên <sup>*</sup></label>
                  <div class="controls">
                    <input name="fullname" type="text" id="inputName" placeholder="VD: Vũ Phong">
                    <span class="span6 form-message" style="color: red;"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="input_email">Email <sup>*</sup></label>
                  <div class="controls">
                    <input name="email" type="text" id="inputEmail" placeholder="VD: abc@gmail.com">
                    <span class="span6 form-message" style="color: red;"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputFname1">Số điện thoại <sup>*</sup></label>
                  <div class="controls">
                    <input name="phone_number" type="text" id="inputPhone" placeholder="Số điện thoại...">
                    <span class="span6 form-message" style="color: red;"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputFname1">Địa chỉ <sup>*</sup></label>
                  <div class="controls">
                    <input name="address" type="text" id="inputAddress" placeholder="Địa chỉ...">
                    <span class="span6 form-message" style="color: red;"></span>

                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputPassword1">Mật khẩu <sup>*</sup></label>
                  <div class="controls">
                    <input name="password" type="password" id="inputPassword" placeholder="Nhập mật khẩu...">
                    <span class="span6 form-message" style="color: red;"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputPassword1">Nhập lại mật khẩu <sup>*</sup></label>
                  <div class="controls">
                    <input name="confirm_password" type="password" id="confirmPassword" placeholder="Nhập lại mật khẩu...">
                    <span class="span6 form-message" style="color: red;"></span>
                  </div>
                </div>
                <p><sup>*</sup>Required field </p>

                <div class="control-group">
                  <div class="controls">
                    <input class="btn btn-large btn-success" name="submit" type="submit" value="ĐĂNG KÍ" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>
</div>

<script src="admin/js/jquery.validate.js"></script>

<script>
  $("#form_login").validate({
    rules: {
      taikhoan: {
        required: true,
        url: true
      },
      password: {
        required: true,
        url: true,
        minlength: 5
      }
    },
    messages: {
      taikhoan: {
        required: "Hãy nhập số điện thoại!",
        url: "Hãy nhập số điện thoại!",
      },
      password: {
        required: "Hãy nhập mật khẩu",
        url: "Hãy nhập mật khẩu!",
        minlength: "Mật khẩu tối thiểu 5 kí tự"
      }
    },
    submitHandler: function(form) {
      $(form).submit();
    }
  });
</script>
<script>
  $("#form_register").validate({
    rules: {
      fullname: {
        required: true,
        url: true,
        words_check: true
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
      address: {
        required: true,
        url: true
      },
      password: {
        required: true,
        url: true,
        minlength: 5
      },
      confirm_password: {
        required: true,
        minlength: 5,
        equalTo: "#inputPassword"
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
      address: {
        required: "Hãy nhập địa chỉ!",
        url: "Hãy nhập địa chỉ!",
      },
      password: {
        required: "mật khẩu không được để trống",
        url: "mật khẩu không được để trống!",
        minlength: "tối thiểu 5 kí tự"
      },
      confirm_password: {
        required: "hãy xác nhận mật khẩu",
        equalTo: "mật khẩu không trùng khớp"
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
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<?php
include 'inc/footer.php';
?>
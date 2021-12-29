<?php include 'inc/header.php'; ?>
<?php
$login_check = Session::get('user_login');
if ($login_check == false) {
  header('location:login.php');
}

//get profile user by id
$user_id = Session::get('user_id');
$getUserByID = $user->getUserByID($user_id);

$getOrderByUserID = $order->getOrderByUserID($user_id);

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  $id = Session::get('user_id');
  $updateUser = $user->updateProfile($id, $_POST);
}

?>
<!-- Header End====================================================================== -->
<div id="mainBody">
  <div class="container">
    <div class="row">
      <!-- Sidebar ================================================== -->
      <?php include 'inc/sidebar.php'; ?>
      <!-- Sidebar end=============================================== -->
      <div class="span9">
        <ul class="breadcrumb">
          <li><a href="index.php">Home</a> <span class="divider">/</span></li>
          <li><a href="products.php">User</a> <span class="divider">/</span></li>
          <li class="active">Profile</li>
        </ul>

      </div>
      <div class="span9">
        <ul id="productDetail" class="nav nav-tabs">
          <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
          <li><a href="#profile" data-toggle="tab">Đơn hàng của tôi</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade active in" id="home">
            <h3> Thông tin tài khoản</h3>
            <div class="well">
              <?php
              if (isset($updateUser))
                echo $updateUser;
              if ($getUserByID) {
                while ($res = $getUserByID->fetch_assoc()) {
              ?>
                  <form class="form-horizontal" method="POST" id="form_update">
                    <div class="control-group">
                      <label class="control-label" for="inputFname1">Họ tên</label>
                      <div class="controls">
                        <input name="fullname" type="text" id="" value="<?php echo $res['fullname'] ?>">
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="input_email">Email </label>
                      <div class="controls">
                        <input name="email" type="email" id="" value="<?php echo $res['email'] ?>">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="input_email">Số điện thoại</label>
                      <div class="controls">
                        <input name="phone_number" type="number" id="" value="<?php echo $res['phone_number'] ?>">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="input_email">Địa chỉ</label>
                      <div class="controls">
                        <textarea name="address" type="text" id="" value=""><?php echo $res['address'] ?></textarea>
                      </div>
                    </div>
                    <div class="control-group">
                      <div class="controls">
                        <input name="submit" class="btn btn-large btn-success" type="submit" value="Lưu" />
                      </div>
                    </div>
                  </form>
              <?php }
              } ?>
            </div>
          </div>
          <div class="tab-pane fade" id="profile">
            <h3>Lịch sử mua hàng</h3>
            <?php
            if ($getOrderByUserID) {
              while ($res_order = $getOrderByUserID->fetch_assoc()) {
            ?>
                <div class="well">
                  <table class="table table-bordered">
                    <tbody>
                      <?php
                      $getDetail = $order->getDetailByOrderID($res_order['id']);
                      if ($getDetail) {
                        while ($resDetail = $getDetail->fetch_assoc()) {
                      ?>
                          <tr>
                            <td> <img width="80" src="admin/uploads/<?php echo $resDetail['image'] ?>" alt="" /></td>
                            <td>
                              <p> <?php echo $resDetail['name'] ?></p>
                              <p><?php echo number_format($resDetail['price'], 0) ?> VNĐ</p>
                            </td>
                            <td>x<?php echo $resDetail['quantity'] ?></td>
                            <td style="text-align: right;"><?php echo number_format($resDetail['total_price'], 0) ?> VNĐ</td>
                          </tr>
                      <?php }
                      } ?>
                      <tr>
                        <td colspan="3" style="text-align:right"><strong>Tổng số tiền</strong></td>
                        <td class="label label-important" style="display:block; text-align: right;"> <strong><?php echo number_format($res_order['total_money'], 0) ?> VNĐ </strong></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php
                  if ($res_order['status'] == 1)
                    echo '<span class="badge badge-success">Hoàn thành</span>';
                  elseif ($res_order['status'] == 2)
                    echo '<span class="badge badge-pill badge-danger">Đã huỷ</span>';
                  elseif ($res_order['status'] == 0)
                    echo '<span class="badge badge-pill badge-primary">Đang xử lí</span>'
                  ?>
                  <a class="btn btn-info" style="float: right;" href="view_detail.php?order_id=<?php echo $res_order['id'] ?>">Xem chi tiết</a>
                </div>
            <?php }
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="admin/js/jquery.validate.js"></script>

<script>
  $("#form_update").validate({
    rules: {
      fullname: {
        required: true,
        url: true
      },
      email: {
        required: true,
        email: true,
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
<?php include 'inc/footer.php'; ?>
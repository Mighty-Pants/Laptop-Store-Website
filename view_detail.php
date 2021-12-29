<?php include 'inc/header.php'; ?>

<?php
$login_check = Session::get('user_login');
if ($login_check == false)
  header('Location:login.php');


?>
<?php
if (isset($_GET['order_id'])) {
  $order_id = $_GET['order_id'];

  $getTotalMoney = $order->getOrderbyID($order_id)->fetch_assoc();
  $getProduct_Order = $order->getDetailByID($order_id);
  $getInformation = $user->getUserByOrderID($order_id);
}
if(isset($_GET['cancelOrderId'])){
  $order_id = $_GET['cancelOrderId'];
  $cancelOrder = $order->cancelOrder($order_id);
  header('location:view_detail.php?order_id='.$order_id);
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
          <li class="active"> SHOPPING CART</li>
        </ul>

        <h2>Chi tiết đơn hàng</h2>

        <hr class="soft" />
        <div class="well">
          <div class="row">
          <?php
              if ($getInformation) {
                while ($res_infor = $getInformation->fetch_assoc()) {
              ?>
            <div class="span4">
              
                  <div style="font-size: 20px; color:#000">ĐỊA CHỈ NHẬN HÀNG</div><br>
                  <div>
                    <h4><?php echo $res_infor['fullname']; ?></h4>
                    <p style="font-size:16px"><?php echo $res_infor['phone_number']; ?></p>
                    <p style="font-size:16px"><?php echo $res_infor['address']; ?></p>
                    <p style="font-size:16px">Ghi chú: <?php echo $res_infor['note']; ?></p>
                  </div>
            </div>
            <div class="span1"></div>
            <div class="span3">
              <div style="font-size: 20px; color:#000">TRẠNG THÁI</div><br>
              <p style="font-size:16px">Thời gian đặt: <?php echo $res_infor['created_date'] ?></p>
              <?php
              if($res_infor['status'] == 2)
                echo '<p style="font-size:16px; color:red">Đã huỷ</p>';
              elseif($res_infor['status'] == 1)
                echo '<p style="font-size:16px; color:green">Giao hàng thành công</p>';
              elseif($res_infor['status'] == 0){
                echo '<p style="font-size:16px; color:#ef4d2d">Đang xử lí</p>';
              ?>
                <br>
                <a  class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn huỷ đơn hàng này?')" href="?order_id=<?php echo $res_infor['id'] ?>&cancelOrderId=<?php echo $res_infor['id'] ?>">Huỷ đơn</a>
                  <?php  }?>
            </div>
            <?php }} ?>
          </div>

        </div>
        <div class="well">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th>Mã sản phẩm</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($getProduct_Order) {
                $total_money = 0;
                $qty = 0;
                while ($result = $getProduct_Order->fetch_assoc()) {
              ?>
                  <tr>
                    <td> <img width="60" src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
                    <td>
                      <p><?php echo $result['product_name'] ?></p>
                      <p><?php echo number_format($result['price'],0) ?> VNĐ</p>
                    </td>
                    <td>
                      x<?php echo $result['num'] ?>
                    </td>
                    <td>
                      <?php echo number_format($result['total_price'],0) ?> VNĐ
                    </td>
                  </tr>
              <?php }} ?>
              <tr>
                <td colspan="3" style="text-align:right">Tổng tiền hàng: </td>
                <td> VNĐ</td>
              </tr>
              <tr>
                <td colspan="3" style="text-align:right">Khuyến mãi: </td>
                <td>- 00.00 VNĐ</td>
              </tr>
              <tr>
                <td colspan="3" style="text-align:right">VAT: </td>
                <td> + 10%</td>
              </tr>
              <tr>
                <?php
                ?>
                <td colspan="3" style="text-align:right"><strong>Tổng thanh toán </strong></td>
                <td class="label label-important" style="display:block"> <strong><?php echo number_format($getTotalMoney['total_money'], 0) ?> VNĐ </strong></td>
              </tr>
            </tbody>
          </table>
        </div>
        <?php
        if (isset($addOrder)) {
          if ($addOrder == true)
            header('Location:product_summary.php');
        }
        ?>
      </div>
    </div>
  </div>
</div>

<script src="admin/js/jquery.validate.js"></script>

<script>
  $("#form_checkout").validate({
    rules: {
      fullname: {
        required: true,
        url: true
      },
      email: {
        required: true,
        email: true
      },
      phone_number: {
        required: true,
        minlength: 10
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
      },
      email: {
        required: "email không được để trống",
        email: "email không hợp lệ"
      },
      phone_number: {
        required: "Số điện thoại không được để trống",
        minlength: "Số điện thoại không hợp lệ"
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
<?php
include 'inc/footer.php';
?>
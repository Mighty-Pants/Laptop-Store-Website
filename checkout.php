<?php include 'inc/header.php'; ?>

<?php
$login_check = Session::get('user_login');
if ($login_check == false)
    header('Location:login.php');

$qty_cart = Session::get('qty');
if ($qty_cart == 0)
    header('Location:index.php');
?>
<?php
$getProduct_Order = $order->getProductOrder();

//get profile user by id
$id = Session::get('user_id');
$getUserByID = $user->getUserByID($id);

//thêm hoá đơn
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $addOrder = $order->addOrder($id, $_POST);
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

                <h3>Thanh Toán</h3>

                <hr class="soft" />
                <div class="well">

                    <table class="table table-bordered">
                        <tr>
                            <th>
                                <div style="color: #ee4d2d; font-size:20px">Địa Chỉ Nhận Hàng</div>

                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($getUserByID) {
                                    while ($res = $getUserByID->fetch_assoc()) {
                                ?>
                                        <form class="form-horizontal" method="POST" id="form_checkout">
                                            <div class="row">
                                                <div class="control-group span3">
                                                    <label class="control-label" for="inputUsername">Họ tên người nhận</label>
                                                    <div class="controls">
                                                        <input name="fullname" type="text" id="" value="<?php echo $res['fullname'] ?>">
                                                    </div>
                                                </div>
                                                <div class="control-group span3">
                                                    <label class="control-label" for="inputPassword1">Email</label>
                                                    <div class="controls">
                                                        <input name="email" type="email" id="" value="<?php echo $res['email'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="control-group span3">
                                                    <label class="control-label" for="inputUsername">Số Điện Thoại</label>
                                                    <div class="controls">
                                                        <input name="phone_number" type="number" id="" value="<?php echo $res['phone_number'] ?>">
                                                    </div>
                                                </div>
                                                <div class="control-group span5">
                                                    <label class="control-label" for="">Địa Chỉ </label>
                                                    <div class="controls">
                                                        <input name="address" type="text" id="inputPassword1" value="<?php echo $res['address'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword1">Ghi Chú</label>
                                                <div class="controls">
                                                    <textarea name="note" type="text" id="inputPassword1" placeholder="Lưu ý cho người bán..."></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button name="submit" type="submit" class="btn btn-danger">Đặt Hàng</button>
                                                    <?php
                                                    if (isset($addOrder)) {
                                                        if ($addOrder == false) {
                                                            echo "<span style='color:red;'>Vui lòng nhập đầy đủ thông tin giao hàng</span>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </form>
                                <?php }
                                } ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="well">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
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
                                        <td><?php echo $result['name'] ?></td>
                                        <td>
                                            <div class="input-append">
                                                <form action="" method="POST">
                                                    <input type="hidden" name="order_detail_id" value="<?php echo $result['id'] ?>">
                                                    <input disabled name="quantity" value="<?php echo $result['quantity'] ?>" class="span1" style="max-width:34px" id="appendedInputButtons" size="16" type="number" min=0>
                                                </form>
                                            </div>
                                        </td>
                                        <td><?php echo number_format($result['price'], 2) ?> VNĐ</td>
                                        <td><?php echo number_format($result['total_price'], 2) ?></td>

                                    </tr>
                            <?php
                                    $qty += $result['quantity'];
                                    $total_money += $result['total_price'];
                                }
                                Session::set('total_money', $total_money);
                            } ?>

                            <tr>
                                <td colspan="4" style="text-align:right">Tổng tiền hàng: </td>
                                <td><?php echo number_format($total_money, 2) ?> VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right">Khuyến mãi: </td>
                                <td>- 00.00 VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right">VAT: </td>
                                <td> + 10%</td>
                            </tr>
                            <tr>
                                <?php
                                $VAT = $total_money * 0.1;
                                $total = $total_money + $VAT;
                                ?>
                                <td colspan="4" style="text-align:right"><strong>Tổng thanh toán </strong></td>
                                <td class="label label-important" style="display:block"> <strong><?php echo number_format($total, 2) ?> VNĐ </strong></td>
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
                address:  {
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
    .error{
        color: red;
    }
</style>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<?php
include 'inc/footer.php';
?>
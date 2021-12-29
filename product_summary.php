<?php include 'inc/header.php'; ?>

<?php
    $login_check = Session::get('user_login');
    if($login_check==false)
        header('Location:login.php');
?>
<?php
$getProduct_Order = $order->getProductOrder();
if(isset($_GET['delOrderId'])){
    $id= $_GET['delOrderId'];
    $delOrder = $order->deleteOrderDetail($id);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $order_detail_id = $_POST['order_detail_id'];
    if($quantity==0){
        $delOrder = $order->deleteOrderDetail($order_detail_id);
    }
    else
        $updateOrder = $order->updateOrderDetail($order_detail_id, $quantity);
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
    <h3>GIỎ HÀNG</h3>
    <hr class="soft" />
   
    <?php
        $check_cart = $order->check_cart();
        if($check_cart){
    ?>
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
                $qty=0;
                while ($result = $getProduct_Order->fetch_assoc()) {
            ?>
                    <tr>
                        <td> <img width="60" src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
                        <td><?php echo $result['name'] ?></td>
                        <td>
                            <div class="input-append">
                                <form action="" method="POST">
                                    <input type="hidden" name="order_detail_id" value="<?php echo $result['id'] ?>">
                                    <input name="quantity" value="<?php echo $result['quantity'] ?>" class="span1" style="max-width:34px" id="appendedInputButtons" size="16" type="number" min=0 max="<?php echo $result['maxQuantity'] ?>">
                                    <button class="btn btn-dark" type="submit" name="submit">Thay đổi</button>
                                    <button class="btn btn-danger" type="button"><a href="?delOrderId=<?php echo $result['id'] ?>"><i class="icon-remove icon-white"></i></a></button>
                                </form>
                            </div>
                        </td>
                        <td><?php echo number_format($result['price'], 2) ?> VNĐ</td>
                        <td><?php echo number_format($result['total_price'], 2) ?></td>

                    </tr>
            <?php
                $qty += $result['quantity'];
                $total_money += $result['total_price'];
                }Session::set('total_money', $total_money);
                
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
        }else{
            echo '<h4>Không có sản phẩm nào trong giỏ !!!</h4>';
        }
?>




    <a href="index.php" class="btn btn-large"><i class="icon-arrow-left"></i> Tiếp tục mua hàng </a>
    <?php
    $qty_cart = Session::get('qty');
    if ($qty_cart != 0)
       echo '<a href="checkout.php" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>';
    ?>
    
    

</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<?php
include 'inc/footer.php';
?>
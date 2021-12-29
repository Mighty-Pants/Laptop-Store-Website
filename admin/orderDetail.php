<?php
include 'inc/header.php';
include '../classes/order.php';
?>

<?php
$order = new Order();


if (!isset($_GET['order_id']) || $_GET['order_id'] == '') {
    echo "<script>window.location = '404.php'</script>";
} else {
    $id = $_GET['order_id'];
    $show_order_detail = $order->getDetailByID($id);

    $getOrder = $order->getOrderbyID($id);
    $getOrderByID = $order->getOrderbyID($id)->fetch_assoc();
}
?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Chi tiết đơn hàng</h1>

    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body row">
            <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Mã</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($show_order_detail) {
                            while ($res = $show_order_detail->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><img src="uploads/<?php echo $res['image'] ?>" alt="" height="100px"></td>
                                <td><?php echo $res['product_name']; ?></td>
                                <td><?php echo number_format($res['price'],0); ?>VNĐ</td>
                                <td><?php echo $res['num']; ?></td>
                                <td><?php echo number_format($res['total_price'],0); ?>VNĐ</td>
                            </tr>
                        <?php }} ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Tổng:</td>
                                <td><?php echo number_format($getOrderByID['total_money'],0); ?>VNĐ</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
        <h1 class="h3 mb-2 text-gray-800">Thông tin giao hàng</h1>
        <table class="talbe table-bordered table-hover" width="100%" cellspacing="0">
            <tr>
                    <th>Người nhận</th>
                    <td><?php echo $getOrderByID['fullname']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $getOrderByID['email']; ?></td>
                </tr>
                <tr>
                    <th>Địa chỉ giao hàng</th>
                    <td><?php echo $getOrderByID['address']; ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><?php echo $getOrderByID['phone_number']; ?></td>
                </tr>
                <tr>
                    <th>Ghi chú</th>
                    <td><?php echo $getOrderByID['note']; ?></td>
                </tr>
            </table>
        </div>
        </div>
    </div>
    <a class="btn  btn-primary" href="orderManager.php" role="button">Back</a>

    <div>
        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                for ($i = 0; $i < $pages; $i++) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                }
                ?>
            </ul>
        </nav> -->
    </div>
</div>

<!-- End of Main Content -->

<!-- Footer -->
<?php
include 'inc/footer.php'
?>
<?php
include 'inc/header.php';
include '../classes/order.php';
?>

<?php
//phan trang
$order = new Order();

$count_record = $order->count_record();

$number = 0;
if ($count_record != null && count($count_record) > 0) {
  $number = $count_record[0]['number'];
}
$pages = ceil($number / 5);
$current_page = 1;
if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
}
$index = ($current_page - 1) * 5;
$getAllOrder = $order->getAllOrder($index);
?>

<?php
//tim kiem
$search = '';
if (isset($_GET['keyword'])) {
  $keyword = $_GET['keyword'];
  $getAllOrder = $order->search_user($keyword, $index);
  $search = Session::get('keyword_order');
} else {
  $getAllOrder = $order->getAllOrder($index);
  Session::set('keyword_order', '');
}
?>

<?php
//cap nhat trang thai don hang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateStatus = $order->updateStatus($_POST);
}
?>

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Quản lí đơn hàng</h1>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <form action="" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
          <input type="text" value="<?php if ($search) echo $search ?>" name="keyword" class="form-control " placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit" value="tim kiem">
              <i class="fas fa-search fa-sm"><a href="?search"></a></i>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Họ tên</th>
              <th>Số điện thoại</th>
              <th>Email</th>
              <th>Địa chỉ</th>
              <th>Ghi chú</th>
              <th>Ngày tạo</th>
              <th>Tổng thanh toán</th>
              <th>Trạng thái</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($getAllOrder) {
              while ($res = $getAllOrder->fetch_assoc()) {
            ?>
                <tr>
                  <td><?php echo $res['fullname']; ?></td>
                  <td><?php echo $res['phone_number']; ?></td>
                  <td><?php echo $res['email']; ?></td>
                  <td><?php echo $res['address']; ?></td>
                  <td><?php echo $res['note'] ?></td>
                  <td><?php echo $res['created_date'] ?></td>
                  <td><?php echo number_format($res['total_money'], 2); ?> VNĐ</td>
                  <td>
                    <?php
                    if ($res['status'] == 0)
                      echo '<span class="badge badge-warning">Đang chờ xử lí</span>';
                    elseif ($res['status'] == 1)
                      echo '<span class="badge badge-success">Hoàn thành</span>';
                    elseif ($res['status'] == 2)
                      echo '<span class="badge badge-danger">Huỷ</span>';
                    ?>
                    <!-- Button trigger modal -->
                    <?php if ($res['status'] == 0) { ?>
                      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $res['id']; ?>">
                        Cập nhật
                      </button>
                    <?php } ?>
                    <!-- Modal -->
                    <form action="" method="POST">
                      <div class="modal fade" id="exampleModal<?php echo $res['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Cập nhật trạng thái đơn hàng</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <input type="text" hidden name="order_id" value="<?php echo $res['id'] ?>">
                              <select name="updateStatus" class="custom-select" id="inputGroupSelect01">
                                <option value="1">Hoàn thành</option>
                                <option value="2">Huỷ</option>
                              </select>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="update" type="button" class="btn btn-primary">Lưu</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-info" href="orderDetail.php?order_id=<?php echo $res['id'] ?>" role="button">View detail</a>
                  </td>
                </tr>

            <?php }
            } ?>


          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php
        for ($i = 0; $i < $pages; $i++) {
          echo '<li class="page-item"><a class="page-link" href="?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
        }
        ?>
      </ul>
    </nav>
  </div>
</div>

<!-- End of Main Content -->

<!-- Footer -->
<?php
include 'inc/footer.php'
?>
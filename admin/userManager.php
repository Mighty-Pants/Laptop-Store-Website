<?php
include 'inc/header.php';
include '../classes/user.php';
?>

<?php
$user = new User();


//phan trang
$count_record = $user->count_record();

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
$getAllUser = $user->getAllUser($index);
?>

<?php
//delete
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $delUser = $user->deleteUserByID($id);
}
?>

<?php
//tim kiem
$search = '';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $getAllUser = $user->search_user($keyword, $index);
    $search = Session::get('keyword');
}else{
    $getAllUser = $user->getAllUser($index);
    Session::set('keyword','');
}
?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quản lí người dùng</h1>

    <button type="button" class="btn btn-primary"><a href="userAdd1.php" class="badge badge-primary">Thêm</a></button></br>
    <?php
    if (isset($delUser))
        echo $delUser;
    ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" value="<?php if($search) echo $search?>" name="keyword" class="form-control " placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <th>Quyền</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($getAllUser) {
                            while ($res = $getAllUser->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $res['fullname']; ?></td>
                                    <td><?php echo $res['phone_number']; ?></td>
                                    <td><?php echo $res['email']; ?></td>
                                    <td><?php echo $res['address']; ?></td>
                                    <td><?php echo $res['role_name'] ?></td>
                                    <td>
                                        <a href="userEdit.php?id=<?php echo $res['id'] ?>">Edit</a>
                                        || <a onclick="return confirm('DELETE THIS USER?')" href="?del_id=<?php echo $res['id'] ?>">Delete</a>
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
<?php
include 'inc/header.php';
include '../classes/category.php';
?>
<!--delete category-->
<?php
$cat = new category();
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $delCat = $cat->delete_category($id);
}

?>
<?php
//phan trang
$count_record = $cat->count_record();

$number = 0;
if ($count_record != null && count($count_record) > 0) {
    $number = $count_record[0]['number'];
}
$pages = ceil($number / 10);
$current_page = 1;
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
$index = ($current_page - 1) * 10;
$getAllCat = $cat->show_category($index);
?>

<?php
//Thêm danh mục sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $created_by = Session::get('fullname');
    $insert_cat = $cat->insert_category($name, $created_by);
}
?>

<?php
//tim kiem
$search = '';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $getAllCat = $cat->search_cat( $index, $keyword);
    $search = Session::get('keyword_cat');
}else{
    $getAllCat = $cat->show_category($index);
    Session::set('keyword_cat','');
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Quản lí danh mục sản phẩm</h1>
    <?php
    if (isset($insert_cat))
        echo $insert_cat;

    if (isset($delCat))
        echo $delCat;
    ?>
    <form class="row g-3" method="POST">
        <div class="col-md-3">
            <input name="name" type="text" class="form-control" id="inputEmail4" placeholder="Thêm danh mục mới......">
        </div>
        <div class="col-3">
            <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
        </div>
        <hr>
    </form>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text"  name="keyword" value="<?php if ($search) echo $search ?>" class="form-control " placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary"  type="submit">
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
                            <th>Danh mục</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if ($getAllCat) {
                            $i = 0;
                            while ($result = $getAllCat->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $result['Name'] ?></td>
                                    <td><a href="categoryEdit.php?ID=<?php echo $result['ID'] ?>">Edit</a>
                                        || <a onclick="return confirm('DELETE THIS CATEGOTY?')" href="?del_id=<?php echo $result['ID'] ?>">Delete</a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
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



<?php include 'inc/footer.php' ?>
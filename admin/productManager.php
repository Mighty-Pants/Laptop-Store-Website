<?php
include 'inc/header.php';
include '../classes/category.php';
include '../classes/product1.php';
include '../classes/producer.php';

include_once '../helpers/format.php';
?>
<?php
$cat = new category();
$product_ = new Product1();
$producer = new Producer();
$url = '';
?>
<?php
//delete product
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $delProduct = $product_->deleteProductByID($id);
}

//tim kiem
$search = '';
if (isset($_GET['keyword']) && $_GET['keyword'] !='') {
    
    $keyword = $_GET['keyword'];
    $url= "keyword=$keyword&";
    $res = $product_->countProductSearched($keyword);

    $number = 0;
    if ($res != null && count($res) > 0) {
        $number = $res[0]['number'];
    }
    $pages = ceil($number / 5);
    $current_page = 1;
    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
    }
    $index = ($current_page - 1) * 5;

    $show_product = $product_->search_product($keyword, $index);
    $search = Session::get('keyword');
} else {
    $url='';
    $res = $product_->count_id();

    $number = 0;
    
    if ($res != null && count($res) > 0) {
        $number = $res[0]['number'];
    }
    $pages = ceil($number / 10);
    $current_page = 1;
    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
    }
    $index = ($current_page - 1) * 10;
    $show_product = $product_->show_product($index);
    Session::set('keyword', '');
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Quản Lí Sản Phẩm</h1>
    <p>
    <?php

    if (isset($delProduct))
        echo $delProduct;
    ?>
  </p>
    <button type="button" class="btn btn-primary"><a href="productAdd1.php" class="badge badge-primary">Thêm sản phẩm mới</a></button></br>
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
                            <th>Mã</th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Nhà sản xuất</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if ($show_product) {
                            while ($result = $show_product->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $result['product_name'] ?></td>
                                    <td><img src="uploads/<?php echo $result['image'] ?>" alt="" height="100px"></td>
                                    <td>
                                        <?php
                                        $getCatByID = $cat->getCatByID($result['category_id']);
                                        if ($getCatByID)
                                            echo $getCatByID->fetch_assoc()['Name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $producer = new Producer();
                                        $getProducer = $producer->getProducerByID($result['producer_id']);
                                        if ($getProducer)
                                            echo $getProducer->fetch_assoc()['name'];
                                        ?>
                                    </td>
                                    <td><?php echo number_format($result['price'], 0); ?> VNĐ</td>
                                    <td><?php echo $result['quantity'] ?></td>                   
                                    <td><a href="productEdit1.php?id=<?php echo $result['id'] ?>">Edit</a>
                                        || <a onclick="return confirm('DELETE THIS PRODUCT?')" href="?del_id=<?php echo $result['id'] ?>">Delete</a>
                                    </td>
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
                    echo '<li class="page-item"><a class="page-link" href="?' . ($url) . 'page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>

</div>



<?php include 'inc/footer.php' ?>
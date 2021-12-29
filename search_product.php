<?php include 'inc/header.php'; ?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    //phan trang
    $count_record = $product->countProductSearched($keyword);

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
    $getProductBySearch = $product->search_product($keyword, $index);
}else{
    echo '<script>window.location="404.php"</script>';
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
                    <li class="active"><?php //echo $getCatName['Name']
                                        ?></li>
                </ul>
                <hr class="soft" />
                <p style="font-size: 20px;">Tìm thấy <strong><?php echo  $number ?></strong> kết quả cho từ khoá ' <strong><?php echo  $keyword ?></strong> ' </p>
                <!-- <form class="form-horizontal span6">
                    <div class="control-group">
                        <label class="control-label alignL">Sort By </label>
                        <select>
                            <option>Priduct name A - Z</option>
                            <option>Priduct name Z - A</option>
                            <option>Priduct Stoke</option>
                            <option>Price Lowest first</option>
                        </select>
                    </div>
                </form> -->

                <div id="myTab" class="pull-right">
                    <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
                    <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
                </div>
                <br class="clr" />
                <div class="tab-content">
                    <div class="tab-pane active" id="listView">
                        <?php
                        if ($getProductBySearch) {
                            while ($res = $getProductBySearch->fetch_assoc()) {
                        ?>
                                <div class="row">
                                    <div class="span2">
                                        <a href="product_details.php?proid=<?php echo $res['id'] ?>"><img src="admin/uploads/<?php echo $res['image'] ?>" alt="" /></a>
                                    </div>
                                    <div class="span4">
                                        <h3><?php echo $res['product_name'] ?></h3>
                                        <hr class="soft" />
                                        <h4><?php echo $res['quantity'] ?> sản phẩm trong kho</h4>
                                        <br class="clr" />
                                    </div>
                                    <div class="span3 alignR">
                                        <form class="form-horizontal qtyFrm" method="POST">
                                            <h3> <?php echo number_format($res['price'], 0) ?> VNĐ</h3>
                                            </label><br />

                                            <input type="text" name="id" class="hidden" value="<?php echo $res['id'] ?>">
                                            <input class="hidden" type="text" name="SPconLai" value="<?php echo $res['quantity'] ?>">
                                            <?php
                                                if($res['quantity']<=0)
                                                    echo '<button disabled type="submit" name="submit" class="btn btn-large btn-danger pull-right"> Hết hàng <i class=" icon-shopping-cart"></i></button>';
                                                else
                                                    echo '<button type="submit" name="submit" class="btn btn-large btn-primary pull-right"> Thêm vào giỏ <i class=" icon-shopping-cart"></i></button>';
                                            ?>
                                            


                                        </form>
                                    </div>
                                </div>
                                <hr class="soft" />
                        <?php }
                        } ?>


                    </div>

                </div>

                <a href="compair.php" class="btn btn-large pull-right">Compair Product</a>
                <div class="pagination">
                    <ul>
                        <?php
                        for ($i = 0; $i < $pages; $i++) {
                            echo '<li><a href="?keyword='.($keyword).'&page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <br class="clr" />
            </div>
        </div>
    </div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<?php
include 'inc/footer.php';
?>
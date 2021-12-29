<?php
include 'inc/header.php';
include 'inc/slider.php';
include 'inc/sidebar.php';
?>

<div class="span9">
  <div class="well well-small">
    <h4>Sản phẩm mới </h4>
    <div class="row-fluid">
      <div id="featured" class="carousel slide">
        <div class="carousel-inner">
          <div class="item active">
            <ul class="thumbnails">
              <?php
              $new_product = $product->getNewProduct();
              while ($res = $new_product->fetch_assoc()) {
              ?>
                <li class="span3">
                  <div class="thumbnail">
                    <i class="tag"></i>
                    <a href="product_details.php?proid=<?php echo $res['id'] ?>"><img src="admin/uploads/<?php echo $res['image']; ?>" alt=""></a>
                    <div class="caption">
                      <div style="height: 80px;">
                        <h5><?php echo $res['product_name'] ?></h5>
                      </div>
                      <h4><a class="btn" href="product_details.php?proid=<?php echo $res['id'] ?>">VIEW</a> <span class="pull-right">$<?php echo $res['price'] ?></span></h4>
                    </div>
                  </div>
                </li>

              <?php } ?>
            </ul>
          </div>
        </div>
        <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#featured" data-slide="next">›</a>
      </div>
    </div>
  </div>
  <div class="well well-small">
    <h4>Sản phẩm bán chạy </h4>
    <div class="row-fluid">
      <div id="featured" class="carousel slide">
        <div class="carousel-inner">
          <div class="item active">
            <ul class="thumbnails">
              <?php
              $top_product = $product->getTopProduct();
              while ($res_top = $top_product->fetch_assoc()) {
                $getProductByID = $product->getProductByID($res_top['product_id'])->fetch_assoc();
              ?>
                <li class="span3">
                  <div class="thumbnail">
                    <i class="tag"></i>
                    <a href="product_details.php?proid=<?php echo $getProductByID['id'] ?>"><img src="admin/uploads/<?php echo $getProductByID['image']; ?>" alt=""></a>
                    <div class="caption">
                      <div style="height: 80px;">
                        <h5><?php echo $getProductByID['product_name'] ?></h5>

                      </div>
                      <h4><a class="btn" href="product_details.php?proid=<?php echo $getProductByID['id'] ?>">VIEW</a> <span class="pull-right">$<?php echo $getProductByID['price'] ?></span></h4>
                    </div>
                  </div>
                </li>

              <?php } ?>
            </ul>
          </div>
        </div>
        <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#featured" data-slide="next">›</a>
      </div>
    </div>
  </div>



</div>
</div>
</div>
</div>
<!-- Footer ================================================================== -->

<?php
include 'inc/footer.php';
?>
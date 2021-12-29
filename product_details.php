<?php include 'inc/header.php'; ?>

<?php
if (!isset($_GET['proid']) || $_GET['proid'] == null)
  echo '<script>window.location="404.php"</script>';
else {
  $id = $_GET['proid'];
  $getProductByID = $product->getProductByID($id)->fetch_assoc();
  $getProductDetailByID = $product->getProductDetailByID($id);

  $getFeedbackByProId = $feedback->getFeedbackByProId($id);

  $relatedProduct = $product->getRelatedProduct($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  $quantity = $_POST['quantity'];
  $addOrder = $order->addToCart($id, $quantity);
}

//gui feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_feedback'])) {
  $addFeedback = $feedback->addFeedback($_POST, $id);
}

//add Related Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCart'])) {
  $idPro = $_POST['relatedProId'];
  $quantity = 1;
  $addOrder = $order->addToCart($idPro, $quantity);
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
          <li><a href="products.php">Products</a> <span class="divider">/</span></li>
          <li class="active">product Details</li>
        </ul>
        <div class="row">
          <div id="gallery" class="span3">
            <a href="admin/uploads/<?php echo $getProductByID['image']; ?>" title="">
              <img src="admin/uploads/<?php echo $getProductByID['image']; ?>" style="width:100%" alt="img" />
            </a>
            <div id="differentview" class="moreOptopm carousel slide">
            </div>

            <div class="btn-toolbar">
              <div class="btn-group">
                <span class="btn"><i class="icon-envelope"></i></span>
                <span class="btn"><i class="icon-print"></i></span>
                <span class="btn"><i class="icon-zoom-in"></i></span>
                <span class="btn"><i class="icon-star"></i></span>
                <span class="btn"><i class=" icon-thumbs-up"></i></span>
                <span class="btn"><i class="icon-thumbs-down"></i></span>
              </div>
            </div>
          </div>
          <div class="span6">
            <h3><?php echo $getProductByID['product_name'] ?> </h3>

            <hr class="soft" />
            <form class="form-horizontal qtyFrm" method="POST">
              <div class="control-group">
                <label class="control-label"><span><?php echo number_format($getProductByID['price'], 0) ?> VNĐ</span></label>
                <div class="controls">
                  <input type="number" class="span1" placeholder="Qty." name="quantity" value="1" min="1" max="<?php echo  $getProductByID['quantity'] ?>" />
                  <?php
                  if ($getProductByID['quantity'] == 0)
                    echo '<button disabled type="submit" name="submit" class="btn btn-large btn-danger pull-right">Hết Hàng <i class=" icon-shopping-cart"></i></button>';
                  else
                    echo '<button type="submit" name="submit" class="btn btn-large btn-primary pull-right"> Thêm vào giỏ <i class=" icon-shopping-cart"></i></button>';
                  ?>
                </div>
                <?php
                if (isset($addOrder))
                  echo '<hr class="soft"/><span style="color:red;font-size:18px">Sản phẩm đã có sẵn trong giỏ hàng</span>';
                ?>
              </div>
            </form>
            <hr class="soft" />
            <h4><?php echo $getProductByID['quantity'] ?> sản phẩm có sẵn</h4>
            <form class="form-horizontal qtyFrm pull-right">
              <div class="control-group">
                <label class="control-label"><span>Color</span></label>
                <div class="controls">
                  <select class="span2">
                    <option>Black</option>
                    <option>Red</option>
                    <option>Blue</option>
                    <option>Brown</option>
                  </select>
                </div>
              </div>
            </form>
            <hr class="soft clr" />
            <p style="font-size: 16px;">
              <?php echo $getProductByID['description'] ?>
            </p>
            <a class="btn btn-small pull-right" href="#detail">More Details</a>
            <br class="clr" />
            <a href="#" name="detail">

            </a>
            <hr class="soft" />
          </div>

          <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
              <li><a href="#home" data-toggle="tab">Thông số</a></li>
              <li class="active"><a href="#profile" data-toggle="tab">Bình luận</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <?php
              if ($getProductDetailByID == 0)
                echo '<div class="tab-pane fade " id="home"></div>';
              else {
              ?>
                <div class="tab-pane fade " id="home">
                  <h4>Thông tin sản phẩm</h4>
                  <table class="table table-bordered">
                    <tbody>
                      <tr class="techSpecRow">
                        <th colspan="2">Thông số sản phẩm</th>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Màn Hình: </td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['display'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Hệ điều hành:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['os'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Camera:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['camera'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Chip:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['chip'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Ram:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['ram'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Bộ nhớ trong:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['internal_memory'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Sim:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['sim'] ?></td>
                      </tr>
                      <tr class="techSpecRow">
                        <td class="techSpecTD1">Pin, sạc:</td>
                        <td class="techSpecTD2"><?php echo $getProductDetailByID['pin'] . ', ' . $getProductDetailByID['charging'] ?></td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              <?php } ?>

              <div class="tab-pane fade active in" id="profile">
                <div class="row">
                  <div class="span5">
                    <div class="well">
                      <h4>Đánh giá sản phẩm</h4>
                      <hr STYLE="background-color:#c0c0c0; height:2px; width:100%;" class="soft" />
                      <?php
                      if ($getFeedbackByProId) {
                        while ($feedback = $getFeedbackByProId->fetch_assoc()) {
                      ?>
                          <p>Khách hàng: <strong><?php echo $feedback['fullname'] ?></strong>&ensp;&ensp;<?php echo $feedback['created_date'] ?>
                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                            <?php
                            $s_id = session_id();
                            if ($feedback['s_id'] == $s_id)
                              echo '<a href="#">xoá</a>';
                            ?>
                          </p>
                          <p>Tiêu đề: <?php echo $feedback['subject_name'] ?></p>
                          <p>Nội dung: <?php echo $feedback['note'] ?></p>
                          <hr STYLE="background-color:#c0c0c0; height:2px; width:100%;" class="soft" />
                      <?php }
                      } ?>
                    </div>
                  </div>
                  <div class="span4">
                    <div class="well">
                      <h4>Viết đánh giá</h4>
                      <form class="form-horizontal" method="POST" id="formFeedback">
                        <fieldset>
                          <div class="control-group">
                            <input name="fullname" type="text" placeholder="họ tên" class="input-xlarge" />
                          </div>
                          <div class="control-group">
                            <input name="phone_number" type="number" placeholder="số điện thoại" class="input-xlarge" />
                          </div>
                          <div class="control-group">
                            <input name="email" type="email" placeholder="email" class="input-xlarge" />
                          </div>
                          <div class="control-group">
                            <input name="subject_name" type="text" placeholder="chủ đề" class="input-xlarge" />
                          </div>
                          <div class="control-group">
                            <textarea name="note" rows="4" id="textarea" class="input-xlarge"></textarea>
                          </div>
                          <button class="btn btn-large" name="send_feedback" type="submit">Gửi phản hồi</button>
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- related product -->
          <div class="span9">
            <h4>Sản phẩm liên quan</h4>
            <ul class="thumbnails">
              <?php  
              if($relatedProduct){
                while( $related = $relatedProduct->fetch_assoc()){
              ?>
              <li class="span3">
                <div class="thumbnail">
                  <a href="product_details.php?proid=<?php echo $related['id'] ?>"><img  style="width:50%" src="admin/uploads/<?php echo $related['image']; ?>" alt="" /></a>
                  <div class="caption">
                    <h5 style="height: 45px;"><?php echo $related['product_name']; ?>
                      </a>
                      </h5>
                    <p>
                    </p>
                    <form class="form-horizontal qtyFrm" method="POST">
                      <h4 style="text-align:center"><a class="btn"> <i class="icon-zoom-in"></i></a> <button type="submit" name="addCart" class="btn" >Add to <i class="icon-shopping-cart"></i></button><a class="btn btn-primary" href="#"><?php echo number_format($related['price'],0); ?>VNĐ</a> </h4>
                      <input style="height: 1px;" type="text" name="relatedProId" class="hidden" value="<?php echo $related['id'] ?>">
                    </form>
                  </div>
                </div>
              </li>
              <?php }} ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->

<script src="admin/js/jquery.validate.js"></script>

<script>
  $("#formFeedback").validate({
    rules: {
      fullname: {
        required: true,
        url: true,
      },
      email: {
        required: true,
        email: true
      },
      phone_number: {
        required: true,
        minlength: 10,
        maxlength: 10
      },
      subject_name: {
        required: true,
        url: true
      },
      note: {
        required: true,
        url: true
      },
    },
    messages: {
      fullname: {
        required: "Hãy nhập họ tên!",
        url: "Hãy nhập họ tên!",
        words_check: "Họ tên chỉ được nhập chữ!"
      },
      email: {
        required: "email không được để trống",
        email: "email không hợp lệ"
      },
      phone_number: {
        required: "Số điện thoại không được để trống",
        minlength: "Số điện thoại không hợp lệ",
        maxlength: "Số điện thoại không hợp lệ"
      },
      subject_name: {
        required: "Hãy nhập tiêu đề!",
        url: "Hãy nhập tiêu đề!",
      },
      note: {
        required: "Hãy nhập nội dung!",
        url: "Hãy nhập nội dung!",
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
<?php include 'inc/footer.php'; ?>
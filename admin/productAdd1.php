<?php include 'inc/header.php' ?>
<?php include '../classes/category.php' ?>
<?php include '../classes/product1.php' ?>
<?php include '../classes/producer.php' ?>

<?php

$product_ = new Product1();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $created_by = Session::get('username');

    $insert_product = $product_->insert_product($_POST, $_FILES, $created_by);
}
?>
<!-- include libraries(jQuery, bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Thêm sản phẩm</h1>
    <?php
    if (isset($insert_product))
        echo $insert_product;
    ?>
    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate id="form_add">
        <div class="form-group">
            <label for="uname">Tên sản phẩm:</label>
            <input type="text" class="form-control" id="" placeholder="" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="uname">Danh mục:</label>
            <select name="category" class="form-select form-control" aria-label="Default select example" required>
                <option selected disabled value="">--- Chọn danh mục ---</option>
                <?php
                $cat = new category();
                $show_cat = $cat->get_category();
                if($show_cat)
                    while($result = $show_cat->fetch_assoc()){
                ?>
                <option value="<?php echo $result['ID'] ?>"><?php echo $result['Name'] ?></option>
                <?php  } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="uname">Nhà sản xuất:</label>
            <select name="producer" class="form-select form-control" aria-label="Default select example" required>
                <option selected disabled value="">--- Chọn nhà sản xuất ---</option>
                <?php
                $producer = new Producer();
                $getProducer = $producer->getProducer();
                if($getProducer)
                    while($result = $getProducer->fetch_assoc()){
                ?>
                <option value="<?php echo $result['id'] ?>"><?php echo $result['name'] ?></option>
                <?php  } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="pwd">Mô tả:</label>
            <textarea class="form-control" id="description" placeholder="" name="description" rows="4" required ></textarea>
        </div>
        <div class="form-group">
            <label for="pwd">Giá:</label>
            <input min=0 type="number" class="form-control" id="" placeholder="" name="price" required>
        </div>
        <div class="form-group">
            <label for="pwd">Upload ảnh:</label>
            <input type="file" class="form-control" id="" placeholder="" name="image" required>
        </div>
        <div class="form-group">
            <label for="pwd">Số lượng:</label>
            <input min=1 type="number" class="form-control" id="" placeholder="" name="quantity" required>
        </div>
        <button name="submit"  type="submit" class="btn btn-primary">Lưu</button>
        <a class="btn btn-primary" href="productManager.php" role="button">Trở lại</a>
    </form>
</div>

<script>
    // Disable form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script src="js/jquery.validate.js"></script>
<script>
    $("#form_add").validate({
			rules: {
				product_name: {
                    url: true
                },
                description:  {
                    url: true
                },
			},
			messages: {
				product_name: {
                    url: "Please fill out this field."
                },
                description:  {
                    url: "Please fill out this field."
                },
			
		}
		});
</script>
<style>
    .error{
        width: 100%;
        font-size: 1rem;
        color: #6e707e;
        line-height: 1.5;
    }
    label.error{
        color: red;
    }
</style>
<?php include 'inc/footer.php' ?>
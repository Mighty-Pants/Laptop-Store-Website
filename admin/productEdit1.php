<?php
include 'inc/header.php';
include_once '../classes/category.php';
include_once '../classes/product1.php';
include_once '../classes/producer.php';

?>

<?php
$product_ = new Product1();
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>window.location = 'productManager.php'</script>";
} else {
    $id = $_GET['id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $modified_by = Session::get('username');
    $update_product = $product_->update_product($id, $_POST, $_FILES, $modified_by);
}
?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Sửa sản phẩm</h1>
    <?php
    if (isset($update_product))
        echo $update_product;
    ?>
    <div class="row">
        <div class="col-md-8">
            <?php
            $getProductByID = $product_->getProductByID($id);
            if ($getProductByID) {
                while ($result_product = $getProductByID->fetch_assoc()) {
            ?>
                    <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" id="form_edit" novalidate>
                        <div class="form-group">
                            <label for="uname">Mã sản phẩm</label>
                            <input type="text" class="form-control" id="" value="<?php echo $result_product['product_name']; ?>" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="uname">Danh mục:</label>
                            <select name="category" class="form-select form-control" aria-label="Default select example" required>
                                <option selected disabled value="">-- Chọn danh mục --</option>
                                <?php
                                $cat = new category();
                                $show_cat = $cat->get_category();
                                if ($show_cat)
                                    while ($result = $show_cat->fetch_assoc()) {
                                ?>
                                    <?php if ($result['ID'] == $result_product['category_id']) { ?>
                                        <option selected value="<?php echo $result['ID'] ?>"><?php echo $result['Name'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $result['ID'] ?>"><?php echo $result['Name'] ?></option>
                                <?php  }
                                    } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="uname">Nhà sản xuất:</label>
                            <select name="producer" class="form-select form-control" aria-label="Default select example" required>
                                <option selected disabled value="">-- Chọn nhà sản xuất --</option>
                                <?php
                                $producer = new Producer();
                                $getProducer = $producer->showProducer();
                                if ($getProducer)
                                    while ($result = $getProducer->fetch_assoc()) {
                                ?>
                                    <?php if ($result['id'] == $result_product['producer_id']) { ?>
                                        <option selected value="<?php echo $result['id'] ?>"><?php echo $result['name'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $result['id'] ?>"><?php echo $result['name'] ?></option>
                                <?php  }
                                    } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Mô tả:</label>
                            <textarea rows="4" class="form-control" id="" placeholder="" name="description" required><?php echo $result_product['description'] ?>
                    </textarea>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Giá:</label>
                            <input min="1" type="text" class="form-control" id="" value="<?php echo $result_product['price'] ?>" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Upload ảnh sản phẩm:</label>
                            <img src="uploads/<?php echo $result_product['image'] ?>" alt="" height="100px">
                            <input type="file" class="form-control" id="" placeholder="" name="image">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Số lượng:</label>
                            <input min="1" type="text" class="form-control" id="" value="<?php echo $result_product['quantity'] ?>" name="quantity" required>
                        </div>
                       
                        <button name="submit" type="submit" class="btn btn-primary">Lưu</button>
                        <a class="btn btn-primary" href="productManager.php" role="button">Trở về</a>
                    </form>
            <?php }
            } ?>
        </div>
        <!-- <div class="col-md-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Product Detail</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div> -->

    </div>
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
    $("#form_edit").validate({
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
<?php
include 'inc/footer.php'
?>
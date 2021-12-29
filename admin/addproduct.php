<?php include 'inc/header.php' ?>
<?php include '../classes/category.php' ?>
<?php include '../classes/product1.php' ?>
<?php

$product_ = new Product1();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $created_by = Session::get('username');

    $insert_product = $product_->insert_product($_POST, $_FILES, $created_by);
}
?>

<div class="container-fluid">
<h1 class="h3 mb-2 text-gray-800">Add Product</h1>
<?php
    if(isset($insert_product))
        echo $insert_product;
?>
<form action="" method="POST" enctype="multipart/form-data">
        <table class="form">
            <tr>
                <td>
                    <label for="">Name</label>
                </td>
                <td>
                    <input type="text" name="product_name" placeholder="Enter name product...">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Select Category</label>
                </td>
                <td>
                    <select name="category" id="">
                        <option value="">-----Select Category-----</option>
                        <?php
                            $cat = new category();
                            $show_cat = $cat->get_category();
                            if($show_cat)
                                while($result = $show_cat->fetch_assoc()){
                        ?>
                            <option value="<?php echo $result['ID'] ?>"><?php echo $result['Name'] ?></option>
                        <?php  } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Description</label>
                </td>
                <td>
                    <textarea name="description" id="" cols="30" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Price</label>
                </td>
                <td>
                    <input type="text" name="price" placeholder="Enter price...">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Upload image</label>
                </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Quantity</label>
                </td>
                <td>
                    <input type="text" name="quantity" placeholder="Enter quantity...">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Detail</label>
                </td>
                <td>
                <textarea name="detail" id="" cols="30" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Status</label>
                </td>
                <td>
                    <select name="status_" id="">
                        <option>Select Status</option>
                        <option value="1">Actived</option>
                        <option value="0">Not Actived</option>
                    </select>
                </t d>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="submit" value="Add" />
                </td>
            </tr>
        </table>
    </form>
                    

</div>

           


<?php include 'inc/footer.php'?>
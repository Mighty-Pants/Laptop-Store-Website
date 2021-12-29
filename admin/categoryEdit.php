<?php
include 'inc/header.php';
include '../classes/category.php';
?>
<?php
    $cat = new category();
   if(!isset($_GET['ID']) || $_GET['ID']==' '){
        echo "<script>window.location = 'categoryManager.php'</script>";
   }else{
        $id = $_GET['ID'];
   }

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $modified_by = Session::get('username');
    $update_cat = $cat->update_category($id, $name, $modified_by);
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Cập nhật danh mục sản phẩm</h1>

    <?php
        if(isset($update_cat))
            echo $update_cat;
        ?>
    <?php
        $get_cat_name = $cat->getCatByID($id);
        if($get_cat_name)
            while($result = $get_cat_name->fetch_assoc()){
    ?>
    <form class="row g-3" method="POST">
        <div class="col-md-3">
            <input name="name" type="text" class="form-control" id="inputEmail4" value="<?php echo $result['Name'] ?>">
        </div>
        <div class="col-12">
          <br>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-primary" href="category.php" role="button">Back</a>
        </div>
    </form>
    <?php
            }
    ?>
    

</div>



<?php
include 'inc/footer.php'
?>
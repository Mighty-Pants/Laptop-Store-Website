<?php
include 'inc/header.php';
include '../classes/producer.php';
?>
<?php
    $producer = new Producer();
   if(!isset($_GET['id']) || $_GET['id']==' '){
        echo "<script>window.location = 'producerManager.php'</script>";
   }else{
        $id = $_GET['id'];
   }

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $modified_by = Session::get('username');
    $update_producer = $producer->update_producer($id, $name);
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Sửa nhà sản xuất</h1>

    <?php
        if(isset($update_producer))
            echo $update_producer;
        ?>
    <?php
        $get_producer = $producer->getProducerByID($id);
        if($get_producer)
            while($result = $get_producer->fetch_assoc()){
    ?>
    <form class="row g-3" method="POST">
        <div class="col-md-3">
            <input name="name" type="text" class="form-control" id="inputEmail4" value="<?php echo $result['name'] ?>">
        </div>
        <div class="col-12">
            <hr/>
            <button type="submit" name="submit" class="btn btn-sm btn-primary">Lưu</button>
            <a class="btn btn-primary btn-sm" href="producerManager.php" role="button">Trở về</a>
        </div>
    </form>
    <?php
            }
    ?>
    

</div>



<?php
include 'inc/footer.php'
?>
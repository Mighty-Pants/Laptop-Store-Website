<?php
include 'inc/header.php';
include_once '../classes/user.php';
include_once '../classes/role.php';
?>
<?php
$user = new User();
$role = new Role();
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>window.location = 'userManager.php'</script>";
} else {
    $id = $_GET['id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $update_user = $user->updateUser($id, $_POST);
}
?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Cập nhật thông tin</h1>
    <?php
    if (isset($update_user))
        echo $update_user;
    ?>
    <?php
    $getUserByID = $user->getUserByID($id);
    if ($getUserByID) {
        while ($result_user = $getUserByID->fetch_assoc()) {
    ?>
        <form action="" method="POST" class="needs-validation" novalidate id="form_edit">
            <input  name="id" value="<?php echo $result_user['id']?>" hidden>
            <div class="form-group">
                <label for="uname">Họ tên</label>
                <input  type="text" class="form-control" id="" name="fullname" value="<?php echo $result_user['fullname']?>" required>
            </div>
            <div class="form-group">
                <label for="uname">Email</label>
                <input  type="email" class="form-control" id="" name="email" value="<?php echo $result_user['email']?>" required>
            </div>
            <div class="form-group">
                <label for="uname">Số điện thoại</label>
                <input maxlength="10" minlength="10" type="number" class="form-control" id="" name="phone_number" value="<?php echo $result_user['phone_number']?>" required>
            </div>
            <div class="form-group">
                <label for="pwd">Địa chỉ</label>
                <input  type="text" class="form-control" id="" name="address" value="<?php echo $result_user['address']?>" required>
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" id="pwd" name="password" value="">
            </div>
            <div class="form-group">
                <label for="">Quyền:</label>
                <select name="role_id" class="form-select form-control" aria-label="Default select example" required>
                    <?php
                    $getRole = $role->getRole();
                    while ($res = $getRole->fetch_assoc()){
                        if($res['id'] == $result_user['role_id']){?>
                            <option selected value="<?php echo $res['id']?>"><?php echo $res['name']?></option>
                    <?php } else { ?>
                            <option value="<?php echo $res['id'] ?>"><?php echo $res['name'] ?></option>
                    <?php  }} ?>
                </select>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Lưu</button>
            <a class="btn btn-primary" href="userManager.php" role="button">Trở về</a>
        </form>
    <?php }
    } ?>

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
                fullname: {
                    url: true,
                },
                address: {
                    url: true,
                }
			},
			messages: {
				fullname: {
					url: "Please fill out this field."
				},
                address: {
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
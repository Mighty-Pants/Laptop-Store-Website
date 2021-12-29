<?php
include 'inc/header.php'
?>
<?php include '../classes/role.php' ?>
<?php include '../classes/user.php' ?>

<?php
$role = new Role();
$getRole = $role->getRole();


$user = new User();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $addUser = $user->addUser($_POST);
}
?>
<!-- include libraries(jQuery, bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Thêm tài khoản</h1>
    <?php
    if (isset($addUser))
        echo $addUser;
    ?>
    <form method="POST" class="needs-validation" novalidate id="form_register">
        <div class="form-group">
            <label for="uname">Họ tên</label>
            <input type="text" class="form-control" id="" name="fullname" required>
        </div>
        <div class="form-group">
            <label for="uname">Email</label>
            <input type="email" class="form-control" id="" name="email" required>
        </div>
        <div class="form-group">
            <label for="uname">Số điện thoại</label>
            <input maxlength="10" minlength="10" type="number" class="form-control" id="" name="phone_number" required>
        </div>
        <div class="form-group">
            <label for="pwd">Địa chỉ</label>
            <input type="text" class="form-control" id="" name="address" required>
        </div>
        <div class="form-group">
            <label for="pwd">Mật khẩu</label>
            <input minlength="5" type="password" class="form-control" id="pwd" name="password" required>
        </div>
        <div class="form-group">
            <label for="pwd">Xác nhận mật khẩu</label>
            <input minlength="5" type="password" class="form-control" id="" name="confirm_password" required>
        </div>
        <div class="form-group">
            <select name="role_id" class="form-select form-control" aria-label="Default select example" required>
                <option selected disabled value="">-- Phân quyền --</option>
                <?php
                while ($res = $getRole->fetch_assoc())
                    echo '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
                ?>
            </select>
        </div>
        <button name="submit" type="submit" class="btn btn-primary">Thêm</button>
        <a class="btn btn-primary" href="userManager.php" role="button">Trở lại</a>
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
    $("#form_register").validate({
			rules: {
                fullname: {
                    url: true,
                },
                address: {
                    url: true,
                },
                confirm_password: {
					equalTo: "#pwd"
				},

			},
			messages: {
				fullname: {
					url: "Please fill out this field."
				},
                address: {
					url: "Please fill out this field."
				},
                confirm_password: {
					equalTo: "Mật khẩu không trùng khớp"
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
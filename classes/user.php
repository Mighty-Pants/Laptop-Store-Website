<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');

?>

<?php
class User
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new database();
		$this->fm = new Format();
	}

	public function getAllUser($index)
	{
		$query = "SELECT tbl_user.*, tbl_role.name as role_name 
                    FROM tbl_user inner join tbl_role on tbl_user.role_id = tbl_role.id
                    WHERE deleted=0 ORDER BY created_date DESC LIMIT " . $index . " ,5";
		$result = $this->db->select($query);
		return $result;
	}
	public  function login_admin($username, $password)
	{
		$username = $this->fm->validation($username);
		$password = $this->fm->validation($password);

		$username = mysqli_real_escape_string($this->db->link, $username);
		$password = mysqli_real_escape_string($this->db->link, $password);

		if (empty($username) || empty($password)) {
			$alert = "<span style='color:red;'>User Name or Password must be not empty</span>";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_user WHERE (phone_number='$username' OR email='$username') AND password = '$password' AND role_id = 1";
			$result = $this->db->select($query);
			if ($result != false) {
				$value = $result->fetch_assoc();
				Session::set('adminlogin', true);
				Session::set('adminID', $value['id']);
				Session::set('fullname', $value['fullname']);
				Session::set('password', $value['password']);
				Session::set('role', $value['role_id']);
				header('Location:index.php');
			} else {
				$alert = "<span style='color:red;'> Incorrect User Name or Password !!!</span>";
				return $alert;
			}
		}
	}
	public function login($data)
	{
		$taikhoan = mysqli_real_escape_string($this->db->link, $data['taikhoan']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));

		if (empty($taikhoan) || empty($password)) {
			$alert = "<h4 style='color:red;'>Vui lòng nhập đầy đủ tài khoản và mật khẩu!!!</h4>";
			return $alert;
		} else {
			$check_login = "SELECT * FROM tbl_user WHERE phone_number='$taikhoan' AND password='$password' AND deleted=0";
			$result_check_login = $this->db->select($check_login);
			if ($result_check_login != false) {
				$temp = $result_check_login->fetch_assoc();
				Session::set('user_login', true);
				Session::set('user_id', $temp['id']);
				Session::set('user_name', $temp['fullname']);
				header('Location:product_summary.php');
			} else {
				$alert = "<h4 style='color:red;'>Tài khoản hoặc mật khẩu không đúng!!!</h4>";
				return $alert;
			}
		}
	}
	public function search_user($keyword, $index)
	{
		$query = "SELECT tbl_user.*, tbl_role.name as role_name 
                    FROM tbl_user inner join tbl_role on tbl_user.role_id = tbl_role.id
                    WHERE deleted=0 and fullname LIKE '%" . $keyword . "%'
                    ORDER BY ID DESC LIMIT " . $index . " ,5";
		$result = $this->db->select($query);
		Session::set('keyword', $keyword);
		return $result;
	}

	public function getUserByID($id)
	{
		$query = "SELECT tbl_user.*, tbl_role.name as role_name 
                    FROM tbl_user inner join tbl_role on tbl_user.role_id = tbl_role.id
                    WHERE deleted=0 and tbl_user.id=$id 
                    ORDER BY ID DESC";
		$result = $this->db->select($query);
		return $result;
	}
	public  function addUserGuest($data)
	{
		$fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$phone_number = mysqli_real_escape_string($this->db->link, $data['phone_number']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$password = mysqli_real_escape_string($this->db->link, $data['password']);

		$password = md5($password);

		if (empty($fullname) || empty($email) || empty($phone_number) || empty($address) || empty($password)) {
			$alert = "<h4 style='color:red;'>Vui lòng nhập đầy đủ thông tin!!!</h4>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_user WHERE email='$email' limit 1";
			$result_check_email = $this->db->select($check_email);

			$check_phone_number = "SELECT * FROM tbl_user WHERE phone_number='$phone_number' limit 1";
			$result_check_phone_number = $this->db->select($check_phone_number);

			if ($result_check_email) {
				$alert = "<h4 style='color:red;'>Email đã được đăng kí trước đây!!!</h4>";
				return $alert;
			} elseif ($result_check_phone_number) {
				$alert = "<h4 style='color:red;'>Số điện thoại đã được đăng kí trước đây!!!</h4>";
				return $alert;
			} else {
				$created_date = date('y-m-d h:i:s');
				$query = "INSERT INTO tbl_user(fullname, email, phone_number, address, password, role_id, created_date, deleted)
                                 VALUES('$fullname', '$email', '$phone_number', '$address', '$password', 2, '$created_date', 0)";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "<h4 style='color:green;'>Add User Successfully !!!</h4>";
					return $alert;
				} else {
					$alert = "<h4 style='color:red;'>Add User  Not Successfully !!!</h4>";
					return $alert;
				}
			}
		}
	}
	public  function addUser($data)
	{

		$fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$phone_number = mysqli_real_escape_string($this->db->link, $data['phone_number']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$password = mysqli_real_escape_string($this->db->link, $data['password']);
		$role_id = mysqli_real_escape_string($this->db->link, $data['role_id']);

		$password = md5($password);

		if (empty($fullname) || empty($email) || empty($phone_number) || empty($address) || empty($password) || empty($role_id)) {
			$msg = "<span style='color:red;'>Fields must be not empty</span>";
			return $msg;
		} else {
			$query_check_phone = "SELECT * FROM tbl_user WHERE phone_number='$phone_number'";
			$result_check_phone = $this->db->select($query_check_phone);

			$query_check_email = "SELECT * FROM tbl_user WHERE email='$email'";
			$result_check_email = $this->db->select($query_check_email);
			if ($result_check_email) {
				$msg = "<span style='color:red;'>Email đã tồn tại</span>";
				return $msg;
			} elseif ($result_check_phone) {
				$msg = "<span style='color:red;'>Số điện thoại đã tồn tại</span>";
				return $msg;
			} else {
				$created_date = date('y-m-d h:i:s');
				$query = "INSERT INTO tbl_user(fullname, email, phone_number, address, password, role_id, created_date, deleted)
                                 VALUES('$fullname', '$email', '$phone_number', '$address', '$password', '$role_id', '$created_date', 0)";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "<span style='color:green;'>Tạo tài khoản thành công !!!</span>";
					return $alert;
				} else {
					$alert = "<span style='color:red;'>Tạo tài khoản thất bại !!!</span>";
					return $alert;
				}
			}
		}
	}
	public function updateUser($id, $data)
	{

		$modified_date = date('y-m-d h:i:s');
		$password = $this->fm->validation($data['password']);

		$id = mysqli_real_escape_string($this->db->link, $data['id']);
		$fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$phone_number = mysqli_real_escape_string($this->db->link, $data['phone_number']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$password = mysqli_real_escape_string($this->db->link, $password);
		$role_id = mysqli_real_escape_string($this->db->link, $data['role_id']);


		$check_email = "SELECT * FROM tbl_user WHERE email='$email' AND id!='$id' limit 1";
		$result_check_email = $this->db->select($check_email);

		$check_phone_number = "SELECT * FROM tbl_user WHERE phone_number='$phone_number' AND id!='$id' limit 1";
		$result_check_phone_number = $this->db->select($check_phone_number);

		if ($result_check_email) {
			$alert = "<span style='color:red;'>Email đã được đăng kí trước đây!!!</span>";
			return $alert;
		} elseif ($result_check_phone_number) {
			$alert = "<span style='color:red;'>Số điện thoại đã được đăng kí trước đây!!!</span>";
			return $alert;
		} else {
			$query = "UPDATE tbl_user SET
            fullname = '$fullname'
            , email = '$email'
            , phone_number = '$phone_number'
            , address = '$address'
            , role_id = '$role_id'
            , modified_date = '$modified_date'
            WHERE id = '$id'";

			$result = $this->db->update($query);

			if ($password != '') {
				$password = md5($password);
				$query1 = "UPDATE tbl_user SET password = '$password'
                WHERE id = '$id'";
				$result1 = $this->db->update($query1);
			}
			if ($result) {
				$alert = "<span style='color:green;'>Update User Successfully !!!</span>";
				return $alert;
			} else {
				$alert = "<span style='color:red;'>Update User  Not Successfully !!!</span>";
				return $alert;
			}
		}
	}
	public function updateProfile($id, $data)
	{

		$modified_date = date('y-m-d h:i:s');

		$fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$phone_number = mysqli_real_escape_string($this->db->link, $data['phone_number']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$check_email = "SELECT * FROM tbl_user WHERE email='$email' AND id!='$id' limit 1";
		$result_check_email = $this->db->select($check_email);

		$check_phone_number = "SELECT * FROM tbl_user WHERE phone_number='$phone_number' AND id!='$id' limit 1";
		$result_check_phone_number = $this->db->select($check_phone_number);

		if ($result_check_email) {
			$alert = "<span style='color:red;'>Email đã được đăng kí trước đây!!!</span>";
			return $alert;
		} elseif ($result_check_phone_number) {
			$alert = "<span style='color:red;'>Số điện thoại đã được đăng kí trước đây!!!</span>";
			return $alert;
		} else {
			$query = "UPDATE tbl_user SET
                        fullname = '$fullname'
                        , email = '$email'
                        , phone_number = '$phone_number'
                        , address = '$address'
                        , modified_date = '$modified_date'
                        WHERE id = '$id'";

			$result = $this->db->update($query);
			if ($result) {
				header("Refresh:0");
			} else {
				$alert = "<span style='color:red;'>Update User  Not Successfully !!!</span>";
				return $alert;
			}
		}
	}

	public function deleteUserByID($id)
	{
		$query = "UPDATE tbl_user SET deleted=1 WHERE id='$id'";
		$result = $this->db->update($query);
		if ($result) {
			$alert = "<span style='color:green;'>Delete User Successfully !!!</span>";
			return $alert;
		} else {
			$alert = "<span style='color:red;'>Delete User Not Successfully !!!</span>";
			return $alert;
		}
	}

	public function count_record()
	{
		$query = "SELECT count(id) as number
                     FROM tbl_user
                     WHERE deleted = 0";
		$result = $this->db->executeResult($query);
		return $result;
	}
	public function getUserByOrderID($order_id)
	{
		$query = "SELECT * FROM tbl_order WHERE id = '$order_id'";
		$result = $this->db->select($query);
		return $result;
	}
}

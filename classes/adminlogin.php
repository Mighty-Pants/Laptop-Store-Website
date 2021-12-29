<?php
    include '../lib/session.php';
    Session::checkLogin();
    include '../lib/database.php';
    include '../helpers/format.php';
?>

<?php
    class adminlogin{

        private $db;
        private $fm;
        public function __construct()
        {
            $this->db = new database();
            $this->fm = new format();
        }

        public  function login_admin($username, $password)
        {
            $username = $this->fm->validation($username);
            $password = $this->fm->validation($password);

            $username = mysqli_real_escape_string($this->db->link, $username);
            $password = mysqli_real_escape_string($this->db->link, $password);

            if(empty($username) || empty($password)){
                $alert = "<span style='color:red;'>User Name or Password must be not empty</span>";
                return $alert;
            }else{ 
                $query = "SELECT * FROM tbl_user WHERE (phone_number='$username' OR email='$username') AND password = '$password' AND role_id = 1";
                $result = $this->db->select($query);
                if($result != false){
                    $value = $result->fetch_assoc();
                    Session::set('adminlogin', true);       
                    Session::set('adminID', $value['id']);
                    Session::set('fullname', $value['fullname']);                 
                    Session::set('password', $value['password']);     
                    Session::set('role', $value['role_id']);            
                    header('Location:index.php');

                }else{
                    $alert = "<span style='color:red;'> Incorrect User Name or Password !!!</span>";
                    return $alert;
                }
            }

        }
    }
?>
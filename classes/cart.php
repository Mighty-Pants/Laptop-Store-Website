<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
    class Cart{
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new database();
            $this->fm = new Format();
        }

        public function addToCart($id, $quantity){
            $quantity = $this->fm->validation($quantity);

            $quantity   = mysqli_real_escape_string($this->db->link, $quantity);
            $id   = mysqli_real_escape_string($this->db->link, $id);
            $sid = session_id();

            $query = "SELECT * FROM tbl_product WHERE id='$id'";
            $result = $this->db->select($query)->fetch_assoc();
            echo '<pre>';
            echo print_r($result);
            echo '</pre>';
        }
    }
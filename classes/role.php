<?php
     $filepath = realpath(dirname(__FILE__));
     include_once ($filepath.'/../lib/database.php');
     include_once ($filepath.'/../helpers/format.php');
?>

<?php
    class Role{
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new database();
            $this->fm = new Format();
        }
        public function getRole(){
            $query = "SELECT * FROM tbl_role";
            $result = $this->db->select($query);
            return $result;
        }
        
    }
<?php
    
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
    
?>

<?php
    class category{

        private $db;
        private $fm;
        public function __construct()
        {
            $this->db = new database();
            $this->fm = new format();
        }

        public  function insert_category($name, $created_by)
        {
            $name = $this->fm->validation($name);

            $name = mysqli_real_escape_string($this->db->link, $name);

            if(empty($name)){
                $alert = "<span style='color:red;'>Category Name must be not empty</span>";
                return $alert;
            }else{ 
                $created_date = date('y-m-d h:i:s');
                $query = "INSERT INTO tbl_category_product(name, created_date, created_by, status)
                             VALUES('$name', '$created_date', '$created_by', 1)";
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span style='color:green;'>Insert Category Successfully !!!</span>";
                    return $alert;
                }else{
                    $alert = "<span style='color:red;'>Insert Category Not Successfully !!!</span>";
                    return $alert;
                }
            }

        }
        public function show_category($index){
            $query = "SELECT * FROM tbl_category_product WHERE status = 1 ORDER BY ID DESC LIMIT " . $index . " ,10";
            $result = $this->db->select($query);
            return $result;
        }

        public function search_cat($index, $keyword)
        {
            $query = "SELECT * FROM tbl_category_product WHERE Name LIKE '%" . $keyword . "%' ORDER BY ID DESC LIMIT " . $index . " ,10";
            $result = $this->db->select($query);
            Session::set('keyword_cat', $keyword);
            return $result;
        }

        public function get_category(){
            $query = "SELECT * FROM tbl_category_product WHERE status = 1";
            $result = $this->db->select($query);
            return $result;
        }

        public function getCatByID($id){
            $query = "SELECT * FROM tbl_category_product WHERE ID='$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function update_category($id, $name, $modified_by){
            $name = $this->fm->validation($name);

            $name = mysqli_real_escape_string($this->db->link, $name);
            $id = mysqli_real_escape_string($this->db->link, $id);

            if(empty($name)){
                $alert = "<span style='color:red;'>Category Name must be not empty</span>";
                return $alert;
            }else{ 
                $modified_date = date('y-m-d h:i:s');

                $query = "UPDATE tbl_category_product SET Name='$name', Modified_by='$modified_by', Modified_date='$modified_date' WHERE ID='$id'";

                             
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span style='color:green;'>Update Category Successfully !!!</span>";
                    return $alert;
                }else{
                    $alert = "<span style='color:red;'>Update Category Not Successfully !!!</span>";
                    return $alert;
                }
            }
        }

        public function delete_category($id){
            $query = "UPDATE  tbl_category_product SET status = 0 WHERE ID='$id'";
            $result = $this->db->update($query);
            if($result){
                $alert = "<span style='color:green;'>Delete Category Successfully !!!</span>";
                return $alert;
            }else{
                $alert = "<span style='color:red;'>Delete Category Not Successfully !!!</span>";
                return $alert;
            }
        }

        public function count_record(){
            $query = "SELECT count(id) as number
                     FROM tbl_category_product
                     WHERE status = 1";
            $result = $this->db->executeResult($query);
            return $result;
        }

    }
?>
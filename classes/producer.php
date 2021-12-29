<?php
    
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
    
?>

<?php
    class Producer{

        private $db;
        private $fm;
        public function __construct()
        {
            $this->db = new database();
            $this->fm = new format();
        }
        public function insert_producer($name)
        {
            $name = $this->fm->validation($name);

            $name = mysqli_real_escape_string($this->db->link, $name);

            if(empty($name)){
                $alert = "<span style='color:red;'>Bạn chưa nhập nhà sản xuất!!!</span>";
                return $alert;
            }else{ 
                $query = "INSERT INTO tbl_producer(name, deleted)
                                VALUES('$name',  0)";
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
        
        public function getAllProducer($index){
            $query = "SELECT * FROM tbl_producer 
                    WHERE deleted = 0
                    ORDER BY ID ASC  LIMIT " . $index . " ,5"; 
            $result = $this->db->select($query);
            return $result;
        }
        public function showProducer(){
            $query = "SELECT * FROM tbl_producer 
                    WHERE deleted = 0 "; 
            $result = $this->db->select($query);
            return $result;
        }

        public function getProducer(){
            $query = "SELECT * FROM tbl_producer 
                    WHERE deleted = 0
                    ORDER BY ID ASC "; 
            $result = $this->db->select($query);
            return $result;
        }

  

        public function getProducerByID($id){
            $query = "SELECT * FROM tbl_producer WHERE id='$id' AND deleted=0";
            $result = $this->db->select($query);
            return $result;
        }
        public function search_producer( $index, $keyword){
            $query = "SELECT * FROM tbl_producer 
                     WHERE deleted = 0 AND name LIKE '%" . $keyword . "%'
                     ORDER BY ID DESC
                     LIMIT " . $index . " ,5"; 
            $result = $this->db->select($query);
            Session::set('keyword_producer', $keyword);
            return $result;
        }

        public function update_producer($id, $name){
            $name = $this->fm->validation($name);

            $name = mysqli_real_escape_string($this->db->link, $name);
            $id = mysqli_real_escape_string($this->db->link, $id);

            if(empty($name)){
                $alert = "<span style='color:red;'>Category Name must be not empty</span>";
                return $alert;
            }else{ 

                $query = "UPDATE tbl_producer SET name='$name' WHERE ID='$id'";
                             
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span style='color:green;'>Cập nhật thành công !!!</span>";
                    return $alert;
                }else{
                    $alert = "<span style='color:red;'>Cập nhật thất bại !!!</span>";
                    return $alert;
                }
            }
        }

        public function getProducerByCatId($catId)
        {
            $query = "SELECT tbl_producer.name as producer, tbl_producer.id as proId
                    FROM tbl_product
                    INNER JOIN tbl_producer ON tbl_product.producer_id = tbl_producer.id
                    WHERE tbl_product.category_id = '$catId' AND tbl_producer.deleted = 0
                    GROUP BY tbl_producer.id
                    ";
            $result = $this->db->select($query);
            return $result;
        }
        // public function update_category($id, $name, $modified_by){
        //     $name = $this->fm->validation($name);

        //     $name = mysqli_real_escape_string($this->db->link, $name);
        //     $id = mysqli_real_escape_string($this->db->link, $id);

        //     if(empty($name)){
        //         $alert = "<span style='color:red;'>Category Name must be not empty</span>";
        //         return $alert;
        //     }else{ 
        //         $modified_date = date('y-m-d h:i:s');

        //         $query = "UPDATE tbl_category_product SET Name='$name', Modified_by='$modified_by', Modified_date='$modified_date' WHERE ID='$id'";

                             
        //         $result = $this->db->update($query);
        //         if($result){
        //             $alert = "<span style='color:green;'>Update Category Successfully !!!</span>";
        //             return $alert;
        //         }else{
        //             $alert = "<span style='color:red;'>Update Category Not Successfully !!!</span>";
        //             return $alert;
        //         }
        //     }
        // }

        // public function delete_category($id){
        //     $query = "UPDATE  tbl_category_product SET status = 0 WHERE ID='$id'";
        //     $result = $this->db->update($query);
        //     if($result){
        //         $alert = "<span style='color:green;'>Delete Category Successfully !!!</span>";
        //         return $alert;
        //     }else{
        //         $alert = "<span style='color:red;'>Delete Category Not Successfully !!!</span>";
        //         return $alert;
        //     }
        // }

        public function delete_producer($id)
        {
            $query = "UPDATE tbl_producer SET deleted=1 WHERE ID='$id'";
                             
            $result = $this->db->update($query);
            if($result){
                $alert = "<span style='color:green;'>Xoá thành công !!!</span>";
                return $alert;
            }else{
                $alert = "<span style='color:red;'>Xoá thất bại !!!</span>";
                return $alert;
            }
        }

        public function count_record_search($keyword){
            $query = "SELECT count(id) as number
                     FROM tbl_producer
                     WHERE deleted = 0 AND name LIKE '%" . $keyword . "%'";
            $result = $this->db->executeResult($query);
            Session::set('keyword_producer', $keyword);
            return $result;
        }
        public function count_record(){
            $query = "SELECT count(id) as number
                     FROM tbl_producer
                     WHERE deleted = 0";
            $result = $this->db->executeResult($query);
            return $result;
        }

    }
?>
<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
    include_once ($filepath.'/../lib/session.php');
?>

<?php
    class Product1{
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new database();
            $this->fm = new Format();
        }
        
        public function insert_product($data, $file, $created_by)
        {

            $name_product = $this->fm->validation($data['product_name']);
            $description = $this->fm->validation($data['description']);

            $name_product   = mysqli_real_escape_string($this->db->link, $name_product);
            $category_id    = mysqli_real_escape_string($this->db->link, $data['category']);
            $producer_id    = mysqli_real_escape_string($this->db->link, $data['producer']);
            $description    = mysqli_real_escape_string($this->db->link, $description);
            $price          = mysqli_real_escape_string($this->db->link, $data['price']);
            $quantity       = mysqli_real_escape_string($this->db->link, $data['quantity']);

            //kiem tra hinh anh va lay hinh anh cho vao folder uploads
            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;

            $product_detail_id = 0;
            if( $category_id ==13 OR  $category_id == 14){
                $product_detail_id = 1;
            }
            if($producer_id=='' || $name_product=='' || $category_id=='' || $description=='' || $price=='' ||  $file_name=='' || $quantity=='' || $file_name=='' ){
                $alert = "<span style='color:red;'>Hãy nhập đủ thông tin</span>";
                return $alert;
            }else{ 
                move_uploaded_file($file_temp, $uploaded_image);

                $created_date = date('y-m-d h:i:s');

                $query = "INSERT INTO tbl_product(product_name, description, image, price, quantity, category_id, producer_id, product_detail_id, created_date, created_by, status)
                             VALUES('$name_product', '$description', '$unique_image', '$price', '$quantity', '$category_id', '$producer_id', '$product_detail_id','$created_date', '$created_by', 1)";
                
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span style='color:green;'>Thêm sản phẩm thành công !!!</span>";
                    return $alert;
                }else{
                    $alert = "<span style='color:red;'>Thêm sản phẩm thất bại !!!</span>";
                    return $alert;
                }
            }

        }
        public function show_product($index){
            $query = "SELECT * FROM tbl_product WHERE status = 1 ORDER BY ID DESC  LIMIT ".$index." ,10";
            $result = $this->db->select($query);
            return $result;
        }

        public function getProductByID($id){
            $query = "SELECT * FROM tbl_product WHERE id='$id'";
            $result = $this->db->select($query);
            return $result;
        }

       

        public function getProductByID_2($id){
            $query = "SELECT * FROM tbl_product WHERE id='$id'";
            $result = $this->db->executeResult($query);
            return $result;
        }
    

        public function getProductDetailByID($id){
            $query_check = "SELECT product_detail_id
                            FROM tbl_product
                            WHERE tbl_product.id='$id'";
            $result_check = $this->db->select($query_check)->fetch_assoc();

            if($result_check['product_detail_id']==0){
                return 0;
            }else{
                $query = "SELECT tbl_product_detail.* FROM tbl_product
                INNER JOIN tbl_product_detail ON  tbl_product.product_detail_id = tbl_product_detail.id
                WHERE tbl_product.id='$id'";
                $result = $this->db->select($query);
                return $result->fetch_assoc();
            }
           
        }

        public function getProductByCatID($id, $index){
            $query = "SELECT * FROM tbl_product
                     WHERE category_id='$id' and status =1
                     LIMIT ".$index." ,6";
            $result = $this->db->select($query);
            return $result;
        }

        public function getProductByProducerID($brandId, $catId, $index){
            $query = "SELECT * FROM tbl_product
                     WHERE producer_id ='$brandId' AND category_id = '$catId' AND status =1
                     LIMIT ".$index." ,6";
            $result = $this->db->select($query);
            return $result;
        }

        public function getCatName($id){
            $query = "SELECT * FROM tbl_category_product
                     WHERE id='$id' and status =1";
            $result = $this->db->select($query);
            return $result;
        }

        public function getNewProduct(){
            $query = "SELECT * FROM tbl_product WHERE status =1  ORDER BY ID DESC  LIMIT 4";
            $result = $this->db->select($query);
            return $result;
        }
        public function getTopProduct(){
          $query = "SELECT SUM(num), product_id
                    FROM tbl_order_detail 
                    WHERE status =1  
                    GROUP BY product_id
                    ORDER BY SUM(num) DESC  LIMIT 4";
          $result = $this->db->select($query);
          return $result;
      }
        public function update_product($id, $data, $file, $modified_by){

            $modified_date = date('y-m-d h:i:s');

            $description = $this->fm->validation($data['description']);

            $name_product   = mysqli_real_escape_string($this->db->link, $data['product_name']);
            $category_id    = mysqli_real_escape_string($this->db->link, $data['category']);
            $producer_id      = mysqli_real_escape_string($this->db->link, $data['producer']);
            $description    = mysqli_real_escape_string($this->db->link, $description);
            $price          = mysqli_real_escape_string($this->db->link, $data['price']);
            $quantity       = mysqli_real_escape_string($this->db->link, $data['quantity']);

            //kiem tra hinh anh va lay hinh anh cho vao folder uploads
            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;

            if($name_product=='' || $category_id=='' || $description=='' || $price=='' || $quantity=='' ||  $producer_id ==''){
                $alert = "<span style='color:red;'>Hãy nhập đủ thông tin</span>";
                return $alert;
            }
            else{ 
                if(!empty($file_name)){
                    //neu nguoi dung chon anh
                    // if($file_size > 1048567){
                    //     $alert=  "<span style='color:red;'>Image Size should be less than 1MB</span>";
                    //     return $alert;
                    // }else
                    if(in_array($file_ext, $permited) === false){
                        $alert = "<span style='color:red;'>You can upload only:-".implode(', ', $permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query = "UPDATE tbl_product SET 
                    product_name='$name_product',
                    image='$unique_image',
                    description='$description',
                    price='$price',
                    quantity='$quantity',
                    category_id='$category_id',
                    producer_id='$producer_id',
                    modified_date='$modified_date',
                    modified_by='$modified_by'
                    WHERE id='$id'
                    ";

                }else{
                    //neu nguoi dung khong chon anh
                    $query = "UPDATE tbl_product SET 
                    product_name='$name_product',
                    description='$description',
                    price='$price',
                    quantity='$quantity',
                    category_id='$category_id',
                    producer_id='$producer_id',
                    modified_date='$modified_date',
                    modified_by='$modified_by'
                    WHERE id='$id'
                    ";
                }
                     
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span style='color:green;'>Cập nhật thành công !!!</span>";
                    return $alert;
                }else{
                    $alert = "<span style='color:red;'>Cập nhật thất bại !!!</span>";
                    return $alert;
                }
            }
        }

        public function deleteProductByID($id){
            $query = "UPDATE tbl_product SET status=0 WHERE id='$id'";
            $result = $this->db->update($query);
            if($result){
                $alert = "<span style='color:green;'>Xoá sản phẩm thành công !!!</span>";
                return $alert;
            }else{
                $alert = "<span style='color:red;'>Xoá sản phẩm thất bại !!!</span>";
                return $alert;
            }
        }

        public function count_id(){
            $query = "SELECT count(id) as number 
                    FROM tbl_product
                    WHERE status=1";
            $result = $this->db->executeResult($query);
            return $result;
        }

        public function count_productByBrand_Cat($brand_id, $catId){
            $query = "SELECT count(id) as number 
                    FROM tbl_product
                    WHERE status=1 AND producer_id='$brand_id' AND category_id='$catId'";
            $result = $this->db->executeResult($query);
            return $result;
        }

        public function countProductSearched($keyword){
            $query = "SELECT count(id) as number 
                    FROM tbl_product
                    WHERE status=1 AND product_name LIKE '%".$keyword."%'";
            $result = $this->db->executeResult($query);
            return $result;
        }

        public function search_product($keyword, $index){
            $query = "SELECT * FROM tbl_product 
                    WHERE status=1 AND product_name LIKE '%".$keyword."%'  
                    ORDER BY ID DESC  LIMIT ".$index." ,5";
            $result = $this->db->select($query);
            Session::set('keyword', $keyword);
            return $result;
        }
      

        public function search_product1($keyword){
            $query = "SELECT * FROM tbl_product 
                    WHERE product_name LIKE '%".$keyword."%'  and status=1
                    ORDER BY ID DESC ";
            $result = $this->db->select($query);
            Session::set('keyword', $keyword);
            return $result;
        }

        public function getRelatedProduct($proId)
        {
          $query = "SELECT category_id, producer_id FROM tbl_product WHERE id='$proId'";
          $result = $this->db->select($query)->fetch_assoc();

          $category_id = $result['category_id'];
          $producer_id = $result['producer_id'];

          $query = "SELECT * FROM tbl_product
          WHERE producer_id ='$producer_id' AND category_id = '$category_id' AND status =1
          LIMIT 0 ,6";
          $result = $this->db->select($query);
          return $result;
        }
}
?>


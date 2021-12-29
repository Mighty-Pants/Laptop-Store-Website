<?php

use function PHPSTORM_META\elementType;

$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class Order
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new database();
        $this->fm = new Format();
    }

    public function getAllOrder($index)
    {
        $query = "SELECT * FROM tbl_order ORDER BY status ASC, created_date DESC LIMIT " . $index . " ,5";
        $result = $this->db->select($query);
        return $result;
    }

    public function search_user($keyword, $index)
    {

        $query = "SELECT * 
                FROM tbl_order 
                WHERE fullname LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%' OR phone_number LIKE '%" . $keyword . "%'
                ORDER BY status ASC, created_date DESC LIMIT " . $index . " ,5";
        $result = $this->db->select($query);
        Session::set('keyword_order', $keyword);
        return $result;
    }

    public function getOrderbyID($id)
    {
        $query = "SELECT * FROM tbl_order WHERE id=$id ORDER BY created_date DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getDetailByID($id)
    {
        $query = "SELECT tbl_order_detail.*, tbl_product.image, tbl_product.product_name
                FROM tbl_order_detail INNER JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.id
                WHERE tbl_order_detail.order_id = $id
                ORDER BY created_date DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getQuarter1()
    {
        $query = "SELECT SUM(total_money) as total_money
                FROM tbl_order
                WHERE status=1 AND (MONTH(created_date)=1 OR MONTH(created_date)=2 OR MONTH(created_date)=3)";
        $result = $this->db->select($query);
        return $result;
    }
    public function getQuarter2()
    {
        $query = "SELECT SUM(total_money) as total_money
                FROM tbl_order
                WHERE status=1 AND (MONTH(created_date)=4 OR MONTH(created_date)=5 OR MONTH(created_date)=6)";
        $result = $this->db->select($query);
        return $result;
    }
    public function getQuarter3()
    {
        $query = "SELECT SUM(total_money) as total_money
                FROM tbl_order
                WHERE status=1 AND (MONTH(created_date)=7 OR MONTH(created_date)=8 OR MONTH(created_date)=9)";
        $result = $this->db->select($query);
        return $result;
    }
    public function getQuarter4()
    {
        $query = "SELECT SUM(total_money) as total_money
                FROM tbl_order
                WHERE status=1 AND (MONTH(created_date)=10 OR MONTH(created_date)=11 OR MONTH(created_date)=12)";
        $result = $this->db->select($query);
        return $result;
    }
    public function getMoney_CurrentMonth()
    {
        $currentMonth = date('m');
        $query = "SELECT SUM(total_money) as total_money
                FROM tbl_order
                WHERE status=1 AND MONTH(created_date)=$currentMonth";
        $result = $this->db->select($query);
        return $result;
    }

    public function getMoney_CurrentYear()
    {
        $currentYear = date('Y');
        $query = "SELECT SUM(total_money) as total_money
                FROM tbl_order
                WHERE status=1 AND  YEAR(created_date)=$currentYear";
        $result = $this->db->select($query);
        return $result;
    }

    public function addToCart($id, $quantity)
    {
        $quantity = $this->fm->validation($quantity);

        $quantity   = mysqli_real_escape_string($this->db->link, $quantity);
        $id   = mysqli_real_escape_string($this->db->link, $id);
        $sid = session_id();

        $checkCart = "SELECT * FROM tbl_order_detail
                    WHERE product_id='$id' AND sid = '$sid' AND status=0";
        $res = $this->db->select($checkCart);

        if ($res) {
            $update_order_detail = "UPDATE tbl_order_detail 
                                    SET num = num +'$quantity'
                                    WHERE product_id='$id' AND sid = '$sid' AND status=0";
            $result_update = $this->db->update($update_order_detail);
            if ($result_update) {
                $this->getQuantity();
                header('location:product_summary.php');
            } else {
                header('location:404.php');
            }
        } else {
            $query = "SELECT * FROM tbl_product WHERE id='$id'";
            $result = $this->db->select($query)->fetch_assoc();

            $price = $result['price'];
            $total_price = (int)$quantity *  (float)$result['price'];
            $query_insert_order = "INSERT INTO tbl_order_detail(product_id, price, num, total_price, sid, status)
                                            VALUES ('$id', '$price', '$quantity', '$total_price', '$sid', 0 )";
            $result_insert_order = $this->db->insert($query_insert_order);
            if ($result_insert_order) {
                $this->getQuantity();
                header('location:product_summary.php');
            } else {
                header('location:404.php');
            }
        }
    }

    public  function getProductOrder()
    {
        $sid = session_id();

        $query = "SELECT tbl_product.product_name as name
                        ,tbl_product.image as image
                        ,tbl_product.quantity as maxQuantity
                        ,tbl_order_detail.num as quantity
                        ,tbl_order_detail.price as price
                        ,tbl_order_detail.total_price as total_price
                        ,tbl_order_detail.id as id
                FROM tbl_product 
                INNER JOIN tbl_order_detail ON tbl_product.id = tbl_order_detail.product_id
                WHERE tbl_order_detail.sid='$sid' AND tbl_order_detail.status=0";
        $result = $this->db->select($query);
        return $result;
    }

    function getQuantity()
    {
        $sid = session_id();
        $query = "SELECT SUM(num) as quantity
        FROM tbl_order_detail
        WHERE sid='$sid' AND status=0";
        $quantity = $this->db->select($query);

        $qty =  $quantity->fetch_assoc()['quantity'];
        if ($qty > 0)
            Session::set('qty', $qty);
        else
            Session::set('qty', '0');
    }

    public function updateOrderDetail($id, $quantity)
    {
        $quantity   = mysqli_real_escape_string($this->db->link, $quantity);
        $id         = mysqli_real_escape_string($this->db->link, $id);

        $query1 = "SELECT * FROM tbl_order_detail WHERE id='$id'";
        $result = $this->db->select($query1)->fetch_assoc();

        $price = $result['price'];
        $total_price = (int)$quantity *  (float)$result['price'];

        $query2 = "UPDATE tbl_order_detail 
                SET num='$quantity', total_price='$total_price'
                WHERE id='$id'";
        $result2 = $this->db->update($query2);
        $this->getQuantity();
        header('location:product_summary.php');
    }
    public function deleteOrderDetail($id)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $query = "DELETE FROM tbl_order_detail WHERE id='$id' AND status=0";
        $result = $this->db->delete($query);
        $this->getQuantity();
        header('location:product_summary.php');
    }
    public function check_cart()
    {
        $sid = session_id();

        $query = "SELECT * FROM tbl_order_detail WHERE sid='$sid' AND status=0";
        $result = $this->db->select($query);
        return $result;
    }

    public function delDataCart()
    {
        $sid = session_id();

        $query = "DELETE FROM tbl_order_detail WHERE sid='$sid' AND status=0";
        $result = $this->db->delete($query);
        return $result;
    }
    public function updateStatus($data)
    {
        $id = mysqli_real_escape_string($this->db->link, $data['order_id']);
        $status = mysqli_real_escape_string($this->db->link, $data['updateStatus']);

        if ($status == 1) {
            $getPro = "SELECT product_id, num FROM tbl_order_detail WHERE order_id='$id'";
            $result_getPro = $this->db->select($getPro);
            while ($temp = $result_getPro->fetch_assoc()) {
                $pro_id = $temp['product_id'];
                $quantity = $temp['num'];
                $update_quantity_pro = "UPDATE tbl_product SET quantity=quantity-$quantity WHERE id='$pro_id'";
                $result_update_quantity_pro = $this->db->update($update_quantity_pro);
            }
        }
        $query = "UPDATE  tbl_order SET status='$status' WHERE id='$id' ";
        $result = $this->db->update($query);
        header('location:orderManager.php');
        return $result;
    }

    public function cancelOrder($order_id)
    {
        $id = mysqli_real_escape_string($this->db->link, $order_id);
       
        $query = "UPDATE  tbl_order SET status='2' WHERE id='$id' ";
        $result = $this->db->update($query);
        
        return $result;
    }
    public function addOrder($user_id, $data)
    {
        $sid = session_id();
        $created_date = date('y-m-d h:i:s');

        $user_id = mysqli_real_escape_string($this->db->link, $user_id);
        $fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $phone_number = mysqli_real_escape_string($this->db->link, $data['phone_number']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        $note = mysqli_real_escape_string($this->db->link, $data['note']);

        if (empty($fullname) || empty($email) || empty($phone_number) || empty($address)) {
            $alert = "<span style='color:red;'>Vui lòng nhập đầy đủ thông tin giao hàng</span>";
            return false;
        } else {
            $query_get_total_money = "SELECT SUM(total_price) as total_money FROM tbl_order_detail WHERE sid='$sid' AND status=0";
            $result_get_total_money = $this->db->select($query_get_total_money)->fetch_assoc();
            $total_money = $result_get_total_money['total_money'];

            $query_insert_order = "INSERT INTO tbl_order(user_id, fullname, email, phone_number, address, note, created_date, status, total_money)
                                    VALUES('$user_id', '$fullname', '$email', '$phone_number', '$address', '$note', '$created_date', 0, '$total_money' )";
            $result_insert_order = $this->db->insert($query_insert_order);

            $query_get_order_id = "SELECT id FROM tbl_order WHERE created_date='$created_date'";
            $result_get_order_id = $this->db->select($query_get_order_id)->fetch_assoc();

            $order_id = $result_get_order_id['id'];

            $query_update_detail_order = "UPDATE tbl_order_detail 
                                            SET order_id='$order_id', status=1
                                            WHERE sid='$sid' AND status=0";

            $result_update_detail_order = $this->db->update($query_update_detail_order);
            $this->getQuantity();
            return true;
        }
    }
    public function count_record()
    {
        $query = "SELECT count(id) as number
                 FROM tbl_order";
        $result = $this->db->executeResult($query);
        return $result;
    }
    public function rateOrderCompleted()
    {
        $query_get_completed = "SELECT count(id) as total_order_completed FROM tbl_order WHERE status = 1 ";
        $result_get_completed = $this->db->select($query_get_completed)->fetch_assoc();

        $query_total_order = "SELECT count(id) as total_order FROM tbl_order";
        $result_total_order = $this->db->select($query_total_order)->fetch_assoc();

        $rate = $result_get_completed['total_order_completed'] /  $result_total_order['total_order'];
        return $rate;
    }

    public function getOrderByUserID($user_id)
    {
        $user_id = mysqli_real_escape_string($this->db->link, $user_id);
        $query = "SELECT * FROM tbl_order WHERE user_id='$user_id' ORDER BY created_date DESC";

        $result = $this->db->update($query);
        return $result;
    }
    public function getDetailByOrderID($order_id)
    {
        $order_id = mysqli_real_escape_string($this->db->link, $order_id);
        $query = "SELECT tbl_product.product_name as name
                        ,tbl_product.image as image
                        ,tbl_product.quantity as maxQuantity
                        ,tbl_order_detail.num as quantity
                        ,tbl_order_detail.price as price
                        ,tbl_order_detail.total_price as total_price
                        ,tbl_order_detail.id as id
                FROM tbl_product 
                INNER JOIN tbl_order_detail ON tbl_product.id = tbl_order_detail.product_id
                WHERE tbl_order_detail.order_id='$order_id'";
        $result = $this->db->select($query);
        return $result;
    }
}

?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class Feedback
{
  private $db;
  private $fm;

  public function __construct()
  {
    $this->db = new database();
    $this->fm = new Format();
  }
  public function addFeedback($data, $proId)
  {

    $created_date = date('y-m-d h:i:s');
    $sid = session_id();

    $fullname = mysqli_real_escape_string($this->db->link, $data['fullname']);
    $phone_number = mysqli_real_escape_string($this->db->link, $data['phone_number']);
    $email = mysqli_real_escape_string($this->db->link, $data['email']);
    $subject_name = mysqli_real_escape_string($this->db->link, $data['subject_name']);
    $note = mysqli_real_escape_string($this->db->link, $data['note']);

    $query = "INSERT INTO tbl_feedback( s_id, fullname, phone_number, email, subject_name, product_id, note, created_date)
                                        VALUES('$sid', '$fullname', '$phone_number', '$email', '$subject_name', '$proId', '$note', '$created_date')";
    $result = $this->db->insert($query);
    if ($result)
      return "<h4 style='color:green;'>Gửi thành công !!!</h4>";
    return "<span style='color:green;'>Gửi thất bại !!!</span>";
  }

  public function getAllFeedback($index)
  {
    $query = "SELECT * FROM tbl_feedback ORDER BY status ASC, created_date DESC LIMIT " . $index . " ,5";
    $result = $this->db->select($query);
    return $result;
  }

  public function updateStatus($feedbackID)
  {
    $modified_date = date('y-m-d h:i:s');

    $query = "UPDATE tbl_feedback
                    SET status = 1, modified_date = '$modified_date'
                    WHERE id='$feedbackID'";
    $result = $this->db->update($query);
    header('Location:feedbackManager.php');
    return $result;
  }
  public function count_record()
  {
    $query = "SELECT count(id) as number
                     FROM tbl_feedback";
    $result = $this->db->executeResult($query);
    return $result;
  }

  public function count_record_search($keyword)
  {
    $query = "SELECT count(id) as number
                   FROM tbl_feedback
                   WHERE (phone_number LIKE '%" . $keyword . "%') OR (subject_name LIKE '%" . $keyword . "%')";
    $result = $this->db->executeResult($query);
    return $result;
  }
  public function search_feedback($index, $keyword)
  {
    $query = "SELECT * FROM tbl_feedback 
                 WHERE (phone_number LIKE '%" . $keyword . "%') OR (subject_name LIKE '%" . $keyword . "%')
                 ORDER BY id DESC
                 LIMIT " . $index . " ,5";
    $result = $this->db->select($query);
    Session::set('keyword_feedback', $keyword);
    return $result;
  }

  public function getFeedbackPending()
  {
    $query = "SELECT count(id) as total FROM tbl_feedback WHERE status = 0";
    $result = $this->db->select($query)->fetch_assoc()['total'];
    return $result;
  }
  public function getFeedbackByProId($proId)
  {
    $query = "SELECT * FROM tbl_feedback WHERE product_id='$proId' ORDER BY created_date DESC";
    $result = $this->db->select($query);
    return $result;
  }
  public function delete_feedback($id)
  {
    $query = "DELETE FROM tbl_feedback WHERE id = '$id'";
    $result = $this->db->delete($query);
    if($result){
      $alert = "<span style='color:green;'>Xoá đánh giá thành công !!!</span>";
      return $alert;
  }else{
      $alert = "<span style='color:red;'>Xoá đánh giá thất bại !!!</span>";
      return $alert;
  }
  }
}

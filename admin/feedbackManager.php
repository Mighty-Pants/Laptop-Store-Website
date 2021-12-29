<?php
include 'inc/header.php';
include '../classes/feedback.php';
?>

<?php
$feedback = new Feedback();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateStatus'])) {
  $feedbackID = $_POST['feedbackID'];
  $updateStatus = $feedback->updateStatus($feedbackID);
}
?>
<?php
//tim kiem
$search = '';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    $count_record = $feedback->count_record_search($keyword);

    $number = 0;
    if ($count_record != null && count($count_record) > 0) {
        $number = $count_record[0]['number'];
    }

    $pages = ceil($number / 5);
    $current_page = 1;
    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
    }
    $index = ($current_page - 1) * 5;
    $getFeedback = $feedback->search_feedback($index, $keyword);
    $search = Session::get('keyword_feedback');
}else{

  $count_record = $feedback->count_record();

  $number = 0;
  if ($count_record != null && count($count_record) > 0) {
    $number = $count_record[0]['number'];
  }
  $pages = ceil($number / 5);
  $current_page = 1;
  if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
  }
  $index = ($current_page - 1) * 5;
  $getFeedback = $feedback->getAllFeedback($index);
  $search = Session::get('keyword_feedback');
}
//Xoa
if (isset($_GET['delID'])) {
  $id = $_GET['delID'];
  $delFeed = $feedback->delete_feedback($id);
  header("Location:feedbackManager.php");
}
?>
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Quản lí feedback</h1>
  <p>
    <?php
      if (isset($delFeed))
      echo $delFeed; 
    ?>
  </p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <form action="" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
          <input type="text" name="keyword" value="<?php if ($search) echo $search ?>" class="form-control " placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search fa-sm"><a href="?search"></a></i>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Họ tên</th>
              <th>Số điện thoại</th>
              <th>Email</th>
              <th>Tiêu đề</th>
              <th>Ngày tạo</th>
              <th>Nội dung</th>
              <th>Trạng thái</th>
            </tr>
          </thead>

          <tbody>
            <?php
            if ($getFeedback) {
              $stt = 0;
              while ($res = $getFeedback->fetch_assoc()) {
            ?>
                <tr>
                  <td><?php echo $res['fullname']; ?></td>
                  <td><?php echo $res['phone_number']; ?></td>
                  <td><?php echo $res['email']; ?></td>
                  <td><?php echo $res['subject_name']; ?></td>
                  <td><?php echo $res['created_date'] ?></td>
                  <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#example<?php echo $res['id']; ?>">
                      Xem
                    </button>
                    || <a onclick="return confirm('Are you sure to delete?')" 
                     href="?delID=<?php echo $res['id']?>">Delete</a>
                    <!-- Modal -->
                    <div class="modal fade" id="example<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $res['subject_name']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <?php echo $res['note']; ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <form action="" method="POST">
                      <input hidden type="text" name="feedbackID" value="<?php echo $res['id'] ?>">
                      <?php
                      if ($res['status'] == 0)
                        echo '<button type="submit" class="btn btn-sm btn-danger" name="updateStatus">Đã đọc</button>';
                      else echo '';
                      ?>
                    </form>
                  </td>
                </tr>
            <?php }
            } ?>


          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php
        for ($i = 0; $i < $pages; $i++) {
          echo '<li class="page-item"><a class="page-link" href="?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
        }
        ?>
      </ul>
    </nav>
  </div>
</div>

<!-- End of Main Content -->

<!-- Footer -->
<?php
include 'inc/footer.php'
?>
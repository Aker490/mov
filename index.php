<?php
include('connect.php');

$limit_page = 8;
$num_rows = mysqli_num_rows(mysqli_query($con,"SELECT * FROM data_movie"));
// Check if 'Page' is set in the URL query parameters
$page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1; // Default to 1 if not set

$num_page = $num_rows/$limit_page;

$limit_start = ($page - 1) * $limit_page; // Calculate the starting limit

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="https://www.anime-sugoi.com/upload/icon.png?v=6">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./">Aker</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./">หน้าแรก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<!-- เมนูส่วนบน   -->

<div class="album py-5">
    <div class="container">

    <div class="row">
        <?php
        $query = mysqli_query($con,"SELECT * FROM data_movie ORDER BY id DESC LIMIT $limit_start,$limit_page");
        while($result = mysqli_fetch_array($query)){
        ?>
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <a href="./list.php?id=<?=$result['id']?>">
                <img src="<?=$result['img']?>" width="100%" height="400" alt="aa">
                <div class="card-body">
                    <p class="card-text text-center"><?=$result['name']?></p>
                </div>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?Page=<?php echo $page - 1; ?>">ก่อน</a>
        </li>
        
        <?php 
        // Logic สำหรับการย่อหน้าและการไฮไลท์หน้าปัจจุบัน
        $total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM data_movie");
        $total_result = mysqli_fetch_array($total_query);
        $total_pages = ceil($total_result['total'] / $limit_page);

        $range = 2; // จำนวนหน้าที่แสดงก่อนและหลังหน้าปัจจุบัน
        $first_page = 1;
        $last_page = $total_pages;

        if ($page > ($range + 1)) {
            echo '<li class="page-item"><a class="page-link" href="?Page='.$first_page.'">'.$first_page.'</a></li>';
            echo '<li class="page-item disabled"><span class="page-link">..</span></li>';
        }

        for ($i = max($page - $range, 1); $i <= min($page + $range, $total_pages); $i++) {
            echo '<li class="page-item '.($page == $i ? 'active' : '').'"><a class="page-link" href="?Page='.$i.'">'.$i.'</a></li>';
        }

        if ($page < ($total_pages - $range)) {
            echo '<li class="page-item disabled"><span class="page-link">..</span></li>';
            echo '<li class="page-item"><a class="page-link" href="?Page='.$last_page.'">'.$last_page.'</a></li>';
        }
        ?>

        <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?Page=<?php echo $page + 1; ?>">หลัง</a>
        </li>
    </ul>
</nav>

</div>

<footer class="blog-footer text-center">
    <p>ดุหนังฟรี ต้องที่นี้ <a href="./">Movie Php</a></p>
</footer>
</body>
</html>

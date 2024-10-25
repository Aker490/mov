<?php
include('connect.php');

// ตรวจสอบว่า ID และ Episode ถูกส่งมาและเป็นตัวเลข
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$episode = isset($_GET['list']) ? intval($_GET['list']) : null; // ใช้ 'list' เป็น episode number

if (!$id) {
    echo 'NoID';
    exit;
}

// Query เพื่อดึงข้อมูลภาพยนตร์
$query_movie = mysqli_query($con, "SELECT * FROM data_movie WHERE id = $id");
$movie_result = mysqli_fetch_array($query_movie);

if (!$movie_result) {
    echo 'Movie not found';
    exit;
}

// Query เพื่อดึงข้อมูลตอน (ถ้ามีการระบุ episode)
if ($episode) {
    $query_episode = mysqli_query($con, "SELECT * FROM data_list WHERE main_id = $id AND episode = $episode");
    $episode_result = mysqli_fetch_array($query_episode);

    if (!$episode_result) {
        echo 'Episode not found';
        exit;
    }
}

// Query เพื่อดึงรายการตอนทั้งหมด
$query_list = mysqli_query($con, "SELECT * FROM data_list WHERE main_id = $id");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$movie_result['name']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="https://www.anime-sugoi.com/upload/icon.png?v=6">
</head>
<body>

<!-- เมนูส่วนบน -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./">Aker</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="./">หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link" href="./">Link</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Dropdown</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link disabled">Disabled</a></li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<div class="album py-5">
    <div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">หน้าแรก</a></li>
            <li class="breadcrumb-item active" aria-current="page">
    <?=$movie_result['name']?> 
    <?php 
        // ตรวจสอบสถานะของเรื่อง
        $status = ($movie_result['status'] == 'completed') ? 'จบแล้ว' : 'ยังไม่จบ';
        echo ' - ' . $status; 
    ?>
</li>

        </ol>
    </nav>

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <img src="<?=$movie_result['img']?>" width="100%" height="380" class="card-img-top" alt="Movie image">
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-4 shadow-sm">
                <iframe width="100%" height="380" src="https://www.youtube.com/embed/<?=$movie_result['vdo_ex']?>" 
                        title="YouTube video player" frameborder="0" allowfullscreen></iframe>
            </div>
            <!-- แสดงสถานะของภาพยนตร์ -->
            <p><strong>สถานะ:</strong> 
                <?php 
                if ($movie_result['status'] == 'completed') {
                    echo 'จบแล้ว';
                } else {
                    echo 'ยังไม่จบ';
                }
                ?>
            </p>
        </div>
    </div>

    <div class="row">
         <div class="col-md-12">
            <div class="card mb-1 shadow-sm text-center" style="background-color: rgb(41, 36, 36);">
                <h2 style="color: rgb(255, 255, 255);">ตอนทั้งหมด</h2>
            </div>
            <div class="card mb-4 shadow-sm">
            <ul class="list-group">
            <?php 
// แสดงข้อมูลตอนจาก query_list
while($result_list = mysqli_fetch_array($query_list)) {
    // ตรวจสอบสถานะของแต่ละตอน
    $status = ($movie_result['status'] == 'completed') ? 'จบแล้ว' : 'ยังไม่จบ';
    
    // แสดงผลรายการตอน พร้อมสถานะ
    echo '<li class="list-group-item list-group-item-secondary">
            <a href="play.php?id='.$result_list['main_id'].'&list='.$result_list['episode'].'" class="text-decoration-none">'
            .$result_list['name'].' ตอนที่ '.$result_list['episode'].'
          </a>
          </li>';
}
?>

</ul>
            </div>
        </div>
    </div>
</div>

<footer class="blog-footer text-center">
    <p>ดูหนังฟรี ต้องที่นี้ <a href="./">Movie Php</a></p>
</footer>

</body>
</html>

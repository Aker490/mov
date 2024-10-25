<?php
include('connect.php');

// ตรวจสอบว่า ID และ Episode ถูกส่งมาและเป็นตัวเลข
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$list = isset($_GET['list']) ? intval($_GET['list']) : null; // ตรวจสอบว่า 'list' (episode) เป็นตัวเลข

if (!$id) {
    echo 'NoID';
    exit;
}

// ตรวจสอบว่าเป็นการดึงข้อมูลภาพยนตร์หรือข้อมูลตอน
if (!$list) {
    // ดึงข้อมูลภาพยนตร์
    $query = mysqli_query($con, "SELECT * FROM data_movie WHERE id = $id");
} else {
    // ดึงข้อมูลตอน
    $query = mysqli_query($con, "SELECT * FROM data_list WHERE main_id = $id AND episode = $list");
}

// ตรวจสอบว่ามีผลลัพธ์จากการ query หรือไม่
if ($query && mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_array($query);
} else {
    echo 'Data not found';
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$result['name']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="https://www.anime-sugoi.com/upload/icon.png?v=6">
</head>
<body>

<!-- เมนูส่วนบน   -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./">Navbar</a>
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
            <li class="breadcrumb-item"><a href="./"><?=$result['name']?></a></li>
        </ol>
    </nav>

    <div class="row">
         <div class="col-md-12">
            <div class="card mb-1 shadow-sm text-center" style="background-color: rgb(41, 36, 36);">
                <h2 style="color: rgb(255, 255, 255);">
                    <?php if ($list) { echo 'ตอนที่ '.$result['episode']; } else { echo $result['name']; } ?>
                </h2>
            </div>
            <div class="card mb-4 shadow-sm">
                <iframe width="100%" height="623" src="https://www.youtube.com/embed/<?=$result['vdo']?>" 
                        title="YouTube video player" frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
             </div>
        </div>
    </div>
</div>


<footer class="blog-footer text-center">
    <p>ดูหนังฟรี ต้องที่นี้ <a href="./">Movie Php</a></p>
</footer>
</body>
</html>

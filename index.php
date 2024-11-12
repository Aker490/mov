<?php
include('connect.php');

$limit_page = 8;

// Handle search query if it exists
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

// Modify SQL query based on search query
if ($search_query) {
    $query_sql = "SELECT * FROM data_movie WHERE name LIKE '%$search_query%'";
} else {
    $query_sql = "SELECT * FROM data_movie";
}

$num_rows = mysqli_num_rows(mysqli_query($con, $query_sql));

$page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
$num_page = ceil($num_rows / $limit_page);
$limit_start = ($page - 1) * $limit_page;

$query_sql .= " ORDER BY id DESC LIMIT $limit_start, $limit_page";
$query = mysqli_query($con, $query_sql);

if (!$query) {
    die('Query failed: ' . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Aker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./">หน้าแรก</a>
                    </li>
                    <!-- other nav items -->
                </ul>
                <!-- Search form -->
                <form class="d-flex" role="search" method="get" action="">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= htmlentities($search_query) ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="album py-5">
        <div class="container">
            <div class="row">
                <?php
                while($result = mysqli_fetch_array($query)){
                ?>
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm">
                        <a href="./list.php?id=<?=$result['id']?>">
                            <img src="<?=$result['img']?>" width="100%" height="400" alt="<?=$result['name']?>">
                            <div class="card-body">
                                <p class="card-text text-center"><?=$result['name']?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?Page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search_query); ?>">ก่อน</a>
                    </li>
                    <?php 
                    $range = 2;
                    $total_pages = ceil($num_rows / $limit_page);

                    if ($page > ($range + 1)) {
                        echo '<li class="page-item"><a class="page-link" href="?Page=1&search='.urlencode($search_query).'">1</a></li>';
                        echo '<li class="page-item disabled"><span class="page-link">..</span></li>';
                    }

                    for ($i = max($page - $range, 1); $i <= min($page + $range, $total_pages); $i++) {
                        echo '<li class="page-item '.($page == $i ? 'active' : '').'"><a class="page-link" href="?Page='.$i.'&search='.urlencode($search_query).'">'.$i.'</a></li>';
                    }

                    if ($page < ($total_pages - $range)) {
                        echo '<li class="page-item disabled"><span class="page-link">..</span></li>';
                        echo '<li class="page-item"><a class="page-link" href="?Page='.$total_pages.'&search='.urlencode($search_query).'">'.$total_pages.'</a></li>';
                    }
                    ?>
                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?Page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search_query); ?>">หลัง</a>
                    </li>
                </ul>
            </nav>
        </div>

        <footer class="blog-footer text-center">
            <p>ดูหนังฟรี ต้องที่นี้ <a href="./">Movie Php</a></p>
        </footer>
</body>

</html>

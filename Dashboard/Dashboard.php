<?php
$servername = "localhost";
$username = "root";
$password = "1236789";
$dbname = "movie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $img_url = isset($_POST['img_url']) ? $_POST['img_url'] : '';
    $vdo_ex_url = isset($_POST['vdo_ex_url']) ? $_POST['vdo_ex_url'] : '';

    // Handle add action
    if ($action === 'add') {
        $check_sql = "SELECT * FROM data_movie WHERE name = ? AND category = ? AND img = ? AND vdo_ex = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ssss", $name, $category, $img_url, $vdo_ex_url);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows == 0) {
            $sql = "INSERT INTO data_movie (name, category, status, img, vdo_ex) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $category, $status, $img_url, $vdo_ex_url);
            $stmt->execute();
        }
    } 
    // Handle edit action
    elseif ($action === 'edit' && $id) {
        $sql = "UPDATE data_movie SET name=?, category=?, status=?, img=?, vdo_ex=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $category, $status, $img_url, $vdo_ex_url, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } 
    // Handle delete action
    elseif ($action === 'delete' && $id) {
        $sql = "DELETE FROM data_movie WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT * FROM data_movie");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Dashboard</title>
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="icon"
        href="https://png.pngtree.com/element_our/png/20181227/movie-icon-which-is-designed-for-all-application-purpose-new-png_287896.jpg?v=6">
</head>

<body>
    <h1>Movie Dashboard</h1>
    <form id="add-movie-form" method="POST">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="id" id="movie-id">

        <label for="name">ชื่อเรื่อง:</label>
        <input type="text" id="name" name="name" required>

        <label for="category">หมวดหมู่:</label>
        <select id="category" name="category">
            <option value="action">Action</option>
            <option value="drama">Drama</option>
            <option value="comedy">Comedy</option>
        </select>

        <label for="status">สถานะ:</label>
        <textarea id="status" name="status" required></textarea>

        <label for="img_url">ลิงก์รูปภาพปก:</label>
        <input type="url" id="img_url" name="img_url" placeholder="https://example.com/image.jpg" required>

        <label for="vdo_ex_url">ลิงก์วิดีโอตัวอย่าง หรือ Video ID:</label>
        <input type="text" id="vdo_ex_url" name="vdo_ex_url" placeholder="https://example.com/video.mp4 or YouTube ID"
            required>

        <button type="submit">บันทึก</button>
    </form>
    <center>
    <h2>รายการหนัง</h2>
    </center>
    <table>
        <tr>
            <th>ชื่อเรื่อง</th>
            <th>หมวดหมู่</th>
            <th>สถานะ</th>
            <th>รูปภาพปก</th>
            <th>วิดีโอตัวอย่าง</th>
            <th>จัดการ</th>
            <center>
            <a href=./Dashboard.php>Dashboard</a>
            </center>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><a href="<?php echo $row['img']; ?>" target="_blank">ดูรูปภาพ</a></td>
            <td><a href="<?php echo $row['vdo_ex']; ?>" target="_blank">ดูวิดีโอตัวอย่าง</a></td>
            <td>
                <button type="button"
                    onclick="populateForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">แก้ไข</button>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">ลบ</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <script>
    function populateForm(data) {
        document.getElementById('name').value = data.name;
        document.getElementById('category').value = data.category;
        document.getElementById('status').value = data.status;
        document.getElementById('img_url').value = data.img;
        document.getElementById('vdo_ex_url').value = data.vdo_ex;
        document.getElementById('movie-id').value = data.id;

        document.querySelector("input[name='action']").value = 'edit';
    }
    </script>
</body>

</html>


<?php $conn->close(); ?>
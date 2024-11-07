<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';
    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $main_id = htmlspecialchars($_POST['main_id'] ?? '', ENT_QUOTES, 'UTF-8');
    $episode = htmlspecialchars($_POST['episode'] ?? '', ENT_QUOTES, 'UTF-8');
    $vdo = htmlspecialchars($_POST['vdo'] ?? '', ENT_QUOTES, 'UTF-8');
    $vdo_02 = htmlspecialchars($_POST['vdo_02'] ?? '', ENT_QUOTES, 'UTF-8');
    $vdo_03 = htmlspecialchars($_POST['vdo_03'] ?? '', ENT_QUOTES, 'UTF-8');

    if ($action === 'add') {
        $check_sql = "SELECT COUNT(*) AS count FROM data_list WHERE name = ? AND vdo = ? AND vdo_02 = ? AND vdo_03 = ? AND main_id = ? AND episode = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ssssss", $name, $vdo, $vdo_02, $vdo_03, $main_id, $episode);
        $stmt->execute();
        $check_result = $stmt->get_result()->fetch_assoc();

        if ($check_result['count'] == 0) {  // Only insert if no duplicates are found
            $insert_sql = "INSERT INTO data_list (name, main_id, vdo, vdo_02, vdo_03, episode) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssssss", $name, $main_id, $vdo, $vdo_02, $vdo_03, $episode);
            $stmt->execute();
            
            // Redirect to avoid duplicate submission on page refresh
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        $stmt->close();
    } elseif ($action === 'edit' && $id) {
        $update_sql = "UPDATE data_list SET name=?, main_id=?, vdo=?, vdo_02=?, vdo_03=?, episode=? WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssssi", $name, $main_id, $vdo, $vdo_02, $vdo_03, $episode, $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete' && $id) {
        $delete_sql = "DELETE FROM data_list WHERE id=?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM data_list");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="Dashboard.css">
</head>
<body>
    <h1>Movie Dashboard</h1>
    <form id="add-movie-form" method="POST">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="id" value="">
        <label for="name">ชื่อเรื่อง:</label>
        <input type="text" id="name" name="name" required>

        <label for="main_id">Main ID:</label>
        <input type="text" id="main_id" name="main_id" required>
        
        <label for="episode">Episode</label>
        <input type="text" id="episode" name="episode" required>

        <label for="vdo">Video ID:</label>
        <input type="text" id="vdo" name="vdo" required>

        <label for="vdo_02">Video ID 2:</label>
        <input type="text" id="vdo_02" name="vdo_02" required>

        <label for="vdo_03">Video ID 3:</label>
        <input type="text" id="vdo_03" name="vdo_03" required>

        <button type="submit">บันทึก</button>
    </form>
    
    <center>
        <h2>รายการหนัง</h2>
        <table>
            <tr>
                <th>ชื่อเรื่อง</th>
                <th>Main ID</th>
                <th>Episode</th>
                <th>Vdo</th>
                <th>Vdo2</th>
                <th>Vdo3</th>
                <th>จัดการ</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['main_id']; ?></td>
                <td><?php echo $row['episode']; ?></td>
                <td><?php echo $row['vdo']; ?></td>
                <td><?php echo $row['vdo_02']; ?></td>
                <td><?php echo $row['vdo_03']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="edit">
                        <button type="button" onclick="populateForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">แก้ไข</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit">ลบ</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </center>

    <script>
        function populateForm(data) {
            document.getElementById('name').value = data.name;
            document.getElementById('main_id').value = data.main_id;
            document.getElementById('episode').value = data.episode;
            document.getElementById('vdo').value = data.vdo;
            document.getElementById('vdo_02').value = data.vdo_02;
            document.getElementById('vdo_03').value = data.vdo_03;
            document.querySelector("input[name='action']").value = 'edit';
            document.querySelector("input[name='id']").value = data.id;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>

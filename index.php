<?php

$dsn = "mysql:host=localhost;dbname=todolist";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "connection fucking failed bitch:" . $e->getMessage();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tasks = $_POST["tasks"];

    try {
        $query = "INSERT INTO tasks (tasks) VALUES (:tasks);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":tasks", $tasks);
        $stmt->execute();
        $pdo = null;
        $stmt = null;
        header("Location: index.php");
        die();
    } catch (PDOException $e) {
        die("Query Failed:" . $e->getMessage());
    }
}

$stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do List</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/de8e2530fe.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>To-do List</h1>
        <form action="index.php" method="post">
            <input type="text" name="tasks" placeholder="Enter new task.." id="">
            <button type="submit" name="addtask">Add Task</button>
        </form>
        <ul>
            <?php foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) ?>
            <li>
                <strong><?php echo $row["tasks"]; ?></strong>
                <div class="actions">
                    <a href="index.php?complete=<?php echo $row['id']; ?>"><i class="fa-solid fa-circle-check"></i></a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></a>
                </div>
            </li>
        </ul>
    </div>
</body>

</html>
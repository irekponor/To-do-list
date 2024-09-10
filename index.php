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

if (isset($_POST["addtask"])) {
    $task = $_POST["task"];
    $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (:task)");
    $stmt->bindParam(":task", $task);
    $stmt->execute();
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>To-do List</h1>
        <form action="index.php" method="post">
            <input type="text" name="task" placeholder="Enter new task.." id="">
            <button type="submit" name="addtask">Add Task</button>
        </form>
    </div>
</body>

</html>
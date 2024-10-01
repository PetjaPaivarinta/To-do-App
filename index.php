<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="Assets/TodoStyle.css">
    <script>
        function showCreateTodo() {
           window.location.href = "create.php";
        }
    </script>
</head>
<body>
    <?php
        include 'header.php';
    ?>

    <button id="makeit" onclick="showCreateTodo()">Create new To-Do</button>

    <div id="createContainer"></div>

    <?php
        include 'db.php';
        $conn = OpenCon();

        $sql = "SELECT * FROM todos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='todo'>";
                echo "<h2>" . $row['title'] . "</h2>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>Due Date: " . $row['due_date'] . "</p>";
                echo "<button onclick='window.location.href=\"edit.php?id=" . $row['id'] . "\"'>Edit</button>";
                echo "<button id='delete' onclick='window.location.href=\"delete.php?id=" . $row['id'] . "\"'>Delete</button>";
                echo "</div>";
            }
        } else {
            echo "0 results";
        }

        include 'footer.php';
    ?>
</body>
</html>
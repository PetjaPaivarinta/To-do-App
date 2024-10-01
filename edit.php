<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create To-Do</title>
    <link rel="stylesheet" href="Assets/TodoStyle.css">
    <script src="/mysqlphptodoapp-PetjaPaivarinta/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea#default',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });
        });
    </script>
</head>
<body>
<?php
include 'db.php';
$conn = OpenCon();

if (isset($_GET['id']) || isset($_POST['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission
        $title = $_POST['title'];
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];

        $sql = "UPDATE todos SET title = ?, description = ?, due_date = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $description, $due_date, $id);

        if ($stmt->execute()) {
            echo "Task updated successfully.";
        } else {
            echo "Error updating task: " . $conn->error;
        }

        $stmt->close();
    } else {
        // Display the form with the current task details
        $sql = "SELECT * FROM todos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo $row['title']; ?>">
                <label for="description">Description:</label>
                <textarea id="default" name="description"><?php echo $row['description']; ?></textarea>
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" value="<?php echo $row['due_date']; ?>">
                <button type="submit">Update</button>
            </form>
            <?php
        } else {
            echo "Task not found.";
        }

        $stmt->close();
    }
} else {
    echo "No task ID provided.";
}

$conn->close();
?>
</body>
</html>
<?php
include 'db.php';
$conn = OpenCon();

if (isset($_GET['id']) || isset($_POST['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

    $sql = "DELETE FROM todos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Task deleted successfully.";
        header ("Location: index.php");
    } else {
        echo "Error deleting task: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No task ID provided.";
}

$conn->close();
?>
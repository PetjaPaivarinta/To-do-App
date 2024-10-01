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
    <div class="makeTodo">
        <form action="create.php" method="POST">
            <input required type="text" id="title" name="todoTitle" placeholder="Title">
            <br>
            <textarea required id="default" name="todoDescription"></textarea>
            <br>
            <span>Due Date</span>
            <br>
            <input required type="date" name="todoDate">
            <br>
            <button name="submit1" type="submit">Add To-Do</button>
        </form>
    </div>

    <?php
        include 'db.php';
        $conn = OpenCon();
        
        if (isset($_POST['submit1'])) {
            $title = $_POST['todoTitle'];
            $description = $_POST['todoDescription'];
            $date = $_POST['todoDate'];

            $sql = "INSERT INTO todos (title, description, due_date) VALUES ('$title', '$description', '$date')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                header ("Location: index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        CloseCon($conn);
    ?>
</body>
</html>
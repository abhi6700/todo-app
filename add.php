<?php
include('connection.php');
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$error = "";

if(isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    if (isset($_POST['title']) && isset($_POST['description'])) {
        if($_POST['title']=="" || $_POST['description']==""){
            $error = "Please enter title and description";
        } else {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $sql = "INSERT INTO list (title, description) VALUES (?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ss", $title, $description);
            if ($stmt->execute()) {
                header("Location: index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Vertical (basic) form</h2>
        <form action="add.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
            </div>
            <div class="form-group">
                <label for="email">Description:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
            </div>
            <?php if(isset($error)) {?>
            <p style="color:red;"><?php echo $error; ?></p>
            <?php } ?>
            <a href="index.php" class="btn btn-light">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
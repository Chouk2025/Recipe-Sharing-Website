<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    $target_dir = __DIR__ . "/uploads/";
    $target_file = "uploads/" . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if ($_FILES["picture"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO recipes (user_id, picture, name, ingredients, instructions) 
                      VALUES ('$user_id', '$target_file', '$name', '$ingredients', '$instructions')";
            if ($conn->query($query) === TRUE) {
                header("Location: home.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Add a New Recipe</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="picture" accept="image/*" required><br>
        <input type="text" name="name" placeholder="Recipe Name" required><br>
        <textarea name="ingredients" placeholder="Ingredients" rows="5" required></textarea><br>
        <textarea name="instructions" placeholder="Instructions" rows="5" required></textarea><br>
        <button type="submit">Add Recipe</button>
    </form>
    <a href="home.php">Back</a>
</body>
</html>

<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $recipe_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $check_query = "SELECT * FROM recipes WHERE id='$recipe_id' AND user_id='$user_id'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $delete_query = "DELETE FROM recipes WHERE id='$recipe_id'";
        if ($conn->query($delete_query) === TRUE) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "You do not have permission to delete this recipe.";
        exit();
    }
} else {
    header("Location: home.php");
    exit();
}
?>

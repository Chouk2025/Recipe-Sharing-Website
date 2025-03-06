<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit();
}

$recipe_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM recipes WHERE id='$recipe_id' AND user_id='$user_id'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    $update_query = "UPDATE recipes SET 
                        name='$name', 
                        ingredients='$ingredients', 
                        instructions='$instructions' 
                     WHERE id='$recipe_id'";
                     
    if ($conn->query($update_query) === TRUE) {
        header("Location: view_recipe.php?id=$recipe_id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Edit Recipe</h2>
    <form method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required><br>
        <textarea name="ingredients" rows="5" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea><br>
        <textarea name="instructions" rows="5" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea><br>
        <button type="submit">Update Recipe</button>
    </form>
    <a href="view_recipe.php?id=<?php echo $recipe_id; ?>">Cancel</a>
</body>
</html>

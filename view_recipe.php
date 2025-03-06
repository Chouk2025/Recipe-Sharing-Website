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

$query = "SELECT * FROM recipes WHERE id='$recipe_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc();
} else {
    echo "Recipe not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Recipe</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="recipe-details">
        <h2><?php echo htmlspecialchars($recipe['name']); ?></h2>
        <img src="<?php echo htmlspecialchars($recipe['picture']); ?>" alt="Recipe Image">

        <div class="box">
            <p><strong>Ingredients:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
        </div>

        <div class="box">
            <p><strong>Instructions:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
        </div>

        <div class="buttons">
            <a href="home.php">Back</a>

            <?php if ($recipe['user_id'] == $user_id): ?>
                <a href="edit_recipe.php?id=<?php echo $recipe_id; ?>">Edit</a>
                <form method="POST" action="delete_recipe.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                    <input type="hidden" name="id" value="<?php echo $recipe_id; ?>">
                    <button type="submit">Delete</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

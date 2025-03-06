<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM recipes";
$result = $conn->query($query);
$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="header">
    <h2 class="header-title">Welcome to the Recipe Hub!</h2>
    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search for recipes..." onkeyup="searchRecipes()">
    </div>
</div>
    <div id="recipeList">
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-item" onclick="viewRecipe(<?php echo $recipe['id']; ?>)">
            <img src="<?php echo htmlspecialchars($recipe['picture']); ?>" alt="Recipe Image">
            <p><?php echo htmlspecialchars($recipe['name']); ?></p>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="top-right-buttons">
    <a href="add_recipe.php">Add Recipe</a>
    <a href="logout.php">Log Out</a>
    </div>
</body>
</html>

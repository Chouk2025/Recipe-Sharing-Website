function searchRecipes() {
    const searchInput = document.getElementById('searchBar').value.toLowerCase();
    const recipes = document.querySelectorAll('.recipe-item');

    if (searchInput === "") {
        recipes.forEach(recipe => {
            recipe.style.display = 'none';
        });
    } else {
        recipes.forEach(recipe => {
            const recipeName = recipe.querySelector('p').textContent.toLowerCase();
            recipe.style.display = recipeName.includes(searchInput) ? 'block' : 'none';
        });
    }
}
function viewRecipe(recipeId) {
    window.location.href = `view_recipe.php?id=${recipeId}`;
}


<?php
/* Allyson West */

use DI\Container;


return function (Container $container) {
// Set a dependency called "Recipe"
    $container->set('Recipe', function () {
        return new RecipeController();
    });
    //set a dependency called "Cuisine"
    $container->set('Cuisine', function () {
        return new CuisineController();
    });
    // Set a dependency called "Category"
    $container->set('Category', function () {
        return new CategoryController();
    });
    // Set a dependency called "Ingredient"
    $container->set('Ingredient', function () {
        return new IngredientController();
    });

    // Set a dependency called "RecipeCategory"
    $container->set('RecipeCategory', function () {
        return new RecipeCategoryController();
    });

    // Set a dependency called "DietaryInformation"
    $container->set('DietaryInformation', function () {
        return new DietaryInformationController();
    });

    // Set a dependency called "RecipeIngredient"
    $container->set('RecipeIngredient', function () {
        return new RecipeIngredientController();
    });

    // Set a dependency called "RecipeDietary"
    $container->set('RecipeDietary', function () {
        return new RecipeDietaryController();
    });




};
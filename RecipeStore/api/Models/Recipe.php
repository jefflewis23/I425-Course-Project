<?php
//Recipe Model
//Jon Ross Richardson

namespace RecipeStore\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{

    //The table associated with this model
    protected $table = 'recipe';
    //The primary key of the table
    protected $primaryKey = 'recipe_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    // Define the many to many relationship between Recipe and Cuisine model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function cuisine()
    {
        return $this->belongsToMany(Cuisine::class, 'recipeCuisine', 'recipe_id', 'cuisine_id');
    }

    // Define the many to many relationship between Recipe and Ingredient model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function ingredient()
    {
        return $this->belongsToMany(Ingredient::class, 'recipeIngredient', 'ingredient_id', 'cuisine_id');
    }

    // Define the many to many relationship between Recipe and DietaryInformation model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function dietary()
    {
        return $this->belongsToMany(DietaryInformation::class, 'recipeDietary', 'dietary_id', 'cuisine_id');
    }

// Define the one to many (inverse) relationship between Category and Recipe
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    /*
    // Define the one to many relationship between Recipe and RecipeCategory model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function RecipeCategory() {
        return $this->hasMany(RecipeCategory::class, 'recipe_id');
    }
    // Define the one to many relationship between Recipe and RecipeIngredient model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function RecipeIngredient() {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id');
    }
    // Define the one to many relationship between Recipe and RecipeDietary model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function RecipeDietary() {
        return $this->hasMany(RecipeDietary::class, 'recipe_id');
    }

*/
    //Retrieve all cuisines
    public static function getRecipes()
    {
//Retrieve all cuisines
        $recipes = self::with('recipe_id')->get();
        return $recipes;
    }

    //View a specific cuisine by id
    public static function getCuisinesByID(string $id)
    {
        $recipes = self::findOfFail($id);
        $recipes->load('recipe_id');
        return $recipes;
    }

    //Insert a new recipe
    public static function createRecipe($request)
    {
        //retrieve parameters from request body
        $params = $request->getParsedBody();

        //create a new Recipe instance
        $recipe = new Recipe();

        //set Recipe's attributes
        foreach ($params as $field => $value) {
            $recipe->$field = $value;
        }

        //Insert into database
        $recipe->save();
        return $recipe;

    }


}

;
<?php
//Recipe Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class Recipe extends Model{

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

    // Define the one to many relationship between Recipe and RecipeCuisine model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function RecipeCuisine() {
        return $this->hasMany(RecipeCuisine::class, 'recipe_id');
    }
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


    //Retrieve all cuisines
    public static function getRecipes() {
//Retrieve all cuisines
        $recipes = self::with('recipe_id')->get();
        return $recipes;
    }
    //View a specific professor by id
    public static function getCuisinesByID(string $id) {
        $recipes = self::findOfFail($id);
        $recipes->load('recipe_id');
        return $recipes;
    }


};
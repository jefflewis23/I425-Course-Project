<?php
//Ingredient Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class Ingredient extends Model{

    //The table associated with this model
    protected $table = 'ingredient';
    //The primary key of the table
    protected $primaryKey = 'ingredient_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;


    // Define the one to many relationship between Cuisine and RecipeCuisine model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function ingredients() {
        return $this->hasMany(Ingredient::class, 'ingredient_id');
    }

    //Retrieve all cuisines
    public static function getIngredients() {
//Retrieve all cuisines
        $ingredients = self::with('ingredients_id')->get();
        return $ingredients;
    }
    //View a specific professor by id
    public static function getIngredientsByID(string $id) {
        $ingredients = self::findOfFail($id);
        $ingredients->load('ingredients_id');
        return $ingredients;
    }


};

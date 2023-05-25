<?php
//RecipeCategory Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class RecipeCategory extends Model{

    //The table associated with this model
    protected $table = 'recipeCategory';
    //The primary key of the table
    protected $primaryKey = 'recipe_category_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;



// Define the one to many (inverse) relationship between Recipe and RecipeCategory
    public function recipe() {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
// Define the one to many (inverse) relationship between Category and RecipeCategory
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //Retrieve all recipe categories
    public static function getRecipeCategories() {
        $RP = self::with(['recipe_id', 'category_id'])->get();
        return $RP;
    }

    //Retrieve a specific recipe by a category number
    public static function getRecipeCategoryByID(int $category) {
        $rc = self::findOrFail($category);
        $rc->load('recipe_id')->load('category_id');
        return $rc;
    }


};


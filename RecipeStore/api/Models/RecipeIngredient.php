<?php
//RecipeIngredient Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class RecipeIngredient extends Model {

    //The table associated with this model
    protected $table = 'recipeIngredient';
    //The primary key of the table
    protected $primaryKey = 'recipe_ingredient_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;


    


};


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


};

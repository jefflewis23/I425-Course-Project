<?php
//Cuisine Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class Cuisine extends Model{

    //The table associated with this model
    protected $table = 'cuisine';
    //The primary key of the table
    protected $primaryKey = 'cuisine_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;


    // Define the many to many relationship between Recipe and Cuisine model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function recipe() {
        return $this->belongsToMany(Recipe::class, 'recipeCuisine', 'recipe_id', 'cuisine_id');
    }

    //Retrieve all cuisines
    public static function getCuisines() {
//Retrieve all cuisines
        $cuisines = self::with('cuisine_id')->get();
        return $cuisines;
    }
    //View a specific professor by id
    public static function getCuisinesByID(string $id) {
        $cuisines = self::findOfFail($id);
        $cuisines->load('cuisine_id');
        return $cuisines;
    }

};


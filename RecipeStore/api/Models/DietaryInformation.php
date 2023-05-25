<?php
//DietaryInformation Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class DietaryInformation extends Model {

    //The table associated with this model
    protected $table = 'dietaryInformation';
    //The primary key of the table
    protected $primaryKey = 'dietary_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;


    // Define the many to many relationship between Recipe and Category model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function recipe() {
        return $this->belongsToMany(Recipe::class, 'recipeDietary', 'recipe_id', 'dietary_id');
    }

    //Retrieve all dietary types
    public static function getDietary() {
//Retrieve all cuisines
        $dietary = self::with('dietaryInformation_id')->get();
        return $dietary;
    }
    //View a specific professor by id
    public static function getDietaryByID(string $id) {
        $dietary = self::findOfFail($id);
        $dietary->load('dietaryInformation_id');
        return $dietary;
    }

};


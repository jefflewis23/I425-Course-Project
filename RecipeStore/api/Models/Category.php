<?php
//Category Model
//Jon Ross Richardson

namespace RecipeStore\Models;
use Illuminate\Database\Eloquent\Model;

Class Category extends Model {

    //The table associated with this model
    protected $table = 'category';
    //The primary key of the table
    protected $primaryKey = 'category_id';
    //The PK is non-numeric
    public $incrementing = false;
    //If the PF is not an integer, set its type
    protected $keyType = 'char';
    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    // Define the one to many relationship(inverse) between Recipe and Category model classes
// The first para is the model class name; the second parameter is the foreign key.
    public function recipe() {
        return $this->hasMany(Recipe::class, 'category_id');
    }


    //Retrieve all cuisines
    public static function getCategories() {
//Retrieve all cuisines
        $categories = self::with('category_id')->get();
        return $categories;
    }
    //View a specific professor by id
    public static function getCategoryByID(string $id) {
        $category = self::findOfFail($id);
        $category->load('category_id');
        return $category;
    }

};


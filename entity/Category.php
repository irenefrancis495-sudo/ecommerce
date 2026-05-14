<?php
namespace Mpemba\Entity;

use Mpemba\Utils\Utility;

class Category{

    public static function getAllCategories():array{
        return Utility::safeQuery("SELECT id,name FROM `categories` ORDER BY name ASC;");
    }

    public static function getCategoryById($id){
        return Utility::safeQuery("SELECT * FROM `categories` WHERE id = ?;",[$id],'SELECT');
    }
}
<?php

class Product {
    public $id;
    public $name;
    public $price;
    public $stock;
    public $category;

    public function __construct($id, $name, $price, $stock, $category) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
    }

    public static function getProducts():array{

    $products = [
    ['id'=>101,'name'=>'King Burger','price'=>6.99,'stock'=>120,'category'=>'Burgers'],
    ['id'=>102,'name'=>'Chicken Noodles','price'=>5.49,'stock'=>80,'category'=>'Noodles'],
    ['id'=>103,'name'=>'Hot & Sour Soup','price'=>3.99,'stock'=>50,'category'=>'Soups'],
    ];

    return $products;
    }

    public function get():array{
        return self::getProducts();
    }
}
<?php
class Product extends CI_Model
{
   public $products;

    public function __construct()
    {
        $this->products=$products = [
            [ "name" => "Sledgehammer", "price" => 125.75 ],
            [ "name" => "Axe", "price" => 190.50 ],
            [ "name" => "Bandsaw", "price" => 562.131 ],
            [ "name" => "Chisel", "price" => 12.9 ],
            [ "name" => "Hacksaw", "price" => 18.45 ],
        ];


    }

    public function getAllProducts()
    {
        return !empty($this->products)?$this->products:null;
    }

    public function getProduct($id)
    {
        return isset($this->products[$id])?$this->products[$id]:false;
    }
}

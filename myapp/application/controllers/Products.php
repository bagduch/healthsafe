<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Products extends CI_Controller
{

    function  __construct()
    {
        parent::__construct();

        // Load cart library
        $this->load->library('cart');

        // Load product model
        $this->load->model('Product');
        header('Content-type: application/json');
    }

    function index()
    {
        $data = array();
        // Fetch products from the database
        $data['products'] = $this->Product->getAllProducts();

        foreach ($data['products'] as $key => $product) {
            $data['products'][$key]['id'] = $key;
        }

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Cart extends CI_Controller
{


    public function  __construct()
    {
        parent::__construct();
    }


    public function getCart()
    {
     
        $this->load->library('cart');
        $this->loadItem();
    }

    protected function loadItem()
    {
        $cart = array();
        $cart['items'] = $this->cart->contents();
        $cart['total'] = round($this->cart->total(), 2);
        echo json_encode($cart, JSON_NUMERIC_CHECK);
    }

    public function addToCart()
    {

        $cart = array();
        $id = $_POST['id'];
        // Fetch specific product by ID
        $this->load->model('Product');
        $this->load->library('cart');
        $product = $this->Product->getProduct($id);

        // Add product to the cart
        $data = array(
            'id'    => $id,
            'qty'    => 1,
            'price'    => round($product['price'], 2),
            'name'    => $product['name'],
        );
        $this->cart->insert($data);
        $this->loadItem();
        // Redirect to the cart page
    }

    public function updateCart()
    {
        $this->load->library('cart');

        $cart = array();
        $rowid = $_POST['rowid'];
        $qty = $_POST['qty'];
        // Fetch specific product by ID
        $this->load->model('Product');
        $this->load->library('cart');

        // Add product to the cart
        $data = array(
            'rowid'    => $rowid,
            'qty'    => $qty,
        );
        $this->cart->update($data);
        $this->loadItem();
    }

    public function removeItem()
    {
        $this->load->library('cart');

        $cart = array();
        $rowid = $_POST['rowid'];
        $this->cart->remove($rowid);
        $this->loadItem();
    }

    public function emptyCart()
    {
        $this->load->library('cart');

        $this->cart->destroy();
        $cart = null;
        echo json_encode($cart, JSON_NUMERIC_CHECK);
    }
}

<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Cart');
    }

    public function index()
    {
        echo 'Estoy en index de Carrito';
    }

    public function addProduct($product_id, $user_id)
    {
        $errors = [];

        if ( ! $this->model->verifyProduct($product_id, $user_id)) {
            if ( $this->model->addProduct($product_id, $user_id) == false) {
                array_push($errors, 'Error al insertar el producto en el carrito');
            }
        }

        $this->index();
    }
}
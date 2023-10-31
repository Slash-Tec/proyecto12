<?php

class AdmincartsController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminCart');
    }

    public function index()
    {
        $session = new Session();

        if ($session->getLogin()) {

            $data = [
                'title' => 'Administración - Inicio',
                'menu' => false,
                'admin' => true,
                'subtitle' => 'Administración de la tienda',
            ];

            $this->view('admincarts/sales', $data);

        } else {
            header('location:' . ROOT . 'admin');
        }

    }

    public function sales()
    {
        $sales = $this->model->sales();

        $data = [
            'title' => 'Ventas',
            'menu' => false,
            'admin' => true,
            'data' => $sales,
        ];
        $this->view('admin/carts/index', $data);
    }

    public function show($date, $id)
    {
        $cart = $this->model->show($date, $id);

        $data = [
            'title' => 'Detalle de ventas',
            'menu' => false,
            'admin' => true,
            'data' => $cart,
            'date' => $date,
        ];
        $this->view('admin/carts/show', $data);
    }
}
<?php

class ShopController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Shop');
    }

    public function index()
    {
        $session = new Session();

        if ($session->getLogin()) {

            $mostSold = $this->model->getMostSold();
            $news = $this->model->getNews();

            $data = [
                'title' => 'Bienvenid@ a nuestra exclusiva tienda de productos',
                'menu' => true,
                'subtitle' => 'Artículos más vendidos',
                'subtitle2' => 'Artículos nuevos',
                'data' => $mostSold,
                'news' => $news,
            ];

            $this->view('shop/index', $data);
        } else {
            header('location:' . ROOT);
        }
    }

    public function logout()
    {
        $session = new Session();
        $session->logout();
        header('location:' . ROOT);
    }

    public function show($id, $back = '')
    {
        $session = new Session();

        $product = $this->model->getProductById($id);

        $data = [
            'title' => 'Detalle del producto',
            'subtitle' => $product->name,
            'menu' => true,
            'admin' => false,
            'back' => $back,
            'errors' => [],
            'data' => $product,
            'user_id' => $session->getUserId(),
        ];

        $this->view('shop/show', $data);
    }

    public function whoami()
    {
        $session = new Session();

        if ($session->getLogin()) {

            $data = [
                'title' => 'Quienes somos',
                'menu' => true,
                'active' => 'whoami',
            ];

            $this->view('shop/whoami', $data);
        } else {
            header('location:' . ROOT);
        }
    }
    public function contact()
    {
        $errors = [];
        $messageSent = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';

            if ($name == '') {
                array_push($errors, 'El nombre es requerido');
            }
            if ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'El correo electrónico no es válido');
            }
            if ($message == '') {
                array_push($errors, 'El mensaje es requerido');
            }

            if (count($errors) == 0) {
                if ($this->model->sendEmail($name, $email, $message)) {
                    $messageSent = true;
                } else {
                    $errors[] = 'Error al enviar el mensaje';
                }
            }
        }

        $data = [
            'title' => 'Contacta con nosotros',
            'menu' => true,
            'active' => 'contact',
            'errors' => $errors,
            'messageSent' => $messageSent,
        ];

        $this->view('shop/contact', $data);
    }
}
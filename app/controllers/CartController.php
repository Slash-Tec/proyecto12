<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Cart');
    }

    public function index($errors = [])
    {
        $session =  new Session();

        if ($session->getLogin()) {

            $user_id = $session->getUserId();

            $cart = $this->model->getCart($user_id);

            $data = [
                'title' => 'Carrito',
                'menu' => true,
                'user_id' => $user_id,
                'data' => $cart,
                'errors' => $errors,
            ];

            $this->view('carts/index', $data);

        } else {
            header('location:' . ROOT);
        }
    }

    public function addProduct($product_id, $user_id)
    {
        $errors = [];

        if ( ! $this->model->verifyProduct($product_id, $user_id)) {
            if ( $this->model->addProduct($product_id, $user_id) == false) {
                array_push($errors, 'Error al insertar el producto en el carrito');
            }
        }

        $this->index($errors);
    }

    public function update()
    {
        if (isset($_POST['rows']) && isset($_POST['user_id'])) {
            $errors = [];
            $rows = $_POST['rows'];
            $user_id = $_POST['user_id'];

            for ($i = 0; $i < $rows; $i++) {
                $product_id = $_POST['i'.$i];
                $quantity = $_POST['c'.$i];
                if ( ! $this->model->update($user_id, $product_id, $quantity) ) {
                    array_push($errors, 'Error al actualizar el producto');
                }
            }
            $this->index($errors);
        }
    }

    public function delete($product_id, $user_id)
    {
        $errors = [];

        if ( ! $this->model->delete($product_id, $user_id)) {
            array_push($errors, 'Error al borrar el producto del carrito');
        }
        $this->index($errors);
    }

    public function address()
    {
        $session = new Session();
        if ($session->getLogin()) {
            $user_id = $session->getUserId();

            $addressModel = $this->model('Address');
            $address = $addressModel->getAddressByUserId($user_id);

            $data = [
                'title' => 'Carrito | Datos de envío',
                'subtitle' => 'Carrito | Verificar dirección de envío',
                'menu' => true,
                'user_id' => $user_id,
                'address' => $address,
            ];

            $this->view('carts/address', $data);
        } else {
            header('location:' . ROOT);
        }
    }

    public function updateAddress()
    {
        if (isset($_POST)) {
            $session = new Session();
            if ($session->getLogin()) {
                $user_id = $session->getUserId();

                $first_name = $_POST['first_name'];
                $last_name_1 = $_POST['last_name_1'];
                $last_name_2 = $_POST['last_name_2'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $postcode = $_POST['postcode'];
                $country = $_POST['country'];

                $addressModel = $this->model('Address');
                $existingAddress = $addressModel->getAddressByUserId($user_id);

                if ($existingAddress) {
                    $addressModel->updateAddress($user_id, $address, $city, $state, $postcode, $country);
                } else {
                    $addressModel->insertAddress($user_id, $address, $city, $state, $postcode, $country);
                }

                header('location:' . ROOT . 'cart/paymentmode');
            }
        }
    }

    public function checkout()
    {
        $session = new Session();

        if ( $session->getLogin()) {

            $user = $session->getUser();

            $data = [
                'title' => 'Carrito | Datos de envío',
                'subtitle' => 'Carrito | Verificar dirección de envío',
                'menu' => true,
                'data' => $user,
            ];
            $this->view('carts/address', $data);

        } else {
            $data = [
                'title' => 'Carrito | Checkout',
                'subtitle' => 'Carrito | Iniciar sesión',
                'menu' => true,
            ];

            $this->view('carts/checkout', $data);
        }
    }

    public function paymentmode()
    {
        $data = [
            'title' => 'Carrito | Forma de pago',
            'subtitle' => 'Carrito | Forma de pago',
            'menu' => true,
        ];
        $this->view('carts/paymentmode', $data);
    }

    public function verify()
    {
        $session = new Session();
        $user = $session->getUser();
        $cart = $this->model->getCart($user->id);
        $payment = $_POST['payment'] ?? '';

        $addressModel = $this->model('Address');
        $address = $addressModel->getAddressByUserId($user->id);

        $data = [
            'title' => 'Carrito | Verificar los datos',
            'subtitle' => 'Carrito | Verificar los datos',
            'breadcrumb' => true,
            'payment' => $payment,
            'user' => $user,
            'address' => $address,
            'data' => $cart,
            'menu' => true,
        ];
        $this->view('carts/verify', $data);
    }

    public function thanks()
    {
        $session = new Session();

        $user = $session->getUser();

        if ($this->model->closeCart($user->id, 1)) {
            $data = [
                'title' => 'Carrito | Gracias por su compra',
                'data' => $user,
                'menu' => true,
            ];
            $this->view('carts/thanks', $data);
        } else {
            $data = [
                'title' => 'Error en la actualización del carrito',
                'menu' => false,
                'subtitle' => 'Error durante el cierre del carrito',
                'text' => 'Ocurrió un problema al actualizar el estado del carrito. Por favor, pruebe más tarde',
                'color' => 'alert-danger',
                'url' => 'login',
                'colorButton' => 'btn-danger',
                'textButton' => 'Regresar',
            ];

            $this->view('mensaje', $data);
        }


    }
}
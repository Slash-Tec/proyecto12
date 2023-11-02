<?php

class AddressController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Address');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $session = new Session();
            $user_id = $session->getUserId();

            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $postcode = $_POST['postcode'];
            $country = $_POST['country'];

            if ($this->model->addAddress($user_id, $address, $city, $state, $postcode, $country)) {
                header('Location: ' . ROOT . 'cart/verify');
            } else {
                header('Location: ' . ROOT . 'shop');
            }
        }
    }
}

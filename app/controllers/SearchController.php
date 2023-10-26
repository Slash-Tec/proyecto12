<?php

class SearchController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Search');
    }

    public function products()
    {
        $search = $_POST['search'] ?? '';

        if (!empty($search)) {
            $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

            $dataSearch = $this->model->getProducts($search);

            if (count($dataSearch) > 0) {
                $data = [
                    'title' => 'Buscador de productos',
                    'data' => $dataSearch,
                    'menu' => true,
                    'subtitle' => 'Buscador de productos',
                    'testMessage' => '¡La seguridad funciona correctamente!'
                ];

                $this->view('search/index', $data);
            } else {
                $data = [
                    'title' => 'No hay productos',
                    'menu' => true,
                    'subtitle' => 'No hay productos',
                    'text' => 'La búsqueda solicitada no ha devuelto ningún producto',
                    'color' => 'alert-danger',
                    'url' => 'shop',
                    'colorButton' => 'btn-danger',
                    'textButton' => 'Regresar',
                ];

                $this->view('mensaje', $data);
            }
        } else {
            header('location:' . ROOT . 'shop');
        }
    }
}
<?php

class Login
{
    private $db;

    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }

    public function existsEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return $query->rowCount();
    }

    public function createUser($data)
    {
        $response = false;

        if ( ! $this->existsEmail($data['email'])) {

            $password = hash_hmac('sha512', $data['password1'], 'elperrodesanroque');

            $sql = 'INSERT INTO users(first_name, last_name_1, last_name_2, email, address, city, state, postcode, country, password) VALUES (:first_name, :last_name_1, :last_name_2, :email, :address, :city, :state, :postcode, :country, :password)';

            $params = [
                ':first_name' => $data['first_name'],
                ':last_name_1' => $data['last_name_1'],
                ':last_name_2' => $data['last_name_2'],
                ':email' => $data['email'],
                ':address' => $data['address'],
                ':city' => $data['city'],
                ':state' => $data['state'],
                ':postcode' => $data['postcode'],
                ':country' => $data['country'],
                ':password' => $password,
            ];

            $query = $this->db->prepare($sql);
            $response = $query->execute($params);
        }

        return $response;
    }

    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email' , $email, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function sendEmail($email)
    {
        $user = $this->getUserByEmail($email);
        $fullname = $user->first_name . ' ' . $user->last_name_1 . ($user->last_name_2 ? ' ' . $user->last_name_2 : '');
        $msg = $fullname . ' accede al siguiente enlace para cambiar la contraseña.<br>';
        $msg .= '<a href="' . ROOT . 'login/changePassword/' . $user->id . '">Cambia tu clave de acceso</a>';

        $headers = 'MIME-Version: 1.0\r\n';
        $headers .= 'Content-type:text/html; charset=UTF-8\r\n';
        $headers .= 'FROM: proyecto12\r\n';
        $headers .= 'Reply-to: admin@proyecto12.local';

        $subject = "Cambiar la contraseña en proyecto12";

        return mail($email, $subject, $msg, $headers);
    }
}
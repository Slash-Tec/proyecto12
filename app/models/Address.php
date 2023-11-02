<?php

class Address
{
    private $db;

    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }

    public function addAddress($user_id, $address, $city, $state, $postcode, $country)
    {
        $sql = 'INSERT INTO addresses (user_id, address, city, state, postcode, country) VALUES (:user_id, :address, :city, :state, :postcode, :country)';
        $query = $this->db->prepare($sql);
        $params = [
            ':user_id' => $user_id,
            ':address' => $address,
            ':city' => $city,
            ':state' => $state,
            ':postcode' => $postcode,
            ':country' => $country,
        ];
        $query->execute($params);

        return $query->rowCount();
    }

    public function getAddressByUserId($userId)
    {
        $sql = 'SELECT * FROM addresses WHERE user_id = :userId';
        $query = $this->db->prepare($sql);
        $query->bindParam(':userId', $userId);
        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertAddress($userId, $address, $city, $state, $postcode, $country)
    {
        $sql = 'INSERT INTO addresses (user_id, address, city, state, postcode, country) VALUES (:userId, :address, :city, :state, :postcode, :country)';
        $query = $this->db->prepare($sql);
        $query->bindParam(':userId', $userId);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':state', $state);
        $query->bindParam(':postcode', $postcode);
        $query->bindParam(':country', $country);

        $query->execute();
    }
    public function updateAddress($addressId, $address, $city, $state, $postcode, $country)
    {
        $sql = 'UPDATE addresses SET address = :address, city = :city, state = :state, postcode = :postcode, country = :country WHERE id = :addressId';
        $query = $this->db->prepare($sql);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':state', $state);
        $query->bindParam(':postcode', $postcode);
        $query->bindParam(':country', $country);
        $query->bindParam(':addressId', $addressId);

        $query->execute();
    }
}

<?php
include __DIR__ . '/../libs/Models.php';
class Book extends Models
{

    public function getBooks()
    {
        $sql = 'SELECT * FROM products WHERE deleted=0 AND type=2';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
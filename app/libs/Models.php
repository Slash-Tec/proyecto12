<?php

class Models
{
    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }
}
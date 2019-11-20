<?php

namespace application\models;

use core\Db;

class Admin extends Db
{
    function __construct(){
        $dbcon = new Db();
        $this->db = $dbcon->getConnection();
    }

    public function checkUserData($name, $pwd)
    {
        $sql = 'SELECT * FROM admins WHERE name = :name';

        $result = $this->db->prepare($sql);
        $result->bindParam(':name', $name, \PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            if (password_verify($pwd, $user['passwords'])) {
            	return $user['id'];
            }
            return false;
        }
        return false;
    }

    public function isEmpty($field)
    {
        return strlen($field) <= 1;
    }

}

<?php

class Model
{
    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", "", "db");
        $this->mysqli->query("SET NAMES utf8;");

        if ($this->mysqli->connect_errno){
            echo "Не удалось подключиться к бд: %s\n".$this->mysqli->connect_error;
            exit();
        }
    }

}
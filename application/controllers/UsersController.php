<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->model = new usersModel();
    }

    function index()
    {
       $data = $this->model->getData();
       echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    function test()
    {
        echo "test";
    }
}
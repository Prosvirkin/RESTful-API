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

    function getUser($id)
    {
        $user = $this->model->getUser($id);
        echo json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

}
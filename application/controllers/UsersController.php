<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->model = new usersModel();
    }

    function index()
    {
        $data = $this->model->getAll();
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    function show($params)
    {
        $user = $this->model->getUser($params);
        echo json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    function add($params){
        $this->model->createUser($params);
    }

    function update($params){
        $this->model->updateUser($params);
    }

    function delete($params){
        $this->model->delete($params);
    }

}
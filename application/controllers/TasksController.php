<?php

class Tasks extends Controller
{

    function __construct()
    {
        $this->model = new tasksModel();
    }

    public function index()
    {
       $tasks = $this->model->getTasks();
       echo json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
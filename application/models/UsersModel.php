<?php

class usersModel extends Model
{
    function getAll()
    {
        $arrData = [];
        $sql = "Select id, name, age from users";
        if ($data = $this->mysqli->query($sql)) {
            while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
                $arrData[] = $row;
            }
            $data->close();
        }
        return $arrData;
    }

    public function getUser($params)
    {
        $id = $params['id'];
        $sql = "Select name, age from users WHERE id = $id";
        if ($user = $this->mysqli->query($sql)) {
            while ($row = $user->fetch_array(MYSQLI_ASSOC)) {
                $arrUser[] = $row;
            }
            $user->close();
        }
        if (empty($arrUser)) {
            Route::Error404();
        } else {
            return $arrUser;
        }
    }

    public function createUser($params)
    {
        $name = $params["name"];
        $age = (int)$params["age"];
        $sql = "insert into users(name, age) values('$name', '$age')";
        if ($this->mysqli->query($sql)) {
            header('HTTP/1.1 200 OK');
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/users');
            echo $_SERVER["REQUEST_METHOD"];
        }
    }

    public function updateUser($params)
    {
        $id = $params['id'];
        $name = $params['name'];
        $age = $params['age'];
        $sql = "update users set name = '$name', age = '$age' where id like $id";
        if ($this->mysqli->query($sql)) {
            header('HTTP/1.1 200 OK');
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/users');
        } else {
            Route::Error404();
        }
    }

    public function delete($params)
    {
        $id = $params['id'];
        $sql = "Delete from users where id = '$id'";
        if ($this->mysqli->query($sql)) {
            header('HTTP/1.1 200 OK');
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/users');
        } else {
            Route::Error404();
        }
    }
}
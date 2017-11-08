<?php

class usersModel extends Model
{
    function getData()
    {
        $arrData = [];

        if ($data = $this->mysqli->query("Select * from users")) {
            while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
                $arrData[] = $row;
            }
            $data->close();
        }

        return $arrData;
    }

    public function getUser($id)
    {
        if($user = $this->mysqli->query("Select * from users WHERE id = $id")){
            while($row = $user->fetch_array(MYSQLI_ASSOC)){
                $arrUser[] = $row;
            }
            $user->close();
        }
        if(empty($arrUser)){
            Route::Error404();
        } else {
            return $arrUser;
        }

    }
}
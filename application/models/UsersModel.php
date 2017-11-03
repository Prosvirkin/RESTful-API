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
}
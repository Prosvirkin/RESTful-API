<?php

class tasksModel extends Model
{
    public function getTasks()
    {
        $arrData = [];
        if($data = $this->mysqli->query("select * from tasks")){
            while ($row = $data->fetch_array(MYSQLI_ASSOC)){
                $arrData[] = $row;
            }
            $data->close();
        }
        return $arrData;
    }
}
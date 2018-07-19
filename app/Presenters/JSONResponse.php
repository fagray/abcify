<?php 

namespace App\Presenters;

class JSONResponse{

    public function __construct($array)
    {
        $this->handle($array);
    }

    public function handle($array)
    {
        echo json_encode($array);
    }
}
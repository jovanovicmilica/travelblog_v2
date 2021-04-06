<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Networks;

class BaseController extends Controller
{
    public $data;
    public function __construct()
    {


        $model=new Menu();
        $this->data['menu']=$model->getMenu();

        $model2=new Networks();
        $this->data['networks']=$model2->getNetworks();

    }
}

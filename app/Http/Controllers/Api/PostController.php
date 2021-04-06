<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request){

        $key="";
        if($request->get("key")){
            $key=$request->get("key");
        }


        $model=new Post();
        $this->data=$model->getAll($key);



        return($this->data);
    }
    public function features(){

        $model=new Post();
        $this->data['posts']=$model->getFeaturedPosts();

        return($this->data['posts']);
    }

}

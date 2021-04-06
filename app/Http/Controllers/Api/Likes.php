<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Likes extends Controller
{
    public function likes($id,Request $request){

        $model=new \App\Models\Likes();
        $this->data['likes']=$model->getLikes($id);
        $likes['likes']=$this->data['likes'];

        if($request->session()->has("user")){
            $idUser=$request->session()->get('user')->idUser;
            $like=$model->userLike($idUser,$id);
            if($like==1){
                $likes['liked']=true;
            }
            else{
                $likes['liked']=false;
            }
        }
        return($likes);
    }

    public function likePost(Request $request){

        $idPost=$request->get("idPost");

        if($request->session()->has("user")){
            $idUser=$request->session()->get("user")->idUser;
            $model=new \App\Models\Likes();
            try{
                $model->like($idPost,$idUser);

                $user=$request->session()->get("user")->email;
                $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."Liked post"."\t".date("Y-m-d H:i:s");
                $zabelezi=new User();
                $zabelezi->log($content);
                return response()->json(['data'=>"Ok"],200);
            }
            catch (\Exception $e){
                return response()->json(['data'=>"Server error"],500);
            }
        }
        else{
            return response()->json(['data'=>"Login to like"],200);
        }
    }

    public function deleteLike($id,Request $request){

        $idUser=$request->session()->get("user")->idUser;

        $model=new \App\Models\Likes();

        try{
            $model->deleteLike($idUser,$id);

            $user=$request->session()->get("user")->email;
            $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."Unliked post"."\t".date("Y-m-d H:i:s");
            $zabelezi=new User();
            $zabelezi->log($content);
            return response()->json(['data'=>"Ok"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }
}

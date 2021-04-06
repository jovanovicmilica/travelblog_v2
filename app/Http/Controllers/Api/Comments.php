<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class Comments extends Controller
{
    public function comments($id,Request $request){

        $model=new \App\Models\Comments();
        $this->data['comments']=$model->getPostComment($id);
        $this->data['user']=false;

        if($request->session()->has("user")){
            $user=$request->session()->get("user")->idUser;
            $comment=$this->data['comments'];
            foreach ($comment as $c){
                if($c->idUser==$user){
                    $c->user=true;
                }
                else{
                    $c->user=false;
                }
            }
        }

        return($this->data['comments']);
    }

    public function insert(Comment $request){

        $code=200;

        $comment=$request->get("comment");
        $id=$request->get("idPost");

        $user=$request->session()->get("user");
        $idUser=$user->idUser;

        $model=new \App\Models\Comments();
        try{
            $rez=$model->insertComment($id,$comment,$idUser);

            $user=$request->session()->get("user")->email;
            $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."Comment inserted"."\t".date("Y-m-d H:i:s");
            $zabelezi=new User();
            $zabelezi->log($content);
            return response()->json(["data"=>"You have successfully post coment!"],$code);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }

    }

    public function delete($id,Request $request){


        $model=new \App\Models\Comments();
        try{
            $model->deleteComment($id);

            $user=$request->session()->get("user")->email;
            $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."Deleted comment"."\t".date("Y-m-d H:i:s");
            $zabelezi=new User();
            $zabelezi->log($content);
            return response()->json(['data'=>"Deleted"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }

    }

    public function edit($id){

        $model=new \App\Models\Comments();
        try{
            $comment=$model->getOneComment($id);
            return response()->json(['data'=>$comment],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }

    public function update(Comment $request){

        $idComment=$request->get("idComment");
        $comment=$request->get("comment");

        $model=new \App\Models\Comments();
        try{
            $model->updateComment($idComment,$comment);

            $user=$request->session()->get("user")->email;
            $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."Updated comment"."\t".date("Y-m-d H:i:s");
            $zabelezi=new User();
            $zabelezi->log($content);
            return response()->json(['data'=>"Updated"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }
}

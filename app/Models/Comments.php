<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    public function getPostComment($id){
        $rez=\DB::table("comments")
            ->join("users","users.idUser","=","comments.idUser")
            ->where("idPost",$id)
            ->orderBy("date")
            ->get();

        return $rez;
    }

    public function insertComment($idPost,$text,$idUser){
        $rez=\DB::table("comments")
            ->insert([
                "comment"=>$text,
                "idPost"=>$idPost,
                "idUser"=>$idUser
            ]);

        return $rez;

    }

    public function deleteComment($id){
        $rez=\DB::table("comments")
            ->where("idComment",$id)
            ->delete();

        return $rez;
    }

    public function getOneComment($id){
        $rez=\DB::table("comments")
            ->where("idComment",$id)
            ->first();

        return $rez;
    }

    public function updateComment($id,$comment){
        $rez=\DB::table("comments")
            ->where("idComment",$id)
            ->update([
                "comment"=>$comment
            ]);

        return $rez;
    }

    public function getCommentsAdmin($id){
        $rez=\DB::table("comments")
            ->where("idPost",$id)
            ->count();

        return $rez;
    }

    public function getAllComents(){
        $rez=\DB::table("comments")
            ->join("users","users.idUser","=","comments.idUser")
            ->get();

        return $rez;
    }


}

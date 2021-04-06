<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    public function getLikes($id){
        $rez=\DB::table("likes")
            ->where("idPost",$id)
            ->count();

        return $rez;
    }

    public function userLike($idUser,$idPost){
        $rez=\DB::table("likes")
            ->where("idUser",$idUser)
            ->where("idPost",$idPost)
            ->count();

        return $rez;
    }

    public function like($idPost,$idUser){
        $rez=\DB::table("likes")
            ->insert([
                "idPost"=>$idPost,"idUser"=>$idUser
            ]);

        return $rez;
    }

    public function deleteLike($idUser,$idPost){
        $rez=\DB::table("likes")
            ->where("idUser",$idUser)
            ->where("idPost",$idPost)
            ->delete();

        return $rez;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    public function getImages($id){
        $rez=\DB::table("images")
            ->where("idPost",$id)
            ->get();

        return $rez;
    }

    public function insertImages($idPost,$name){
        $rez=\DB::table("images")
            ->insert([
                "src"=>$name,"idPost"=>$idPost
            ]);

        return $rez;
    }

    public function deleteImage($id){
        $rez=\DB::table("images")
            ->where("idImage",$id)
            ->delete();

        return $rez;
    }
}

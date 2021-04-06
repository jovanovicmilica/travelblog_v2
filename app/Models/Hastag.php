<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hastag extends Model
{
    use HasFactory;

    public function getHashtags(){
        $rez=\DB::table("hashtag")
            ->get();

        return $rez;
    }

    public function insertPostHashtag($idPost,$idHash){
        $rez=\DB::table("posthashtag")
            ->insert([
                "idPost"=>$idPost,"idHashtag"=>$idHash
            ]);

        return $rez;
    }
    public function insertHashtag($hash){
        $rez=\DB::table("hashtag")
            ->insert([
                "hashtag"=>$hash
            ]);

        return $rez;
    }

    public function deleteHashtag($id){
        $rez=\DB::table("hashtag")
            ->where("idHashtag",$id)
            ->delete();

        return $rez;
    }

    public function getPostHashtag($id){
        $rez=\DB::table("posthashtag")
            ->join("hashtag","hashtag.idHashtag","=","posthashtag.idHashtag")
            ->where("posthashtag.idPost",$id)
            ->get();

        return $rez;

    }


    public function deleteHashFromPost($id){
        $rez=\DB::table("posthashtag")
            ->where("idPost",$id)
            ->delete();

        return $rez;
    }

    public function getHashtag($id){
        $rez=\DB::table("hashtag")
            ->where("idHashtag",$id)
            ->first();

        return $rez;
    }


    public function updateHashtag($id,$hashtag){
        $rez=\DB::table("hashtag")
            ->where("idHashtag",$id)
            ->update([
                "hashtag"=>$hashtag
            ]);

        return $rez;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getFeaturedPosts(){
        $posts=\DB::table('posts')
            ->where("approved","=",1)
            ->orderBy('date',"desc")
            ->limit(4)
            ->get();

        return $posts;
    }


    public function getAll($key){

        $id=[];
        $idP=[];

        $hashtags=\DB::table("hashtag")->where("hashtag","like","%".$key."%")->get();


        foreach ($hashtags as $h){
            $id[]=$h->idHashtag;
        }
        $idH=\DB::table("posthashtag")->whereIN("idHashtag",$id)->get();


        foreach ($idH as $i){
            $idP[]=$i->idPost;
        }


        $posts=\DB::table('posts')
            ->where("approved","=",1)
            ->where("title","LIKE","%".$key."%")
            ->paginate(8);


        return (["posts"=>$posts,"hashtags"=>$hashtags]);
    }

    public function getOne($id){
        $post=\DB::table("posts")
            ->join("users","users.idUser","=","posts.idUser")
            ->where("posts.id",$id)
            ->first();

        return $post;
    }

    public function getAllAdmin(){
        $posts=\DB::table('posts')
            ->get();

        return $posts;
    }

    public function insertPost($title,$text,$thumb,$idUser){
        $post=\DB::table("posts")
            ->insertGetId([
                "title"=>$title,"text"=>$text,"img"=>$thumb,"idUser"=>$idUser
            ]);

        return $post;
    }

    public function deletePost($id){
        $rez=\DB::table("posts")
            ->where("id",$id)
            ->delete();

        return $rez;

    }

    public function updatePost($id,$title,$text,$img){
        $rez=\DB::table("posts")
            ->where("id",$id);

            if($img!=null){
                $rez->update([
                    "title"=>$title,"text"=>$text,"img"=>$img
                ]);
            }
            else{
                $rez->update([
                    "title"=>$title,"text"=>$text
                ]);
            }

        return $rez;

    }

    public function approvePost($id){
        $rez=\DB::table("posts")
            ->where("id",$id)
            ->update(["approved"=>1]);
        return $rez;
    }
}

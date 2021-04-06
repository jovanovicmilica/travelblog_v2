<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    use HasFactory;

    public function getSponsors(){
        $rez=\DB::table("sponsors")
            ->get();

        return $rez;
    }

    public function addSponsor($name,$img){
        $rez=\DB::table("sponsors")
            ->insert([
                "name"=>$name,"img"=>$img
            ]);

        return $rez;
    }

    public function deleteSponsor($id){
        $rez=\DB::table("sponsors")
            ->where("idSponsor",$id)
            ->delete();

        return $rez;

    }

    public function getSponsor($id){
        $rez=\DB::table("sponsors")
            ->where("idSponsor",$id)
            ->first();

        return $rez;
    }

    public function isExists($name){
        $rez=\DB::table("sponsors")
            ->where("name",$name)
            ->first();

        return $rez;
    }

    public function updateSponsor($id,$name,$img){
        $rez=\DB::table("sponsors")
            ->where("idSponsor",$id);
        if($img!=""){
            $rez->update([
                "name"=>$name,"img"=>$img
            ]);
        }
        else{
            $rez->update([
                "name"=>$name
            ]);
        }


        return $rez;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Networks extends Model
{
    use HasFactory;

    public function getNetworks(){
        $rez=\DB::table("social")
            ->get();

        return $rez;
    }

    public function insertNetwork($link,$icon){
        $rez=\DB::table("social")
            ->insert([
                    "link"=>$link,"icon"=>$icon
            ]);

        return $rez;
    }

    public function deleteNetwork($id){
        $rez=\DB::table("social")
            ->where("idNetwork",$id)
            ->delete();

        return $rez;
    }

    public function getNetwork($id){
        $rez=\DB::table("social")
            ->where("idNetwork",$id)
            ->first();

        return $rez;
    }
    public function updateNetwork($id,$link){
        $rez=\DB::table("social")
            ->where("idNetwork",$id)
            ->update([
                "link"=>$link
            ]);

        return $rez;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function insertMessage($fName,$lName,$email,$subject,$message){
        $upit=\DB::table('messages')->insert([
            "firstName"=>$fName,
            "lastName"=>$lName,
            "email"=>$email,
            "subject"=>$subject,
            "message"=>$message
        ]);

        return $upit;
    }

    public function getAllMessages(){
        $rez=\DB::table("messages")
            ->get();

        return $rez;
    }

    public function deleteMessage($id){
        $rez=\DB::table("messages")
            ->where("id",$id)
            ->delete();

        return $rez;
    }
}

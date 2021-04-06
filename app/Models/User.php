<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findUser($email){
        $rez=\DB::table("users")
            ->where("email",$email)
            ->where("active",1)
            ->count();

        return $rez;
    }


    public function user($email,$pass){
        $rez=\DB::table("users")
            ->join("roles","roles.idRole","=","users.idRole")
            ->where("email",$email)
            ->where("password",$pass)
            ->first();

        return $rez;
    }

    public function register($fName,$lName,$email,$pass){
        $active=1;
        $code=md5($email.time());
        $idRole=2;
        $rez=\DB::table("users")
            ->insert(
                ['firstName'=>$fName,'lastName'=>$lName,"email"=>$email,'password'=>$pass,'code'=>$code,'idRole'=>$idRole,'active'=>$active]
            );

        return $rez;
    }

    public function updateUser($fName,$lName,$email,$pass,$currentEmail){
        $rez=\DB::table("users")
            ->where("email",$currentEmail);
            if($pass!=null){
                $rez=$rez
                    ->update(['firstName'=>$fName,"lastName"=>$lName,'email'=>$email,'password'=>$pass]);
            }
            else{
                $rez=$rez
                    ->update(['firstName'=>$fName,"lastName"=>$lName,'email'=>$email]);
            }

            return $rez;
    }

    public function getUsers(){
        $rez=\DB::table("users")
            ->join("roles","roles.idRole","=","users.idRole")
            ->get();

        return $rez;
    }

    public function log($content){
        if(Storage::disk("local")->exists("log.txt")){
            Storage::append("log.txt",$content);
        }
        else{
            Storage::disk("local")->put("log.txt",$content);
        }
    }

    public function updatePassUser($id){
        $rez=\DB::table("users")
            ->where("idUser",$id)
            ->first();

        return $rez;
    }

    public function doUpdateAdmin($id,$pass){
        $rez=\DB::table("users")
            ->where("idUser",$id)
            ->update([
                "password"=>$pass
            ]);

        return $rez;
    }
}

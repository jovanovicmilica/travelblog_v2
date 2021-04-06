<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UserLogin;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function login(Request $request,UserLogin $requestUser){

        $email=$requestUser->get("email");
        $pass=$requestUser->get("pass");

        $pass=md5($pass);

        $code=200;


        try{
            ///upit za logovanje
            $model=new User();
            $userExists=$model->findUser($email);
            if($userExists){
                $user=$model->user($email,$pass);
                if($user){
                    $this->data="ok";
                    $request->session()->put("user",$user);


                    $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user->email."\t"."User logged in"."\t".date("Y-m-d H:i:s");

                    $model->log($content);
                }
                else{
                    $this->data="Invalid password";
                }
            }
            else{
                $this->data="User not found";
                //return response(['data'=>"User not found or your account is not active"],$code);
            }
        }
        catch (\Exception $e){
            $code=500;
            $this->data="Server error";
        }


        return response()->json([$this->data],$code);
    }

    public function logout(Request $request){

        $user=$request->session()->get("user")->email;
        $request->session()->remove("user");


        $model=new User();
        $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."User logged out "."\t".date("Y-m-d H:i:s");

        $model->log($content);

        return response()->json([],200);
    }

    public function register(Register $request){

        $fname=$request->get("fName");
        $lName=$request->get("lName");
        $email=$request->get("email");
        $pass=$request->get("pass");
        $passConf=$request->get("passConf");


        $code=200;
        $pass=md5($pass);


        $model=new User();
        $emailExists=$model->findUser($email);
        if($emailExists){
            $this->data="E-mail adresss is already taken";
        }
        else{
            ///upit
            try{
                $upit=$model->register($fname,$lName,$email,$pass);
                $this->data="You have successfully register";
            }
            catch (\Exception $e){
                $code=500;
                $this->data="Server error";
            }
        }



        return response()->json([$this->data],$code);

    }
    function editProfile(Request $request){
        $user=$request->session()->get('user');

        return response()->json($user,200);
    }

    function update(UpdateUser $request){

        $fname=$request->get("firstName");
        $lName=$request->get("lastName");
        $email=$request->get("email");
        $pass=$request->get("password");

        if($pass!=null){
            $pass=md5($pass);
        }

        $code=200;
        $this->data="ok";

        $currentEmail=$request->session()->get('user')->email;

        $model=new User();
        if($request->session()->get("user")->email!=$email){
            $emailExists=$model->findUser($email);
            if($emailExists){
                $this->data="E-mail adresss is already taken";
                return response()->json([$this->data],$code);

            }
        }
            try{
                $model->updateUser($fname,$lName,$email,$pass,$currentEmail);
                if($pass==null){
                    $pass=$request->session()->get("user")->password;
                }
                $user=$model->user($email,$pass);
                $request->session()->put('user',$user);
                $this->data="Updated";

                $user=$request->session()->get("user")->email;
                $content=$request->ip()."\t".$request->url()."\t".$request->method()."\t".$user."\t"."Updated profile"."\t".date("Y-m-d H:i:s");
                $zabelezi=new User();
                $zabelezi->log($content);
            }
            catch (\Exception $e){
                $code=500;
                $this->data="Server error";
            }





        return response()->json([$this->data],$code);
    }
}

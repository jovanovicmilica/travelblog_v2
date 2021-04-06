<?php

namespace App\Http\Controllers;


use App\Http\Requests\Message;
use App\Models\Hastag;
use App\Models\Images;
use App\Models\Post;
use App\Models\Sponsors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FrontendController extends BaseController
{

    public function index(){

        $model2=new Sponsors();

        $this->data['sponsors']=$model2->getSponsors();




        return view("pages.index",$this->data);
    }

    public function about(){

        return view("pages.about",$this->data);
    }



    public function newPost(){
        $model=new Hastag();

        $this->data['hashtags']=$model->getHashtags();

        return view("pages.newpost",$this->data);
    }

    public function editPost(Request $request,$id){

        $model=new Hastag();

        $this->data['hashtags']=$model->getHashtags();

        $model=new Post();

        $this->data['post']=$model->getOne($id);

        $modelimg=new Images();
        $this->data['images']=$modelimg->getImages($id);

        $modeltags=new Hastag();
        $this->data['hashtag']=$modeltags->getPostHashtag($id);

        if($request->session()->has("user") && $request->session()->get("user")){
            if($this->data['post']->idUser==$request->session()->get("user")->idUser){
                return view("pages.edit",$this->data);
            }
            else{
                return redirect()->route("error");
            }
        }
        else{
            return redirect()->route("error");
        }

    }

    public function updatePost(Request $request,$id){
        $title=$request->get("title");
        $thumbnail=$request->file("thumbnail");
        $photos=$request->file('photos');
        $summernote=$request->get("summernote");
        $chbHash=$request->get("idHashtag");

        if($thumbnail!=null){
            $name=time().$thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('assets/images'),$name);
        }
        else{
            $name="";
        }

        $model=new Post();

        $model2=new Hastag();

        $model3=new Images();


        try{
            $model2->deleteHashFromPost($id);
            $model->updatePost($id,$title,$summernote,$name);
            if($chbHash!=null){
                foreach ($chbHash as $cb){
                    $model2->insertPostHashtag($id,$cb);
                }
            }
            if($photos!=null){
                foreach ($photos as $p){
                    $name2=time().$p->getClientOriginalName();
                    try{
                        $p->move(public_path('assets/images'),$name2);
                        $model3->insertImages($id,$name2);
                    }
                    catch (\Exception $e){
                        return response()->json(['data'=>"Server error"],500);
                    }
                }
            }
            return response()->json(['data'=>"Updated successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }


    public function contact(){

        return view("pages.contact",$this->data);
    }
    public function author(){

        return view("pages.author",$this->data);
    }
    public function error(){

        return view("pages.error",$this->data);
    }

    public function storeMessage(Message $request){

        $firstName=$request->get("fName");
        $lastName=$request->get("lName");
        $email=$request->get("email");
        $subject=$request->get("subject");
        $message=$request->get("message");

        $message=implode(" ",$message);

        $model= new \App\Models\Message();
        try{
            $rez=$model->insertMessage($firstName,$lastName,$email,$subject,$message);
            $data = array(
                'message' => $message,
                'email' => $email
            );
            //Mail::to("mikipn99@gmail.com")->send(new \App\Mail\Message($data));
            //Ne radi na localhostu
            return response(['data'=>"You have successfuly sent message"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }



    }



    public function editProfile(){


        return view("pages.editProfile",$this->data);
    }
    public function admin(){
        return view("pages.admin");
    }

    public function logFile(Request $request){
        $date=null;
        if($request->filled("date")){
            $date=strtotime($request->input("date"));
        }
        $content=null;
        if(Storage::disk("local")->exists("log.txt")){
            $content=Storage::get("log.txt");
            $content=explode("\r\n",$content);
            if($date){
                $newContent=[];
                foreach ($content as $item){
                    $items=explode("\t",$item);
                    if($date<strtotime($items[count($items)-1])){
                        $newContent[]=$item;
                    }
                }
                $content=$newContent;
            }
        }


        return response()->json(["log"=>$content],200);
    }



}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUpdate;
use App\Models\Hastag;
use App\Models\Images;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPosts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $model=new Post();

        $this->data['posts']=$model->getAllAdmin();

        $modelLikes=new \App\Models\Likes();
        $modelComments= new \App\Models\Comments();

        $posts=$this->data['posts'];

        foreach ($posts as $p){
            $p->likes=$modelLikes->getLikes($p->id);
            $p->comments=$modelComments->getCommentsAdmin($p->id);
        }


        return response()->json($this->data['posts'],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $model=new Hastag();
        $this->data['hashtags']=$model->getHashtags();
        return response()->json($this->data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Post $request)
    {

        $title=$request->get("title");
        $thumbnail=$request->file("thumbnail");
        $photos=$request->file('photos');
        $summernote=$request->get("summernote");
        $chbHash=$request->get("idHashtag");
        $idUser=$request->session()->get("user")->idUser;


        $name=time().$thumbnail->getClientOriginalName();
        $thumbnail->move(public_path('assets/images'),$name);

        $model=new Post();

        try{
            $idPost=$model->insertPost($title,$summernote,$name,$idUser);
            foreach ($photos as $p){
                $name=time().$p->getClientOriginalName();
                $p->move(public_path('assets/images'),$name);
                $model2=new Images();
                try{
                    $model2->insertImages($idPost,$name);

                }
                catch (\Exception $e){
                    return response()->json(['data'=>$e],500);
                }
            }

            $model3=new Hastag();
            foreach ($chbHash as $cb){
                try{
                    $model3->insertPostHashtag($idPost,$cb);
                }
                catch (\Exception $e){
                    return response()->json(['data'=>"Server error"],500);
                }
            }
            return response()->json(['data'=>"Inserted successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }


        dd($file);
        foreach ($file as $file){
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model=new Post();

        $this->data['post']=$model->getOne($id);

        $modelimg=new Images();
        $this->data['images']=$modelimg->getImages($id);

        $modeltags=new Hastag();
        $this->data['hashtag']=$modeltags->getPostHashtag($id);

        return response()->json([$this->data],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $model=new Post();

        try{
            $model->approvePost($id);
            return response()->json(['data'=>"ok"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }

/*
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
*/

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $model=new Post();
        try{
            $rez=$model->deletePost($id);
            return response()->json(['data'=>"Deleted successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }

}

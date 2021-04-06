<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hashtag;
use App\Models\Hastag;
use Illuminate\Http\Request;

class Hashtags extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $model=new Hastag();

        $this->data['hashtags']=$model->getHashtags();


        return response()->json($this->data['hashtags'],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Hashtag $request)
    {
        $hash=$request->get("hashtag");

        $model=new Hastag();

        try{
            $model->insertHashtag($hash);
            return response()->json(['data'=>"Inserted successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
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
        $model=new Hastag();
        $hash=$model->getHashtag($id);
        return response()->json(["data"=>$hash],200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Hashtag $request, $id)
    {
        $hashtag=$request->get("hashtag");
        $model=new Hastag();

        try{
            $model->updateHashtag($id,$hashtag);
            return response()->json(['data'=>"Updated successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model=new Hastag();

        try{
            $model->deleteHashtag($id);
            return response()->json(['data'=>"Inserted successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }
}

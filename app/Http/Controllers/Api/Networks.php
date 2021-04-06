<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertNetwork;
use Illuminate\Http\Request;

class Networks extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=new \App\Models\Networks();

        $this->data['networks']=$model->getNetworks();


        return response()->json($this->data['networks'],200);
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
    public function store(InsertNetwork $request)
    {
        $link=$request->get("link");
        $icon=$request->get("icon");


        $model=new \App\Models\Networks();

        try{
            $model->insertNetwork($link,$icon);
            return response()->json(['data'=>"Inserted successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>$e],500);
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
        $model=new \App\Models\Networks();

        $mreza=$model->getNetwork($id);

        return response()->json(['data'=>$mreza],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\Networks $request, $id)
    {
        $link=$request->get("link");
        $model=new \App\Models\Networks();

        try{
            $model->updateNetwork($id,$link);;
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
            $model=new \App\Models\Networks();

            try{
                $model->deleteNetwork($id);;
                return response()->json(['data'=>"Successfully deleted"],200);
            }
            catch (\Exception $e){
                return response()->json(['data'=>"Server error"],500);
            }
    }
}

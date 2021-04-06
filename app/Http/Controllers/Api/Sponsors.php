<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorUpdate;
use Illuminate\Http\Request;

class Sponsors extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=new \App\Models\Sponsors();

        $this->data['sponsors']=$model->getSponsors();

        return response()->json($this->data['sponsors'],200);
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
    public function store(\App\Http\Requests\Sponsors $request)
    {
        $name=$request->get("name");
        $img=$request->file("img");



        $photo=time().$img->getClientOriginalName();
        $img->move(public_path('assets/images'),$photo);

        $model=new \App\Models\Sponsors();

        try{
            $model->addSponsor($name,$photo);
            return response()->json(['data'=>"Successfully inserted"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server errror"],500);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model=new \App\Models\Sponsors();
        $this->data['sposnor']=$model->getSponsor($id);


        return response()->json([$this->data['sposnor']],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SponsorUpdate $request, $id)
    {
        $name=$request->get("name");
        $img=$request->file("img");


        if($img!=""){
            $photo=time().$img->getClientOriginalName();
            $img->move(public_path('assets/images'),$photo);
        }
        else{
            $photo="";
        }
        $modelProvera=new \App\Models\Sponsors();
        $rez=$modelProvera->isExists($name);


        if($rez){
            $isThisSponsorName=$rez->idSponsor;

            if($isThisSponsorName!=$id){;
                return response()->json(['data'=>"Sponsor already exists"],200);
            }
            else{
                try{
                    $modelProvera->updateSponsor($id,$name,$photo);
                    return response()->json(['data'=>"Successfully updated"],200);
                }
                catch (\Exception $e){
                    return response()->json(['data'=>"Server errror"],500);
                }
            }
        }
        else{
            try{
                $modelProvera->updateSponsor($id,$name,$photo);
                return response()->json(['data'=>"Successfully updated"],200);
            }
            catch (\Exception $e){
                return response()->json(['data'=>"Server errror"],500);
            }
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

        $model=new \App\Models\Sponsors();
        try{
            $model->deleteSponsor($id);
            return response()->json(['data'=>"Successfully deleted"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server errror"],500);
        }
    }
}

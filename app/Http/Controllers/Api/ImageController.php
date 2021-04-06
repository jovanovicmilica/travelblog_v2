<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Images;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    function deleteImage($id){

        $model=new Images();

        try{
            $model->deleteImage($id);
            return response()->json(['data'=>"Deleted successfully"],200);
        }
        catch (\Exception $e){
            return response()->json(['data'=>"Server error"],500);
        }
    }
}

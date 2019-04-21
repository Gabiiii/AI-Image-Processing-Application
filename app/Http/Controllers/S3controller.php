<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
 use Storage;

class S3controller extends Controller
{
    public function Form(Request $request) 
    { 
        return view('uploadFileToS3'); 
    } 
    
    public function uploadFileToS3(Request $request) 
    { 
        $image = $request->file('image'); 
        $imageFileName = time() . '.' . $image->getClientOriginalExtension(); // $filepath should be absolute path to a file on disk $filepath = '/microsites/horoscope/images/'.$imageFileName; $bucket = env('AWS_BUCKET'); $keyname = env('AWS_KEY'); $region = env('AWS_REGION'); $s3 = \Storage::disk('s3'); 
        $filePath = '/microsites/horoscope/images/' . $imageFileName; 
        $s3->put($filePath, file_get_contents($image), 'public-read'); 
        dd('File uploaded.....'.Storage::url($filepath));
    
    }
    
}






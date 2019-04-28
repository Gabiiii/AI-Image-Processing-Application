<?php

namespace App\Http\Controllers\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Post;
// use Storage;
class S3Controller extends Controller
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

    public function imageshow($id)
    {
        // dd($id);
        $post=Post::find($id);

        $imageName = Storage::disk('s3')->url($post->image);
        
        return "<img src='".$imageName."'/>";
         
    }

    public function imagedown($id)
    {
        $post = Post::find($id);
        $image =  Storage::disk('s3')->url($post->image); 
        // $imagename="test.jpeg";
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $post->image);
        header("Content-Type: image/jpeg");
        return readfile($image);



    }
}

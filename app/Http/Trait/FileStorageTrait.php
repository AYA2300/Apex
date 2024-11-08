<?php
namespace App\Http\Trait;

use Exception;
use Illuminate\Support\Str;
use League\Flysystem\Visibility;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

 trait FileStorageTrait{


    public function storeFile($file,string $folderName)
    {

        $extension = $file->getClientOriginalExtension();


        $fileName = Str::random(32);
        $fileName = preg_replace('/[^A-Za-z0-9_\-]/','',$fileName);

        //store the file in the public disc
        $path = $file->storeAs($folderName,$fileName . '.' . $extension,'public');

        //verify the path to ensure it matches the expected pattern
        $expectedPath = storage_path('app/public/'. $folderName .'/' . $fileName . '.' . $extension);
        $actualPath = storage_path('app/public/'.$path);


        // get the url of the stored file
        // $url = Storage::disk('public')->url($path);
        $url = Storage::url($path);
        return $url;


    }


 }















?>
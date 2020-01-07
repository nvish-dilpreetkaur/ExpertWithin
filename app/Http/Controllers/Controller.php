<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Config;
use Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function userRoles() {
        return auth()->user()->role->where("user_id", auth()->user()->id)->where("status", 1)->pluck("role")->toArray();
    }
    
    function resizeImage($file,$folder,$size=150) { 
        if (!Storage::disk('public_uploads')->exists($folder)) { 
			Storage::disk('public_uploads')->makeDirectory($folder, 0777, true);
		}
		$destinationPath = Storage::disk('public_uploads')->path($folder);
		$pic = Storage::disk('public_uploads')->get($file);
		$image_thumb = Image::make($pic)->resize($size,$size, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();            
        })->stream();
		Storage::disk('public_uploads')->put($folder.config('constants.DS').$file, $image_thumb->__toString());
		return true;
    }
}

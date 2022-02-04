<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Product;

class FileController extends Controller
{
    public function getSignedUrl($id){
        return URL::temporarySignedRoute('UserDownloadFile', now()->addMinutes(180), ['id' => $id,'user' => Auth::id()]);
    }

    public function getFile($id){
        $find = Product::findOrFail($id);
        $file_path = base_path().'/public/'.$find->image;
        if (file_exists($file_path))         {
            return response()->download($file_path);
        }         else         {
            exit('فایل در حال به روز رسانی می باشد و فعلا قابل دانلود نمی باشد.');
        }
    }


}

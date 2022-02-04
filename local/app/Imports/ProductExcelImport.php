<?php

namespace App\Imports;

use App\Offcode;
use App\Miniproduct;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductExcelImport implements ToModel
{

    public function model(array $row)
    {
        $slug=make_slug($row[1]);
        $product=Product::where('product_id',$row[0])->first();
        if ($product==""){
            return new Product([
                'product_id' => $row[0],
                'title' => $row[1],
                'unit' => $row[2],
                'price' => $row[3],
                'depot' => $row[4],
                'user_id' => Auth::id(),
                'slug' => $slug,
                'status' => 'PUBLISHED',
            ]);
        }else{
            if ($product->title!=$row[1] or $product->price!=$row[3] or $product->depot!=$row[4]){
                $product->title=$row[1];
                $product->price=$row[3];
                $product->depot=$row[4];
                $product->save();
            }

        }


    }
}
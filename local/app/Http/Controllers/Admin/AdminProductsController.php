<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Attribute_category;
use App\Attribute_product;
use App\Brand;
use App\Category_product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Product;
use App\Gallery;
use App\Linkdownload;
use App\Category;
use App\Feature;
use Gate;
use App\Imports\ProductExcelImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class AdminProductsController extends Controller
{

    public function index()
    {
        abort_unless(Gate::allows('products_index'),403,'شما به این بخش دسترسی ندارید');
        if (@$_GET['key']){
            $productItems = Product::with('categories')->where('title', 'like', "%" . $_GET['key'] . "%")->orderby('id','desc')->paginate(40);
        }else{
            $productItems = Product::with('categories')->orderby('id','desc')->paginate(40);

        }

        $Active_list="products";
        $Active="products";
        return view('adminbizness.product.index',compact('productItems','Active_list','Active'));
    }


    public function attributes($slug)
    {
        abort_unless(Gate::allows('products_attr'),403,'شما به این بخش دسترسی ندارید');
        $product = Product::where('slug',$slug)->first();
        $categories=Category_product::where('product_id',$product->id)->select('category_id')->get();

        foreach ($categories as $category){
            $category_ids[]=$category->category_id;
        }
        $attributes=[];
        $Attribute_categories=Attribute_category::whereIn('category_id',$category_ids)->select('attribute_id')->distinct()->get();
        if (count($Attribute_categories)){
            foreach ($Attribute_categories as $Attribute_category){

                $Attribute_category_id[]=$Attribute_category->attribute_id;
            }
            $attributes=Attribute::whereIn('id',$Attribute_category_id)->get();
        }


       /* foreach ($categories as $category){
            $attributes[]=Attribute_category::where('category_id',$category->category_id)->select('attribute_id', 'category_id')->distinct()->get();
        }*/
        $Active_list="products";
        $Active="attribute";
        return view('adminbizness.product.attribute',compact('attributes','category_ids','product','category_ids','Active_list','Active'));
    }

    public function attribute_create(Request $request)
    {
        Attribute_product::where('product_id',$request->product_id)->delete();

        foreach ($request->attribute as $key=> $attrs) {
            foreach ($attrs as $attr){
                $attribute = new Attribute_product();
                $attribute->attribute_value_id = $attr;
                $attribute->attribute_id = $key;
                $attribute->product_id = $request->product_id;
                $attribute->save();
            }

        }
        session()->put('insertProduct', 'ویژگی ها برای محصول مورد نظر ثبت شد');
        return redirect(route('products.index'));
    }


    public function create()
    {
        abort_unless(Gate::allows('products_create'),403,'شما به این بخش دسترسی ندارید');
        $categories = Category::all();
        $brands=Brand::all();

        $Active_list="products";
        $Active="products";
        return view('adminbizness.product.create', compact(['categories','brands','Active_list','Active']));

    }

    public function store(ProductCreateRequest $request)
    {
        $product = new Product();
        $linkdownload = new Linkdownload();

        if($request->input('slug')){
            $product->slug = make_slug($request->input('slug'));
        }else{
            $product->slug = make_slug($request->input('title'));
        }

        $product->user_id = Auth::id();
        $product->title = $request->input('title');
        $product->title_seo = $request->input('seoTitle');
        $product->slug = $request->input('slug');
        $product->content = $request->input('content');
        $product->excerpt = $request->input('shortContent');
        $product->meta_description = $request->input('seoContent');
        $product->price = $request->input('mainPrice');
        if (!empty($request->input('discount'))){
            $product->discount = $request->input('discount');
        }else{
            $product->discount=0;
        }
        $product->marginprice = $request->input('marginprice');
        $product->depot = $request->input('depot');
        $product->unit = $request->input('unit');
        $product->buy_limited = $request->input('buy_limited');
        $product->brand = $request->input('brand');
        $product->day_basket = $request->input('day_basket');
        $product->special = $request->input('special');
        $product->status = $request->input('status');
        //$product->type = $request->input('type');
        $product->view = 0;


        //////////////////////////// upload image ///////////////////////////////
        $file = $request->file('image');
        if($file){
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(210, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/' . Auth::id())){
                mkdir("images/". Auth::id());
            }
            $image->save('images/' . Auth::id() .'/'. $name);

            ///////////// save image in table /////////////
            $product->image = 'images/' . Auth::id().'/'.$name;
            ///////////// save image in table /////////////
        }
        //////////////////////////// upload image ///////////////////////////////

        //////////////////////////// upload video ///////////////////////////////
        $file = $request->file('video');
        if($file){
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $path = 'videos/' . Auth::id() .'/'. $name;
            $file->move(public_path().'/videos/'. Auth::id(), $name);
            ///////////// save video in table /////////////
            $product->video = $path;
            ///////////// save video in table /////////////
        }
        //////////////////////////// upload video ///////////////////////////////


        //////////////////////////// upload sound ///////////////////////////////
        $file = $request->file('sound');
        if($file){
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $path = 'sounds/' . Auth::id() .'/'. $name;
            $file->move(public_path().'/sounds/'. Auth::id(), $name);
            ///////////// save sound in table /////////////
            $product->sound = $path;
            ///////////// save sound in table /////////////
        }
        //////////////////////////// upload sound ///////////////////////////////


        $product->save();

        //////////////////////////// upload file ///////////////////////////////
        $file = $request->file('file');
        if($file){
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $path = 'files/' . Auth::id() .'/'. $name;
            $file->move(public_path().'/files/'. Auth::id(), $name);
            ///////////// save file in table /////////////
            $linkdownload->path = $path;
            ///////////// save file in table /////////////
            $linkdownload->user_id = Auth::id();
            $linkdownload->product_id = $product->id;
            $linkdownload->save();
        }
        //////////////////////////// upload file ///////////////////////////////


        //////////////////////////// upload gallery ///////////////////////////////
        $files = $request->file('photo');
        if($files){
            foreach ($files as $file){
                $photos = new Gallery();
                $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
                $image = Image::make($file);
               /* $image->resize(550 , null, function ($constraint) {
                    $constraint->aspectRatio();
                });*/
                if(!is_dir('images/' . Auth::id())){
                    mkdir("images/". Auth::id());
                }
                $image->save('images/' . Auth::id() .'/'. $name);

                ///////////// save image in table /////////////
                $photos->name = $file->getClientOriginalName();
                $photos->path = 'images/' . Auth::id().'/'.$name;
                $photos->product_id = $product->id;
                $photos->user_id = Auth::id();
                $photos->save();
                ///////////// save image in table /////////////
            }
        }
        //////////////////////////// upload gallery ///////////////////////////////

        $product->categories()->attach($request->checkbox);

        if($request->feature) {
            if ($request->feature[0] != "") {
                for ($i = 0; $i < count($request->feature); $i++) {
                    $featur = new Feature();
                    $featur->title = $request->feature[$i];
                    $featur->content = $request->featureValue[$i];
                    $featur->product_id = $product->id;
                    $featur->save();
                }
            }
        }
        session()->put('insertProduct', 'محصول مورد نظر با موفقیت ثبت شد.');
        return redirect(route('products.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_unless(Gate::allows('products_edit'),403,'شما به این بخش دسترسی ندارید');
        $images = Gallery::where(['product_id'=>$id, 'type'=>'product'])->get();
        $features = Feature::where('product_id', $id)->get();

        $product = Product::find($id);
        $category_product = $product->categories;
        $brands=Brand::all();
        $categories = Category::all();

        $Active_list="products";
        $Active="products";
        return view('adminbizness.product.edit',compact('product', 'categories', 'category_product', 'images', 'features', 'brands','Active_list','Active'));
    }

    public function update(ProductEditRequest $request, $id)
    {
        $product = Product::findorfail($id);
        $linkdownload = new Linkdownload();

        if($request->input('slug')){
            $product->slug = make_slug($request->input('slug'));
        }else{
            $product->slug = make_slug($request->input('title'));
        }

        $product->title = $request->input('title');
        $product->title_seo = $request->input('title_seo');
        $product->slug = $request->input('slug');
        $product->content = $request->input('content');
        $product->excerpt = $request->input('excerpt');
        $product->meta_description = $request->input('meta_description');
        $product->price = $request->input('price');
        if (!empty($request->input('discount'))){
            $product->discount = $request->input('discount');
        }else{
            $product->discount=0;
        }
        $product->marginprice = $request->input('marginprice');
        $product->depot = $request->input('depot');
        $product->unit = $request->input('unit');
        $product->buy_limited = $request->input('buy_limited');
        $product->brand = $request->input('brand');
        //$product->type = $request->input('type');
        $product->status = $request->input('status');
        $product->day_basket = $request->input('day_basket');
        $product->special = $request->input('special');


        //////////////////////////// upload image ///////////////////////////////
        $file = $request->file('image');
        if($file){
            if (!empty($product->image)){
                if(file_exists(public_path() . '/' . $product->image)){
                    unlink(public_path() . '/' . $product->image);
                }
            }

            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $image = Image::make($file);
            $image->resize(210, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!is_dir('images/' . Auth::id())){
                mkdir("images/". Auth::id());
            }
            $image->save('images/' . Auth::id() .'/'. $name);

            ///////////// save image in table /////////////
            $product->image = 'images/' . Auth::id().'/'.$name;
            ///////////// save image in table /////////////
        }
        //////////////////////////// upload image ///////////////////////////////

        //////////////////////////// upload video ///////////////////////////////
        $file = $request->file('video');
        if($file){
            if(!empty($product->video)){
                if(file_exists(public_path() . '/' . $product->video)){
                    unlink(public_path() . '/' . $product->video);
                }
            }
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $path = 'videos/' . Auth::id() .'/'. $name;
            $file->move(public_path().'/videos/'. Auth::id(), $name);
            ///////////// save video in table /////////////
            $product->video = $path;
            ///////////// save video in table /////////////
        }
        //////////////////////////// upload video ///////////////////////////////

        //////////////////////////// upload sound ///////////////////////////////
        $file = $request->file('sound');
        if($file){
            if(!empty($product->video)){
                if(file_exists(public_path() . '/' . $product->sound)){
                    unlink(public_path() . '/' . $product->sound);
                }
            }
            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $path = 'sounds/' . Auth::id() .'/'. $name;
            $file->move(public_path().'/sounds/'. Auth::id(), $name);
            ///////////// save sound in table /////////////
            $product->sound = $path;
            ///////////// save sound in table /////////////
        }
        //////////////////////////// upload sound ///////////////////////////////
        if($request->feature){
        if($request->feature[0]!=""){
            $featur_del = Feature::where('product_id', $id);
            $featur_del->delete();
                for($i=0; $i<count($request->feature);$i++){
                    $featur = new Feature();
                    $featur->title = $request->feature[$i];
                    $featur->content = $request->featureValue[$i];
                    $featur->product_id = $id;
                    $featur->save();
                }

        }
       }else{
            $featur_del = Feature::where('product_id', $id);
            $featur_del->delete();
        }

        $product->save();

        //////////////////////////// upload file ///////////////////////////////
        $file = $request->file('file');
        if($file){
            if(!empty($product->video)){
                if(file_exists(public_path() . '/' . $product->video)){
                    unlink(public_path() . '/' . $product->video);
                }
            }
            $linkdownload_delete = Linkdownload::where('product_id', $id)->first();
            if (!empty($linkdownload_delete)){
                $linkdownload_delete->delete();
            }


            $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
            $path = 'files/' . Auth::id() .'/'. $name;
            $file->move(public_path().'/files/'. Auth::id(), $name);
            ///////////// save video in table /////////////
            $linkdownload->path = $path;
            ///////////// save video in table /////////////
            $linkdownload->user_id = Auth::id();
            $linkdownload->product_id = $product->id;
            $linkdownload->save();
        }
        //////////////////////////// upload file ///////////////////////////////

        //////////////////////////// upload gallery ///////////////////////////////
        $files = $request->file('photo');
        if($files){
            foreach ($files as $file){
                $photos = new Gallery();
                $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
                $image = Image::make($file);
                /*$image->resize(550, null, function ($constraint) {
                    $constraint->aspectRatio();
                });*/
                if(!is_dir('images/' . Auth::id())){
                    mkdir("images/". Auth::id());
                }
                $image->save('images/' . Auth::id() .'/'. $name);

                ///////////// save image in table /////////////
                $photos->name = $file->getClientOriginalName();
                $photos->path = 'images/' . Auth::id().'/'.$name;
                $photos->product_id = $product->id;
                $photos->user_id = Auth::id();
                $photos->save();
                ///////////// save image in table /////////////
            }
        }
        //////////////////////////// upload gallery ///////////////////////////////

        $product->categories()->sync($request->checkbox);
        session()->put('insertProduct', 'محصول مورد نظر با موفقیت ویرایش شد.');
        return redirect(route('products.index'));
    }

    public function destroy(Product $product)
    {
        if(!empty($product->image)){
            if(file_exists(public_path() . '/' . $product->image)){
                unlink(public_path() . '/' . $product->image);
            }
        }

        if(!empty($product->video)){
            if(file_exists(public_path() . '/' . $product->video)){
                unlink(public_path() . '/' . $product->video);
            }
        }

        $gallery = Gallery::where('product_id', $product->id)->get();
        if(!empty($gallery)){
            foreach ($gallery as $val){
                if(file_exists(public_path() . '/' . $val->path)){
                    unlink(public_path() . '/' . $val->path);
                }
                $val->delete();
            }
        }

        $product->categories()->detach();

        $featur_del = Feature::where('product_id', $product->id);
        $featur_del->delete();

        $Linkdownload = Linkdownload::where('product_id', $product->id);
        $Linkdownload->delete();


            if($product->delete()){
            session()->put('delete_product', 'محصول مورد نظر با موفقیت حذف شد');
            return redirect()->back();
        }
    }

    public function deletegalleryproduct($id){

        $photo = Gallery::findOrFail($id);

        if(file_exists(public_path() . '/' . $photo->path)){
            unlink(public_path() . '/' . $photo->path);
        }

        if($photo->delete()){
            session()->put('delete_img', 'تصویر مورد نظر با موفقیت حذف شد');
            return redirect()->back();
        }
    }


    public function deletefileproduct($id){

        $photo = Linkdownload::findOrFail($id);

        if(file_exists(public_path() . '/' . $photo->path)){
            unlink(public_path() . '/' . $photo->path);
        }

        if($photo->delete()){
            session()->put('delete_img', 'فایل مورد نظر با موفقیت حذف شد');
            return redirect()->back();
        }
    }

    public function deletevideoproduct($id)
    {
        $product=Product::find($id);
        $product->video="";
        $product->save();
        session()->put('delete_img', 'ویدیو با موفقیت حذف شد');
        return redirect()->back();
    }

    public function excel()
    {
        abort_unless(Gate::allows('add_excel_product'),403,'شما به این بخش دسترسی ندارید');

        $Active_list="tools";
        $Active="insert-excel";
        return view('adminbizness.product.excel', compact(['Active_list','Active']));

    }

    public function store_excel(Request $request)
    {
        if ($request->fileExcel){
            Excel::Import(new ProductExcelImport,request()->file('fileExcel'));

            session()->put('insertProduct', 'فایل مورد نطر با موقیت آپلود شد');
            return redirect('/admin/product/add-excel');
        }else {
            return redirect('/admin/product/add-excel');
        }

    }

}

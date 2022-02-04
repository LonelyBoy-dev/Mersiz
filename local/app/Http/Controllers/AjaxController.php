<?php

namespace App\Http\Controllers;

use App\Description;
use App\Education;
use App\Package;
use App\Photo;
use App\Rule;
use App\Test;
use App\Tree;
use App\Video;
use App\Sound;
use App\User;
use App\Edusound;
use App\Eduvideo;
use App\Eduphoto;
use App\Edupdf;
use App\Listpeople;
use App\Accessuser;
use App\Userrequest;
use App\Meeting;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{

    public function index()
    {
        $msg = "This is a simple message.";
        return response()->json(array('msg' => $msg), 200);
    }

    public function test_status(Request $request){
        $response = array(
            'status' => 'success',
            'msg' => $request->message,
        );
        $test=Test::findOrFail($request->id);
        $test->status=$request->value;
        $test->save();
        if ($test)
        {
            return response()->json('true');
        }

    }

    public function delete_test(Request $request)
    {
        $test=Test::findorfail($request->id);
        $test->delete();
        if ($test){
            echo 'true';
        }
    }

    public function Call_search(Request $request)
    {
        $value=$request->input('value');

        $users=User::where('name', 'LIKE', '%' . $value . '%')->orWhere('national_code', 'LIKE', '%' . $value . '%')->orWhere('reference_code', 'LIKE', '%' . $value . '%')->orWhere('mobile', 'LIKE', '%' . $value . '%')->get();

        foreach ($users as $user){?>
            <tr>
                <td>
                    <input type="checkbox" id="md_checkbox_<?= $user['id'] ?>" class="filled-in chk-col-teal checkBox">
                    <label for="md_checkbox_<?= $user['id'] ?>"></label>
                </td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['reference_code'] ?></td>
                <td><?= $user['mobile'] ?></td>


            </tr>
        <?php }
    }

    public function users_search(Request $request)
    {
        $value=$request->input('value');

        $users=User::where('name', 'LIKE', '%' . $value . '%')->Where('role','!1')->orWhere('national_code', 'LIKE', '%' . $value . '%')->Where('role','!1')->orWhere('reference_code', 'LIKE', '%' . $value . '%')->Where('role','!1')->orWhere('mobile', 'LIKE', '%' . $value . '%')->Where('role','!1')->get();

        foreach ($users as $user){?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 user">
                <div class="card">
                    <div class="header">
                        <div class="col-md-2">
                            <?php
                            if ($user->new == 'YES') {
                                ?>
                                <i onclick="new_user('{{$user->id}}',this)" class="material-icons new-user" title="کاربر جدید">new_releases</i>
                            <?php } ?>
                            <div class="image">

                                <?php if ($user->avatar == '') { ?>
                                    <img src="<?= asset('images/user.png') ?>" width="48" height="48" alt="User"/>
                                <?php } else { ?>
                                    <img src="<?= asset('images/user_profile/' . $user->avatar) ?>" width="48"
                                         height="48" alt="User"/>
                                <?php }
                                ?>

                            </div>  <?php
                            if ($user->status == 'INACTIVE') {
                                ?>
                                <div class="status-inactive">
                                    <i class="material-icons">do_not_disturb_on</i>
                                </div>
                            <?php }

                            ?>
                        </div>

                        <div class="col-md-10">
                            <h2>

                                <small>نام و نام خانوادگی : <span><?= $user['name'] ?></span></small>
                                <small>نام کاربری : <span><?= $user['username'] ?></span></small>
                                <small>کد کاربری : <span><?= $user['reference_code'] ?></span></small>
                                <small>موبایل  : <span><?= $user['mobile'] ?></span></small>
                                <small>زمان ثبت نام  : <span><?=\Hekmatinasser\Verta\Verta::instance($user->created_at)->formatDifference(\Hekmatinasser\Verta\Verta::today('Asia/Tehran'))?></span></small>

                            </h2>
                        </div>



                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle"
                                   data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?=route('users.edit',$user->id)?>">ویرایش<i style="color: #666 !important;" class="material-icons">mode_edit</i></a></li>
                                    <li><a onclick="delete_users(<?= $user->id ?>,this)">حذف<i class="material-icons">delete</i></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="body"  style="<?php if($user->level==1){?>
                        background: url(<?= asset('images/background/white.svg')?>) no-repeat;
                    <?php } elseif($user->level==2){?>
                        background: url(<?= asset('images/background/yellow.svg')?>) no-repeat;
                    <?php } elseif($user->level==3){?>
                        background: url(<?= asset('images/background/green.svg')?>) no-repeat;
                    <?php } elseif($user->level==4){?>
                        background: url(<?= asset('images/background/blue.svg')?>) no-repeat;
                    <?php } elseif($user->level==5){?>
                        background: url(<?= asset('images/background/red.svg')?>) no-repeat;
                    <?php } elseif($user->level==6){?>
                        background: url(<?= asset('images/background/banafsh.svg')?>) no-repeat;
                    <?php } elseif($user->level==7){?>
                        background: url(<?= asset('images/background/black.svg')?>) no-repeat;
                    <?php } ?>
                        ">

                    </div>
                </div>
            </div>
        <?php }
    }

    public function education_search(Request $request)
    {
        $value=$request->input('value');
        $level=$request->input('level');

        $educations=Education::where('title', 'LIKE', '%' . $value . '%')->where('level',$level)->orWhere('surface', 'LIKE', '%' . $value . '%')->where('level',$level)->orWhere('level', 'LIKE', '%' . $value . '%')->where('level',$level)->get();

        foreach ($educations as $education){?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 user">
                <div class="card">
                    <div class="header">



                        <h2>

                            <small>عنوان آموزش : <span><?= $education['title'] ?></span></small>
                            <small>سطح آموزش : <span><?= $education['level'] ?></span></small>
                            <small> مرحله : <span><?= $education['surface'] ?></span></small>
                            <small style="border: none">توضیحات  : <span>مرحله <?= $education['surface'] ?>
                                        شامل
                                        <?= $education['shamel'] ?>
                                        می باشد که در طی زمانی
                                        <?= $education['zaman'] ?>
                                        باید انجام شود.</span></small>

                        </h2>




                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle"
                                   data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?=route('education.edit',$education['id'])?>">ویرایش<i style="color: #666 !important;" class="material-icons">mode_edit</i></a></li>
                                    <li>

                                        <form method="post" class="form_test" action="<?= route('test.show_index') ?>">
                                            <input name="_token" type="hidden" value="P1VyHzxbF3BJfbpN5qiDeaJFVHPb6uzyIm4CSwrO">
                                            <input type="hidden" name="level" value="<?=$education['level']?>">
                                            <input type="hidden" name="surface" value="<?=$education['surface']?>">
                                            <button>
                                                <i class="material-icons">blur_linear</i>
                                                آزمون

                                            </button>

                                        </form>
                                    </li>

                                    <li><a onclick="delete_education(<?=$education['id'] ?>,this)">حذف<i class="material-icons">delete</i></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div style="" class="body">

                    </div>
                </div>
            </div>
        <?php }
    }

    public function delete_users(Request $request)
    {
        $user=User::findorfail($request->input('id'));
        $user->delete();
        if ($user){
            echo 'true';
        }
    }

    public function delete_educations(Request $request)
    {
        $education=Education::findorfail($request->input('id'));
        @$photos=Eduphoto::where('surface',$education->surface)->get();
        if (count($photos)){
            foreach ($photos as $photo){
                unlink('amozesh/level'.$photo->level.'/surface'.$photo->surface.'/photos/'.$photo->path);
                $photo->delete();
            }
        }


        @$sounds=Edusound::where('surface',$education->surface)->get();
        if (count($sounds)){
            foreach ($sounds as $sound){
                unlink('amozesh/level'.$sound->level.'/surface'.$sound->surface.'/sound/'.$sound->path);
                $sound->delete();
            }
        }





        @$pdfs=Edupdf::where('surface',$education->surface)->get();
        if (count($pdfs)){
            foreach ($pdfs as $pdf){
                unlink('amozesh/level'.$pdf->level.'/surface'.$pdf->surface.'/pdf/'.$pdf->path);
                $pdf->delete();
            }
        }
        @$videos=Eduvideo::where('surface',$education->surface)->get();
        if (count($videos)){
            foreach ($videos as $video){
                $video->delete();
            }
        }

        $education->delete();
        if ($education){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    public function writer_users(Request $request)
    {
        $user=User::findorfail($request->input('id'));
        $user->role=$request->input('val');
        $user->save();
        if ($request->input('val')==1){
            $access=new Accessuser();
            $access->access="profile";
            $access->user_id=$request->input('id');
            $access->save();
        }else{
            $accesss=Accessuser::where('user_id',$request->input('id'))->get();
            foreach ($accesss as $access){
                $access->delete();
            }
        }


        if ($request->input('val')==2){
            echo 'writer';
        }else{
            echo 'user';
        }
    }



    public function delete_rule(Request $request)
    {
        $rule=Rule::findorfail($request->input('id'));
        $rule->delete();
        if ($rule){
            echo 'true';
        }
    }

    public function delete_description(Request $request)
    {
        $rule=Description::findorfail($request->input('id'));
        $rule->delete();
        if ($rule){
            echo 'true';
        }
    }

    public function status_photo(Request $request)
    {
        $id=$request->input('id');
        $status=$request->input('status');
        if ($status=='DELETE'){
            $photo=Photo::findorfail($id);
            unlink('images/photos/'.$photo->path);
            $photo->delete();
        }else{
            $photo=Photo::findorfail($id);
            $photo->status=$status;
            $photo->save();
        }

        if ($photo){
            echo 'true';
        }
    }

    public function status_video(Request $request)
    {
        $id=$request->input('id');
        $status=$request->input('status');
        if ($status=='DELETE'){
            $photo=Video::findorfail($id);
            unlink('videos/'.$photo->path);
            $photo->delete();
        }else{
            $photo=Video::findorfail($id);
            $photo->status=$status;
            $photo->save();
        }

        if ($photo){
            echo 'true';
        }
    }

    public function status_sound(Request $request)
    {
        $id=$request->input('id');
        $status=$request->input('status');
        if ($status=='DELETE'){
            $photo=Sound::findorfail($id);
            unlink('sounds/'.$photo->path);
            $photo->delete();
        }else{
            $photo=Sound::findorfail($id);
            $photo->status=$status;
            $photo->save();
        }

        if ($photo){
            echo 'true';
        }
    }

    public function remove_educations(Request $request)
    {
        $id=$request->input('id');

        if ($request->input('edu')=="photo"){
            $photo=Eduphoto::findorfail($id);
            unlink('amozesh/level'.$photo->level.'/surface'.$photo->surface.'/photos/'.$photo->path);
            $photo->delete();
        }
        if ($request->input('edu')=="video"){
            $video=Eduvideo::findorfail($id);
            $video->delete();
        }
        if ($request->input('edu')=="sound"){
            $sound=Edusound::findorfail($id);
            unlink('amozesh/level'.$sound->level.'/surface'.$sound->surface.'/sound/'.$sound->path);
            $sound->delete();
        }
        if ($request->input('edu')=="pdf"){
            $pdf=Edupdf::findorfail($id);
            unlink('amozesh/level'.$pdf->level.'/surface'.$pdf->surface.'/pdf/'.$pdf->path);
            $pdf->delete();
        }
        return response()->json($request->input('id'));
    }

    public function search_listpeople(Request $request)
    {
        $value = $request->input('value');


        if (empty($value)) {
            $Listpeople = Listpeople::with('user')->get();
        }
        $users = User::where('name', 'LIKE', '%' . $value . '%')->get();
        foreach ($users as $list) {


            $Listpeople = Listpeople::with('user')->where('user_id', $list->id)->get();



            foreach ($Listpeople as $user) {
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 user">
                    <div class="card">

                        <a href="<?= route('listpeople.show', $user->id) ?>">
                            <div class="header">
                                <div class="col-md-2">


                                    <div class="image">
                                        <?php if ($user->user->avatar == '') { ?>
                                            <img src="<?= asset('images/user.png') ?>" width="48" height="48"
                                                 alt="User"/>
                                        <?php } else { ?>
                                            <img src="<?= asset('images/user_profile/' . $user->user->avatar) ?>"
                                                 width="48" height="48" alt="User"/>
                                        <?php } ?>

                                    </div>


                                </div>

                                <div class="col-md-10">
                                    <h2>

                                        <small>نام و نام خانوادگی : <span><?= $user->user->name ?></span></small>
                                        <small>نام کاربری : <span><?= $user->user->username ?></span></small>
                                        <small>کد کاربری : <span><?= $user->user->reference_code ?></span></small>
                                        <small>سطح : <span><?= $user->user->level ?></span></small>
                                        <small>مرحله : <span><?= $user->user->surface ?></span></small>

                                    </h2>
                                </div>


                                <!--    <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle"
                                       data-toggle="dropdown" role="button" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{route('users.edit',$user->id)}}">ویرایش<i style="color: #666 !important;" class="material-icons">mode_edit</i></a></li>
                                        <li><a onclick="delete_users('<?/*= $user->id */ ?>',this)">حذف<i class="material-icons">delete</i></a></li>

                                    </ul>
                                </li>
                            </ul>-->
                            </div>

                            <div class="body" style="<?php if ($user->user->level == 1) { ?>
                                background: url(<?= asset('images/background/white.svg') ?>) no-repeat;
                            <?php } elseif ($user->user->level == 2) { ?>
                                background: url(<?= asset('images/background/yellow.svg') ?>) no-repeat;
                            <?php } elseif ($user->user->level == 3) { ?>
                                background: url(<?= asset('images/background/green.svg') ?>) no-repeat;
                            <?php } elseif ($user->user->level == 4) { ?>
                                background: url(<?= asset('images/background/blue.svg') ?>) no-repeat;
                            <?php } elseif ($user->user->level == 5) { ?>
                                background: url(<?= asset('images/background/red.svg') ?>) no-repeat;
                            <?php } elseif ($user->user->level == 6) { ?>
                                background: url(<?= asset('images/background/banafsh.svg') ?>) no-repeat;
                            <?php } elseif ($user->user->level == 7) { ?>
                                background: url(<?= asset('images/background/black.svg') ?>) no-repeat;
                            <?php } ?>
                                ">
                        </a>


                    </div>
                </div>
                </div>
            <?php }
        }
    }

    public function user_request_user(Request $request){
        $req=new Userrequest();
        $req->user_id=$request->input('user_id');
        $req->request=$request->input('request');
        $req->save();
        echo 'ok';

    }
    public function user_request_confirm(Request $request){
        $user=User::findorfail($request->input('user_id'));
        if ($request->input('request')=="Exam"){
            $user->test_confirm="NO";
            $req=Userrequest::where(['user_id'=>$request->input('user_id'),'request'=>$request->input('request')])->first();
            $req->Exam="YES";
            $req->save();
        }else{
            $user->surface=$user->surface+1;
            $req=Userrequest::where(['user_id'=>$request->input('user_id'),'request'=>$request->input('request')]);
            $req->delete();
        }

        $user->save();




        echo 'ok';

    }
    public function status_new_user(Request $request){
        $user=User::findorfail($request->input('user_id'));
        $user->new="NO";
        $user->status="ACTIVE";
        $user->save();
        echo 'ok';

    }
    public function delete_meeting(Request $request){
        $Meeting=Meeting::findorfail($request->input('meeting_id'));
        $Meeting->delete();
        echo 'ok';

    }
    public function Again_code(Request $request){
        $mobile=session('verifire_mobile');
        if (!empty($mobile)) {
            $user = User::where('mobile', $mobile)->first();
            $length = 6; // تعداد حروف و اعداد که برای کاربر نمایش داده میشوند
            $str = "123456789";
            $max = strlen($str) - 1;
            $random = "";
            for ($i = 0; $i < $length; $i++) {
                $number = mt_rand(0, $max);
                $random .= substr($str, $number, 1);
            }
            $user->verifire_code = $random;

            $username = "udreams";
            $password = 'fardabia20002000';
            $from = "+983000505";
            $pattern_code = "30a206hbb9";
            $to = array($mobile);
            $input_data = array("verification-code" => $random);
            $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            $user->save();

            echo 'ok';
        }

    }

    public function checkbag(Request $request)
    {
        $id_package=$request->input('id_package');
        $wallet=Wallet::where('user_id',Auth::id())->first();
        $package=Package::findorfail($id_package);


        $maliat=$package->price*9/100;
        $price_package=$package->price+$maliat;
        if ($wallet->price>=$price_package){
            echo 'ok';
        }else{
            echo 'notok';
        }
    }

    public function refresh_price_wallet(Request $request)
    {
        $wallet=Wallet::where('user_id',Auth::id())->first();
        echo number_format($wallet->price);
    }

    public function get_left_and_right(Request $request)
    {
        $submultiple = 0;
        $refral_codes = Tree::where('reference_code', $request->code)->where('right_total_sell', '>=', 2000000)->where('left_total_sell', '>=', 2000000)->first();
        if (!empty($refral_codes)) {
            $right_pricr = $refral_codes->right_total_sell;
            $left_price = $refral_codes->left_total_sell;


            if ($right_pricr < $left_price) {
                $submultiple = (int)($right_pricr / 2000000);
            } elseif ($right_pricr > $left_price) {
                $submultiple = (int)($left_price / 2000000);
            } else {
                $submultiple = (int)($right_pricr / 2000000);
            }

        }



        $hands = Tree::where('reference_code' , $request->code)->first();

        if(!empty($hands->left_hand)){

            $hands_user_left = Tree::where('reference_code' , $hands->left_hand)->first();
            $user_left = User::findorfail($hands_user_left->user_id);
            $name_left = $user_left->name;
            $state_left = $user_left->ostan;
            $city_left = $user_left->city;
            $mobile_left = $user_left->mobile;
            $balance = $submultiple;
            $direct_selling_left = number_format($hands_user_left->direct_selling_save);

        }else{
            $name_left = '';
            $state_left = '';
            $city_left = '';
            $mobile_left = '';
            $direct_selling_left= 0;
            $balance = '';
        }

        if(!empty($hands->right_hand)){

            $hands_user_right = Tree::where('reference_code' , $hands->right_hand)->first();
            $user_right = User::findorfail($hands_user_right->user_id);
            $name_right = $user_right->name;
            $state_right = $user_right->ostan;
            $city_right = $user_right->city;
            $mobile_right = $user_right->mobile;
            $balance = $submultiple;
            $direct_selling_right = number_format($hands_user_right->direct_selling_save);

        }else{
            $name_right = '';
            $state_right = '';
            $city_right = '';
            $mobile_right = '';
            $direct_selling_right = 0;
            $balance = '';
        }




        if($request->code == Auth::user()->reference_code){
            $back_hand = 0;
        }else{
            $back_hand = $hands->reference;
        }

        return response()->json([
            "vleft" => $hands->left_hand,
            "vright" => $hands->right_hand,
            "reference" => $back_hand,
            "leftcount" => $hands->left_count,
            "rightcount" => $hands->right_count,
            "leftsave" => number_format($hands->left_price),
            "rightsave" => number_format($hands->right_price),
            "name_left" => $name_left,
            "state_left" => $state_left,
            "city_left" => $city_left,
            "mobile_left" => $mobile_left,
            "name_right" => $name_right,
            "state_right" => $state_right,
            "city_right" => $city_right,
            "mobile_right" => $mobile_right,
            "direct_selling_right" => $direct_selling_right,
            "direct_selling_left" => $direct_selling_left,
            "balance" => $submultiple,
        ]);
    }

    public function getusercode(Request $request)
    {
        $code = Tree::Where('reference_code', 'like', '%' . $request->code . '%')->get();
        return response()->json([
            "code" => $code
            ]);
    }
}

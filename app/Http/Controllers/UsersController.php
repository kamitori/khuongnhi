<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;

class UsersController extends Controller {
    protected $layout = 'layout.index';

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex()
    {
        echo 123;
    }

    public function postChangeColor(Request $request){
        $arr_return = ['status'=>'error'];
        $primary_color = $request->has('primary_color')?$request->input('primary_color'):0;
        $menu_color = $request->has('menu_color')?$request->input('menu_color'):0;
        $user_id = \Auth::user()->id;
        $check = User::where('id',$user_id)->update([
                                                        'primary_color'=>$primary_color,
                                                        'menu_color'=>$menu_color
                                                    ]);
        if($check){
            $arr_return['status'] = 'success';
        }else{
            $arr_return['message'] = 'Save error';
        }
        return $arr_return;
    }

}
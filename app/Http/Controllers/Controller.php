<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Menu;
abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    protected $layout = 'layout.index';
	protected $auth_check = 1;
    /**
     * Show the user profile.
     */

    public function __construct()
    {
        if($this->auth_check){
            $this->middleware('auth');
            $this->middleware('admin');
            $this->middleware('permission');
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');

    }
    public function setContent($view, $data = [])
    {

        if ( ! is_null($this->layout))
        {
            return $this->layout->nest('child', $view, $data);
        }

        return view($view, $data);

    }

    /**
     * Set the layout used by the controller.
     *
     * @param $name
     * @return void
     */
    protected function setLayout($name)
    {
        $this->layout = $name;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = view($this->layout);
            $this->layout->menus = Menu::getMenu() ;
        }
    }


    public function callAction($method, $parameters)
    {
        $this->setupLayout();

        $response = call_user_func_array(array($this, $method), $parameters);


        if (is_null($response) && ! is_null($this->layout))
        {
            $response = $this->layout;
        }

        return $response;
    }
}

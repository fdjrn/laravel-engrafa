<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\RoleMenu;
use App\Models\Menu;

class GlobalComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        try{

            $menu = array();
            if(Auth::check()){
                $menu = Menu::tree(Auth::user()->role);
            }
            // dd($menu);
            $view->with('roleMenus',$menu);

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

}
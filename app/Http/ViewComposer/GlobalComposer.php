<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\RoleMenu;
use App\Models\Menu;
use App\Models\Survey;
use App\Models\Role;

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

                $mnsurvey = Survey::mnsurvey();
                $view->with('mnsurvey', $mnsurvey);
                $data_roles = Role::data_roles();
                $view->with('data_roles', $data_roles);
            }
            // dd($menu);
            $view->with('roleMenus',$menu);

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

}
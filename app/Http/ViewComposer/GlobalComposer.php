<?php
namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\RoleMenu;
use App\Models\Menu;
use App\Models\Survey;
use App\Models\Role;
use App\Models\ItGoal;
use App\Models\Level;
use App\Models\Process;

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
                $dataItGoal = ItGoal::dataItGoal();
                $view->with('dataItGoal', $dataItGoal);
                $dataItGoalToProcess = ItGoal::dataItGoalToProcess();
                $view->with('dataItGoalToProcess', $dataItGoalToProcess);
                $dataLevel = Level::dataLevel();
                $view->with('dataLevel', $dataLevel);
                $dataProcess = Process::getDataProcess();
                $view->with('dataProcess', $dataProcess);
            }
            // dd($menu);
            $view->with('roleMenus',$menu);

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

}
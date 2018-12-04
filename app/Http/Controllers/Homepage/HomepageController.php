<?php

namespace App\Http\Controllers\Homepage;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class HomepageController
 *
 * @author fadjrin
 * @since 2018-12-04
 * @package App\Http\Controllers\Homepage
 */
class HomepageController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index(){
    	return view('homepage.homepage');
    }
}

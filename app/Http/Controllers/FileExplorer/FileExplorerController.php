<?php

namespace App\Http\Controllers\FileExplorer;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FileExplorerController extends Controller
{
    //
    public function index(){
    	return view('fileexplorer.file-explorer');
    }
}

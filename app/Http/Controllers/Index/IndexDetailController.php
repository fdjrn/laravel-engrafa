<?php

namespace App\Http\Controllers\Index;

use App\Models\Files;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexDetailController extends Controller
{
    public function index($id){
        $files = Files::findOrFail($id);
        return view('index.index-detail')
            ->with('file_detail', $files)
            ->with('loggedUser', Auth::user());
    }

}

<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    //
    public function index(){
    	return view("chat.chat");
    }

    public function invite(){
    	return view("chat.chatinvite");
    }
}

<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\User;

class ChatController extends Controller
{
    //
    public function index(){
    	return view("chat.chat");
    }

    public function invite(){
    	return view("chat.chatinvite");
    }

    public function getUser(){
    	$users = User::where('id','<>',Auth::user()->id)->get();

    	return response()->json($users);
    }

    public function getUserAvailable(){
    	$users = User::where('id','<>',Auth::user()->id)->get();

    	return response()->json($users);
    }
}

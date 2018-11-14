<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class SurveyController extends Controller
{
    //
    public function index(Request $request){
    	return view('survey.survey');
    }

    public function addQuestion(Request $request){
    	return view('survey.survey-add-question');	
    }

    public function chooseAnswer(Request $request){
    	return view('survey.survey-choose-answer');	
    }

    public function test(Request $request){
        $msg = $request->text;
        return response()->json(array('msg'=>$msg),200);
    }
}

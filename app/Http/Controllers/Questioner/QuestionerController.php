<?php

namespace App\Http\Controllers\Questioner;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\UploadedFile;
use App\Models\Questioner;
use App\Models\QuestionerCategory;
use App\Models\Question;
use App\Models\QuestionAsking;
use App\Models\QuestionSlider;
use App\Models\QuestionStarRating;
use App\Models\QuestionCheckbox;
use App\Models\Answer;

class QuestionerController extends Controller
{

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create questioner
     *
     * URL /questioner
     */
    public function index()
    {
        return view('questioner.questioner');
    }

    
    /**
     * Create questioner
     *
     * URL /questioner
     */
    public function get_list_all(Request $request)
    {
        //return \DataTables::of(Questioner::getQuestionerAll())->make(true);
        $questioner = Questioner::getQuestionerAll();
        return DataTables::of($questioner)
            ->addColumn('action', function ($questioner) {
                return '<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-n-questioner"><i class="glyphicon glyphicon-edit"></i></button>
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-n-questioner"><i class="glyphicon glyphicon-trash"></i></button>';
                })
            ->make(true);
    }

    public function view_questioner(Request $request, $id){
        $questioner = Questioner::getQuestionerQuestionAll($id);

        return view('questioner.questioner-view', ['questioner'=>$questioner]);
    }

    public function question_answer(Request $request){

        $userId = Auth::id();
        $id = isset($request->id)? $request->id:null;

        $question_id = isset($request->question_id) ? $request->question_id : [];
        $id_question_type = isset($request->id_question_type) ? $request->id_question_type : [];
        $answer_asking = isset($request->answer_asking) ? $request->answer_asking : [];
        $answer_checkbox = isset($request->answer_checkbox) ? $request->answer_checkbox : [];
        $answer_rating = isset($request->answer_rating) ? $request->answer_rating : [];
        $answer_slider = isset($request->answer_slider) ? $request->answer_slider : []; 

        if(count($answer_asking) > 0 && count($answer_checkbox) > 0 && count($answer_rating) > 0 && count($answer_slider) > 0){

            foreach($question_id as $key=>$value){
                
                $data = [];
                if($id_question_type[$key]==1){
                    $data = [
                        'id_quisioner' => $id,
                        'id_question' => $question_id[$key],
                        'created_by' => $userId,
                        'id_answer_asking'=> $answer_asking[ $question_id[$key] ]
                    ];

                    $insert = Answer::createAnswerAsking($data);

                    if(!$insert){
                        $response = array(
                            'status' => 0,
                            'message' => 'Insert answer asking failed'
                        );
            
                        return $response;
                    }
                }

                if($id_question_type[$key]==2){
                    $data = [
                        'id_quisioner' => $id,
                        'id_question' => $question_id[$key],
                        'created_by' => $userId,
                        'value_slider'=> $answer_slider[ $question_id[$key] ]
                    ];

                    $insert = Answer::createAnswerSlider($data);

                    if(!$insert){
                        $response = array(
                            'status' => 0,
                            'message' => 'Insert answer slider failed'
                        );
            
                        return $response;
                    }
                }

                if($id_question_type[$key]==3){
                    $data = [
                        'id_quisioner' => $id,
                        'id_question' => $question_id[$key],
                        'created_by' => $userId,
                        'value_rating'=> $answer_rating[ $question_id[$key] ]
                    ];

                    $insert = Answer::createAnswerStarsRating($data);

                    if(!$insert){
                        $response = array(
                            'status' => 0,
                            'message' => 'Insert answer rating failed'
                        );
            
                        return $response;
                    }
                }

                if($id_question_type[$key]==4){
                    
                    foreach($answer_checkbox[ $question_id[$key] ] as $item){
                        $data = [
                            'id_quisioner' => $id,
                            'id_question' => $question_id[$key],
                            'created_by' => $userId,
                            'id_answer_checkbox'=> $item
                        ];

                        $insert = Answer::createAnswerCheckbox($data);

                        if(!$insert){
                            $response = array(
                                'status' => 0,
                                'message' => 'Insert answer checkbox failed'
                            );
                
                            return $response;
                        }
                    }

                }


            }

            $response = array(
                'status' => 1,
                'message' => 'Quisioner Answer Has Been Saved'
            );
            toastr()->success($response['message'],'Success');

            return $response;

        }else{
            $response = array(
                'status' => 0,
                'message' => 'Question is must answer all'
            );

            return $response;
        }
    }

    /**
     * Create new questioner
     *
     * URL /create-new-questioner
     */
    public function create_new_questioner(Request $request)
    {
        return view('questioner.questioner-create');
    }

    /**
     * Create questioner
     *
     * URL /create-questioner
     */
    public function create_questioner(Request $request)
    {
        $userId = Auth::id();
        $c_questioner_name = isset($request->c_questioner_name) ? $request->c_questioner_name : '';
        $c_questioner_category = isset($request->c_questioner_category) ? $request->c_questioner_category : '' ;

        $c_question_name = isset($request->c_question_name) ? $request->c_question_name : [];
        $c_question_category = isset($request->c_question_category) ? $request->c_question_category : [];

        $choise_asking_question = isset($request->choise_asking_question) ? $request->choise_asking_question : [];
        $choise_checkbox_question = isset($request->choise_checkbox_question) ? $request->choise_checkbox_question : [];
        $slider_min_value = isset($request->slider_min_value) ? $request->slider_min_value : [];
        $slider_max_value = isset($request->slider_max_value) ? $request->slider_max_value : [];
        $star_rating_value = isset($request->star_rating_value) ? $request->star_rating_value : [];

        $questioner = Questioner::existsQuestionerByName($c_questioner_name);
        
        if($questioner){
            $response = array(
                'status' => 0,
                'message' => 'Quisioner name already exist'
            );

            return $response;
        }else{

            if(count($c_question_name) > 0){

                $insert_id = Questioner::createQuestioner([
                    "user_id" => $userId,
                    "quisioner_name" => $c_questioner_name,
                    "quisioner_category" => $c_questioner_category
                ]);
    
                if($insert_id){                
                        
                    foreach($c_question_name as $i=>$value){

                        $question = [
                            "id_quisioner" => $insert_id,
                            "question" => $c_question_name[$i],
                            "id_question_type" => $c_question_category[$i],
                        ];

                        $insert_id_question = Question::createQuestion($question);

                        if($insert_id_question){

                            //asking question
                            if($c_question_category[$i] == "1"){
                                if(isset($choise_asking_question[$i])){

                                    if(count($choise_asking_question[$i]) > 0){

                                        foreach($choise_asking_question[$i] as $key=>$value){

                                            $question_asking = [
                                                "id_question" => $insert_id_question,
                                                "question_asking_answer" => $value,
                                            ];

                                            $insert_question_asking = QuestionAsking::createQuestionAsking($question_asking);

                                            if(!$insert_question_asking){
                                                $response = array(
                                                    'status' => 0,
                                                    'message' => 'Insert question asking failed'
                                                );
                                    
                                                return $response;
                                            }

                                        }

                                    }

                                }
                            }

                            //slider question
                            if($c_question_category[$i] == "2"){
                                if(isset($slider_min_value[$i]) && $slider_max_value[$i]){
                                    $question_slider = [
                                        'id_question' => $insert_id_question,
                                        'min_value' => $slider_min_value[$i],
                                        'max_value' => $slider_max_value[$i],
                                    ];

                                    $insert_question_slider = QuestionSlider::createQuestionSlider($question_slider);

                                    if(!$insert_question_slider){
                                        $response = array(
                                            'status' => 0,
                                            'message' => 'Insert question slider failed'
                                        );
                            
                                        return $response;
                                    }
                                }
                            }

                            //star rating question
                            if($c_question_category[$i] == "3"){
                                if(isset($star_rating_value[$i])){
                                    $question_slider = [
                                        'id_question' => $insert_id_question,
                                        'number_of_stars' => $star_rating_value[$i],
                                    ];

                                    $insert_question_stars_rating = QuestionStarRating::createQuestionStarsRating($question_slider);

                                    if(!$insert_question_stars_rating){
                                        $response = array(
                                            'status' => 0,
                                            'message' => 'Insert question stars rating failed'
                                        );
                            
                                        return $response;
                                    }
                                }
                            }

                            //checbox question
                            if($c_question_category[$i] == "4"){
                                if(isset($choise_checkbox_question[$i])){

                                    if(count($choise_checkbox_question[$i]) > 0){

                                        foreach($choise_checkbox_question[$i] as $key=>$value){

                                            $question_checkbox = [
                                                "id_question" => $insert_id_question,
                                                "question_checkbox_answer" => $value,
                                            ];

                                            $insert_question_checkbox = QuestionCheckbox::createQuestionCheckbox($question_checkbox);

                                            if(!$insert_question_checkbox){
                                                $response = array(
                                                    'status' => 0,
                                                    'message' => 'Insert question checkbox failed'
                                                );
                                    
                                                return $response;
                                            }

                                        }

                                    }

                                }
                            }
                        }else{
                            $response = array(
                                'status' => 0,
                                'message' => 'Insert question failed'
                            );
                
                            return $response;
                        }

                    }                  
    
                    $response = array(
                        'status' => 1,
                        'message' => 'Quisioner Has Been Created'
                    );
                    toastr()->success($response['message'],'Success');
        
                    return $response;
                }else{
                    $response = array(
                        'status' => 0,
                        'message' => 'Insert Questioner failed'
                    );
        
                    return $response;
                }
            }else{
                $response = array(
                    'status' => 0,
                    'message' => 'Question is must be at least 1'
                );
    
                return $response;
            }
            
        }


    }
}
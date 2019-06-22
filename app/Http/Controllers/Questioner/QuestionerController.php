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
     * URL /questioner/preview
     */
    public function preview()
    {
        return view('questioner.questioner-preview');
    }

    /**
     * Create questioner
     *
     * URL /questioner/preview/detail/{id}
     */
    public function preview_detail($id)
    {
        $questioner = Questioner::getQuestionerQuestionAnswerAll($id);
        return view('questioner.questioner-preview-detail', ['questioner'=>$questioner]);
    }

    public function quisioner_answer_asking(Request $request){
        $quisionerId = isset($request['idQuisioner']) ? $request['idQuisioner'] : '';
        $questionId = isset($request['idQuestion']) ? $request['idQuestion'] : '';
        $quisionerAnswerId = isset($request['idQuisionerAnswer']) ? $request['idQuisionerAnswer'] : '';
        
        if(!empty($quisionerAnswerId) && !empty($quisionerId) && !empty($questionId)){
            $get_user_quisioner = Questioner::getUserQuisioner('asking', $quisionerId, $questionId, $quisionerAnswerId);

            if(count($get_user_quisioner) > 0){
                $response = array(
                                'status' => 1,
                                'message' => 'success',
                                'data' => $get_user_quisioner
                            );
            }else{
                $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
            }
        }else{
            $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
        }

        return $response;
    }

    public function quisioner_answer_checkbox(Request $request){
        $quisionerId = isset($request['idQuisioner']) ? $request['idQuisioner'] : '';
        $questionId = isset($request['idQuestion']) ? $request['idQuestion'] : '';
        $quisionerAnswerId = isset($request['idQuisionerAnswer']) ? $request['idQuisionerAnswer'] : '';

        if(!empty($quisionerAnswerId) && !empty($quisionerId) && !empty($questionId)){
            $get_user_quisioner = Questioner::getUserQuisioner('checkbox', $quisionerId, $questionId, $quisionerAnswerId);

            if(count($get_user_quisioner) > 0){
                $response = array(
                                'status' => 1,
                                'message' => 'success',
                                'data' => $get_user_quisioner
                            );
            }else{
                $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
            }
        }else{
            $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
        }

        return $response;
    }

    public function quisioner_answer_slider(Request $request){
        $quisionerId = isset($request['idQuisioner']) ? $request['idQuisioner'] : '';
        $questionId = isset($request['idQuestion']) ? $request['idQuestion'] : '';
        $quisionerAnswerId = isset($request['idQuisionerAnswer']) ? $request['idQuisionerAnswer'] : '';

        if(!empty($quisionerId) && !empty($questionId)){
            $get_user_quisioner = Questioner::getUserQuisioner('slider', $quisionerId, $questionId, $quisionerAnswerId);

            if(count($get_user_quisioner) > 0){
                $response = array(
                                'status' => 1,
                                'message' => 'success',
                                'data' => $get_user_quisioner
                            );
            }else{
                $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
            }
        }else{
            $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
        }

        return $response;
    }

    public function quisioner_answer_rating(Request $request){
        $quisionerId = isset($request['idQuisioner']) ? $request['idQuisioner'] : '';
        $questionId = isset($request['idQuestion']) ? $request['idQuestion'] : '';
        $quisionerAnswerId = isset($request['idQuisionerAnswer']) ? $request['idQuisionerAnswer'] : '';

        if(!empty($quisionerId) && !empty($questionId)){
            $get_user_quisioner = Questioner::getUserQuisioner('rating', $quisionerId, $questionId, $quisionerAnswerId);

            if(count($get_user_quisioner) > 0){
                $response = array(
                                'status' => 1,
                                'message' => 'success',
                                'data' => $get_user_quisioner
                            );
            }else{
                $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
            }
        }else{
            $response = array(
                                'status' => 0,
                                'message' => 'no data',
                                'data' => []
                            );
        }

        return $response;
    }

    /**
     * Create questioner
     *
     * URL /questioner
     */
    public function get_list_all(Request $request)
    {
        $userId = Auth::id();
        $user = Questioner::getUserById($userId);
        $questioner = Questioner::getQuestionerAll($user, $userId);

        return DataTables::of($questioner)
            ->addColumn('quisioner_filled', function ($questioner) {
                $idUser = Auth::id();
                $checkFilled = Questioner::checkFilledQuisioner($questioner->id, $idUser);
                if($checkFilled == 1){
                    return 1;
                }else{
                    return 0;
                }
            })
            ->addColumn('action', function ($questioner) {
                $idUser = Auth::id();
                $user = Questioner::getUserById($idUser);
                $answeredQuesioner = Questioner::checkAnsweredQuisioner($questioner->id);
                $str_result = '';

                if($user[0]->role == '1-Super Admin' || $user[0]->role == '2-Admin' || $user[0]->role == '3-Creator'){
                    if($answeredQuesioner == 1){
                        $str_result = '
                        <a href="quisioner/share/'.$questioner->id.'" class="btn btn-xs btn-primary" title="Share"><i class="glyphicon glyphicon-share"></i></a>
                        <a class="btn btn-xs btn-primary" title="Edit" style="background-color: rgb(182, 168, 168);"><i class="glyphicon glyphicon-edit"></i></a>
                        <a class="btn btn-xs btn-primary" title="Delete" style="background-color: rgb(182, 168, 168);"><i class="glyphicon glyphicon-trash"></i></a>
                        ';
                    }else{
                        $str_result = '
                        <a href="quisioner/share/'.$questioner->id.'" class="btn btn-xs btn-primary" title="Share"><i class="glyphicon glyphicon-share"></i></a>
                        <a href="quisioner/edit/'.$questioner->id.'" class="btn btn-xs btn-primary" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="quisioner/delete/'.$questioner->id.'" class="btn btn-xs btn-primary" title="Delete" ><i class="glyphicon glyphicon-trash"></i></a>
                        ';
                    }
                }else{
                    $str_result = '
                    <a class="btn btn-xs btn-primary" title="Share" style="background-color: rgb(182, 168, 168);"><i class="glyphicon glyphicon-share" style="color:white;"></i></a>
                    <a class="btn btn-xs btn-primary" title="Edit" style="background-color: rgb(182, 168, 168);"><i class="glyphicon glyphicon-edit"></i></a>
                    <a class="btn btn-xs btn-primary" title="Delete" style="background-color: rgb(182, 168, 168);"><i class="glyphicon glyphicon-trash"></i></a>
                    ';
                }

                return $str_result;
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

        if(count($answer_asking) > 0 || count($answer_checkbox) > 0 || count($answer_rating) > 0 || count($answer_slider) > 0){

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
            //toastr()->success($response['message'],'Success');

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
                    //toastr()->success($response['message'],'Success');
        
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

    public function edit_questioner(Request $request, $id){
        $questioner = Questioner::getQuestionerQuestionAll($id);
        //dd($questioner);

        return view('questioner.questioner-edit', ['questioner'=>$questioner]);
    }

    public function share_questioner($id){
        $userId = Auth::id();
        $questioner = Questioner::getQuestionerQuestionAll($id);
        $users = Questioner::getUserAll($userId);

        return view('questioner.questioner-share', ['questioner'=>$questioner, 'users'=>$users]);
    }

    public function save_share_questioner(Request $request){
        $quisionerId = isset($request['idQuisioner']) ? $request['idQuisioner'] : '';
        $userId = isset($request['idUser']) ? $request['idUser'] : '';

        if(!empty($quisionerId) && !empty($userId)){
            $check_shared_quisioner = Questioner::checkExistSharedQuisioner($quisionerId, $userId);

            if($check_shared_quisioner){
                $response = array(
                                'status' => 3,
                                'message' => 'Quisioner has beed shared user'
                            );
            }else{
                $insert_id = Questioner::saveShareQuestioner([
                    "quisionerId" => $quisionerId,
                    "userId" => $userId
                ]);

                if($insert_id){
                    $response = array(
                                    'status' => 1,
                                    'message' => 'Quisioner has been shared'
                                );
                }else{
                    $response = array(
                                    'status' => 0,
                                    'message' => 'Quisioner shared failed'
                                );
                }
            }
        }else{
            $response = array(
                                'status' => 2,
                                'message' => 'Quisioner or user must be filled'
                            );
        }

        return $response;
    }

    public function save_edit_questioner(Request $request)
    {
        $userId = Auth::id();
        $c_questioner_id = isset($request->c_questioner_id) ? $request->c_questioner_id : '';
        $c_questioner_name = isset($request->c_questioner_name) ? $request->c_questioner_name : '';
        $c_questioner_category = isset($request->c_questioner_category) ? $request->c_questioner_category : '' ;

        $c_question_id = isset($request->c_question_id) ? $request->c_question_id : [];
        $c_question_name = isset($request->c_question_name) ? $request->c_question_name : [];
        $c_question_category = isset($request->c_question_category) ? $request->c_question_category : [];
        $c_question_category_old = isset($request->c_question_category_old) ? $request->c_question_category_old : [];

        $choise_asking_question = isset($request->choise_asking_question) ? $request->choise_asking_question : [];
        $choise_checkbox_question = isset($request->choise_checkbox_question) ? $request->choise_checkbox_question : [];
        $slider_min_value = isset($request->slider_min_value) ? $request->slider_min_value : [];
        $slider_max_value = isset($request->slider_max_value) ? $request->slider_max_value : [];
        $star_rating_value = isset($request->star_rating_value) ? $request->star_rating_value : [];

        $questioner = Questioner::existsQuestionerByNameForEdit($c_questioner_id, $c_questioner_name);

        if($questioner){
            $response = array(
                'status' => 0,
                'message' => 'Quisioner name already exist'
            );

            return $response;
        }else{

            if(count($c_question_name) > 0){

                $insert_id = Questioner::editQuestioner([
                    "quisioner_id" => $c_questioner_id,
                    "user_id" => $userId,
                    "quisioner_name" => $c_questioner_name,
                    "quisioner_category" => $c_questioner_category
                ]);

                if($insert_id == 1){                
                        
                    foreach($c_question_name as $i=>$value){

                        //cek empty question id
                        if(!empty($c_question_id[$i])){
                            $question = [
                                "id_question" => $c_question_id[$i],
                                "id_quisioner" => $c_questioner_id,
                                "question" => $c_question_name[$i],
                                "id_question_type" => $c_question_category[$i],
                            ];

                            $insert_id_question = Question::editQuestion($question);

                            if($insert_id_question == true){

                                //asking question
                                if($c_question_category[$i] == "1"){
                                    if(isset($choise_asking_question[$i])){

                                        if(count($choise_asking_question[$i]) > 0){
                                            //delete old data
                                            if($c_question_category_old[$i] == "1"){
                                                $delete_asking_question = QuestionAsking::deleteQuestionAskingByIdQuestion($c_question_id[$i]);
                                            }else if($c_question_category_old[$i] == "2"){
                                                $delete_asking_question = QuestionSlider::deleteQuestionSliderByIdQuestion($c_question_id[$i]);
                                            }else if($c_question_category_old[$i] == "3"){
                                                $delete_asking_question = QuestionStarRating::deleteQuestionStarsRatingByIdQuestion($c_question_id[$i]);
                                            }else if($c_question_category_old[$i] == "4"){
                                                $delete_asking_question = QuestionCheckbox::deleteQuestionCheckboxByIdQuestion($c_question_id[$i]);
                                            }
                                            //end delete old data

                                            if($delete_asking_question){
                                                foreach($choise_asking_question[$i] as $key=>$value){

                                                    $question_asking = [
                                                        "id_question" => $c_question_id[$i],
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
                                            }else{
                                                $response = array(
                                                            'status' => 0,
                                                            'message' => 'Insert question asking failed'
                                                        );
                                            
                                                return $response;
                                            }

                                        }

                                    }
                                }

                                //slider question
                                if($c_question_category[$i] == "2"){
                                    if(isset($slider_min_value[$i]) && $slider_max_value[$i]){
                                        //delete old data
                                        if($c_question_category_old[$i] == "1"){
                                            $delete_slider_question = QuestionAsking::deleteQuestionAskingByIdQuestion($c_question_id[$i]);
                                        }else if($c_question_category_old[$i] == "2"){
                                            $delete_slider_question = QuestionSlider::deleteQuestionSliderByIdQuestion($c_question_id[$i]);
                                        }else if($c_question_category_old[$i] == "3"){
                                            $delete_slider_question = QuestionStarRating::deleteQuestionStarsRatingByIdQuestion($c_question_id[$i]);
                                        }else if($c_question_category_old[$i] == "4"){
                                            $delete_slider_question = QuestionCheckbox::deleteQuestionCheckboxByIdQuestion($c_question_id[$i]);
                                        }
                                        //end delete old data

                                        if($delete_slider_question){
                                            $question_slider = [
                                                'id_question' => $c_question_id[$i],
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
                                        }else{
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
                                        //delete old data
                                        if($c_question_category_old[$i] == "1"){
                                            $delete_stars_rating_question = QuestionAsking::deleteQuestionAskingByIdQuestion($c_question_id[$i]);
                                        }else if($c_question_category_old[$i] == "2"){
                                            $delete_stars_rating_question = QuestionSlider::deleteQuestionSliderByIdQuestion($c_question_id[$i]);
                                        }else if($c_question_category_old[$i] == "3"){
                                            $delete_stars_rating_question = QuestionStarRating::deleteQuestionStarsRatingByIdQuestion($c_question_id[$i]);
                                        }else if($c_question_category_old[$i] == "4"){
                                            $delete_stars_rating_question = QuestionCheckbox::deleteQuestionCheckboxByIdQuestion($c_question_id[$i]);
                                        }
                                        //end delete old data

                                        if($delete_stars_rating_question){
                                            $question_stars_rating = [
                                                'id_question' => $c_question_id[$i],
                                                'number_of_stars' => $star_rating_value[$i],
                                            ];

                                            $insert_question_stars_rating = QuestionStarRating::createQuestionStarsRating($question_stars_rating);

                                            if(!$insert_question_stars_rating){
                                                $response = array(
                                                    'status' => 0,
                                                    'message' => 'Insert question stars rating failed'
                                                );
                                    
                                                return $response;
                                            }
                                        }else{
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
                                            //delete old data
                                            if($c_question_category_old[$i] == "1"){
                                                $delete_checkbox_question = QuestionAsking::deleteQuestionAskingByIdQuestion($c_question_id[$i]);
                                            }else if($c_question_category_old[$i] == "2"){
                                                $delete_checkbox_question = QuestionSlider::deleteQuestionSliderByIdQuestion($c_question_id[$i]);
                                            }else if($c_question_category_old[$i] == "3"){
                                                $delete_checkbox_question = QuestionStarRating::deleteQuestionStarsRatingByIdQuestion($c_question_id[$i]);
                                            }else if($c_question_category_old[$i] == "4"){
                                                $delete_checkbox_question = QuestionCheckbox::deleteQuestionCheckboxByIdQuestion($c_question_id[$i]);
                                            }
                                            //end delete old data

                                            if($delete_checkbox_question){
                                                foreach($choise_checkbox_question[$i] as $key=>$value){
                                                    $question_checkbox = [
                                                        "id_question" => $c_question_id[$i],
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
                                            }else{
                                                $response = array(
                                                            'status' => 0,
                                                            'message' => 'Insert question checkbox failed'
                                                        );
                                            
                                                return $response;
                                            }
                                        }
                                    }
                                }
                            }else{
                                $response = array(
                                    'status' => 0,
                                    'message' => 'Update question failed'
                                );
                    
                                return $response;
                            }
                        }else{
                            $question = [
                                "id_quisioner" => $c_questioner_id,
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
                                                        'message' => 'Update question asking failed'
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
                                                'message' => 'Update question slider failed'
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
                                                'message' => 'Update question stars rating failed'
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
                                                        'message' => 'Update question checkbox failed'
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
                                    'message' => 'Update question failed'
                                );
                    
                                return $response;
                            }
                        }
                        //end cek question id

                    }                  
    
                    $response = array(
                        'status' => 1,
                        'message' => 'Quisioner Has Been Updated'
                    );
                    //toastr()->success($response['message'],'Success');
        
                    return $response;
                }else{
                    $response = array(
                        'status' => 0,
                        'message' => 'Update Questioner failed'
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

    public function delete_questioner(Request $request, $id){
        $questioner = Questioner::getQuestionerQuestionAll($id);
        //dd($questioner);

        return view('questioner.questioner-delete', ['questioner'=>$questioner]);
    }

    public function save_delete_questioner(Request $request)
    {
        $userId = Auth::id();
        $c_questioner_id = isset($request->c_questioner_id) ? $request->c_questioner_id : '';
        $c_questioner_name = isset($request->c_questioner_name) ? $request->c_questioner_name : '';
        $c_questioner_category = isset($request->c_questioner_category) ? $request->c_questioner_category : '' ;

        $c_question_id = isset($request->c_question_id) ? $request->c_question_id : [];
        $c_question_name = isset($request->c_question_name) ? $request->c_question_name : [];
        $c_question_category = isset($request->c_question_category) ? $request->c_question_category : [];

        $choise_asking_question = isset($request->choise_asking_question) ? $request->choise_asking_question : [];
        $choise_checkbox_question = isset($request->choise_checkbox_question) ? $request->choise_checkbox_question : [];
        $slider_min_value = isset($request->slider_min_value) ? $request->slider_min_value : [];
        $slider_max_value = isset($request->slider_max_value) ? $request->slider_max_value : [];
        $star_rating_value = isset($request->star_rating_value) ? $request->star_rating_value : [];

        
        //delete question_asking, question_checkbox, question_slider, question_stars_rating
        foreach($c_question_name as $i=>$value){
            //cek empty question id
            if(!empty($c_question_id[$i])){
                //asking question
                if($c_question_category[$i] == "1"){
                    //delete old data
                    $delete_asking_question = QuestionAsking::deleteQuestionAskingByIdQuestion($c_question_id[$i]);
                    if($delete_asking_question){
                        $response = array(
                            'status' => 1,
                            'message' => 'Delete question success'
                        );
            
                        // return $response;
                    }else{
                        $response = array(
                            'status' => 0,
                            'message' => 'Delete question failed'
                        );
            
                        return $response;
                    }
                }

                //slider question
                if($c_question_category[$i] == "2"){
                    //delete old data
                    $delete_slider_question = QuestionSlider::deleteQuestionSliderByIdQuestion($c_question_id[$i]);
                    if($delete_slider_question){
                        $response = array(
                            'status' => 1,
                            'message' => 'Delete question success'
                        );
            
                        // return $response;
                    }else{
                        $response = array(
                            'status' => 0,
                            'message' => 'Delete question failed'
                        );
            
                        return $response;
                    }
                }

                //star rating question
                if($c_question_category[$i] == "3"){
                    //delete old data
                    $delete_stars_rating_question = QuestionStarRating::deleteQuestionStarsRatingByIdQuestion($c_question_id[$i]);
                    if($delete_stars_rating_question){
                        $response = array(
                            'status' => 1,
                            'message' => 'Delete question success'
                        );
            
                        // return $response;
                    }else{
                        $response = array(
                            'status' => 0,
                            'message' => 'Delete question failed'
                        );
            
                        return $response;
                    }
                }

                //checkbox question
                if($c_question_category[$i] == "4"){
                    //delete old data
                    $delete_checkbox_question = QuestionCheckbox::deleteQuestionCheckboxByIdQuestion($c_question_id[$i]);
                    if($delete_checkbox_question){
                        $response = array(
                            'status' => 1,
                            'message' => 'Delete question success'
                        );
            
                        // return $response;
                    }else{
                        $response = array(
                            'status' => 0,
                            'message' => 'Delete question failed'
                        );
            
                        return $response;
                    }
                }

            }else{
                $response = array(
                    'status' => 0,
                    'message' => 'Delete question failed'
                );

                return $response;
            }
        }

        //delete question
        $deleteQuestion = Question::deleteQuestionByIdQuestioner($c_questioner_id);
        if($deleteQuestion){
            $response = array(
                'status' => 1,
                'message' => 'Delete question success'
            );
        }else{
            $response = array(
                'status' => 0,
                'message' => 'Delete question failed'
            );

            return $response;
        }

        //delete quesioner
        $deleteQuestioner = Questioner::deleteQuestionerByIdQuestioner($c_questioner_id);
        if($deleteQuestioner){
            $response = array(
                'status' => 1,
                'message' => 'Delete questioner success'
            );
        }else{
            $response = array(
                'status' => 0,
                'message' => 'Delete questioner failed'
            );

            return $response;
        }        

        return $response;
    }


}
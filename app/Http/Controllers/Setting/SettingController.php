<?php

namespace App\Http\Controllers\Setting;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('setting.index');  
    }

    public function users()
    {
        $data['users'] = DB::table('users')
            ->select('*')
            ->get();
        $data['total_users'] = count($data['users']);


        $data['teams'] = DB::table('survey_members')
            ->select('survey_members.id','surveys.id','surveys.name')
            ->join('surveys','surveys.id','=','survey_members.survey')
            ->where('survey_members.user',Auth::user()->id)
            ->get();
        return view('setting.users',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected function validator(Request $data)
    {
        return Validator::make($data, [
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'roles' => 'required|string',
            'username' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create_user(Request $data)
    {
        User::create([
            'name' => $data['nama_depan'].' '.$data['nama_belakang'],
            'first_name' => $data['nama_depan'],
            'last_name' => $data['nama_belakang'],
            'username' => $data['username'],
            'role' => $data['roles'],
            'phone' => $data['telepon'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect('setting/users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

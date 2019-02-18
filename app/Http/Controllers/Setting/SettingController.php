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
use App\Models\Survey;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $data['user_role'] = DB::table('users')
            ->select('role')
            ->where('id', '=', $userId)
            ->get();

        return view('setting.index');  
    }

    public function users()
    {
        $userId = Auth::id();
        $data['user_role'] = DB::table('users')
            ->select('role')
            ->where('id', '=', $userId)
            ->get();
            
        $data['users'] = DB::table('users')
            ->select('*')
            ->whereNotNull('role')
            ->get();
        $data['total_users'] = count($data['users']);

        $data['guests'] = DB::table('users')
            ->select('*')
            ->whereNull('role')
            ->get();

        $data['total_guests'] = count($data['guests']);

        $data['teams'] = Survey::mnsurvey();

        return view('setting.users',$data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create_user(Request $data)
    {

        $validator = Validator::make(
            $data->all(), [
                'nama_depan' => 'required|max:95',
                'nama_belakang' => 'required|max:95',
                'username' => 'required|unique:users,username|min:5|max:255',
                'roles' => 'required',
                'email' => 'required|email|max:191',
                'telepon' => 'required|max:191',
                'password' => 'required|min:6|max:191|confirmed',
            ],
            [
                'nama_depan.required' => '&#8226;The <span class="text-danger">Nama Depan</span> field is required',
                'nama_belakang.required' => '&#8226;The <span class="text-danger">Nama Belakang</span> field is required',
                'username.required' => '&#8226;The <span class="text-danger">Username</span> field is required',
                'username.unique' => '&#8226;The <span class="text-danger">Username</span> already exists',
                'username.min' => '&#8226;The <span class="text-danger">Username</span> minimum 5 characters',
                'roles.required' => '&#8226;The <span class="text-danger">Roles</span> field is required',
                'email.required' => '&#8226;The <span class="text-danger">Email</span> field is required',
                'email.email' => '&#8226;The <span class="text-danger">Email</span> format is invalid',
                'telepon.required' => '&#8226;The <span class="text-danger">Telepon</span> field is required',
                'password.required' => '&#8226;The <span class="text-danger">Password</span> field is required',
                'password.min' => '&#8226;The <span class="text-danger">Password</span> minimum 5 characters',
                'password.confirmed' => '&#8226;The <span class="text-danger">Password</span> confirmation does not match.',
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => implode("<br>",$validator->messages()->all())
            ]);
        }

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

        return json_encode([
            'status' => 1,
            'messages' => '/setting/users'
        ]);
    }

    protected function edit_user(Request $data)
    {

        $validator = Validator::make(
            $data->all(), [
                'nama_depan' => 'required|max:95',
                'nama_belakang' => 'required|max:95',
                'username' => 'required|min:5|max:255|unique:users,username,'.$data['user_id'],
                'roles' => 'required',
                'email' => 'required|email|max:191',
                'telepon' => 'required|max:191'
            ],
            [
                'nama_depan.required' => '&#8226;The <span class="text-danger">Nama Depan</span> field is required',
                'nama_belakang.required' => '&#8226;The <span class="text-danger">Nama Belakang</span> field is required',
                'username.required' => '&#8226;The <span class="text-danger">Username</span> field is required',
                'username.unique' => '&#8226;The <span class="text-danger">Username</span> already exists',
                'username.min' => '&#8226;The <span class="text-danger">Username</span> minimum 5 characters',
                'roles.required' => '&#8226;The <span class="text-danger">Roles</span> field is required',
                'email.required' => '&#8226;The <span class="text-danger">Email</span> field is required',
                'email.email' => '&#8226;The <span class="text-danger">Email</span> format is invalid',
                'telepon.required' => '&#8226;The <span class="text-danger">Telepon</span> field is required'
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => implode("<br>",$validator->messages()->all())
            ]);
        }

        $User = User::find($data['user_id']);

        $User->name         = $data['nama_depan'].' '.$data['nama_belakang'];
        $User->first_name   = $data['nama_depan'];
        $User->last_name    = $data['nama_belakang'];
        $User->username     = $data['username'];
        $User->role         = $data['roles'];
        $User->phone        = $data['telepon'];
        $User->email        = $data['email'];

        $User->save();

        return json_encode([
            'status' => 1,
            'messages' => '/setting/users'
        ]);
    }

    protected function get_user_by_id($id){
        echo json_encode(DB::table('users')->where('id','=',$id)->get()->first());
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

    public function blackwhitelist()
    {
        $userId = Auth::id();
        $data['user_role'] = DB::table('users')
            ->select('role')
            ->where('id', '=', $userId)
            ->get();

        $data['whiteUsers'] = DB::table('users')
            ->select('*')
            ->where('is_blacklist', '=', 0)
            ->get();
        //$data['total_users'] = count($data['whiteUsers']);
        $data['blackUsers'] = DB::table('users')
            ->select('*')
            ->where('is_blacklist', '=', 1)
            ->get();

        return view('setting.blackwhitelist',$data);
    }

    public function update_blackwhitelist(Request $request)
    {
        //update blacklist
        if(!empty($request['dataBlack'])){
            foreach ($request['dataBlack'] as $blackList) {
                $updateBlackList = DB::table('users')
                    ->where('id', $blackList)
                    ->update(
                      [
                        'is_blacklist' => 1
                      ]
                );
            }
        }

        //update whitelist
        if(!empty($request['dataWhite'])){
            foreach ($request['dataWhite'] as $whiteList) {
                $updateWhiteList = DB::table('users')
                    ->where('id', $whiteList)
                    ->update(
                      [
                        'is_blacklist' => 0
                      ]
                );
            }
        }

        $response = array(
            'status' => 'success'
        );

        return $response;
    }

    public function profile_user()
    {
        $userId = Auth::id();

        $data['user_role'] = DB::table('users')
            ->select('role')
            ->where('id', '=', $userId)
            ->get();

        $data['users'] = DB::table('users')
            ->select('*')
            ->where('id', '=', $userId)
            ->get();

        return view('setting.profile',$data);
    }

    public function update_profile_user(Request $request)
    {
        $userId = Auth::id();
        $user = DB::table('users')
            ->select('*')
            ->where('id', '=', $userId)
            ->get();

        if($request['password'] != null){
            $updateUser = DB::table('users')
                ->where('id', $user[0]->id)
                ->update(
                  [
                    'first_name' => $request['nama_depan'],
                    'last_name' => $request['nama_belakang'],
                    'name' => $request['username'],
                    'role' => $request['roles'],
                    'email' => $request['email'],
                    'phone' => $request['telepon'],
                    'password' => Hash::make($request['password'])
                    //'updated_at' => $request['username'],
                  ]
            );
        }else{
            $updateUser = DB::table('users')
                ->where('id', $user[0]->id)
                ->update(
                  [
                    'first_name' => $request['nama_depan'],
                    'last_name' => $request['nama_belakang'],
                    'name' => $request['username'],
                    'role' => $request['roles'],
                    'email' => $request['email'],
                    'phone' => $request['telepon']
                    //'password' => Hash::make($request['password'])
                    //'updated_at' => $request['username'],
                  ]
            );
        }

        return redirect()->action('Setting\SettingController@profile_user');

    }

    public function backuprestore()
    {
        return view('setting.backuprestore');
    }
}

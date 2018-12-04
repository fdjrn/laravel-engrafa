<?php

namespace App\Http\Controllers\Index;

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


/**
 * @author fadjrin
 * @since 2018-11-29
 *
 * Class IndexController
 * @package App\Http\Controllers\Index
 */
class IndexController extends Controller
{

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('index.index');
    }

    /**
     *
     * @param DataTables $dataTables
     * @return mixed
     * @throws \Exception
     */
    public function getListAll()
    {
        $root_folder_id = 0;
        $lists = DB::table('files')
            ->join('users','users.id','=','files.created_by')
            ->selectRaw("files.id, folder_root, file_root, files.name, url, is_file, 
                        version, size, description, comment, created_by, files.created_at, 
                        files.updated_at, users.name AS owner")
            ->where('folder_root', $root_folder_id)
            ->orderBy('is_file')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $root_folder_name = $this->getRootFolderName($root_folder_id);

        return DataTables::of($lists)
            ->addColumn('checkbox', function ($list) {
                return '<input type="checkbox" name="selected[]" value="' . htmlentities(json_encode($list)) .'">';
            })
            ->with('mainRootFolderName',$root_folder_name)
            ->with('mainRootFolderId',$root_folder_id)
            ->make(true);

    }

    /**
     * @param Request $request
     * @param $id
     * @throws \Exception
     */
    public function getListAllPrevious($id)
    {
        if ($id == 0)
            return;

        $root = Files::find($id);

        $lists = DB::table('files')
            ->join('users','users.id','=','files.created_by')
            ->selectRaw("files.id, folder_root, file_root, files.name, url, is_file, 
                        version, size, description, comment, created_by, files.created_at, 
                        files.updated_at, users.name AS owner")
                ->whereRaw('folder_root = (SELECT folder_root FROM files WHERE id = '.$id.')')
            ->orderBy('is_file')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $root_folder_name = $this->getRootFolderName($root['folder_root']);

        return DataTables::of($lists)
            ->addColumn('checkbox', function ($list) {
                return '<input type="checkbox" name="selected[]" value="' . htmlentities(json_encode($list)) .'">';
            })
            ->with('mainRootFolderName',$root_folder_name)
            ->with('mainRootFolderId',$root['folder_root'])
            /*->with('currentMainFolderId',$root['id'])*/
            ->make(true);
    }

    /**
     * @param Request $request
     * @param $root_folder_id
     * @return mixed
     * @throws \Exception
     */
    public function getListDetail($root_folder_id)
    {
        $lists = DB::table('files')
            ->join('users','users.id','=','files.created_by')
            ->selectRaw("files.id, folder_root, file_root, files.name, url, is_file, 
                        version, size, description, comment, created_by, files.created_at, 
                        files.updated_at, users.name AS owner")
            ->where('folder_root', $root_folder_id)
            ->orderBy('is_file')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $root_folder_name = $this->getRootFolderName($root_folder_id);

        return DataTables::of($lists)
            ->addColumn('checkbox', function ($list) {
                return '<input type="checkbox" name="selected[]" value="' . htmlentities(json_encode($list)) .'">';
            })
            ->with('mainRootFolderName',$root_folder_name)
            ->with('mainRootFolderId',$root_folder_id)
            /*->with('currentMainFolderId',$lists['id'])*/
            ->make(true);
    }

    /**
     * Get list main grid/table at first init
     * @return mixed
     * @throws \Exception
     */
    public function getListFolder()
    {
        $root_folder_id = 0;
        $folders = DB::table('files')
            ->select('files.id','files.name','files.folder_root')
            ->where('files.folder_root', $root_folder_id)
            ->where('files.is_file','=',0)
            ->orderBy('name', 'ASC')
            ->get();

        $rootFolderName = $this->getRootFolderName($root_folder_id);

        return DataTables::of($folders)
            ->with('rootFolderName',$rootFolderName)
            ->with('rootFolderId',0)
            ->make(true);
    }

    /**
     * Route for get list folder detail on main grid
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getListFolderDetail($id)
    {
        $folders = DB::table('files')
            ->select('files.id','files.name','files.folder_root')
            ->where('files.folder_root', $id)
            ->where('files.is_file','=',0)
            ->orderBy('name', 'ASC')
            ->get();

        $rootFolderName = $this->getRootFolderName($id);

        return DataTables::of($folders)
            ->with('rootFolderName',$rootFolderName)
            ->with('rootFolderId',$id)
            /*->with('currentFolderId',$folders['id'])*/
            ->make(true);
    }

    /**
     * Route for get list previous folder
     * @param $id
     * @throws \Exception
     */
    public function getListPreviousFolder($id)
    {
        if ($id == 0)
            return;

        $root = Files::find($id);
        $folders = DB::table('files')
            ->where('files.is_file','=',0)
            ->whereRaw('folder_root = (SELECT folder_root FROM files WHERE id = '.$id.')')
            ->orderBy('name', 'ASC')
            ->get();

        $root_folder_name = $this->getRootFolderName($root['folder_root']);
        return DataTables::of($folders)
            ->with('rootFolderName',$root_folder_name)
            ->with('rootFolderId',$root['folder_root'])
            /*->with('currentFolderId',$root['id'])*/
            ->make(true);
    }

    // TODO
    public function showFile()
    {

    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewFolder(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['folderName' => 'required|max:255'],
            ['New Folder Name cannot be empty!']
        );

        $folder_name = $request->input('folderName');
        if ($validator->passes()) {

            $root = Files::find($id);
            if ($root['id'] == 0) {
                $folder_path = '/storage/index/'.$folder_name;
                Storage::makeDirectory($folder_name);
            } else {
                $folder_path = $root['url'].'/'.$folder_name;
                Storage::makeDirectory(substr($folder_path,15));
            }

            // Storage::makeDirectory($url);

            $folder = new Files();
            $folder->folder_root = $id;
            $folder->name = $folder_name;
            $folder->url= $folder_path;
            $folder->is_file = 0;
            $folder->created_by = Auth()->user()->id;

            $folder->save();

            return response()->json([
                'success' => '1',
                'result'=>$folder
            ]);
        }

        return response()->json(['errors' => $validator->errors(),'inputs'=>$folder_name, 'root folder id'=>$id]);
    }

    // TODO
    public function uploadFiles(Request $request)
    {
        $folderId = $request->get('folderId');
        $files = $request->file('file');
        $file_flag = 1;

        $current_folder = Files::find($folderId);

        foreach ($files as $file){
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getClientSize();
            $file_created_by = Auth()->user()->id;

            if ($folderId == 0){
                $folder_root = 0;
                $file_url = '/'. $file->getClientOriginalName();

            } else {
                $folder_root = $folderId; //$current_folder['folder_root'];
                $file_url = $current_folder['url'].'/'.$file->getClientOriginalName();
            }

            $new_file = Files::create([
                'folder_root' => $folder_root,
                'name' => $file_name,
                'url' => $file_url,
                'is_file' => $file_flag,
                'size' => $file_size,
                'created_by' => $file_created_by,
            ]);


            if ($new_file) {
                $file_path = substr($current_folder['url'],15) .'/'.$file->getClientOriginalName();
                Storage::disk('public')->put($file_path, file_get_contents($file));
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => 'error cenah',
                ], 404);
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function getRootFolderName($id)
    {
        // $root_folder_name = "";

        if ($id == 0)
            $root_folder_name = 'Index';
        else {
            $folder =  Files::find($id);
            $root_folder_name = $folder->name;
        }

        return $root_folder_name;
    }
}
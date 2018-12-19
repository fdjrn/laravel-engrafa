<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Files;
use App\Traits\FilesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


/**
 * @author fadjrin
 * @since 2018-11-29
 *
 * Class IndexController
 * @package App\Http\Controllers\Index
 */
class IndexController extends Controller
{

    use FilesTrait;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $folderIdReq = !is_null($request->get('folder_id')) ? $request->get('folder_id') : "0";
        return view('index.index')->with('folderID', $folderIdReq);
    }

    /**
     * Get list all files and folder based on folder root id
     *
     * @return mixed
     * @throws \Exception
     */
    public function getListAll($id)
    {
        $data = $this->getListByFolderRootId($id);
        $root_folder_name = $this->getFolderNameById($id);

        return DataTables::of($data)
            ->addColumn('checkbox', function ($dt) {
                return '<input type="checkbox" name="selected[]" value="' . htmlentities(json_encode($dt)) . '">';
            })
            ->addColumn('action', function ($f) {
                return'
                <a onclick="bookmarkFile('. $f->id .')" class="btn btn-xs btn-outline-light">
                    <i class="fa fa-bookmark fa-2x"></i>
                </a>
                <div class="btn-group">
                    <a class="btn btn-xs btn-outline-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fa-align-justify fa-2x"></i></span><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">View</a></li>
                        <li><a href="#">Download</a></li>
                        <li><a href="#">Upload New Version</a></li>
                        <li><a href="#">See File Version</a></li>
                    </ul>
                </div>
                ';
            })

            ->with('mainRootFolderName', $root_folder_name)
            ->with('mainRootFolderId', $id)
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
        $data = $this->getListByFolderId($id);
        $root_folder_name = $this->getFolderNameById($root['folder_root']);

        return DataTables::of($data)
            ->addColumn('checkbox', function ($list) {
                return '<input type="checkbox" name="selected[]" value="' . htmlentities(json_encode($list)) . '">';})
            ->addColumn('action', function ($f) {
                return'
                <a onclick="bookmarkFile('. $f->id .')" class="btn btn-xs btn-outline-light"><i class="fa fa-bookmark fa-2x"></i></a>
                <div class="btn-group">
                    <a class="btn btn-xs btn-outline-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fa-align-justify fa-2x"></i></span><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">View</a></li>
                        <li><a href="#">Download</a></li>
                        <li><a href="#">Upload New Version</a></li>
                        <li><a href="#">See File Version</a></li>
                    </ul>
                </div>
                ';
            })
            ->with('mainRootFolderName', $root_folder_name)
            ->with('mainRootFolderId', $root['folder_root'])
            ->make(true);
    }

    /**
     * Route for get list folder detail on main grid
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getListAllFolder($id)
    {
        // get all folder by id
        $folders = $this->getListFolderByRootId($id);

        $rootFolderName = $this->getFolderNameById($id);

        return DataTables::of($folders)
            ->with('rootFolderName', $rootFolderName)
            ->with('rootFolderId', $id)
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
        $folders = $this->getListFolderById($id);

        $root_folder_name = $this->getFolderNameById(($root['folder_root']));
        return DataTables::of($folders)
            ->with('rootFolderName', $root_folder_name)
            ->with('rootFolderId', $root['folder_root'])
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
                $folder_path = '/storage/index/' . $folder_name;
                Storage::makeDirectory($folder_name);
            } else {
                $folder_path = $root['url'] . '/' . $folder_name;
                Storage::makeDirectory(substr($folder_path, 15));
            }

            // Storage::makeDirectory($url);

            $folder = new Files();
            $folder->folder_root = $id;
            $folder->name = $folder_name;
            $folder->url = $folder_path;
            $folder->is_file = 0;
            $folder->created_by = Auth()->user()->id;

            $folder->save();

            return response()->json([
                'success' => '1',
                'result' => $folder
            ]);
        }

        return response()->json(['errors' => $validator->errors(), 'inputs' => $folder_name, 'root folder id' => $id]);
    }

    /**
     * Upload files to current folder id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $folderId = $request->get('folderId');
        $files = $request->file('file');
        $file_flag = 1;

        $current_folder = Files::find($folderId);

        foreach ($files as $file) {
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getClientSize();
            $file_created_by = Auth()->user()->id;

            if ($folderId == 0) {
                $folder_root = 0;
                $file_url = '/storage/index/' . $file->getClientOriginalName();

            } else {
                $folder_root = $folderId; //$current_folder['folder_root'];
                $file_url = $current_folder['url'] . '/' . $file->getClientOriginalName();
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
                $file_path = substr($current_folder['url'], 15) . '/' . $file->getClientOriginalName();
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
     * Bookmark file/folder on main grid
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookmarkFile($id) {
        $bookmark = Bookmark::with('files')
            ->where('file', $id)
            ->where('created_by', auth()->id())
            ->first();

        if ($bookmark !== null && $bookmark->count() > 0) {
            return response()->json([
                "success" => false,
                "message" => "Already Bookmarked",
                "data" => $bookmark->files
            ],500);
        } else {
            $new_bookmark = Bookmark::create([
                'file' => $id,
                'user' => auth()->id(),
                'created_by' => auth()->id()
            ]);

            if ($new_bookmark)
                $files = Files::find($new_bookmark->file);

            return response()->json([
                "success" => true,
                "message" => "Success Bookmarked!",
                "data" => $files
            ]);
        }
    }

    /**
     * Get Files by ID;
     *
     * @param $id
     * @return mixed
     */
    public function getFilesById($id)
    {
        $files = Files::findOrFail($id);
        return $files;
    }

    /**
     * Update record in table Files
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFilesById(Request $request, $id) {
        $type = $request->get('fieldName');
        $files = Files::findOrFail($id);

        if($type === 'comment')
            $files->comment = $request->get('filecomment');
        else
            $files->description = $request->get('filecomment');

        $files->save();

        return response()->json([
            "data" => $files,
            "tipe" => $type,
            "message" => ($type === 'comment' ? 'Comment' : 'Description') . ' Added/Updated Successfully'
        ]);
    }

}
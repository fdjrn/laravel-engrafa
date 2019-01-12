<?php

namespace App\Http\Controllers\Index;

use App\Events\NewBookmarks;
use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Files;
use App\Traits\FilesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $folderIdReq = $request->get('folder_id') ?? 0;
        return view('index.index')
            ->with('folderID', $folderIdReq)
            ->with('currentUser', Auth::user());
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
            ->addColumn('action', function ($file) {

                $newCol =
                    '<a onclick="bookmarkFile('. $file->id .')" class="btn btn-xs btn-outline-light"><i class="fa fa-bookmark fa-2x"></i></a>'.
                    '<div class="btn-group"><a class="btn btn-xs btn-outline-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                    '<span><i class="fa fa-align-justify fa-2x"></i></span><span class="caret"></span></a><ul class="dropdown-menu">';

                if ($file->is_file === 1 ) {
                    if(auth()->user()->role <= '4') {
                        $list = '<li><a href="/index/detail/'. $file->id .'">View</a></li>'.
                            '<li><a href="/index/download-file/'.$file->id.'">Download</a></li>'.
                            '<li><a onclick="uploadNewVersion('. $file->id .')" >Upload New Version</a></li>'.
                            '<li><a onclick="seeFileHistory('. $file->id .')" >See File Version</a></li>';
                    } else {
                        $list = '<li><a href="/index/detail/'. $file->id .'">View</a></li>'.
                            '<li><a href="/index/download-file/'.$file->id.'">Download</a></li>'.
                            '<li><a onclick="seeFileHistory('. $file->id .')" >See File Version</a></li>';
                    }
                } else {
                    $list = '<li><a href="#">View</a></li><li><a href="#">Download</a></li><li><a href="#">Upload New Version</a></li>'.
                    '<li><a href="#">See File Version</a></li>';
                }

                $newCol =  $newCol . $list .'</ul></div>';
                return $newCol;
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
            ->addColumn('action', function ($file) {

                $newCol =
                    '<a onclick="bookmarkFile('. $file->id .')" class="btn btn-xs btn-outline-light"><i class="fa fa-bookmark fa-2x"></i></a>'.
                    '<div class="btn-group"><a class="btn btn-xs btn-outline-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                    '<span><i class="fa fa-align-justify fa-2x"></i></span><span class="caret"></span></a><ul class="dropdown-menu">';

                if ($file->is_file === 1 ) {
                    if(auth()->user()->role <= '4') {
                        $list = '<li><a href="/index/detail/'. $file->id .'">View</a></li>'.
                            '<li><a href="/index/download-file/'.$file->id.'">Download</a></li>'.
                            '<li><a onclick="uploadNewVersion('. $file->id .')" >Upload New Version</a></li>'.
                            '<li><a onclick="seeFileHistory('. $file->id .')" >See File Version</a></li>';
                    } else {
                        $list = '<li><a href="/index/detail/'. $file->id .'">View</a></li>'.
                            '<li><a href="/index/download-file/'.$file->id.'">Download</a></li>'.
                            '<li><a onclick="seeFileHistory('. $file->id .')" >See File Version</a></li>';
                    }
                } else {
                    $list = '<li><a href="#">View</a></li><li><a href="#">Download</a></li><li><a href="#">Upload New Version</a></li>'.
                        '<li><a href="#">See File Version</a></li>';
                }

                $newCol =  $newCol . $list .'</ul></div>';
                return $newCol;
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
                //$folder_path = '/storage/index/' . $folder_name;
                $folder_path = $folder_name;
                Storage::makeDirectory($folder_name);
            } else {
                $folder_path = $root['url'] . '/' . $folder_name;
                Storage::makeDirectory($folder_path);
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
        $folderRoot = $request->get('folderId');
        $folderRoot = ($folderRoot === '' ? 0 : $folderRoot);
        $files = $request->file('file');

        $current_folder = Files::find($folderRoot);

        foreach ($files as $file) {
            $fileMimeType = $file->getClientMimeType();
            $fileName = str_replace(' ','_',$file->getClientOriginalName());
            $fileSize = $file->getClientSize();
            $fileCreatedBy = Auth()->user()->id;

            if ($folderRoot == 0) {
                $file_url = $fileName;

            } else {
                $file_url = $current_folder['url'] . '/' . $fileName;
            }

            $new_file = Files::create([
                'file_root' => 0,
                'folder_root' => $folderRoot,
                'name' => $fileName,
                'url' => $file_url,
                'is_file' => 1,
                'size' => $fileSize,
                'mime_type' => $fileMimeType,
                'version' => 1,
                'created_by' => $fileCreatedBy
            ]);


            if ($new_file) {
                $file_path = $new_file->url;
                Storage::disk('public')->put($file_path, file_get_contents($file));
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => 'Failed to create File',
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

            if ($new_bookmark) {
                $files = Files::find($new_bookmark->file);
                broadcast(new NewBookmarks($new_bookmark, $files, Auth::user()));
            }

            return response()->json([
                "success" => true,
                "message" => "Success Bookmarked!",
                "data" => $files
            ]);
        }
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

    /**
     * Delete files by id
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFilesById($id) {
        $files = Files::find($id);

        if ($files->is_file == 1) {
            $files->delete();
            Storage::disk('public')->delete($files->url);
        } else {
            $this->deleteFilesRecursive($files->id);
            Storage::disk('public')->deleteDirectory($files->url);
        }

        return response()->json(['success' => true, 'message' => 'File/Folder Successfully Deleted!']);
    }

    /**
     * Upload new version of file based on selected files
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadNewVersion(Request $request)
    {
        $reqFileId = $request->get('fileroot');
        $reqFolderRootId = $request->get('folderId');
        $files = $request->file('new-file-version');

        // find current files
        $currentFile = Files::findOrFail($reqFileId);

        // count file_root child then adjust it;
        if ($currentFile['file_root'] == 0) {
            $fileVersion = Files::where('file_root', $currentFile['id'])->count() + 2;
        } else {
            $fileVersion = Files::where('file_root', $currentFile['file_root'])->count() + 2;
        }

        $fileRoot = ($currentFile['file_root'] == 0) ? $currentFile['id'] : $currentFile['file_root'];

        foreach ($files as $file) {
            $fileMimeType = $file->getClientMimeType();
            $fileName = str_replace(' ','_',$file->getClientOriginalName());
            $fileSize = $file->getClientSize();
            $fileCreatedBy = Auth()->user()->id;

            if ($reqFolderRootId == 0) {
                $fileUrl = $fileName;
            } else {
                $lenUrl = strlen($currentFile['name']);
                $fileUrl = substr($currentFile['url'], 0, -($lenUrl)) . $fileName;
            }

            $new_file = Files::create([
                'file_root' => $fileRoot,
                'folder_root' => $currentFile['folder_root'],
                'name' => $fileName,
                'url' => $fileUrl,
                'is_file' => 1,
                'size' => $fileSize,
                'version' =>$fileVersion,
                'mime_type' => $fileMimeType,
                'created_by' => $fileCreatedBy
            ]);

            if ($new_file) {
                $file_path = $new_file->url;
                Storage::disk('public')->put($file_path, file_get_contents($file));
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => 'Failed to create File',
                ], 404);
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Show list history files
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function showFileHistory($id)
    {
        $data = $this->getFileHistory($id);
        return DataTables::of($data)
            ->addColumn('action', function ($dt) {
                /*return '<a href="/index/download-file/'.$dt->id.' class="btn btn-xs btn-outline-light"><i class="fa fa-download"></i></a>';*/
                return '<a href="/index/download-file/'.$dt->id.'" class="btn btn-xs btn-outline-light"><i class="fa fa-download"></i></a></a>';
            })
            ->make(true);
    }
}
<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Files;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/**
 * Class HomepageController
 *
 * @author fadjrin
 * @since 2018-12-04
 * @package App\Http\Controllers\Homepage
 */
class HomepageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $latestFile = DB::table('files')
            ->selectRaw("
                id, folder_root, file_root, name, url, is_file, version, `size`, description, 
                SUBSTRING_INDEX(name, '.', -1 ) AS file_ext, comment, 
                created_by, created_at, updated_at
            ")
            ->where('is_file', 1)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $latestFolder = Files::where('is_file', 0)->orderBy('updated_at', 'DESC')->first();

        $lastSurveys = Survey::orderBy('updated_at', 'DESC')->first();

        return view('homepage.homepage')
            /*->with('latestFile-ext', $latestFile)*/
            ->with('latestFile', $latestFile)
            ->with('latestSurvey', $lastSurveys)
            ->with('latestFolder', $latestFolder);

    }

    public function listAll()
    {
        $lists = DB::table('files')
            ->join('users', 'users.id', '=', 'files.created_by')
            ->selectRaw("files.id, folder_root, file_root, files.name, url, is_file, 
                        version,  CONCAT(round(size/1024,2), ' Kb') AS size, 
                        files.description, files.comment, files.created_by, files.created_at, 
                        files.updated_at, users.name AS owner")
            ->get();

        return DataTables::of($lists)
            ->make(true);
    }

    public function createNewFolder(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['folderName' => 'required|max:255'],
            ['New Folder Name cannot be empty!']
        );

        $folder_name = $request->input('folderName');
        if ($validator->passes()) {

            $folder_path = $folder_name;
            Storage::makeDirectory($folder_name);

            $folder = new Files();
            $folder->folder_root = 0;
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

        return response()->json(['errors' => $validator->errors(), 'inputs' => $folder_name, 'root folder id' => 0]);
    }

    public function uploadFiles(Request $request)
    {
        $files = $request->file('file');

        foreach ($files as $file){
            $fileMimeType = $file->getClientMimeType();
            $fileName = str_replace(' ','_',$file->getClientOriginalName());
            $fileSize = $file->getClientSize();
            $fileCreatedBy = Auth()->user()->id;
            $file_url = $fileName;

            $new_file = Files::create([
                'folder_root' => 0,
                'name' => $fileName,
                'url' => $file_url,
                'is_file' => 1,
                'size' => $fileSize,
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
            'success' => true,
            'result' => $new_file
        ]);
    }
}

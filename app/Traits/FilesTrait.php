<?php
/**
 * Created by PhpStorm.
 * User: fadjrin
 * Date: 07/12/18
 * Time: 05:56
 */

namespace App\Traits;

use App\Models\Files;
use Illuminate\Support\Facades\DB;

trait FilesTrait
{
    /**
     * Get list all files and folder by folder root
     *
     * @param $id
     * @return mixed
     */
    public function getListByFolderRootId($id)
    {
        return Files::join('users', 'users.id', '=', 'files.created_by')
            ->selectRaw("files.id, folder_root, file_root, files.name, url, is_file, 
                        version, size, description, comment, created_by, files.created_at, 
                        files.updated_at, users.name AS owner")
            ->where('folder_root', $id)
            ->orderBy('is_file')
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    /**
     * Get list all files and folder by id
     *
     * @param $id
     * @return mixed
     */
    public function getListByFolderId($id)
    {
        return Files::join('users', 'users.id', '=', 'files.created_by')
            ->selectRaw("files.id, folder_root, file_root, files.name, url, is_file, 
                        version, size, description, comment, created_by, files.created_at, 
                        files.updated_at, users.name AS owner")
            ->whereRaw('folder_root = (SELECT folder_root FROM files WHERE id = ' . $id . ')')
            ->orderBy('is_file')
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    /**
     * Get list folder by folder root
     *
     * @param $id
     * @return mixed
     */
    public function getListFolderByRootId($id)
    {
        $folder =  Files::where('files.folder_root', $id)
            ->where('files.is_file', '=', 0)
            ->select('files.id', 'files.name', 'files.folder_root')
            ->orderBy('name', 'ASC')
            ->get();

        // count child folder
        $folderCount = Files::select(DB::raw("folder_root, count(folder_root) AS folder_count"))
            ->where('is_file','=',0)
            ->where('folder_root','>',0)
            ->groupBy('folder_root')
            ->get();

        // add child folder count to each folders
        $folder = $folder->map(function ($folder) use ($folderCount, $id){
            $fcount = $folderCount->where('folder_root',$folder->id)->first();

            $folder->child_count = $fcount ? $fcount->folder_count : 0;

            return $folder;
        });

        return $folder;

    }

    /**
     * get list folder by id
     * @param $id
     * @return mixed
     */
    public function getListFolderById($id)
    {
        $folder =  Files::where('files.is_file', '=', 0)
            ->whereRaw('folder_root = (SELECT folder_root FROM files WHERE id = ' . $id . ')')
            ->orderBy('name', 'ASC')
            ->get();

        // count child folder
        $folderCount = Files::select(DB::raw("folder_root, count(folder_root) AS folder_count"))
            ->where('is_file','=',0)
            ->where('folder_root','>',0)
            ->groupBy('folder_root')
            ->get();

        // add child folder count to each folders
        $folder = $folder->map(function ($folder) use ($folderCount, $id){
            $fcount = $folderCount->where('folder_root',$folder->id)->first();

            $folder->child_count = $fcount ? $fcount->folder_count : 0;

            return $folder;
        });

        return $folder;
    }

    /**
     * Get folder name
     *
     * @param $id
     * @return mixed
     */
    public function getFolderNameById($id)
    {
        $folderName = 'Index';

        if ($id > 0) {
            $folderName = Files::where('id', $id)
                ->where('is_file', 0)
                ->value('name');
        }

        return $folderName;
    }

    /**
     * Delete record on files table recuresively
     *
     * @param $id
     */
    public function deleteFilesRecursive($id)
    {
        $files = Files::where('folder_root', $id)->get();
        foreach ($files as $file) {
            $this->deleteFilesRecursive($file->id);
        }

        Files::find($id)->delete();
    }

    /**
     * Get list file history
     *
     * @param $id
     * @return array
     */
    public function getFileHistory($id)
    {
        $files = Files::findOrFail($id);

        $fileHistory = DB::select(
        "SELECT * FROM files WHERE id = ? UNION SELECT * FROM files WHERE file_root = ?", array($files['id'], $files['id'])
        );

        return $fileHistory;
    }
}
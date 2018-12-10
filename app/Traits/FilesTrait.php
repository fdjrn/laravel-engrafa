<?php
/**
 * Created by PhpStorm.
 * User: fadjrin
 * Date: 07/12/18
 * Time: 05:56
 */

namespace App\Traits;

use App\Models\Files;

trait FilesTrait
{
    /**
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

    public function getListFolderByRootId($id)
    {
        return Files::where('files.folder_root', $id)
            ->where('files.is_file', '=', 0)
            ->select('files.id', 'files.name', 'files.folder_root')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getListFolderById($id)
    {
        return Files::where('files.is_file', '=', 0)
            ->whereRaw('folder_root = (SELECT folder_root FROM files WHERE id = ' . $id . ')')
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
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
}
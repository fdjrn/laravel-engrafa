<?php

namespace App\Http\Controllers\Bookmark;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    public function getBookmarks($id)
    {
        //$bookmark = Bookmark::with('files')->where('user', auth()->id())->get();

        $bookmark = collect(
            DB::select(
                " SELECT bookmarks.id, bookmarks.file, bookmarks.created_at, files.name, files.is_file, " .
                " COALESCE(files.description,'') AS descr " .
                " FROM bookmarks INNER JOIN files " .
                " WHERE bookmarks.file  = files.id" .
                " AND bookmarks.user = ? ", array($id))
        );

        /*$bookmark = $bookmark->map(function($bookmark) {
            $dt = Carbon::createFromTimeString($bookmark->created_at);

           $bookmark->added = $dt->diffForHumans();
        });*/

        $result = $bookmark->map(function ($data) {
            $data->created_at = Carbon::createFromTimeString($data->created_at)->diffForHumans();
            return $data;
        });

        return response()->json($result);
    }

    public function showBookmarkedFiles($id)
    {
        $files = Files::find($id);

        if ($files['is_file'] == 0) {
            // if is a folder
            return redirect('index');

        } else {
            // if is a file
            return redirect('index/detail/' . $id);
        }
    }
}

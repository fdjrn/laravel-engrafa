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

        $bookmark =
            DB::select(
                " SELECT bookmarks.id, bookmarks.file, bookmarks.created_at, files.name, files.is_file, " .
                " COALESCE(files.description,'') AS descr " .
                " FROM bookmarks INNER JOIN files " .
                " WHERE bookmarks.file  = files.id" .
                " AND bookmarks.user = ? ", array($id));

        return response()->json($bookmark);
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

    public function searchBookmark($searchText) {

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use App\Comments;
use Auth;
use Illuminate\Http\Request;


class CommentsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function saveComment(Request $request) {
       //  d($_POST,1);
        $user_id = Auth::user()->id;
        $comments = new Comments();
        $comments->user_id = $user_id;
        $comments->comment = $request->comment;
        $comments->video_id = $request->video_id;
        $comments->save();
        
        Session::flash('success', 'Successfully Submitted!');
        
        return back();
    }

}

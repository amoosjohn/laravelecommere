<?php

namespace App\Http\Controllers;

use Session;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect;
use App\BlogCategories;
use App\BlogPosts;
use Illuminate\Http\Request;

class BlogController extends Controller {

    private $sessionId;

    public function __construct() {
        session_start();
        $this->sessionId = session_id();
    }

    public function index($q = "") {
        $querystringArray = array();
        $posts = BlogPosts::where("status", "=", 1);
        if (is_numeric($q)) {
            $posts = $posts->where("category_id", "=", $q);
        } elseif (isset($_GET['q'])) {
            $q = $_GET['q'];
            $posts = $posts->where("name", "like", "%$q%");
            $querystringArray = ['q' => $q];
        }
        $posts = $posts->paginate(9);
        $link = str_replace("blog/?", "blog?", $posts->appends($querystringArray)->render());
        return view('front.blog.index', compact('posts', 'q', 'link'));
    }

    public function post($id) {
        $post = BlogPosts::find($id);
        $similarPosts=BlogPosts::where("category_id",'=',$id)->limit(3)->get();
        return view('front.blog.post', compact('post','similarPosts'));
    }
}

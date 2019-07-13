<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Contactus;
use App\NewsLetter;
use App\Http\Requests;
use Session;

class ContactusController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $contactus = Contactus::orderBy('id', 'desc')->paginate(10);
        return view('admin.contactus', compact('contactus'));
    }

    public function detail($id) {

        $contactus = Contactus::where('id', '=', $id)->first();
        return view('admin.contactusdetail', compact('contactus'));
    }
    
   public function all_newsletter()
    {
         $news = NewsLetter::orderBy('id', 'desc')->paginate(10);
        return view('admin.news_letter', compact('news'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect;
use App\Contactus;
use App\NewsLetter;
use App\Functions\Functions;
use Session;
use Illuminate\Http\Request;

class ContactusController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // use CaptchaTrait;

    public function __construct() {
        
    }

    // Contact-us
    public function index() {
        return view('front.contact-us');
    }

    public function store(Request $request) {
        // d($_POST, 1);
        $validation = array(
            'name' => 'required|max:30',
            'email' => 'required|email|max:30',
            'message' => 'required|min:6|max:200',
//            'g-recaptcha-response'  => 'required',
//            'captcha'               => 'required|min:1'
        );
//		 $messages = [
//		 'g-recaptcha-response.required' => 'Captcha is required',
//         'captcha.min'           => 'Wrong captcha, please try again.'
//      ];
        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $contactus = new Contactus;
        $contactus->name = $request->name;
        $contactus->email = $request->email;
        $contactus->message = $request->message;
        $contactus->save();
        
//         $subject = view('emails.confirm_email.subject');
//         $body = view('emails.confirm_email.body', compact('confirmation_code'));
//         Functions::sendEmail($request->email, $subject, $body);

        $request->session()->flash('success', 'Successfully Submitted, Thanks for contacting us!');
        return redirect('home');
    }
    
    public function newsletter(Request $request)
    {
        $validation = array(
            'email' => 'required|email|max:50|unique:news',
        );
        $response['error'] = 0;
        $validator = Validator::make($request->all(), $validation);
         
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
        } else {
            $news = new NewsLetter;
            $news->email = $request->email;
            $news->save();
        }
        if ($response['error'] == 1) {
            foreach ($response['errors']->all() as $error) {
                echo '<li>' . $error . '</li>';
            }
        } else {
            echo '1';
        } 
       
    }
    
   

}

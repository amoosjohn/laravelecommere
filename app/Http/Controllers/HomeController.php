<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect,Session,Config;
use Illuminate\Http\Request;
use App\User;
use App\General;
use App\Content;
use App\Complaint;
use Intervention\Image\Facades\Image as Image;
use App\Functions\Functions;
use App\GalleryImage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topBrands = General::getBrands('top');
        $topFashions = General::getBrands('fashion');
        $topElectronics = General::getBrands('electronic');
        $sliderImages = General::getSliderImages();
        $sliderTop = General::getSliderImage(2);
        $sliderBottom = General::getSliderImage(3);
        $brandSide = General::getSliderImage(4);
        $categoryBanner = General::getSliderImage(5);
        $topSection = General::getSection(1);
        if(!is_null($topSection['section'])){
            $top = $topSection['section'];
        }
        $middleSection = General::getSection(2);
        if(!is_null($middleSection['section'])){
            $middle = $middleSection['section'];
        }
        $bottomSection = General::getSection(3);
        if(!is_null($bottomSection['section'])){
            $bottom = $bottomSection['section'];

        }
        return view('front.index',compact('topBrands','topSection','categoryBanner','top','middleSection','middle','bottomSection','bottom','topFashions','topElectronics','sliderImages','sliderTop','sliderBottom','brandSide','topSection'));
    }
	
    public function termsConditions() {
        $content = Content::getPage('terms-condition');
        $title = $content->metaTitle;
        $description = $content->metaDescription;
        $keywords = $content->keywords;
        return view('front.content.terms-and-conditions',compact('content','title','description','keywords'));
    }

    public function refundPolicies() {
        $content = Content::getPage('refund-policies');
        $title = $content->metaTitle;
        $description = $content->metaDescription;
        $keywords = $content->keywords;
        return view('front.content.refund-policies',compact('content','title','description','keywords'));
    }

    public function returnReplacePolicy() {
        $content = Content::getPage('return-policies');
        $title = $content->metaTitle;
        $description = $content->metaDescription;
        $keywords = $content->keywords;
        return view('front.content.return-replacement-policies',compact('content','title','description','keywords'));
    }

    public function vendorAgreement() {
		$content = Content::getPage('vendor-agreement');
        $title = $content->metaTitle;
        $description = $content->metaDescription;
        $keywords = $content->keywords;
        return view('front.content.vendor-agreement',compact('content','title','description','keywords'));
    }
	
    public function complaint() {
        $types = Complaint::$types;
        return view('front.complaint',compact('types'));
    }
    public function complaintStore(Request $request) {
        $validation = array(
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'contact' => 'required|max:50',
            'type' => 'required|max:50',
            'address' => 'required|max:255',
            'complainDetail' => 'required|max:1000',
        );
        $validator = Validator::make($request->all(), $validation);
        $response['error'] = 0;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
        }
        if ($response['error'] == 0) {
            $input = $request->all();
            unset($input['_token']);
            unset($input['complainDetail']);
            $input['details'] = $request->complainDetail;
            $input['status'] = 0;
            $input['created_at'] = date('Y-m-d H:i:s');
            Complaint::insert($input);
            Session::flash('success', 'Thank you, your complaint has been submitted.');
            return redirect()->back();
        } else {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
    }
	
	public function complain() {
       
        return view('front.complain');
    }
	
	public function thankyou_order() {
       
        return view('front.thankyou_order');
    }
	
    public function review() {
        return view('front.review');
    }
    public function show($page) {
        $breadcrumb = array();        
        $content = Content::where('code','=',$page)->where('type','=','page')->first();
        if (isset($content) && !empty($content) && count($content)>0) {
            $pageTitle = $content->title;
            $content->body = Functions::setTemplate($content->body, array());
            return view('front.page', compact('content','pageTitle'));

        } else {
            return redirect('/');
        }
    }
    public function importImages(Request $request) {
       //Note 100 Images be will downloaded from url request 
       $limit = 100; 
       $images = GalleryImage::getImages(0,0,$limit);
       $imageMimes = Config::get('params.imageMimes');
       $extension = 'png';
        if(count($images)>0) {
        foreach($images as $image) {
            $url = $image->url;
            $path = $image->path;
            if($url!='' && $path!='' && @getimagesize($url) ) {
             $move = Image::make($url)->mime();
             if(in_array($move,$imageMimes)) {  
                 $fileName = rand(111, 999) . time() . '.' . $extension; 
                 $destinationPath = public_path() . '/' . $path;
                 $destinationPathLarge = $destinationPath . '/large/';
                 $destinationPathThumb = $destinationPath . '/thumbnail/';
                 $destinationPathMedium = $destinationPath . '/medium/';
                 Image::make($url)->encode($extension)->save($destinationPathLarge . $fileName); 
                 Image::make($destinationPathLarge . $fileName)->resize('500','500')->save($destinationPathLarge . $fileName);
                 Image::make($destinationPathLarge . $fileName)->resize('200','200')->save($destinationPathThumb . $fileName);
                 Image::make($destinationPathLarge . $fileName)->resize('400','400')->save($destinationPathMedium . $fileName);

                 $path = $path. 'large/';
                 $input['download'] = 1;
                 $input['url'] = $path.$fileName;
                 $input['image_name'] = $fileName;
                 GalleryImage::where('id','=',$image->id)->update($input);
             }
            }
            else {
                GalleryImage::where('id','=',$image->id)->delete();
            }
         }
         echo 'All Images Downloaded Successfully!';
       }
       else {
           echo 'No image found to be download!!';
       }
       
    }
    

}

<?php

namespace App\Functions;

use Mail;
use Storage;

class Functions {

    public static function prettyJson($inputArray, $statusCode) {
        return response()->json($inputArray, $statusCode, array('Content-Type' => 'application/json'), JSON_PRETTY_PRINT);
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public static function saveImage($file, $destinationPath, $destinationPathThumb = '') {
        $extension = $file->getClientOriginalExtension();
        $fileName = rand(111, 999) . time() . '.' . $extension;
        $image = $destinationPath . '/' . $fileName;
        //$upload_success = Storage::copy($file,$image);
        $file->move($destinationPath, $fileName);
        return $fileName;
    }

    public static function stringTrim($string = '', $needle = 0, $start = 0, $end = 0) {
        return (strlen($string) > $needle) ? substr($string, $start, $end) . '...' : $string;
    }

    public static function makeOrderEmailTemplate($orders, $addresses) {
        $template = "";
        return view('email.order', compact('orders', 'addresses'));
    }

    public static function generateRandomString($length = 10,$number=0) {
        //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($number!=0)
        {
            $characters = '0123456789';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function setEmailTemplate($contentModel, $replaces) {
        $data['body'] = $contentModel[0]->body;
        $data['subject'] = $contentModel[0]->subject;
        $data['title'] = $contentModel[0]->title;
        foreach ($replaces as $key => $replace) {
            $data['body'] = str_replace("%%" . $key . "%%", $replace, $data['body']);
        }
        return $data;
    }

    public static function sendEmail($email, $subject, $body, $header = '', $from = "", $cc = "", $bcc = "") {
      
            $data['to'] = $email;
            $data['body'] = $body;
            $data['subject'] = $subject;
            return Mail::send('emails.template', $data, function($message) use ($data) {
                    $message->SMTPOptions = array('ssl' => array('verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                        $message->from('noreply@vitalmart.pk', 'Vital Mart');
                        $message->to($data['to'])->subject($data['subject']);
                    });
       
    }

    public static function makeCurlRequest($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
                )
        );
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

    public static function setTemplate($body, $replaces) {

        $replaces["asset('')"] = asset("");
        $replaces["url('')"] = url("");

        foreach ($replaces as $key => $replace) {
            // $key=str_replace(" ", "", $key);
            $body = str_replace("{{" . $key . "}}", $replace, $body);
        }
        return $body;
    }

    public static function getChildCategories($allCategories) {
        $categories = array();

        foreach ($allCategories as $category) {
            if ($category->parent_id == 0) {
                $categories[$category->id]['id'] = $category->id;
                $categories[$category->id]['name'] = $category->name;
                $categories[$category->id]['parent_id'] = $category->parent_id;
                $categories[$category->id]['class'] = $category->class;
            } else {
                $categories[$category->parent_id]['categories'][$category->id] = array('name' => $category->name, 'class' => $category->class, 'id' => $category->id, 'parent_id' => $category->parent_id);
            }
        }
        return $categories;
    }

    public static function getCategories($allCategories) {
        $categories = array();

        foreach ($allCategories as $category) {
            
            if ($category->level == 1) {
               $categories[$category->id]['name'] = $category->name;
               $categories[$category->id]['commission'] = $category->commission;
               $parent_id = $category->id;

            }
            if ($category->level == 2) {
                $categories[$category->parent_id]['categories'][$category->id]= $category->name;
                $categories[$category->parent_id]['categories_commission'][$category->id] = $category->commission;
                
            }
            if ($category->level == 3) {
                $categories[$parent_id][$category->parent_id]['subcategories'][$category->id] = $category->name;
                $categories[$parent_id][$category->parent_id]['subcategories_commission'][$category->id] = $category->commission;
            }
        }
        return $categories;
    }

    public static function moneyFormat($price)
    {
        $price=number_format($price,0);
        return $price;
    }
    public static function getArray($search)
    {
        $getResults = implode(",", $search);
        $getResult = explode(",", $getResults);
        $result = array_map('intval', $getResult); 
        
        return $result;
    }
    public static function dateFormat($date) {

        $date = date('d/m/Y', strtotime($date));
        return $date;
    }
    public static function orderDateFormat($date) {

        $date = date('F d, Y h:i:s a', strtotime($date));
        return $date;
    }
    public static function calculateCommission($commission,$price) {

        $per = $commission / 100;
        $comm = $price * $per;
        return Functions::moneyFormat($comm);
    }
    public static function addBrTag($string)
    {
       $result = preg_replace("/\r\n|\r|\n/", ' ', $string);
       return $result;
    }
    public static function frontDate($date) {

        $date = date('F d, Y', strtotime($date));
        return $date;
    }
    public static function ratingStars($rating) {
        $result = '';
        for ($i = 1; $i <= 5; $i++) {
            $star = '-o';
            if($rating >= $i)
            { 
               $star = '';
            }        
            $result .= '<i class="fa fa-star'.$star.'"></i>';
        }
        return $result;
       
    }
    public static function avg($sum,$count) {
        $result = round($sum/5,0);
        return $result;    
    }

}

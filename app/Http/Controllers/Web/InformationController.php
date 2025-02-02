<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ophim\Core\Models\Contact;

class InformationController extends Controller
{
    protected function getSeoData()
    {
        $settings = $this->getSeoSettings();
        $seoData['title'] = $settings->get('site_meta_siteName')->value;
        $seoData['icon'] = asset($settings->get('site_meta_shortcut_icon')->value);
        $seoData['description_meta'] = $settings->get('site_meta_description')->value;
        $seoData['keywords_meta'] = $settings->get('site_meta_keywords')->value;
        $seoData['image_meta'] = $settings->get('site_meta_image')->value;
        $seoData['head_tags_meta'] = $settings->get('site_meta_head_tags')->value;
        $seoData['site_script'] = $settings->get('site_scripts_google_analytics')->value;

        return $seoData;
    }

    public function dmca(){
        $data = [
            'seoData' => $this->getSeoData()
        ];
        return view('frontend-web.information.dmca', $data);
    }

    public function aboutUs(){
        $data = [
            'seoData' => $this->getSeoData()
        ];
        return view('frontend-web.information.about-us', $data);
    }

    public function contact(){
        $data = [
            'seoData' => $this->getSeoData()
        ];
        return view('frontend-web.information.contact', $data);
    }

    public function privacy(){
        $data = [
            'seoData' => $this->getSeoData()
        ];
        return view('frontend-web.information.privacy', $data);
    }


}

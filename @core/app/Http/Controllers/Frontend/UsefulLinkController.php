<?php

namespace App\Http\Controllers\Frontend;

use App\UsefulLink;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;

class UsefulLinkController extends Controller
{
    public function page()
    {
        $lang  = LanguageHelper::user_lang_slug();
        $links = UsefulLink::where(['status' => 'publish', 'lang' => $lang])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('frontend.pages.useful-links.index')->with([
            'links' => $links,
        ]);
    }
}

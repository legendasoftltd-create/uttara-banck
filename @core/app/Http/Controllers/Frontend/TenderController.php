<?php

namespace App\Http\Controllers\Frontend;

use App\Tender;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    const BASE_PATH = 'frontend.pages.tender.';

    public function page(Request $request)
    {
        $lang = LanguageHelper::user_lang_slug();
        $year = $request->get('year');

        $all_years = Tender::where(['status' => 'publish', 'lang' => $lang])
            ->selectRaw('YEAR(notice_date) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $tab_years = array_slice($all_years, 0, 3);

        $query = Tender::where(['status' => 'publish', 'lang' => $lang])
            ->orderBy('notice_date', 'desc');

        if ($year && $year !== 'archive') {
            $query->whereYear('notice_date', $year);
        } elseif ($year === 'archive') {
            if (!empty($tab_years)) {
                $query->whereRaw('YEAR(notice_date) NOT IN (' . implode(',', array_map('intval', $tab_years)) . ')');
            }
        } else {
            if (!empty($tab_years)) {
                $query->whereYear('notice_date', $tab_years[0]);
            }
        }

        $all_tenders = $query->get();
        $active_year = $year ?: ($tab_years[0] ?? date('Y'));

        return view(self::BASE_PATH . 'index')->with([
            'all_tenders'  => $all_tenders,
            'tab_years'    => $tab_years,
            'active_year'  => $active_year,
            'selected_year'=> $year,
        ]);
    }

    public function single($slug)
    {
        $lang   = LanguageHelper::user_lang_slug();
        $tender = Tender::where(['slug' => $slug, 'status' => 'publish', 'lang' => $lang])->firstOrFail();

        return view(self::BASE_PATH . 'single')->with([
            'tender' => $tender,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Auction;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    const BASE_PATH = 'frontend.pages.auction.';

    public function page(Request $request)
    {
        $lang = LanguageHelper::user_lang_slug();
        $year = $request->get('year');

        $query = Auction::where(['status' => 'publish', 'lang' => $lang])
            ->orderBy('notice_date', 'desc');

        $available_years = Auction::where(['status' => 'publish', 'lang' => $lang])
            ->selectRaw('YEAR(notice_date) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $tab_years = array_slice($available_years, 0, 3);

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

        $all_auctions = $query->get();
        $active_year  = $year ?: ($tab_years[0] ?? date('Y'));

        return view(self::BASE_PATH . 'index')->with([
            'all_auctions'  => $all_auctions,
            'tab_years'     => $tab_years,
            'active_year'   => $active_year,
            'selected_year' => $year,
        ]);
    }

    public function single($slug)
    {
        $lang    = LanguageHelper::user_lang_slug();
        $auction = Auction::where(['slug' => $slug, 'status' => 'publish', 'lang' => $lang])->firstOrFail();

        return view(self::BASE_PATH . 'single')->with([
            'auction' => $auction,
        ]);
    }
}

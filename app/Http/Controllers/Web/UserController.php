<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ophim\Core\Models\Manga;

class UserController extends Controller
{
    public function bookmarkIndex(Request $request)
    {
        $homeController = new HomeController();
        $mostViewedMangas = $homeController->getMostViewedMangas('month');

        $data = [
            'seoData' => $this->getSeoData(),
            'mostViewedMangas' => $mostViewedMangas
        ];
        return view('frontend-web.user.bookmark', $data);
    }

    public function getBookmark(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $bookmarkIds = $request->input('bookmarkIds', []);

            $itemsPerPage = 10;
            $mangas = Manga::whereIn('id', $bookmarkIds)
                ->withSum('views', 'views')
                ->with([
                    'chapters' => function ($query) {
                        return $query
                            ->orderBy('chapter_number', 'desc')
                            ->select('manga_id', 'chapter_number', 'created_at')
                            ->limit(3);
                    }
                ])
                ->paginate($itemsPerPage);

            // Render từng item bằng partial
            $followedListHtml = '';
            foreach ($mangas as $manga) {
                $followedListHtml .= view('frontend-web.partials.manga-list.item', [
                    'manga' => $manga,
                    'isBookmarkPage' => true, // Xác định đây là trang Bookmark
                ])->render();
            }

            // // Render pagination từ partial
            // $pagerHtml = view('frontend-web.partials.manga-list.pagination', compact('mangas'))->render();

            return response()->json([
                'success' => true,
                'followedListHtml' => $followedListHtml,
                // 'pagerHtml' => $pagerHtml,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
            ]);
        }
    }


    public function historyIndex(Request $request)
    {
        $homeController = new HomeController();
        $mostViewedMangas = $homeController->getMostViewedMangas('month');

        $data = [
            'seoData' => $this->getSeoData(),
            'mostViewedMangas' => $mostViewedMangas
        ];
        return view('frontend-web.user.history', $data);
    }

    public function getHistory(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $loadType = $request->input('loadType', 0);
            $historyIds = $request->input('historyIds', []);

            $mangas = Manga::whereIn('id', $historyIds)
                ->withSum('views', 'views')
                ->with([
                    'chapters' => function ($query) {
                        return $query
                            ->orderBy('chapter_number', 'desc')
                            ->select('manga_id', 'chapter_number', 'created_at')
                            ->limit(1);
                    }
                ])
                ->get();

            $followedListHtml = '';
            foreach ($mangas as $manga) {
                $followedListHtml .= view('frontend-web.partials.manga-list.item', [
                    'manga' => $manga,
                    'isHistoryPage' => true,
                ])->render();
            }

            $pagerHtml = '';

            // Trả về kết quả JSON
            return response()->json([
                'success' => true,
                'followedListHtml' => $followedListHtml,
                'pagerHtml' => $pagerHtml,
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    protected function getSeoData()
    {
        $settings = $this->getSeoSettings();
        $seoData['title'] = $settings->get('site_meta_siteName')->value;
        $seoData['description'] = $settings->get('site_meta_description')->value;
        $seoData['keywords'] = $settings->get('site_meta_keywords')->value;
        $seoData['image'] = $settings->get('site_meta_image')->value;
        $seoData['head_tags'] = $settings->get('site_meta_head_tags')->value;
        $seoData['site_script'] = $settings->get('site_scripts_google_analytics')->value;

        return $seoData;
    }
}

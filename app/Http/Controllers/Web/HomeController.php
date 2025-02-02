<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Ophim\Core\Models\Manga;

class HomeController extends Controller
{

    public function index()
    {
        // Lấy dữ liệu SEO
        $seoData = $this->getSeoData();

        // Lấy manga được đề xuất cho slider hoặc manga mới nhất
        $sliderMangas = Manga::where('is_recommended', true)
            ->orderByDesc('created_at')
            ->select(['title', 'slug', 'cover'])
            ->with([
                'chapters' => function ($query) {
                    $query->orderBy('chapter_number', 'desc')
                        ->select('chapter_number', 'created_at')
                        ->limit(1);
                }
            ])
            ->take(10)
            ->get();

        // Lấy manga được xem nhiều nhất trong tháng
        $startDate = Carbon::now()->startOfMonth();
        $mostViewedMangas = Manga::select(['id', 'title', 'slug', 'cover', 'description'])
            ->whereHas('views', function ($query) use ($startDate) {
                $query->where('updated_at', '>=', $startDate);
            })
            ->with([
                'chapters' => function ($query) {
                    $query->orderBy('chapter_number', 'desc')
                        ->select('manga_id', 'chapter_number', 'created_at')
                        ->limit(1);
                }
            ])
            ->withSum('views', 'views')
            ->orderByDesc('views_sum_views')
            ->take(10)
            ->get();

        // Lấy manga mới cập nhật
        $updatedMangas = Manga::select(['id', 'title', 'slug', 'cover', 'description', 'updated_at'])
            ->orderByDesc('updated_at')
            ->with([
                'chapters' => function ($query) {
                    $query->select('manga_id', 'chapter_number', 'created_at')
                        ->orderBy('chapter_number', 'desc')
                        ->limit(2);
                }
            ])
            ->withSum('views', 'views')
            ->paginate(36);

        // Chuẩn bị dữ liệu truyền vào view
        $data = [
            'seoData' => $seoData,
            'sliderMangas' => $sliderMangas,
            'mostViewedMangas' => $mostViewedMangas,
            'updatedMangas' => $updatedMangas,
        ];

        return view('frontend-web.home.index', $data);
        // return $data;
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

    public function getUpdatedMangas()
    {
        $mangas = Manga::query()
            ->orderByDesc('updated_at')
            ->with([
                'chapters' => function ($query) {
                    return $query
                        ->orderBy('chapter_number', 'desc')
                        ->select('manga_id', 'chapter_number', 'created_at')
                        ->limit(2);
                }
            ])
            ->withSum('views', 'views')
            ->paginate(36);

        return $mangas;
    }

    public function getLatestMangas()
    {
        $mangas = Manga::query()
            ->orderByDesc('id')
            ->select('id', 'title', 'slug', 'cover')
            ->with([
                'chapters' => function ($query) {
                    return $query
                        ->orderBy('chapter_number', 'desc')
                        ->select('manga_id', 'chapter_number', 'created_at')
                        ->limit(1);
                }
            ])
            ->take(10)->get();

        return $mangas;
    }

    protected function getSliderMangas()
    {
        $mangas = Cache::rememberForever('slider_mangas', function () {
            return Manga::where('is_recommended', true)
                ->select(['id', 'title', 'slug', 'cover', 'description'])
                ->with([
                    'taxanomies' => function ($query) {
                        return $query->whereIn('type', ['genre', 'status'])
                            ->select('name', 'slug', 'type');
                    },
                ])
                ->with([
                    'chapters' => function ($query) {
                        return $query
                            ->orderBy('chapter_number', 'desc')
                            ->select('manga_id', 'chapter_number', 'created_at')
                            ->limit(1);
                    }
                ])
                ->take(10)
                ->get();
        });

        if (!count($mangas) > 0) {
            return $this->getLatestMangas();
        }
    }

    public static function getMostViewedMangas($timeType)
    {
        return Cache::remember('popular_mangas_' . $timeType, now()->addHours(1), function () use ($timeType) {
            $now = Carbon::now();
            switch ($timeType) {
                case 'day':
                    $startDate = $now->startOfDay();
                    break;
                case 'week':
                    $startDate = $now->startOfWeek(); // Đầu tuần
                    break;
                case 'month':
                    $startDate = $now->startOfMonth(); // Đầu tháng
                    break;
                default:
                    $startDate = $now->startOfDay();
            }

            $mangas = Manga::select(['id', 'title', 'slug', 'cover', 'description'])
                ->whereHas('views', function ($query) use ($startDate) {
                    $query->where('updated_at', '>=', $startDate);
                })
                ->with([
                    'chapters' => function ($query) {
                        return $query
                            ->orderBy('chapter_number', 'desc')
                            ->select('manga_id', 'chapter_number', 'created_at')
                            ->limit(1);
                    }
                ])
                // ->withCount('chapters')
                ->withSum('views', 'views')
                ->orderByDesc('views_sum_views')
                ->take(10)->get();

            return $mangas;
        });
    }

    public function hotIndex()
    {
        $data = [
            'seoData' => $this->getSeoData(),
            'sliderMangas' => $this->getSliderMangas(),
            'mostViewedMangas' =>   $this->getMostViewedMangas('month'),
            'updatedMangas' => $this->getUpdatedMangas(),
        ];

        return view('frontend-web.home.index', $data);
    }

    protected function getHotMangas()
    {
        $mangas = Manga::query()
            ->with([
                'chapters' => function ($query) {
                    return $query
                        ->orderBy('chapter_number', 'desc')
                        ->select('manga_id', 'chapter_number', 'created_at')
                        ->limit(2);
                }
            ])
            ->withSum('views', 'views')
            ->orderByDesc('views_sum_views')
            ->paginate(36);

        return $mangas;
    }
}

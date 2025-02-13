<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Ophim\Core\Models\Manga;
use Ophim\Core\Models\Taxonomy;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $letter = $request->input('letter');
        $search = $request->input('keyword');
        $type = $request->input('type');
        $genre = $request->input('genre');
        $status = $request->input('status');
        $sort = $request->input('sort');

        $query = Manga::select('id', 'title', 'alternative_titles', 'slug', 'cover', 'description')
            ->with([
                'taxanomies' => function ($query) {
                    $query->select('name', 'slug', 'type');
                },
            ])
            ->with([
                'chapters' => function ($query) {
                    return $query
                        ->orderBy('chapter_number', 'desc')
                        ->select('manga_id', 'chapter_number', 'created_at')
                        ->limit(3);
                }
            ])
            ->withSum('views', 'views');

        $settings = $this->getSeoSettings();
        $seoData['title'] = $settings->get('site_meta_siteName')->value;
        $seoData['icon'] = asset($settings->get('site_meta_shortcut_icon')->value);
        $seoData['description'] = $settings->get('site_meta_description')->value;
        $seoData['keywords'] = $settings->get('site_meta_keywords')->value;
        $seoData['image'] = $settings->get('site_meta_image')->value;
        $seoData['head_tags'] = $settings->get('site_meta_head_tags')->value;
        $seoData['site_script'] = $settings->get('site_scripts_google_analytics')->value;

        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        if ($letter) {
            if ($letter == '0-9') {
                $query->where('title', 'REGEXP', '^[0-9]')->orderBy('title', 'asc');
            } elseif ($letter >= 'a' && $letter <= 'z') {
                $query->where('title', 'LIKE', $letter . '%')->orderBy('title', 'asc');
            }
        }

        if ($type) {
            $query->whereHas('taxanomies', function ($subQuery) use ($type) {
                $subQuery->where('slug', $type);
            });
        }

        //lọc theo thể loại
        if ($genre) {
            $query->whereHas('taxanomies', function ($subQuery) use ($genre) {
                $subQuery->where('slug', $genre);
            });
            $genre = Taxonomy::where('slug', $genre)->first();
            $seoData['title'] = $genre->seo_title ?? $settings->get('site_meta_siteName')->value;
            $seoData['description_meta'] = $genre->seo_des;
            $seoData['keywords_meta'] = $genre->seo_key;
        }

        if ($status) {
            if ($status !== 'completed') {
                $query->whereHas('taxanomies', function ($subQuery) use ($status) {
                    $subQuery->where('slug', $status);
                });
            } else {
                $query->orderBy('updated_at');
            }
        }

        // Sorting
        if ($sort) {
            if ($sort == 'latest_update') {
                $query->orderBy('updated_at', 'desc');
            } else if ($sort == 'newest') {
                $query->orderBy('created_at', 'desc');
            } else if ($sort == 'top') {
                $query->withSum('views', 'views')
                    ->orderByDesc('views_sum_views');
            } else if ($sort == 'top-monthly') {
                $query->withSum('views', 'views')
                    ->orderByDesc('views_sum_views');
            } else if ($sort == 'top-weekly') {
                $query->withSum('views', 'views')
                    ->orderByDesc('views_sum_views');
            } else if ($sort == 'top-daily') {
                $query->withSum('views', 'views')
                    ->orderByDesc('views_sum_views');
            } else if ($sort == 'follow') {
                $query->orderByDesc('created_at');
            } else if ($sort == 'chapter') {
                $query->withSum('chapters', 'chapter_number')
                    ->orderByDesc('chapters_sum_chapter_number');
            }
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        $mangas = $query->paginate(20);

        $data = [
            'seoData' => $seoData,
            'genres' => $this->getGenres(),
            'statuses' => $this->getStatus(),
            'mangas' => $mangas
        ];

        return view('frontend-web.search.index', $data);
    }

    public function getStatus()
    {
        return Cache::remember('statuses', now()->addHours(8), function () {
            return Taxonomy::where("type", 'status')->orderBy('name', 'asc')->get(["name", "slug", "seo_des as description"]);
        });
    }

    public function getGenres()
    {
        return Cache::remember('categories_in_filter', now()->addHours(8), function () {
            return Taxonomy::where("type", 'genre')->orderBy('name', 'asc')->get();
        });
    }

    public function suggestSearch(Request $request)
    {
        try {
            $keyword = $request->input('q');

            $mangas = Manga::where('title', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orWhere('alternative_titles', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('author', 'LIKE', "%$keyword%")
                ->orderBy('title', 'asc')
                ->get();

            $html = '<ul>';
            foreach ($mangas as $manga) {
                // Kiểm tra nếu manga có chapters và ít nhất 1 chapter
                $lastChapterNumber = $manga->chapters->isNotEmpty() ? $manga->chapters->last()->chapter_number : null;

                $html .= '<li>';
                $html .= '<a href="">';
                $html .= '<img src="' . $manga->cover . '" alt="' . $manga->title . '">';
                $html .= '<h3>' . $manga->title . '</h3>';

                // Kiểm tra chapter trước khi hiển thị
                if ($lastChapterNumber) {
                    $html .= '<h4><i>' . __('menu.chapter', ['number' => $lastChapterNumber]) . '</i><i>' . $manga->title . ' - <b>' . $manga->author . '</b></i></h4>';
                } else {
                    $html .= '<h4><i>' . __('menu.chapter', ['number' => 'N/A']) . '</i><i>' . $manga->title . ' - <b>' . $manga->author . '</b></i></h4>';
                }

                $html .= '</a></li>';
            }
            $html .= '</ul>';

            return response($html);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}

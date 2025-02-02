<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Bookmark;
use Ophim\Core\Models\Manga;
use Ophim\Core\Models\Chapter;

class MangaDetailController extends Controller
{
    public function index($slug)
    {
        try {
            // Tạo cache key    
            $cacheKey = 'manga_' . $slug;

            $manga = Cache::rememberForever($cacheKey, function () use ($slug) {
                return Manga::where('slug', $slug)
                    ->with([
                        'taxanomies' => function ($query) {
                            $query->select('name', 'slug', 'type');
                        },
                        'chapters' => function ($query) {
                            $query->orderBy('chapter_number', 'desc')
                                ->select('manga_id', 'chapter_number', 'created_at');
                        }
                    ])
                    ->select(['id', 'title', 'alternative_titles', 'slug', 'cover', 'description', 'author', 'updated_at'])
                    ->withSum('views', 'views')
                    ->firstOrFail();
            });

            if (!$manga) {
                abort(404);
            }

            // Group and filter data for the view
            $genres = $manga->taxanomies
                ->where('type', 'genre')
                ->whereNotIn('slug', ['manga', 'manhwa', 'manhua', 'comic'])
                ->values();

            $status = $manga->taxanomies->firstWhere('type', 'status'); // More efficient than `->where()->first()`
            $chapters = $manga->chapters;

            $latestChapter = $chapters->first(); // Already ordered descending
            $oldestChapter = $chapters->last(); // Opposite of latest

            $manga->addView();

            // Lấy danh sách manga được xem nhiều nhất
            $mostViewedMangas = (new HomeController())->getMostViewedMangas('month');

            // Chuẩn bị dữ liệu SEO
            $seoData = $this->getSeoData($manga, $manga->chapters->first()->chapter_number ?? null);

            /// Trả về view với dữ liệu
            return view('frontend-web.manga-detail.index', [
                'seoData' => $seoData,
                'manga' => $manga,
                'genres' => $genres,
                'status' => $status,
                'chapters' => $chapters,
                'latestChapter' => $latestChapter,
                'oldestChapter' => $oldestChapter,
                'mostViewedMangas' => $mostViewedMangas,
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function random()
    {
        $randomManga = DB::table('mangas')->inRandomOrder()->select('slug')->first();
        if ($randomManga) {
            return redirect()->route('manga.detail', ['slug' => $randomManga->slug]);
        }
    }

    protected function getSeoData($manga, $latestChapterNumber)
    {
        $settings = $this->getSeoSettings();
        $titleHeadTemp = $settings->get('site_movie_title')->value;
        $seoData['title'] = str_replace(
            ['{name}', '{origin_name}', '{episode_chapter}'],
            [$manga->title ?? '', $manga->alternative_titles ?? '', $latestChapterNumber ?? ''],
            $titleHeadTemp
        );
        $seoData['head_tags'] = $settings->get('site_meta_head_tags')->value;
        $seoData['keywords'] = str_replace(
            ['{name}'],
            [$manga->title ?? ''],
            $settings->get('site_tag_key')->value
        );

        $description = $manga->description;
        if (str_ends_with($description, '...')) {
            $description = substr($description, 0, -3);
        }
        $seoData['description'] = mb_substr($description, 0, 156);
        $seoData['image'] = $manga->cover;
        $seoData['site_script'] = $settings->get('site_scripts_google_analytics')->value;

        return $seoData;
    }

    public function read($slug, $chapter_number)
    {
        $manga = Manga::where('slug', $slug)
            ->select(['id', 'title', 'slug', 'cover'])
            ->with(['chapters' => function ($query) {
                return $query->select('manga_id', 'content', 'chapter_number', 'updated_at', 'created_at')
                    ->distinct('chapter_number')
                    ->orderBy('chapter_number');
            }])
            ->firstOrFail();

        $manga->addView();

        $currentChapter = $manga->chapters->firstWhere('chapter_number', $chapter_number);

        $chapters = $manga->chapters->unique('chapter_number');

        if ($chapters->isNotEmpty()) {
            $previousChapter = $chapters
                ->filter(fn($chapter) => $chapter->chapter_number < $currentChapter->chapter_number)
                ->last(); // Last smaller chapter (ordered asc by default)

            $nextChapter = $chapters
                ->filter(fn($chapter) => $chapter->chapter_number > $currentChapter->chapter_number)
                ->first(); // First larger chapter (ordered asc by default)
        } else {
            $previousChapter = null;
            $nextChapter = null;
        }

        $data = [
            'seoData' => $this->getChapterSeoData($manga, $currentChapter->chapter_number),
            'manga' => $manga,
            'currentChapter' => $currentChapter,
            'chapters' => $chapters,
            'previousChapter' => $previousChapter,
            'nextChapter' => $nextChapter,
        ];

        return view('frontend-web.chapter.index', $data);
    }

    protected function getChapterSeoData($manga, $chapter_number)
    {
        $settings = $this->getSeoSettings();
        $seoData['title'] = str_replace(
            ['{manga.name}', '{manga.origin_name}', '{manga.chapter_current}'],
            [$manga->title, ('- ' . $manga->alternative_titles), $chapter_number ?? '最新'],
            $settings->get('site_episode_watch_title')->value
        );
        $seoData['keywords'] = str_replace(
            ['{name}'],
            [$manga->title . " 第{$chapter_number}話" ?? ''],
            $settings->get('site_tag_key')->value
        );
        $seoData['head_tags'] = $settings->get('site_meta_head_tags')->value;
        $seoData['description'] = $seoData['title'];
        $seoData['image'] = $manga->cover;
        $seoData['site_script'] = $settings->get('site_scripts_google_analytics')->value;

        return $seoData;
    }
}

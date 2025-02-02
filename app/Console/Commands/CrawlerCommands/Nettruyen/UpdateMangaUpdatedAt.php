<?php

namespace App\Console\Commands\NetMangarawCommands;

use App\Helpers\CurlHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Ophim\Core\Models\Manga;
use Ophim\Crawler\OphimCrawler\NetmangarawCrawler\NetmangarawCrawler;
use Symfony\Component\DomCrawler\Crawler;

class UpdateMangaUpdatedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netmangaraw-update_manga_updated_at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $context;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
    printf("Update manga updated_at \n");

    Manga::orderByDesc('updated_at')->take(380)->chunk(50, function ($mangasChunk) {
        foreach ($mangasChunk as $key => $manga) {
            try {
            $body = CurlHelper::fetchHtmlViaNoProxy("https://netmangaraw.com/manga/" . $manga->slug);
            $crawler = new Crawler($body);

            $updatedAtNode = $crawler->filterXPath('.//time[@class="small"]');
            if($updatedAtNode->count() > 0){
                $dateString = $updatedAtNode->text();
                $before_datetime = $manga->updated_at;
                preg_match('/\[(?:最終更新日時: )(.+?)\]/', $dateString, $matches);
                $dateTime = $matches[1];
                $manga->update(['updated_at' => $dateTime]);
                printf("%s. %s success: created_at %s => %s\n", $key, $manga['slug'], $before_datetime, $manga->updated_at);
            }
            } catch (\Exception $e) {
                continue;
            }
        }
    });

    printf("Done\n");

    return 0;
    }


    protected function getMangaList($url)
    {
        $response = CurlHelper::fetchHtmlViaNoProxy($url);
        return $response;
    }

}

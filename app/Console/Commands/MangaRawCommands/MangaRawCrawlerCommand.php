<?php

namespace App\Console\Commands\MangaRawCommands;

use App\Helpers\CurlHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Ophim\Crawler\OphimCrawler\MangaRawCrawler\MangaRawCrawler;
use Symfony\Component\DomCrawler\Crawler;

class MangaRawCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mangaraw-crawler';

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
        // Ghi nhận thời gian bắt đầu
    $start_time = microtime(true);

    // Lấy ngày hiện tại
    $current_date = date('Y-m-d H:i:s');

    $page_from = 1;
    $page_to = 74;

    printf("[%s] ページ番号を指定して mangaraw.in からストーリーをダウンロードします (FROM PAGE: %d | TO PAGE: %d)\n", $current_date, $page_from, $page_to);
    
    for ($page = $page_to; $page >= $page_from; $page--) {
        $url = "https://mangaraw.in/manga-list?page={$page}";
        $items = $this->getMangaList($url);

        foreach ($items as $item) {
            $manga_item = $this->getMangaItemData($item);
            $manga_data = $manga_item['data']['item'];
            $manga_url = $manga_data['url'];
            
                $crawler = new MangaRawCrawler(
                    $manga_url,
                );

                $crawler->handle(); 
        }
    }

    Artisan::call('optimize:clear');
    $end_time = microtime(true);
    $execution_time = round($end_time - $start_time, 2);

    printf("[%s] Total execution time: %s seconds\n", $current_date, $execution_time);

    return 0;
    }


    public function getMangaList($url)
    {
        $body = CurlHelper::fetchHtmlViaProxy($url);
        $crawler = new Crawler($body);
        $items = $crawler->filterXPath('//div[@class="relative"]');
        return $items;
    }

    public function getMangaItemData($item){
        $itemCrawler = new Crawler($item);
        $manga_url = $itemCrawler->filter('a')->attr('href');
        $manga_name = $itemCrawler->filterXPath('.//div[@class="latest-chapter truncate"]')->text() ?? '';

        $manga = [];
        $manga['name'] = $manga_name;
        $manga['url'] = "https://mangaraw.in". $manga_url;

        return [
            "data" => [
                'item' => $manga,
            ]
        ];
    }

}

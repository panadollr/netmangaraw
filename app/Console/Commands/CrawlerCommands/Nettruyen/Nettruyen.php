<?php

namespace App\Console\Commands\CrawlerCommands\Nettruyen;

use App\Helpers\CurlHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Ophim\Crawler\OphimCrawler\Crawlers\Nettruyen\NettruyenCrawler;
use Symfony\Component\DomCrawler\Crawler;

class NetTruyen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nettruyen-crawler';

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
        $page_to = 1;

        printf("haha");
        printf("[%s] Tải truyện từ nettruyen theo số trang (TỪ TRANG: %d | ĐẾN TRANG: %d)\n", $current_date, $page_from, $page_to);

        for ($page = $page_from; $page <= $page_to; $page++) {
            $url = "https://nettruyenrr.com/tim-truyen?page={$page}";

            $items = $this->getMangaList($url);

            foreach ($items as $item) {
                $manga_item = $this->getMangaItemData($item);
                $manga_data = $manga_item['data']['item'];
                $manga_url = $manga_data['url'];
                print_r($manga_url . "\n");

                // Tạo Crawler cho từng manga
                $crawler = new NettruyenCrawler(
                    $manga_url
                );

                $crawler->handle();
            }

            Artisan::call('optimize:clear');
        }

        $end_time = microtime(true);
        $execution_time = round($end_time - $start_time, 2);

        printf("[%s] Total execution time: %s seconds\n", $current_date, $execution_time);

        return 0;
    }


    public function getMangaList($url)
    {
        $response = fetchHtml($url);
        $crawler = new Crawler($response);
        $items = $crawler->filterXPath('//div[@class="items"]/div[@class="row"]/div[@class="item"]');
        return $items;
    }

    public function getMangaItemData($item)
    {
        $itemCrawler = new Crawler($item);
        $manga_name = $itemCrawler->filterXPath('//figcaption/h3/a')->text();
        $manga_url = $itemCrawler->filter('.image a')->attr('href');

        return [
            'data' => [
                'item' => [
                    'name' => $manga_name,
                    'url' => $manga_url,
                ],
            ],
        ];
    }
}

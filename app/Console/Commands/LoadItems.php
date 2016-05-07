<?php

namespace App\Console\Commands;

use App\Cluster;
use App\Item;
use Illuminate\Console\Command;

class LoadItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i:l';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Loading items...');
        $years = range(1966, 2015);
        foreach($years as $year) {
            $this->getForYear($year);
        }

        // delete all clusters
        Cluster::truncate();

        // create clusters with all the non-expired items
        $items = \App\Item::where('end_time', '>', \Carbon\Carbon::now())
            ->orderBy('end_time', 'asc')
            ->get();

        while (count($items)) {
            $this->info('Creating cluster, ' . count($items) . ' to go');

            $cluster = Cluster::create([]);

            $item = $items->first();

            $similarItems = $items->filter(function ($item2) use ($item) {
                return $this->distance($item->title, $item2->title);
            });
            foreach($similarItems as $similarItem) {
                $similarItem->cluster_id = $cluster->id;
                $this->info($similarItem->year . ' Adding ' . $similarItem->title . ' to cluster ' . $cluster->id);
                $similarItem->save();
            }
            $items = $items->reject(function ($item2) use ($item) {
                return $this->distance($item->title, $item2->title);
            });
        }
    }

    private function distance($title1, $title2) {
        $title1 = $this->stripWords($title1);
        $title2 = $this->stripWords($title2);
        $distance = levenshtein($title1, $title2) / strlen($title2);
        return $distance < 0.6;
    }

    private function stripWords($title) {
        $words = ['star trek', 'the next generation', 'deep space nine', 'ds9', 'tng', 'voyager', 'enterprise'];
//        $words = ['pokemon'];
        foreach($words as $word) {
            $title = str_replace($word, '', strtolower($title));
        }
        return $title;
    }

    private function getForYear($year)
    {
        $this->info('Year is ' . $year);
        $service = new \DTS\eBaySDK\Finding\Services\FindingService([
            'apiVersion' => '1.13.0',
            'globalId' => \DTS\eBaySDK\Constants\GlobalIds::US,
            'credentials' => [
                'appId' => env('EBAY_APP_ID'),
                'certId' => env('EBAY_CERT_ID'),
                'devId' => env('EBAY_DEV_ID')
            ]
        ]);

        /**
         * Create the request object.
         */
        $request = new \DTS\eBaySDK\Finding\Types\FindItemsByKeywordsRequest();
        /**
         * Assign the keywords.
         */
        $request->keywords = 'star trek ' . $year;

//    dd(\Carbon\Carbon::today()->format('Y-m-d\TH:i:s\Z'));
        // YYYY-MM-DDTHH:MM:SS.SSSZ
        // 2016-05-03T00:00:00+0000"
        // 2016-05-03T00:00:00Z
        /**
         * Add additional filters to only include items that fall in the price range of $1 to $10.
         *
         * Notice that we can take advantage of the fact that the SDK allows object properties to be assigned via the class constructor.
         */
//        $request->itemFilter[] = new \DTS\eBaySDK\Finding\Types\ItemFilter([
//            'name' => 'EndTimeFrom',
//            'value' => [\Carbon\Carbon::tomorrow()->format('Y-m-d\TH:i:s\Z')]
//        ]);
        $request->itemFilter[] = new \DTS\eBaySDK\Finding\Types\ItemFilter([
            'name' => 'EndTimeTo',
            'value' => [\Carbon\Carbon::today()->endOfDay()->format('Y-m-d\TH:i:s\Z')]
        ]);

        /**
         * Send the request.
         */
        $response = $service->findItemsByKeywords($request);
        /**
         * Output the result of the search.
         */
        if (isset($response->errorMessage)) {

            foreach ($response->errorMessage->error as $error) {
                printf(
                    "%s: %s\n\n",
                    $error->severity === \DTS\eBaySDK\ResolutionCaseManagement\Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
                    $error->message
                );
            }
        }
        if ($response->ack !== 'Failure') {
            foreach ($response->searchResult->item as $item) {
                $this->info($item->title);
                if(\App\Item::where('item_id', $item->itemId)->first()) {
                    $this->info('Item already exists, skipping...');
                    continue;
                }
                $stopWords = ['dvd',
                    'bluray',
                    'blu-ray',
                    'vhs',
                    'magazine',
                    'signed',
                    'autograph',
                    'novel',
                    'paperback',
                    'funko',
                    'card',
                    'tv guide',
                    'poster',
                    'comic',
                    'gold key',
                    'marvel',
                    'dc',
                    'whitman',
                    'book',
                    'Original Slide Transparency',
                    'photo',
                    'laserdisc',
                    'Frankenstein #',
                ];
                foreach($stopWords as $stopWord) {
                    if(strpos(strtolower($item->title), strtolower($stopWord)) !== false) {
                        $this->info('Contains stop word ' . $stopWord . ' skipping...');
                        continue 2;
                    }
                }
                if(!$item->galleryPlusPictureURL->count()) {
                    // ignore all posts, with low quality pictures
                    continue;
                }
                \App\Item::create([
                    'year' => $year,
                    'item_id' => $item->itemId,
                    'title' => $item->title,
                    'gallery_url' => $item->galleryURL,
                    'gallery_plus_url' => $item->galleryPlusPictureURL->count() ? $item->galleryPlusPictureURL[0] : $item->galleryURL || '',
                    'view_item_url' => $item->viewItemURL,
                    'currency_id' => $item->sellingStatus->currentPrice->currencyId,
                    'currency_value' => $item->sellingStatus->currentPrice->value,
                    'time_left' => '',
                    'start_time' => \Carbon\Carbon::instance($item->listingInfo->startTime),
                    'end_time' => \Carbon\Carbon::instance($item->listingInfo->endTime)
                ]);
            }
        }
    }
}

http://i.ebayimg.com/images/g/HswAAOSwYHxWP8Jz/s-l500.jpg



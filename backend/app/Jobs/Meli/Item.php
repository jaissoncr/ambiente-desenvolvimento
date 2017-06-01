<?php

namespace MLTools\Jobs\Meli;

use MLTools\Jobs\Job;
use MLTools\Models\Advert;
use MLTools\Services\Meli\Item as MeliItem;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use MLTools\Helpers\Convert;
use MLTools\Repositories\Eloquent\AdvertRepository;

class Item extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $meli;
    protected $id;

    public function __construct($id)
    {
        $this->meli = \App::make('MeliUser');
        $this->id = $id;
    }

    public function handle()
    {
        /** Meli\Item instance */
        $meliItem = new MeliItem(new \MLTools\Models\Store());
        $item = $meliItem->get($this->id);

        if (isset($item['httpCode']) && $item['httpCode'] == 200) {

            $item = Convert::objectToArray($item['body']);
            $repo = new AdvertRepository(new Advert());
            $repo->findOrCreate($item);

        } else {
            throw new \Exception('Invalid Request');
        }
    }

}
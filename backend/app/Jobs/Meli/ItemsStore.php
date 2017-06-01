<?php

namespace MLTools\Jobs\Meli;

use MLTools\Http\Controllers\Controller;
use MLTools\Jobs\Job;
use MLTools\Services\Meli\Item as MeliItem;
use MLTools\Models\Store;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ItemsStore extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    protected $store;
    protected $page;
    protected $meli;

    public function __construct(Store $store, $page)
    {
        $this->store = $store;
        $this->page = $page;
        $this->meli = \App::make('MeliUser');
    }

    public function handle()
    {
        /** Revalidate access_token */
        $this->store = $this->meli->refresh($this->store);

        /** Set meli access_token */
        $this->meli->setAccessToken($this->store->access_token);

        /** Meli\Item instance */
        $meliItem = new MeliItem($this->store);
        $items = $meliItem->itemsByUser($this->page);

        if (isset($items['httpCode']) && $items['httpCode'] == 200) {

            $items = $items['body'];
            if ($items->paging->total > 0) {
                // Lançar jobs pra cada result...
                foreach ($items->results as $id) {
                    if (!empty($id)) {
                        $this->dispatch(new Item($id));
                    }
                }

                // Lançar jobs caso existirem mais páginas
                if ( $items->paging->total > ($items->paging->offset + $items->paging->limit) ) {
                    $this->dispatch(new \MLTools\Jobs\Meli\ItemsStore($this->store, ($this->page + 1)));
                }
            }

        } else {
            // Neste momento esta opção esta comentada para evitar possíveis loops,
            // Para casos de erro verificar funcionalidade de restaurar casos de erro
            // $this->dispatch(new ItemsStore($this->store));
            throw new \Exception('Invalid Request');
        }
    }
}
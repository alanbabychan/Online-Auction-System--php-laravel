<?php

namespace App\Providers;

use App\Providers\BidWasCreated;
use App\Repository\BidBotRepository;
use App\Repository\BidHistoryRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;

use function auth;
use function dd;

class TriggerAutoBid
{
    public $bidBotRepository;
    public $bidHistoryRepository;

    /**
     * Create the event listener.
     *
     * @param  BidBotRepository  $bidBotRepository
     * @param  BidHistoryRepository  $bidHistoryRepository
     */
    public function __construct(BidBotRepository $bidBotRepository, BidHistoryRepository $bidHistoryRepository)
    {
        $this->bidBotRepository     = $bidBotRepository;
        $this->bidHistoryRepository = $bidHistoryRepository;
    }

    /**
     * Handle the event.
     *
     * @param  BidWasCreated  $event
     *
     * @return void
     */
    public function handle(BidWasCreated $event)
    {
        $latestBidder = $this->bidHistoryRepository->getLatestBidder($event->item);

        $autoBids = $this->bidBotRepository->getBots($event->item, $latestBidder);

        if ($autoBids->count() > 0) {
            $latestBidAmount = $latestBidder->bid_amount ?? 0;

            foreach ($autoBids as $bid) {
                if ($bid->user->auto_bid > $latestBidAmount) {
                    $latestBidAmount += 1;
                    $this->bidHistoryRepository->store([
                        'item_id'    => $event->item->id,
                        'user_id'    => $bid->user->id,
                        'bid_amount' => $latestBidAmount
                    ]);
                }
            }
        }
    }
}

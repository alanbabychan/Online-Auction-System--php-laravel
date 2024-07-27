<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\BidHistoryRequest;
use App\Models\BidHistory;
use App\Models\Item;
use App\Repository\BidHistoryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use function dd;
use function redirect;

class BidHistoryController extends Controller
{
    public $bidHistoryRepository;

    /**
     * BidHistoryController constructor.
     *
     * @param  BidHistoryRepository  $bidHistoryRepository
     */
    public function __construct(BidHistoryRepository $bidHistoryRepository)
    {
        $this->bidHistoryRepository = $bidHistoryRepository;
    }

    /**
     * @param  Item  $item
     * @param  BidHistoryRequest  $request
     *
     * @return RedirectResponse
     */
    public function submitBid(Item $item, BidHistoryRequest $request): RedirectResponse
    {
        $this->preCheckBeforeBid($item, $request);

        $bidData = [
            'item_id'    => $item->id,
            'user_id'    => auth()->user()->id,
            'bid_amount' => $request->input('bid')
        ];

        $this->bidHistoryRepository->store($bidData);

        return redirect()->back()->with('success', 'Thank you, bid submitted');
    }

    /**
     * Checks before making the bid
     *
     * @param  Item  $item
     * @param  Request  $request
     *
     * @throws GeneralException
     */
    private function preCheckBeforeBid(Item $item, Request $request)
    {
        // checks if item is active and can be bidded
        $this->itemIsActive($item);
        // checks and matches the min bid amount
        $this->minimumBidAmount($item, $request);
        // makes sure if the bid is greater than the last one
        $this->bidShouldBeGreaterThanTheLast($item, $request);
    }

    /**
     * @param  Item  $item
     * @param  Request  $request
     *
     * @throws GeneralException
     */
    private function minimumBidAmount(Item $item, Request $request)
    {
        if ((int) $request->input('bid') < (int) $item->minimal_bid) {
            throw new GeneralException('Please submit at least minimal bid amount !');
        }
    }

    /**
     * @param  Item  $item
     * @param  Request  $request
     *
     * @throws GeneralException
     */
    private function bidShouldBeGreaterThanTheLast(Item $item, Request $request)
    {
        if ($item->bids()->count() > 0 && (int) $request->input('bid') <= @(int) $item->bids()->latest()->first()->bid_amount) {
            throw new GeneralException('You bid should be bigger than the last one!');
        }
    }

    /**
     * @param  Item  $item
     *
     * @throws GeneralException
     */
    private function itemIsActive(Item $item)
    {
        if (!$item->active) {
            throw new GeneralException('This auction has expired!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Repository\BidBotRepository;
use Illuminate\Http\Request;

use function __;
use function auth;
use function redirect;

class BidBotController extends Controller
{
    public $bidBotRepository;

    /**
     * BidBotController constructor.
     *
     * @param  BidBotRepository  $bidBotRepository
     */
    public function __construct(BidBotRepository $bidBotRepository)
    {
        $this->bidBotRepository = $bidBotRepository;
    }

    /**
     * @param  Item  $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Item $item): \Illuminate\Http\RedirectResponse
    {
        $this->bidBotRepository->activateOrDeactivate($item, [
            'item_id' => $item->id,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back()->with('success', __('Operation was successful'));
    }
}

<?php


namespace App\Repository;


use App\Exceptions\GeneralException;
use App\Models\BidBot;
use App\Models\BidHistory;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use function auth;
use function dd;

class BidBotRepository extends BaseRepository
{
    /**
     * CommentRepository constructor.
     *
     * @param  BidBot  $bidBot
     */
    public function __construct(BidBot $bidBot)
    {
        $this->model = $bidBot;
    }

    /**
     * @param  Item  $item
     * @param  BidHistory  $latestBidder
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws GeneralException
     */
    public function getBots(Item $item, BidHistory $latestBidder)
    {
        try {
            return $this->model->where('item_id', $item->id)
                               ->where('user_id', '!=', $latestBidder->user->id)
                               ->orderBy('created_at', 'asc')
                               ->get();
        } catch (Exception $exception) {
            throw new GeneralException('Auto bidding bots cannot be retrieved!');
        }
    }

    /**
     * @param  Item  $item
     * @param  array  $data
     *
     * @return BidHistory|\Illuminate\Http\RedirectResponse
     */
    public function activateOrDeactivate(Item $item, array $data = [])
    {
        DB::beginTransaction();

        try {
            $activated = $this->model->where('item_id', $item->id)
                                     ->where('user_id', auth()->user()->id)
                                     ->first();

            if ($activated) {
                $activated->delete();
            } else {
                $this->model->create($data);
            }
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with('error', __('Problem creating auto bid'));
        }

        DB::commit();
    }
}
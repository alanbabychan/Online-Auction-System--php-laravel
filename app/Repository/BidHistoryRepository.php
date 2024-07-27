<?php


namespace App\Repository;


use App\Exceptions\GeneralException;
use App\Jobs\TriggerAutoBid;
use App\Models\BidHistory;
use App\Models\Item;
use App\Providers\BidWasCreated;
use Exception;

use Illuminate\Support\Facades\DB;

use function __;
use function dispatch;
use function event;
use function now;
use function redirect;

class BidHistoryRepository extends BaseRepository
{
    /**
     * CommentRepository constructor.
     *
     * @param  BidHistory  $bidHistory
     */
    public function __construct(BidHistory $bidHistory)
    {
        $this->model = $bidHistory;
    }

    /**
     * @param  array  $data
     *
     * @return BidHistory|\Illuminate\Http\RedirectResponse
     */
    public function store(array $data = [])
    {
        DB::beginTransaction();

        try {
            $bidHistory = $this->model->create($data);
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with('error', __('Problem creating bid request'));
        }

        DB::commit();

        // dispatch auto-bidding event
        dispatch(new TriggerAutoBid($bidHistory->item))->afterCommit();

        return $bidHistory;
    }

    /**
     * @param  Item  $item
     *
     * @throws GeneralException
     */
    public function getLatestBidder(Item $item)
    {
        try {
            return $this->model->where('item_id', $item->id)
                               ->latest()
                               ->firstOrFail();
        } catch (Exception $exception) {
            throw new GeneralException('Bidder cannot be found!');
        }
    }

}
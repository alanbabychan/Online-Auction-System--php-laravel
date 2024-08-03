<?php


namespace App\Repository;


use App\Models\BidHistory;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use function __;
use function redirect;

class ItemRepository extends BaseRepository
{
    /**
     * CommentRepository constructor.
     *
     * @param    $item
     */
    public function __construct(Item $item)
    {
        $this->model = $item;
    }

    /**
     * @param  Request  $request
     * @param  int  $paginateNumber
     *
     * @return LengthAwarePaginator|\Illuminate\Http\RedirectResponse|null
     */
    public function getPaginatedList(Request $request, $paginateNumber = 12)
    {
        try {
            $items = $this->model::query();

            $items = $items->with('bids');

            if ($request->has('search_term')) {
                $items->where('name', 'LIKE', '%'.$request->input('search_term').'%');
            }

            if ($request->has('order')) {
                $items->orderBy('minimal_bid', $request->input('order'));
            } else {
                // by default
                $items->orderBy('minimal_bid', 'asc');
            }

            return $items->paginate(12);
        } catch (Exception $exception) {
            return redirect()->back()->with('error', __('Problem getting paginated data'));
        }
    }

    /**
     * @param  Item  $item
     *
     * @return Collection|\Illuminate\Http\RedirectResponse
     */
    public function getBids(Item $item)
    {
        try {
            return $item->bids()
                        ->orderBy('created_at', 'desc')
                        ->get();
        } catch (Exception $exception) {
            return redirect()->back()->with('error', __('Cannot get bids'));
        }
    }
}
<?php


namespace App\Repository;


use App\Models\User;
use Exception;

use Illuminate\Support\Facades\DB;

use function dd;
use function redirect;

class UserRepository extends BaseRepository
{
    /**
     * CommentRepository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param  User  $user
     * @param  array  $data
     *
     * @return User|\Illuminate\Http\RedirectResponse
     */
    public function update(User $user, array $data)
    {
        DB::beginTransaction();

        try {
            $user->update($data);
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Cannot update user!');
        }

        DB::commit();

        return $user;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use function auth;
use function dd;

class SettingController extends Controller
{
    public $userRepository;

    /**
     * SettingController constructor.
     *
     * @param  UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('settings');
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->userRepository->update(auth()->user(), ['auto_bid' => $request->input('auto_bid')]);

        return redirect()->back()->with('success', 'Settings Updated');
    }
}

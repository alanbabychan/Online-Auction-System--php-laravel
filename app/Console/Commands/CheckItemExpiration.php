<?php

namespace App\Console\Commands;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckItemExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks and expires items';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $items = Item::active()->get();

        foreach ($items as $item) {
            if (Carbon::parse($item->expires_at)->lt(Carbon::now())) {
                // item has expired
                $item->active = Item::INACTIVE;
                $item->save();
            }
        }

        return $this->line('Command executed successfully!');
    }
}

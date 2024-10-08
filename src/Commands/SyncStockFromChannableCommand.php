<?php

namespace Dashed\DashedEcommerceChannable\Commands;

use Illuminate\Console\Command;
use Dashed\DashedCore\Models\Customsetting;
use Dashed\DashedEcommerceChannable\Classes\Channable;

class SyncStockFromChannableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channable:sync-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync stock with Channable';

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
        if (Channable::isConnected() && Customsetting::get('channable_stock_sync_enabled', null, 0)) {
            Channable::syncStock();
        }
    }
}

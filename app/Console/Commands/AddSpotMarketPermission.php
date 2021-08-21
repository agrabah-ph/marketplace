<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSpotMarketPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:spot_market';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Spot Market Permissions';

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

        $addBuyerRole = Role::firstOrCreate([
            'name' => 'buyer',
            'display_name' => 'Buyer',
            'guard_name' => 'web',
        ]);
        $spotMarketPermissions = [
            [
                'read-spot-market',
                'Read',
                'web',
                'spot_markets',
                'SpotMarket',
            ],
            [
                'add-spot-market',
                'Add',
                'web',
                'spot_markets',
                'SpotMarket',
            ],
            [
                'browse-spot-market',
                'Browse',
                'web',
                'spot_markets',
                'SpotMarket',
            ],
            [
                'delete-spot-market',
                'Delete',
                'web',
                'spot_markets',
                'SpotMarket',
            ],
            [
                'buy-spot-market',
                'Buy',
                'web',
                'spot_markets',
                'SpotMarket',
            ],
        ];
        foreach($spotMarketPermissions as $spotMarketPermission){
            $permission = Permission::firstOrNew(['name' => $spotMarketPermission[0]]);
            $permission->name =  $spotMarketPermission[0];
            $permission->display_name =  $spotMarketPermission[1];
            $permission->guard_name =  $spotMarketPermission[2];
            $permission->table_name =  $spotMarketPermission[3];
            $permission->table_display_name =  $spotMarketPermission[4];
            $permission->save();
        }
    }
}

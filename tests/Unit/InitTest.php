<?php

namespace Tests\Unit;

use App\MarketplaceCategories;
use App\Profile;
use App\Settings;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class InitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAdminUser()
    {
        DB::beginTransaction();

        $this->assertTrue(User::where('email', 'superadmin@agrabah.ph')->exists());

        DB::rollBack();

    }

    public function testRoles()
    {
        DB::beginTransaction();

        $roles = [
            'super-admin',
            'administrator',
            'community-leader',
            'farmer',
            'loan-provider',
            'bfar',
            'enterprise-client',
            'buyer',
        ];
        foreach($roles as $role){
            $this->assertTrue(Role::where('name', $role)->exists());
        }

        DB::rollBack();
    }

    public function testCategories()
    {
        DB::beginTransaction();

        $this->assertTrue(MarketplaceCategories::count()>0);

        DB::rollBack();
    }

    public function testBfarSettings()
    {
        DB::beginTransaction();

        $settings = Settings::where('name','bfar')->first();
        $this->assertTrue(count($settings->toArray()) > 0);
        $this->assertTrue(count($settings->profile->toArray()) > 0);

        DB::rollBack();
    }

    public function testServiceFeeSettings()
    {
        DB::beginTransaction();

        $settings = Settings::where('name','service_fee_percentage')->first();
        $this->assertTrue(count($settings->toArray()) > 0);

        DB::rollBack();
    }
}

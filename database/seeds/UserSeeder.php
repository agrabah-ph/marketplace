<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Profile;
use App\MasterFarmer;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = array(
            array('User', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            )),
            array('Profile', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            )),
            array('Inventory', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            )),
            array('Setting', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            ))
        );

        foreach ($models as $model) {
            foreach ($model[1] as $permission){
                Permission::create([
                    'name' => stringSlug($permission).'-'.stringSlug($model[0]),
                    'display_name' => $permission, 'table_name' => stringSlug($model[0]),
                    'table_display_name' => $model[0]
                ]);
            }
        }

        $roles = array(
            'Super Admin',
            'Community Leader',
            'Farmer',
            'Loan Provider',
            'Borrower'
        );

        foreach($roles as $role) {
            Role::create(array(
                'name' => stringSlug($role),
                'display_name' => $role
            ));
        }

        $user = new User();
        $user->name = 'Administrator';
        $user->email = 'superadmin@agrabah.ph';
        $user->password = bcrypt('agrabah');
        $user->passkey = 'agrabah';
        $user->active = 1;
        if($user->save()) {
            $user->assignRole(stringSlug('Super Admin'));
            $user->markEmailAsVerified();
        }

//        $user = new User();
//        $user->name = 'Master Farmer';
//        $user->email = 'masterfarmer@gmail.com';
//        $user->password = bcrypt('agrabah');
//        $user->passkey = 'agrabah';
//        $user->active = 1;
//        if($user->save()) {
//            $profile = new Profile();
//            $profile->first_name = 'Master';
//            $profile->last_name = 'Farmer';
//            if($profile->save()){
//                $number = str_pad(MasterFarmer::count() + 1, 5, 0, STR_PAD_LEFT);
//                $master = new MasterFarmer();
//                $master->account_id = $number;
//                $master->user_id = $user->id;
//                $master->profile_id = $profile->id;
//                $master->save();
//            }
//            $user->assignRole(stringSlug('Master Farmer'));
//            $user->markEmailAsVerified();
//        }

    }
}

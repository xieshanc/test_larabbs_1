<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(10)->make();

        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $user1 = User::find(1);
        $user1->name = 'sunge';
        $user1->email = 'exy2000a@163.com';
        $user1->avatar = 'http://larabbs1.local/uploads/images/avatars/202003/1_1585467489_oDDaVkRClX.jpg';
        $user1->save();

        $user1->assignRole('Founder');

        $user2 = User::find(2);
        $user2->assignRole('Maintainer');
    }
}

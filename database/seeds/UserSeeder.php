<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$total_players = config('keyboardgamer.total_players');
        DB::transaction(function() use($total_players) {
        	for($i=1; $i<=$total_players; $i++) {
        		$user = new User;
        		$user->username = "user_".$i."@keyboardgamer";
        		$user->password = Hash::make("user_".$i."@keyboardgamer");
                $user->started = false;
        		$user->save();
        	}
        });
    }
}

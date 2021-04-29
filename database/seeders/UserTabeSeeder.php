<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Jobs\UserSeedJob;
use App\Models\User;

class UserTabeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $users = User::factory(50000)->make();

        $chunks = $users->chunk(5000);
        $i = 0;
        $chunks->each(function ($chunk) use($i) {
            dispatch(new UserSeedJob($chunk->toArray()));
            // dispatchSync(new UserSeedJob($chunk->toArray()));
            // UserSeedJob::dispatchSync($chunk->toArray());
            $i++;
        });
        // User::factory(1)->create(['email' => 'admin@yahoo.com']);
        // User::factory(10)->create();
    }
}

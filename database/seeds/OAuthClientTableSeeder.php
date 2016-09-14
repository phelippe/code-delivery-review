<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datetime = Carbon::now();
        $clients = [
            [
                'id' => 'appid01',
                'secret' => 'secret',
                'name' => 'Minha App Mobile',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],
            /*[
                'id' => 'client2id',
                'secret' => 'client2secret',
                'name' => 'client2',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ],*/
        ];
        DB::table('oauth_clients')->insert($clients);
    }
}

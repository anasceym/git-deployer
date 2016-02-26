<?php

use Illuminate\Database\Seeder;
use App\Provider;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::where('provider_code', 'BITBUCKET')->delete();
        Provider::where('provider_code', 'GITHUB')->delete();

        $provider = new Provider();
        $provider->title = "Bitbucket.org";
        $provider->provider_code = "BITBUCKET";
        $provider->save();

        $provider = new Provider();
        $provider->title = "Github.org";
        $provider->provider_code = "GITHUB";
        $provider->save();
    }
}

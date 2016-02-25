<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository;
use App\Provider;

class BitbucketController extends Controller
{
    private $provider = null;

    public function __construct() {
        $this->provider = Provider::bitbucket();

        if(!$this->provider) {
            throw new \Exception('Please run `php artisan db:seed`');
        }
    }
    /**
     * Handles hook from Bitbucket.com POST hook.
     *
     * @return void
     */
    public function hookHandler(Request $request) {
        $payload = json_decode( stripslashes( $request->get('payload') ), true );

        $repository = $this->provider->repositories()->where('reference',$payload['repository']['slug'])->first();

        print '<pre>'; var_dump($payload); die();
    }
}

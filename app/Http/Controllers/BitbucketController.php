<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository;
use App\Provider;

class BitbucketController extends Controller
{
    private $provider = null;

    /**
     * Constructor
     *
     */
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

        // We only interested in push events
        if($request->headers->get('X-Event-Key') !== 'repo:push') {
            return response()->json(['success'=>false,'message'=>'I only want push events :P.'], 200);
        }

        $payload = json_decode( stripslashes( $request->get('payload') ), true );

        if(!isset($payload['push']['changes'][0]['new'])) {
            return response()->json(['success'=>false,'message'=>'No changes found.'], 200);
        }

        $pushType = $payload['push']['changes'][0]['new']['type'];
        // We only interested in tag push not branch.
        // TODO: Option for branch or tag?
        if($pushType !== 'tag' && $pushType !== ' annotated_tag') {
            return response()->json(['success'=>false,'message'=>'No tag push found.'], 200);
        }

        $repository =   $this->provider
                        ->repositories()
                        ->where('reference',$payload['repository']['uuid'])
                        ->first();

    }
}

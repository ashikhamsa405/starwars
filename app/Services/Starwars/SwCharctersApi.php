<?php

namespace app\Services\Starwars;

use App\Contracts\StarWars\swcharctersprovider;
use Exception;
use Illuminate\Support\Facades\Log;

class SwCharctersApi implements swcharctersprovider
{
    protected $base_url;
    public function __construct(iterable $mode)
    {
        $this->base_url = $mode['base_url'];
    }

    public function getSwCharcters(int $page)
    {


        $url = $this->base_url;
        $url .= 'people/';
        $url .= '?page=' . $page;
        $result = $this->doRequest($url);
        return json_decode($result);

    }


    public function doRequest(string $url)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->get($url);
            return $request->getBody();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
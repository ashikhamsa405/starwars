<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Starwars\SwCharcterFeilds;
use App\Http\Requests\StarWarsRequest;
use App\Contracts\Starwars\swcharctersprovider;

class StarwarsCharctersController extends Controller
{



    public function __construct(protected swcharctersprovider $swcharctersprovider, protected SwCharcterFeilds $swCharcterFeilds)
    {
        $this->middleware('auth:api');
    }


    /**
     * listing of startwars characters.
     * @return  array
     */


    public function index(StarWarsRequest $request)
    {

        //calling the interface which bind with api calling service container
        $data = $this->swcharctersprovider->getSwCharcters($request->page);
        //setting up  the response 
        $result = $this->swCharcterFeilds->transform($data);

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);

    }


}

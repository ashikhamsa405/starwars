<?php
namespace app\Services\Starwars;


class SwCharcterFeilds
{
    public function transform($input)
    {

      
        if ($input == null) {
            $result['data'] =  null;
            $result['message'] = 'No characters Found';
            return $result;

        }    
        $result['data'] = collect($input->results)->map(function ($item) {
            return [
                'name' => $item->name,
                'height' => $item->height,
                'mass' => $item->mass,
                'hair_color' => $item->hair_color,
                'date_of_birth' => $item->birth_year,
                'gender' => $item->gender,
            ];
        })->toArray();
        $result['message'] = 'Charcters retrieved successfully';
        
        return $result;
    }
}

?>
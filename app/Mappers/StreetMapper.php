<?php
namespace App\Mappers;

use App\Models\Geography\street;

/**
 *
 * @author silver.ibenye
 *
 */
class StreetMapper
{
    /**
     *
     * @param array $streets
     * @return \App\Models\Geography\Street
     */
    public function map($streets)
    {
        $streetObjs = [];

        foreach ($streets as $street) {
            $streetObj = new Street();

            $streetObj->streetName = array_key_exists('name', $street) ? $street['name'] : NULL;
            $streetObj->urbanAreaSlug = array_key_exists('urbanAreaSlug', $street) ? $street['urbanAreaSlug'] : NULL;
            $streetObj->urbanAreaName = array_key_exists('urbanAreaName', $street) ? $street['urbanAreaName'] : NULL;
            $streetObj->urbanTownName = array_key_exists('urbanTownName', $street) ? $street['urbanTownName'] : NULL;
            $streetObj->stateName = array_key_exists('stateName', $street) ? $street['stateName'] : NULL;
            $streetObj->stateCode = array_key_exists('stateCode', $street) ? $street['stateCode'] : NULL;
            $streetObj->stateSlug = array_key_exists('stateSlug', $street) ? $street['stateSlug'] : NULL;
            $streetObj->postcode = array_key_exists('postcode', $street) ? $street['postcode'] : [];

            $streetObjs[] = $streetObj;
        }
        
        return $streetObjs;
    }
}

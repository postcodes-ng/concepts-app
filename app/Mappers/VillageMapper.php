<?php
namespace App\Mappers;

use App\Models\Geography\village;

/**
 *
 * @author silver.ibenye
 *
 */
class VillageMapper
{
    /**
     *
     * @param array $villages
     * @return \App\Models\Geography\Village
     */
    public function map($villages)
    {
        $villageObjs = [];

        foreach ($villages as $village) {
            $villageObj = new Village();

            $villageObj->villageName = array_key_exists('name', $village) ? $village['name'] : NULL;
            $villageObj->ruralAreaSlug = array_key_exists('ruralAreaSlug', $village) ? $village['ruralAreaSlug'] : NULL;
            $villageObj->ruralAreaName = array_key_exists('ruralAreaName', $village) ? $village['ruralAreaName'] : NULL;
            $villageObj->lgaSlug = array_key_exists('lgaSlug', $village) ? $village['lgaSlug'] : NULL;
            $villageObj->lgaName = array_key_exists('lgaName', $village) ? $village['lgaName'] : NULL;
            $villageObj->stateName = array_key_exists('stateName', $village) ? $village['stateName'] : NULL;
            $villageObj->stateCode = array_key_exists('stateCode', $village) ? $village['stateCode'] : NULL;
            $villageObj->stateSlug = array_key_exists('stateSlug', $village) ? $village['stateSlug'] : NULL;
            $villageObj->postcode = array_key_exists('postcode', $village) ? $village['postcode'] : [];

            $villageObjs[] = $villageObj;
        }
        
        return $villageObjs;
    }
}

<?php
namespace App\Mappers;

use App\Models\Geography\LocalGovernmentArea;

/**
 *
 * @author silver.ibenye
 *
 */
class LGAMapper
{
    /**
     *
     * @param array $lgas
     * @return \App\Models\Geography\LocalGovernmentArea
     */
    public function map($lgas)
    {
        $lgaObjs = [];

        foreach ($lgas as $lga) {
            $lgaObj = new LocalGovernmentArea();

            $lgaObj->lgaSlug = array_key_exists('slug', $lga) ? $lga['slug'] : NULL;
            $lgaObj->lgaName = array_key_exists('name', $lga) ? $lga['name'] : NULL;
            $lgaObj->stateName = array_key_exists('stateName', $lga) ? $lga['stateName'] : NULL;
            $lgaObj->stateCode = array_key_exists('stateCode', $lga) ? $lga['stateCode'] : NULL;
            $lgaObj->stateSlug = array_key_exists('stateSlug', $lga) ? $lga['stateSlug'] : NULL;

            $lgaObjs[] = $lgaObj;
        }

        return $lgaObjs;

    }
}

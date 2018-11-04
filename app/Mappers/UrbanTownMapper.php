<?php
namespace App\Mappers;

use App\Models\Geography\UrbanTown;

/**
 *
 * @author silver.ibenye
 *
 */
class UrbanTownMapper
{
    /**
     *
     * @param array $urbanTowns
     * @return \App\Models\Geography\UrbanTown
     */
    public function map($urbanTowns)
    {
        $urbanTownObjs = [];

        foreach ($urbanTowns as $urbanTown) {
            $urbanTownObj = new UrbanTown();

            $urbanTownObj->urbanTownSlug = array_key_exists('slug', $urbanTown) ? $urbanTown['slug'] : NULL;
            $urbanTownObj->urbanTownName = array_key_exists('name', $urbanTown) ? $urbanTown['name'] : NULL;
            $urbanTownObj->lgaSlug = array_key_exists('lgaSlug', $urbanTown) ? $urbanTown['lgaSlug'] : NULL;
            $urbanTownObj->lgaName = array_key_exists('lgaName', $urbanTown) ? $urbanTown['lgaName'] : NULL;
            $urbanTownObj->stateName = array_key_exists('stateName', $urbanTown) ? $urbanTown['stateName'] : NULL;
            $urbanTownObj->stateCode = array_key_exists('stateCode', $urbanTown) ? $urbanTown['stateCode'] : NULL;
            $urbanTownObj->stateSlug = array_key_exists('stateSlug', $urbanTown) ? $urbanTown['stateSlug'] : NULL;

            $urbanTownObjs[] = $urbanTownObj;
        }
        

        return $urbanTownObjs;
    }

}

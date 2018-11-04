<?php
namespace App\Mappers;

use App\Models\Geography\UrbanArea;

/**
 *
 * @author silver.ibenye
 *
 */
class UrbanAreaMapper
{
    /**
     *
     * @param array $urbanAreas
     * @return \App\Models\Geography\UrbanArea
     */
    public function map($urbanAreas)
    {
        $urbanAreaObjs = [];

        foreach ($urbanAreas as $urbanArea) {
            $urbanAreaObj = new UrbanArea();

            $urbanAreaObj->urbanAreaSlug = array_key_exists('slug', $urbanArea) ? $urbanArea['slug'] : NULL;
            $urbanAreaObj->urbanAreaName = array_key_exists('name', $urbanArea) ? $urbanArea['name'] : NULL;
            $urbanAreaObj->urbanTownSlug = array_key_exists('urbanTownSlug', $urbanArea) ? $urbanArea['urbanTownSlug'] : NULL;
            $urbanAreaObj->urbanTownName = array_key_exists('urbanTownName', $urbanArea) ? $urbanArea['urbanTownName'] : NULL;
            $urbanAreaObj->stateName = array_key_exists('stateName', $urbanArea) ? $urbanArea['stateName'] : NULL;
            $urbanAreaObj->stateCode = array_key_exists('stateCode', $urbanArea) ? $urbanArea['stateCode'] : NULL;
            $urbanAreaObj->stateSlug = array_key_exists('stateSlug', $urbanArea) ? $urbanArea['stateSlug'] : NULL;
            $urbanAreaObj->postcodes = array_key_exists('postcodes', $urbanArea) ? $urbanArea['postcodes'] : [];

            $urbanAreaObjs[] = $urbanAreaObj;
        }
        
        return $urbanAreaObjs;
    }
}

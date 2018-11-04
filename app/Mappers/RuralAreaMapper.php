<?php
namespace App\Mappers;

use App\Models\Geography\RuralArea;

/**
 *
 * @author silver.ibenye
 *
 */
class RuralAreaMapper
{
    /**
     *
     * @param array $ruralAreas
     * @return \App\Models\Geography\RuralArea
     */
    public function map($ruralAreas)
    {
        $ruralAreaObjs = [];

        foreach ($ruralAreas as $ruralArea) {
            $ruralAreaObj = new RuralArea();

            $ruralAreaObj->ruralAreaSlug = array_key_exists('slug', $ruralArea) ? $ruralArea['slug'] : NULL;
            $ruralAreaObj->ruralAreaName = array_key_exists('name', $ruralArea) ? $ruralArea['name'] : NULL;
            $ruralAreaObj->lgaSlug = array_key_exists('lgaSlug', $ruralArea) ? $ruralArea['lgaSlug'] : NULL;
            $ruralAreaObj->lgaName = array_key_exists('lgaName', $ruralArea) ? $ruralArea['lgaName'] : NULL;
            $ruralAreaObj->stateName = array_key_exists('stateName', $ruralArea) ? $ruralArea['stateName'] : NULL;
            $ruralAreaObj->stateCode = array_key_exists('stateCode', $ruralArea) ? $ruralArea['stateCode'] : NULL;
            $ruralAreaObj->stateSlug = array_key_exists('stateSlug', $ruralArea) ? $ruralArea['stateSlug'] : NULL;
            $ruralAreaObj->postcodes = array_key_exists('postcodes', $ruralArea) ? $ruralArea['postcodes'] : [];

            $ruralAreaObjs[] = $ruralAreaObj;
        }
        
        return $ruralAreaObjs;
    }
}

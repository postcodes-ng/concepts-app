<?php
namespace App\Mappers;

use App\Models\Geography\Facility;

/**
 *
 * @author silver.ibenye
 *
 */
class FacilityMapper
{
    /**
     *
     * @param array $facilities
     * @return \App\Models\Geography\Facility
     */
    public function map($facilities)
    {
        $facilityObjs = [];

        foreach ($facilities as $facility) {
            $facilityObj = new Facility();

            $facilityObj->facilityName = array_key_exists('name', $facility) ? $facility['name'] : NULL;
            $facilityObj->facilityType = array_key_exists('facilityType', $facility) ? $facility['facilityType'] : NULL;
            $facilityObj->street = array_key_exists('street', $facility) ? $facility['street'] : NULL;
            $facilityObj->area = array_key_exists('area', $facility) ? $facility['area'] : NULL;
            $facilityObj->town = array_key_exists('town', $facility) ? $facility['town'] : NULL;
            $facilityObj->lgaSlug = array_key_exists('lgaSlug', $facility) ? $facility['lgaSlug'] : NULL;
            $facilityObj->lgaName = array_key_exists('lgaName', $facility) ? $facility['lgaName'] : NULL;
            $facilityObj->stateName = array_key_exists('stateName', $facility) ? $facility['stateName'] : NULL;
            $facilityObj->stateCode = array_key_exists('stateCode', $facility) ? $facility['stateCode'] : NULL;
            $facilityObj->stateSlug = array_key_exists('stateSlug', $facility) ? $facility['stateSlug'] : NULL;
            $facilityObj->postcode = array_key_exists('postcode', $facility) ? $facility['postcode'] : NULL;
            $facilityObj->rangeOfPMB = array_key_exists('rangeOfPMB', $facility) ? $facility['rangeOfPMB'] : NULL;
            $facilityObj->rangeOfPOB = array_key_exists('rangeOfPOB', $facility) ? $facility['rangeOfPOB'] : NULL;

            $facilityObjs[] = $facilityObj;
        }
        
        return $facilityObjs;
    }
}

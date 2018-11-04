<?php
namespace App\Mappers;

use App\Models\Geography\State;

/**
 *
 * @author silver.ibenye
 *
 */
class StateMapper
{
    /**
     *
     * @param array $states
     * @return \App\Models\Geography\State
     */
    public function map($states)
    {
        $stateObjs = [];

        foreach ($states as $state) {
            $stateObj = new State();

            $stateObj->stateSlug = array_key_exists('slug', $state) ? $state['slug'] : NULL;
            $stateObj->stateName = array_key_exists('name', $state) ? $state['name'] : NULL;
            $stateObj->stateCode = array_key_exists('code', $state) ? $state['code'] : NULL;
            $stateObj->stateCapital = array_key_exists('capital', $state) ? $state['capital'] : NULL;
            $stateObj->stateRegion = array_key_exists('region', $state) ? $state['region'] : NULL;

            $stateObjs[] = $stateObj;
        }
        
        return $stateObjs;
    }
}

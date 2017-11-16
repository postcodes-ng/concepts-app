<?php
namespace App\Services;

use App\Utilities\PostcodeApiWrapper;
use App\Utilities\CommonFunctions;

class SearchService
{
    /**
     * @var PostcodeApiWrapper
     */
    private $postcodeApiWrapper;

    /**
     * @var CommonFunctions
     */
    private $commonFunctions;

    public function __construct(PostcodeApiWrapper $postcodeApiWrapper, CommonFunctions $commonFunctions)
    {
        $this->postcodeApiWrapper = $postcodeApiWrapper;
        $this->commonFunctions = $commonFunctions;
    }

    public function streetSearch($streetNameHint) {
        $streetResponse = $this->postcodeApiWrapper->searchByStreetName($streetNameHint);

        $responseArray = [];

        if (array_key_exists('error', $streetResponse)) {
            return $responseArray;
        }

        foreach ($streetResponse as $data) {
            if (empty($data['urbanStreetName'])
                    || $data['urbanStreetName'] == ' ') {
                        continue;
                    }
            $data['urbanStreetName'] = $this->cleanupStreetName($data['urbanStreetName']);
            $data['urbanAreaName'] = $this->cleanupAreaName($data['urbanAreaName']);
            $responseArray[] = $data;
        }

        return $responseArray;
    }

    public function postcodeSearch($postcode) {
        $reverseLookupResponse = $this->postcodeApiWrapper->searchByPostcode($postcode);

        if (array_key_exists('error', $reverseLookupResponse)) {
            return [];
        }

        return $reverseLookupResponse;
    }

    private function cleanupStreetName($street) {
        $street = trim($street);

        if ($this->commonFunctions->endsWith($street, ' St.')) {
            $street = str_ireplace(' ST.', ' Street', $street);
        } else if ($this->commonFunctions->endsWith($street, ' St. St.')) {
            $street = str_ireplace(' ST. ST.', ' Street', $street);
        } else if ($this->commonFunctions->endsWith($street, ' St St.')) {
            $street = str_ireplace(' ST ST.', ' Street', $street);
        } else if ($this->commonFunctions->endsWith($street, ' Street St.')) {
            $street = str_ireplace(' Street ST.', ' Street', $street);
        } else if ($this->commonFunctions->endsWith($street, ' Rd.')) {
            $street = str_ireplace(' Rd.', ' Road', $street);
        }

        return $street;
    }

    private function cleanupAreaName($area) {
        $area = trim($area);

        $area = $area . ' AREA';

        return $area;
    }

}
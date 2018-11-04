<?php
namespace App\Models\Geography;

use GuzzleHttp\Psr7\Stream;

class LocalGovernmentArea
{
    /**
     *
     * @var string
     */
    public $lgaSlug;

    /**
     *
     * @var string
     */
    public $lgaName;

    /**
     *
     * @var string
     */
    public $stateCode;

    /**
     *
     * @var string
     */
    public $stateName;

    /**
     *
     * @var string
     */
    public $stateSlug;
}

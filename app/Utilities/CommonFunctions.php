<?php
namespace App\Utilities;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CommonFunctions {

    public function startswith($haystack, $needle) {
        $haystack = strtolower($haystack);
        $needle = strtolower($needle);

        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    public function endsWith($haystack, $needle) {
        $haystack = strtolower($haystack);
        $needle = strtolower($needle);

        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Build the cacheKey.
     */
    public function getCacheKey($endpoint, $params) {
        $cacheKey = $endpoint;

        foreach ($params as $key => $value) {
            $key = str_replace(' ', '', strtolower($key));
            $value = str_replace(' ', '', strtolower($value));
            $keyValue = $key . '_' . $value;
            $cacheKey = $cacheKey . '|' . $keyValue;
        }

        return $cacheKey;
    }

    public function retrieveFromCache($cacheKey) {
        $value = null;
        if (Cache::has($cacheKey)) {
            $value = Cache::get($cacheKey);
            Log::info('CACHE HIT: ' . $cacheKey);
        } else {
            Log::info('CACHE MISS: ' . $cacheKey);
        }

        return $value;
    }

    public function storeInCache($cacheKey, $item) {
        $expirationInSeconds = Config::get('app.cache_ttl');
        Cache::put($cacheKey, $item, $expirationInSeconds);
    }

    /**
     * Decodes a json object.
     *
     * @param string $string The string to decode.
     *
     * @return associative array.
     * @throws \Exception Response is not a valid JSON string.
     */
    public function convertToAssociativeArray($string)
    {
        $responseArray = json_decode($string, true);

        return $responseArray;
    }
}

<?php

namespace App\Http\Helpers;

use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Builder;

class AjaxHelper {
    public static function generateWebJWT() {
        return static::buildJWT('http://www.postcodes.ng', 'http://www.postcodes.ng/api', 3600);
    }

    public static function generateAPIJWT() {
        return static::buildJWT('http://www.postcodes.ng/api', 'http://www.postcodes.ng/api', 20);
    }

    public static function validateJWT($jwtTokenString, $type) {
        $jwtSecret = config('auth.jwt_secret');
        $jwtId = config('auth.jwt_id');
        $jwtIssuer = $type == 'web' ? 'http://www.postcodes.ng' : 'http://www.postcodes.ng/api';
        $jwtAudience = 'http://www.postcodes.ng/api';

        $token = (new Parser())->parse((string) $jwtTokenString);

        # ensure the jwt token isn't expired
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($jwtIssuer );
        $data->setAudience($jwtAudience);
        $data->setId($jwtId);

        if (!$token->validate($data)) {
            return false;
        }

        # verify the jwt signature
        $signer = new Sha256();
        if (!$token->verify($signer, $jwtSecret)) {
            return false;
        }

        return true;
    }

    public static function formatAjaxResponse($response) {
        $originalContent = $response->getOriginalContent();

        if (is_array($originalContent) && array_key_exists('error', $originalContent)) {
            return response()->json(
                    [
                            'status' => 'error',
                            'message' => $originalContent ['error'],
                            'response' => NULL
                    ], $response->status() === 200 ? 400 : $response->status());
        } else if (is_array($originalContent)) {
            return response()->json(
                    [
                            'status' => 'success',
                            'message' => NULL,
                            'response' => $originalContent
                    ], 200);
        } else {
            return $response;
        }
    }

    private static function buildJWT($issuer, $audience, $expireInSeconds) {
        $signer = new Sha256();

        $jwtSecret = config('auth.jwt_secret');
        $jwtId = config('auth.jwt_id');

        $token = (new Builder())->setIssuer($issuer) // Configures the issuer (iss claim)
                                ->setAudience($audience) // Configures the audience (aud claim)
                                ->setId($jwtId, true) // Configures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                                ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + $expireInSeconds) // Configures the expiration time of the token (exp claim)
                                ->sign($signer, $jwtSecret) // creates a signature using the secret as key
                                ->getToken(); // Retrieves the generated token
        
        return $token;
    }
}
<?php

namespace AccountBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher;

/**
 * Description of VerifyTokenService
 *
 * @author Steve-KOUNA
 */
class VerifyTokenService {
    public function tokenTest($token, $uri) {

        $curl = curl_init();

        $headers = [
            "cache-control: no-cache",
            "content-type: application/json",
            "Authorization: Bearer " . $token
        ];

        $opts = [
            CURLOPT_URL => $uri . "/admin/account",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ];

        curl_setopt_array($curl, $opts);
        $result = curl_exec($curl);
        $response = json_decode($result);
        
        curl_close($curl);
//        dump(json_decode($result, true));die;
        if ((isset($response->{'code'}) && $response->{'code'} == 403) || (isset($response->{'error'})) ) {
            $session->clear();
            return false;
        }
        
        return true;
    }
}

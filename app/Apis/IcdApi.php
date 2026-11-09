<?php

namespace App\Apis;

use GuzzleHttp\Client;

class IcdApi
{
    private function getAccessToken($clientId, $clientSecret) {
        $client = new Client();

        $response = $client->post('https://icdaccessmanagement.who.int/connect/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ],
        ]);

        return json_decode($response->getBody(), true)['access_token'];
    }

    private function fetchICDData($accessToken, $entityUri) {
        $client = new Client();

        $response = $client->get($entityUri, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'API-Version' => 'v2',
                'Accept' => 'application/json',
                'Accept-Language' => 'es',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getICDData()
    {
        $clientId = config('services.icd.client_id');
        $clientSecret = config('services.icd.client_secret');
        $entityUri = 'https://id.who.int/icd/entity/search?q=colico';

        try {
            $accessToken = $this->getAccessToken($clientId, $clientSecret);
            $icdData = $this->fetchICDData($accessToken, $entityUri);

            dd($icdData);
        } catch (\Throwable $error) {
            dd("Error: " . $error->getMessage());
        }
    }
}

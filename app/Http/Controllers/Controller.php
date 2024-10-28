<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Session;

abstract class Controller
{
    protected function sendRequest($method, $url, $postField = null, $requiresAuth = false)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        if ($requiresAuth) {
            $headers['Authorization'] = 'Bearer ' . Session::get('token');
        }
        $request = new Request($method, env("URL_API") . $url, $headers);
        try {
            $res = $client->sendAsync($request, [
                'json' => $postField,
                'timeout' => 0,
                'http_errors' => false,
                'allow_redirects' => [
                    'max' => 10,
                    'strict' => true,
                    'referer' => false,
                    'protocols' => ['http', 'https'],
                ]
            ])->wait();
            return json_decode($res->getBody(), true);
        } catch (RequestException $e) {
            return [
                'status' => false,
                'message' => 'Request failed',
                'errors' => $e->hasResponse() ? json_decode($e->getResponse()->getBody(), true)['errors'] ?? 'Unknown error' : 'No response from server'
            ];
        }
    }

    public function GET($url, $postField)
    {
        return $this->sendRequest('GET', $url, $postField, true);
    }

    public function GETNOTLOGIN($url, $postField)
    {
        return $this->sendRequest('GET', $url, $postField, false);
    }

    public function POSTLOGIN($url, $postField)
    {
        return $this->sendRequest('POST', $url, $postField, false);
    }

    public function POST($url, $postField)
    {
        return $this->sendRequest('POST', $url, $postField, true);
    }

    public function PATCH($url, $postField)
    {
        return $this->sendRequest('PATCH', $url, $postField, true);
    }

    public function DELETE($url)
    {
        return $this->sendRequest('DELETE', $url, null, true);
    }
}

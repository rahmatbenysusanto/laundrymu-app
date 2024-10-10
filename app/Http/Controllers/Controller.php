<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Session;

abstract class Controller
{
    public function GET($url, $postField)
    {
        $client = new Client();

        $request = new Request('GET', env("URL_API") . $url, [
            'Authorization' => 'Bearer ' . Session::get('token'),
            'Content-Type'  => 'application/json'
        ]);

        $res = $client->sendAsync($request, [
            'json'      => $postField,
            'timeout'   => 0,
            'http_errors' => false,
            'allow_redirects' => [
                'max'       => 10,
                'strict'    => true,
                'referer'   => false,
                'protocols' => ['http', 'https'],
            ]
        ])->wait();

        return json_decode($res->getBody());
    }

    public function GETNOTLOGIN($url, $postField)
    {
        $client = new Client();

        $request = new Request('GET', env("URL_API") . $url, [
            'Content-Type'  => 'application/json'
        ]);

        $res = $client->sendAsync($request, [
            'json' => $postField,
            'timeout' => 0,
            'allow_redirects' => [
                'max' => 10,
                'strict' => true,
                'referer' => false,
                'protocols' => ['http', 'https'],
            ]
        ])->wait();

        return json_decode($res->getBody());
    }

    public function POSTLOGIN($url, $postField)
    {
        $client = new Client();

        $request = new Request('POST', env("URL_API") . $url, [
            'Content-Type' => 'application/json'
        ]);

        $res = $client->sendAsync($request, [
            'json' => $postField,
            'timeout' => 0,
            'allow_redirects' => [
                'max' => 10,
                'strict' => true,
                'referer' => false,
                'protocols' => ['http', 'https'],
            ]
        ])->wait();

        return json_decode($res->getBody());
    }

    public function POST($url, $postField)
    {
        $client = new Client();

        $request = new Request('POST', env("URL_API") . $url, [
            'Authorization' => 'Bearer ' . Session::get('token'),
            'Content-Type'  => 'application/json'
        ]);

        $res = $client->sendAsync($request, [
            'json'      => $postField,
            'timeout'   => 0,
            'http_errors' => false,
            'allow_redirects' => [
                'max'       => 10,
                'strict'    => true,
                'referer'   => false,
                'protocols' => ['http', 'https'],
            ]
        ])->wait();

        return json_decode($res->getBody());
    }

    public function PATCH($url, $postField)
    {
        $client = new Client();

        $request = new Request('PATCH', env("URL_API") . $url, [
            'Authorization' => 'Bearer ' . Session::get('token'),
            'Content-Type'  => 'application/json'
        ]);

        $res = $client->sendAsync($request, [
            'json'      => $postField,
            'timeout'   => 0,
            'http_errors' => false,
            'allow_redirects' => [
                'max'       => 10,
                'strict'    => true,
                'referer'   => false,
                'protocols' => ['http', 'https'],
            ]
        ])->wait();

        return json_decode($res->getBody());
    }

    public function DELETE($url)
    {
        $client = new Client();

        $request = new Request('DELETE', env("URL_API") . $url, [
            'Authorization' => 'Bearer ' . Session::get('token'),
            'Content-Type'  => 'application/json'
        ]);

        $res = $client->sendAsync($request, [
            'timeout' => 0,
            'allow_redirects' => [
                'max' => 10,
                'strict' => true,
                'referer' => false,
                'protocols' => ['http', 'https'],
            ]
        ])->wait();

        return json_decode($res->getBody());
    }
}

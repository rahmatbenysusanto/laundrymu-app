<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

abstract class Controller
{
    private function request($method, $url, $postField = null, $withAuth = true)
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => env("URL_API") . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ];

        if ($withAuth) {
            $options[CURLOPT_HTTPHEADER] = [
                'Authorization: Bearer ' . Session::get('token'),
                'Content-Type: application/json',
            ];
        } else {
            $options[CURLOPT_HTTPHEADER] = [
                'Content-Type: application/json',
            ];
        }

        switch (strtoupper($method)) {
            case 'GET':
                // No need to set a body for GET requests
                break;

            case 'POST':
            case 'PATCH':
                $options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
                $options[CURLOPT_POSTFIELDS] = json_encode($postField);
                break;

            case 'DELETE':
                $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                break;

            default:
                throw new \InvalidArgumentException('Invalid request method');
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            // Handle error
            $errorMessage = curl_error($ch);
            curl_close($ch);
            return ['error' => $errorMessage];
        }

        curl_close($ch);
        return json_decode($response);
    }

    public function GET($url, $postField)
    {
        return $this->request('GET', $url, $postField);
    }

    public function GETNOTLOGIN($url, $postField)
    {
        return $this->request('GET', $url, $postField, false);
    }

    public function POSTLOGIN($url, $postField)
    {
        return $this->request('POST', $url, $postField, false);
    }

    public function POST($url, $postField)
    {
        return $this->request('POST', $url, $postField);
    }

    public function PATCH($url, $postField)
    {
        return $this->request('PATCH', $url, $postField);
    }

    public function DELETE($url)
    {
        return $this->request('DELETE', $url);
    }
}

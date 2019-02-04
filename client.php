<?php
require_once('OAuthRequest.php');
require_once('OAuthSignatureMethod_HMAC_SHA1.php');

class Client
{
    private $consumer;

    /**
     *
     */
    public function __construct($consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     *
     */
    public function post($url, $params = [])
    {
        $oauth = $this->getOauth($url, 'POST', $params);

        // echo "\n****************\n";
        // echo $post_data;
        // echo "\n****************\n";

        $post_data = $oauth->to_postdata();
        $params = $oauth->get_parameters();
        // var_dump($params);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     *
     */
    public function getOauth($url, $method, $params)
    {
        $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

        $auth_params = [
            'oauth_timestamp'        => $this->generateTimestamp(),
            'oauth_nonce'            => $this->generateNonce(),
            'oauth_consumer_key'     => $this->consumer->key256,
            'oauth_consumer_secret'  => $this->consumer->secret,
            'oauth_signature_method' => 'HMAC-SHA1',
        ];

        $params = array_merge($params, $auth_params);

        $oauth = new OAuthRequest($method, $url, $params);
        $oauth->sign_request($signature_method, $this->consumer, null);

        return $oauth;
    }

    /**
     * util function: current timestamp
     */
    private function generateTimestamp() {
        return time();
    }

    /**
     * util function: current nonce
     */
    private function generateNonce() {
        $mt = microtime();
        $rand = mt_rand();

        return md5($mt . $rand); // md5s look nicer than numbers
    }
}

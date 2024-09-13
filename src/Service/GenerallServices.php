<?php

namespace App\Service;

use App\Utils\Helper;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GenerallServices
{

    private $SUYOOL_API_HOST;
    private $NOTIFICATION_SUYOOL_HOST;
    private $client;
    private $merchantAccountID;
    private $hash_algo;
    private $winning;
    private $cashout;
    private $cashin;
    private $METHOD_POST = "POST";
    private $METHOD_GET = "GET";
    private $helper;
    private $userlog;

    public function __construct()
    {
        $this->hash_algo = $_ENV['ALGO'];
       
    }


    public static function decrypt($stringToDecrypt)
    {
        $decrypted_string = openssl_decrypt($stringToDecrypt, $_ENV['CIPHER_ALGORITHME'], $_ENV['DECRYPT_KEY'], 0, $_ENV['INITIALLIZATION_VECTOR']);
        return $decrypted_string;
    }

    public static function decryptWebKey($webkey)
    {
        $webkey = $webkey['authorization'] ?? $webkey['Authorization'] ?? null;
        $webkeyDecrypted = openssl_decrypt($webkey, $_ENV['CIPHER_ALGORITHME'], $_ENV['DECRYPT_KEY'], 0, $_ENV['INITIALLIZATION_VECTOR']);
        // dd($webkeyDecrypted);
        try {
            $webkeyParts = explode('!#!', $webkeyDecrypted);
            $webkeyArray = [
                'merchantId' => $webkeyParts[0],
                'devicesType' => $webkeyParts[1],
                'lang' => $webkeyParts[2],
                'timestamp' => $webkeyParts[3],
                'message' => 'Success',
            ];
        } catch (Exception $e) {
            $webkeyArray = [
                'merchantId' => null,
                'devicesType' => null,
                'lang' => null,
                'timestamp' => null,
                'message' => 'Failed to decrypt webkey',
            ];
        }

        return $webkeyArray;
    }

    public static function aesDecryptString($base64StringToDecrypt)
    {
        // $decryptedData = openssl_decrypt($base64StringToDecrypt, 'AES128', "hdjs812k389dksd5", 0, $_ENV['INITIALLIZATION_VECTOR']);
        // return $decryptedData;
        try {
            $passphraseBytes = utf8_encode("hdjs812k389dksd5");
            $decryptedData = openssl_decrypt($base64StringToDecrypt, 'AES128', $passphraseBytes, 0, $_ENV['INITIALLIZATION_VECTOR']);

            return $decryptedData;
        } catch (Exception $e) {
            return $base64StringToDecrypt;
        }
    }

}

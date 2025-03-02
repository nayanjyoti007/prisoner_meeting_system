<?php


namespace App\Helper;


class SMSSendHelp
{


//    private static $api = "NTc2YjRlNzIzNTQ5NGI0ZDcyMzc2ODc0NjU0ODYxNGM=";
//    private static $sender = "ASSEDM";

    private static $api = "NTc2YjRlNzIzNTQ5NGI0ZDcyMzc2ODc0NjU0ODYxNGM=";
    private static $sender = "MSIQES";

    private static $api2 = "NTc2YjRlNzIzNTQ5NGI0ZDcyMzc2ODc0NjU0ODYxNGM=";
    private static $sender2 = "ASSEDM";

    private static $profileid = "20081130";
    private static $pwd = "exam@2024";
    private static $senderid = "ASSEBB";


    public static function sendMessage($message, $number)
    {


        $message = urlencode($message);

        $data = "apikey=" . self::$api . "&message=" . $message . "&sender=" . self::$sender . "&numbers=" . $number;
        $ch = curl_init('https://control.textlocal.in/api2/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        curl_close($ch);
    }


    public static function generateRandomOTP($length)
    {
        return substr(str_shuffle("0123456789"), 0, $length);

    }

    public static function ahsecSendMessage($message, $number)
    {
        $profileid = self::$profileid;
        $pwd = self::$pwd;
        $senderid = self::$senderid;

        $url = "http://bulksmspune.mobi/sendurlcomma.aspx";

        $params = [
            'user' => $profileid,
            'pwd' => $pwd,
            'senderid' => $senderid,
            'CountryCode' => '91',
            'mobileno' => $number,
            'msgtext' => $message,
        ];

        $fullUrl = $url . '?' . http_build_query($params);
        $rtr = "http://bulksmspune.mobi/sendurlcomma.aspx?user=$profileid&pwd=$pwd&senderid=$senderid&CountryCode=91&mobileno=9101067303&msgtext=$message";

        $ch = curl_init($fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            curl_close($ch);
            die("Error occurred during cURL execution: $error_message");
        }
        curl_close($ch);

    }


}

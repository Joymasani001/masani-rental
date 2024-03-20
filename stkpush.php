<?php

// INCLUDE THE ACCESS TOKEN FILE
include 'accessToken.php';
include 'dbcon.php'; 

// CONSTANTS
$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$callbackurl = 'http://verbally-full-kiwi.ngrok-free.app/rental/callback.php'; 
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = '174379';
$phone = $_GET['contact']; // phone number to receive the stk push
$money = '1';
$PartyA = $phone;
$PartyB = '254708374149';
$AccountReference = 'Rental booking system';
$TransactionDesc = 'stkpush test';
$Amount = $money;

// TIMESTAMP
$Timestamp = date('YmdHis');
date_default_timezone_set('Africa/Nairobi');

// ENCRYPT DATA TO GET PASSWORD
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

// INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $callbackurl,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc,
]));

// EXECUTE CURL REQUEST
$curl_response = curl_exec($curl);

// HANDLE RESPONSE
$data = json_decode($curl_response);
$CheckoutRequestID = $data->CheckoutRequestID;
$ResponseCode = $data->ResponseCode;

// ECHO RESPONSE
if ($ResponseCode == "0") {
    echo "The transaction is being processed... ";
} else {
    echo "Error: " . $ResponseCode . " - " . $data->errorMessage;
}

// CLOSE CURL
curl_close($curl);
?>
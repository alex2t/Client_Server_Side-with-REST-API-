<?php
session_start();
include("access_token.php");

$data = '{
    "intent": "CAPTURE",
    "purchase_units": [
        {
            "reference_id": "1",
            "amount": {
                "currency_code": "EUR",
                "value": "11.00",
                "breakdown": {
                    "item_total": {
                        "currency_code": "EUR",
                        "value": "10.00"
                    },
                    "shipping": {
                        "currency_code": "EUR",
                        "value": "1.00"
                    }
                }
            },
            "items": [
                {
                    "name": "box",
                    "quantity": "1",
                    "unit_amount": {
                        "currency_code": "EUR",
                        "value": "10.00"
                    }
                }
            ],
            "shipping": {
                "name": {
                    "full_name": "herbert lawn"
                },
                "address": {
                    "address_line_1": "my street 1",
                    "admin_area_1": "my state",
                    "admin_area_2": "my town",
                    "postal_code": "12345678",
                    "country_code": "GB"
                }
            },
            "description": "Payment for order",
            "custom_id": "1234567890"
        }
    ]
    
}';


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v2/checkout/orders",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HEADER => false,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "prefer:return=representation",
    "Authorization: Bearer " . $_SESSION['access_token']
  ),
  CURLOPT_POSTFIELDS => $data)
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "<pre>cURL Error #:" . $err . "</pre>";
  echo $httpcode . $response;

}else{
//   $response = json_decode($response);
  echo json_encode($response);
//   $orderId= $response->id ;
  
//   $_SESSION['orderId'] = $orderId;
//     $orderId= $response->id ;
//   echo $orderId;
  

}        



  
  




<?php
session_start();


// $id = $_POST["orderId"];
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
//   //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

  $id = json_decode($content, true);
  // var_dump($id);
  // echo gettype($id);
  

  // //If json_decode failed, the JSON is invalid.
if(! is_array($id)) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.sandbox.paypal.com/v2/checkout/orders/" . $id . "/capture",
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
      //CURLOPT_POSTFIELDS => $data
      )
    );
  
     $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if ($err) {
    echo "<pre>cURL Error #:" . $err . "</pre>";
    echo $httpcode . $response;
    }
    else{
    //$response = json_decode($response);
    echo json_encode($response);
    // echo "<pre>";
    // print_r($response);
   }
  
} //If json_decode failed, the JSON is invalid.
  else {
    // Send error back to user.
    echo 'error';
  }

}
// ?>

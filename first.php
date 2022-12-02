<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// Used for composer based installation
require __DIR__  . '/vendor/autoload.php';
// Use below for direct download installation
// require __DIR__  . '/PayPal-PHP-SDK/autoload.php';

// // After Step 1 플랫폼 
// $apiContext = new \PayPal\Rest\ApiContext(
//   new \PayPal\Auth\OAuthTokenCredential(
//       'AUnmLatjym_DdaZnWYLC2mn0daHBwRlpBV__0OihKwScrnH3qIiGong9LAWnW_yfNRlbyF7mwWeXwV6X',     // ClientID
//       'EMVOpM2wrXhUueAN1VVUjBuj4Cb0lwzBV0tzlT423_lViDWQG5enyIL4jH6SduW4xjlta9fxvUW5ng4E'      // ClientSecret
//   )
// );

// After Step 1 개인 셀러  clientID, ClientSecret 
$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
      'AYn6jGB2gnqW4GfGEop2fypxsga8CeOYYR_S1AFaljE3pMde51CyMRsS5ywUKW0jbBZniVpSQGhGdw4m',     // ClientID
      'EHtEIMBdkGpFKTu-V_46N67_tZceaTIgB9ZeO0vIX3BFosMjG4TYxRKPQCXI8LMIpo6V182s7uDw6XER'      // ClientSecret
  )
);

// After Step 2
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal('1.00');
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl("https://example.com/your_redirect_url.html")
    ->setCancelUrl("https://example.com/your_cancel_url.html");

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);


    // After Step 3
try {
  $payment->create($apiContext);
  echo $payment;

  echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
  // This will print the detailed information on the exception.
  //REALLY HELPFUL FOR DEBUGGING
  echo $ex->getData();
}
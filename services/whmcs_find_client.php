<?php

function whmcs_find_client($userEmail){
 /**
 * WHMCS Sample API Call
 *
 * @package    WHMCS
 * @author     WHMCS Limited <development@whmcs.com>
 * @copyright  Copyright (c) WHMCS Limited 2005-2016
 * @license    http://www.whmcs.com/license/ WHMCS Eula
 * @version    $Id$
 * @link       http://www.whmcs.com/
 */

// Set post values
$postfields = array(
    'username' => $username,
    'password' => md5($password),
    'action' => 'GetClients',
    'responsetype' => 'json',
    'search'=> $userEmail,
);

// Call the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
$response = curl_exec($ch);
if (curl_error($ch)) {
    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
}
curl_close($ch);

// Decode response
$jsonData = json_decode($response);
// Dump array structure for inspection
$totalresults=$jsonData->{'totalresults'};
//var_dump($jsonData->{'clients'}->{'client'}[0]);

return $jsonData;
}
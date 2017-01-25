<?
$domain =null;
$errName=null;
$whois=null;
$status=null;

//Check if is Get and validates the variables
if (isset($_GET["domain"])) {
    $domain = $_GET["domain"];
} else {
    // Check if name has been entered
    $errName = 'Please enter the domain name';
}
		

// If there are no errors, check the domain avaialbility

if (!$errName && isset($_GET["domain"])) {

    // Get values of tlds
    foreach($_GET["check_tld"] as $tld) {

        $postfields = array(
            'username' => $username,
            'password' => md5($password),
            'action' => 'DomainWhois',
            'responsetype' => 'json',
            'domain' =>  $domain.$tld,
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
            $jsonData = json_decode($response, true);
            if ($jsonData["result"] == "success") {
                    if ($jsonData["status"] == "available") {
                        $alerts[]="
                        <div class=\"panel panel-success\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">$domain$tld $status</h3>
                            </div>
                            <div class=\"panel-body\">
                            $whois
                            </div>
                        </div>";       
                    }
                    if ($jsonData["status"]=="unavailable") {
                        $whois=$jsonData["whois"];
                        $status=$jsonData["status"];
                        $alerts[]="
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">$domain$tld $status</h3>
                            </div>
                            <div class=\"panel-body\">
                            $whois
                            </div>
                        </div>";

                        
                        //$alerts[]= '<div class="alert alert-danger">'.$domain.$tld.'==>'.$jsonData["status"].'</div>';
                        //$alerts[]= '<div class="panel panel-default"><div class="panel-body">'.$jsonData["whois"].'</div></div>';
                    } else 
                        if ($jsonData["result"] == "error") {
                            echo '<div class="alert alert-danger"> WHO IS SERVER PROBLEM PLEASE TRY LATER</div>';
                        }

            }
         
    }
}

?>
<?php
require_once __DIR__ . '/testing/assets/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
require_once __DIR__ . "/testing/configuration/configuration.php";
session_start() ;
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
<!DOCTYPE html>
<html lang="el">
    <head>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>Blank Template for Bootstrap</title>
            <!-- Bootstrap core CSS -->
            <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
            <!-- Custom styles for this template -->
            <link href="style.css" rel="stylesheet">
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        </head>
        <body>
            <div class="container">
                <nav class="navbar navbar-default" role="navigation"> 
                    <div class="container-fluid"> 
                        <div class="navbar-header"> 
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
                                <span class="sr-only">Toggle navigation</span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                            </button>                             
                            <a class="navbar-brand" href="#">Webdomains</a> 
                        </div>                         
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
                            <ul class="nav navbar-nav navbar-right"> 
                                <li class="dropdown"> 
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Σύνδεση <b class="caret"></b></a> 
                                    <ul class="dropdown-menu"> 
                                        <li>
                                            <a href="#">Εγγραφή</a>
                                        </li>                                         
                                        <li class="divider"></li>                                         
                                        <li>
                                            <li>
                                                <a href="#">Σύνδεση με Facebook </a>
                                            </li>                                             
                                            <li>
                                                <a href="#">Συνδεση με email</a>
                                            </li>                                             
                                    </ul>                                     
                                </li>
                                <li>
                                    <a href="#">Αναζήτηση</a>
                                </li>
                                <li>
                                    <a href="#">Τιμοκατάλογος</a>
                                </li>                                 
                                <li>
                                    <a href="#">Πληροφορίες</a>
                                </li>
                                <li>
                                    <a href="#">Επικοινωνία</a>
                                </li>                                 
                            </ul>                             
                        </div>                         
                    </div>                     
                </nav>
            </div>
            <div class="container">
                <legend data-pg-tree-id="1111">Αναζητηση Domain</legend>
                <form action="index.php" method="get" role="form">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="col-md-4 control-label" for="Domain" data-pg-tree-id="1112">Domain</label>                             
                        </div>
                        <div data-pg-tree-id="1115" class="col-md-6">
                            <div class="form-group" data-pg-tree-id="1116">
                                <input id="domain" name="domain" type="text" placeholder="Δωστε το Domain που θελετε να αναζητησατε" class="form-control input-md" required="" data-pg-tree-id="1113"> 
                            </div>                             
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group" data-pg-tree-id="1182">
                            <div class="col-md-2">
                                <label> 
                                    <input class="control-label" type="checkbox" value="" id="checkAll"> Επιλογή όλων Domain
                                </label>                                 
                            </div>
                            <div class="col-md-2" data-pg-tree-id="1133">
                                <div class="checkbox" data-pg-tree-id="1120">
                                    <label for="check_tld-0" data-pg-tree-id="1119">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-20" value=".com" data-pg-tree-id="1118" class="checkme">
                                        .com
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1120">
                                    <label for="check_tld-0" data-pg-tree-id="1119">
                                        <input type="checkbox" class="checkme" name="check_tld[]" id="check_tld-0" value=".gr" data-pg-tree-id="1118">
                                        .gr
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1123">
                                    <label for="check_tld-1" data-pg-tree-id="1122">
                                        <input type="checkbox" class="checkme" name="check_tld[]" id="check_tld-1" value=".com.gr" data-pg-tree-id="1121">
                                        .com.gr
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1126">
                                    <label for="check_tld-2" data-pg-tree-id="1125">
                                        <input type="checkbox" class="checkme" name="check_tld[]" id="check_tld-2" value=".net.gr" data-pg-tree-id="1124">
                                        .net.gr
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1129">
                                    <label for="check_tld-3" data-pg-tree-id="1128">
                                        <input type="checkbox" class="checkme" name="check_tld[]" id="check_tld-3" value=".org.gr" data-pg-tree-id="1127">
                                        .org.gr
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1132">
                                    <label for="check_tld-4" data-pg-tree-id="1131">
                                        <input type="checkbox" class="checkme" name="check_tld[]" id="check_tld-4" value=".edu.gr" data-pg-tree-id="1130">
                                        .edu.gr
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2" data-pg-tree-id="1149">
                                <div class="checkbox" data-pg-tree-id="1136">
                                    <label for="check_tld-5" data-pg-tree-id="1135">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-5" value=".gov.gr" data-pg-tree-id="1134" class="checkme">
                                        .gov.gr
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1139">
                                    <label for="check_tld-6" data-pg-tree-id="1138">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-6" value=".org" data-pg-tree-id="1137" class="checkme">
                                        .org
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1142">
                                    <label for="check_tld-7" data-pg-tree-id="1141">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-7" value=".eu" data-pg-tree-id="1140" class="checkme">
                                        .eu
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1145">
                                    <label for="check_tld-8" data-pg-tree-id="1144">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-8" value=".info" data-pg-tree-id="1143" class="checkme">
                                        .info
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1148">
                                    <label for="check_tld-9" data-pg-tree-id="1147">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-9" value=".net" data-pg-tree-id="1146" class="checkme">
                                        .net
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2" data-pg-tree-id="1165">
                                <div class="checkbox" data-pg-tree-id="1152">
                                    <label for="check_tld-10" data-pg-tree-id="1151">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-10" value=".tv" data-pg-tree-id="1150" class="checkme">
                                        .tv
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1155">
                                    <label for="check_tld-11" data-pg-tree-id="1154">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-11" value=".co.uk" data-pg-tree-id="1153" class="checkme">
                                        .co.uk
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1158">
                                    <label for="check_tld-12" data-pg-tree-id="1157">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-12" value=".biz" data-pg-tree-id="1156" class="checkme">
                                        .biz
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1161">
                                    <label for="check_tld-13" data-pg-tree-id="1160">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-13" value=".de" data-pg-tree-id="1159" class="checkme">
                                        .de
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1164">
                                    <label for="check_tld-14" data-pg-tree-id="1163">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-14" value=".cn" data-pg-tree-id="1162" class="checkme">
                                        .cn
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2" data-pg-tree-id="1181">
                                <div class="checkbox" data-pg-tree-id="1168">
                                    <label for="check_tld-15" data-pg-tree-id="1167">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-15" value=".solutions" data-pg-tree-id="1166" class="checkme">
                                        .solutions
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1171">
                                    <label for="check_tld-16" data-pg-tree-id="1170">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-16" value=".vacations" data-pg-tree-id="1169" class="checkme">
                                        .vacations
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1174">
                                    <label for="check_tld-17" data-pg-tree-id="1173">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-17" value=".website" data-pg-tree-id="1172" class="checkme">
                                        .website
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1177">
                                    <label for="check_tld-18" data-pg-tree-id="1176">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-18" value=".consulting" data-pg-tree-id="1175" class="checkme">
                                        .consulting
                                    </label>
                                </div>
                                <div class="checkbox" data-pg-tree-id="1180">
                                    <label for="check_tld-19" data-pg-tree-id="1179">
                                        <input type="checkbox" name="check_tld[]" id="check_tld-19" value=".deals" data-pg-tree-id="1178" class="checkme">
                                        .deals
                                    </label>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <div class="row text-center">
                        <button type="submit" class="btn btn-default">Αναζητηση</button>
                    </div>
                </form>
                <div class="row">
                    <div class="clearfix clear-columns col-md-12">
                        <section>
                            <?
                if (isset($_GET["domain"])) {
                    foreach ($alerts as $alert){
                        print ($alert);
                        }
                    }
            ?>
                        </section>                         
                    </div>
                </div>
                <div class="row">
                    <div class="clearfix clear-columns col-md-12">
                        <section>
                            <?
      $fb = new Facebook\Facebook([
  'app_id' => '255263358227641', // Replace {app-id} with your app id
  'app_secret' => 'a0c29effa1c06cf0f1094a25135b070f',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($appURL.'fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
      ?>
                        </section>
                    </div>
                </div>
            </div>
            <!-- Bootstrap core JavaScript
    ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
            <script src="assets/js/checkall.js"></script>
        </body>
</html>
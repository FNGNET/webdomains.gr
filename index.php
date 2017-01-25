<?php
session_start();
require_once __DIR__ . '/assets/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
require_once __DIR__ . '/configuration/configuration.php'; // this needs to be updated as per each site
require_once __DIR__ . '/services/domain_search.php';
require_once __DIR__ . '/services/whmcs_find_client.php';
$domain =null;
$errName=null;
$whois=null;
$status=null;
?>
<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Webdomains</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="assets/css/starter-template.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
        <!-- Custom styles for this template -->
        <link href="assets/css/style.css" rel="stylesheet">
        <!-- Optional theme -->
        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>     
    <body>
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
  'app_id' => $app_id, // Replace {app-id} with your app id
  'app_secret' => $app_secret,
  'default_graph_version' => $default_graph_version,
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><\/script>')</script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="assets/js/checkall.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>         
    </body>
</html>

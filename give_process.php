<?php
require_once 'wow.php';

# Functions
function doTorRequest ( ) {
  $reverse_client_ip = implode ( '.', array_reverse ( explode ( '.', $_SERVER['REMOTE_ADDR'] ) ) );
  $reverse_server_ip = implode ( '.', array_reverse ( explode ( '.', $_SERVER['SERVER_ADDR'] ) ) );
  $hostname          = $reverse_client_ip . "." . $_SERVER['SERVER_PORT'] . "." . $reverse_server_ip . ".ip-port.exitlist.torproject.org";
  return gethostbyname ( $hostname ) == "127.0.0.2";
} 

function doProxy ( ) {
  if ( @file_get_contents ( "http://www.shroomery.org/ythan/proxycheck.php?ip=$_SERVER[REMOTE_ADDR]" ) != "Y" ) {
    return false;
  } else {
    return true;
  }
}


# Language
switch ( $_POST['lang'] ) {
    case "fr":
        $wrongtoken   = "Token invalide. Essayez de actualiser la page.";
        $usernotfound = "Utilisateur inconnu.";
        break;
    case "tr":
        $wrongtoken   = "Yanlış belirteç. Sayfayı yenilemeyi dene.";
        $usernotfound = "Kullanıcı bulunamadı.";
        break;
    case "gr":
        $wrongtoken   = "Λάθος συμβολική. Δοκιμάστε δροσιστικό.";
        $usernotfound = "Ο χρήστης δεν βρέθηκε.";
        break;
    case "nl":
        $wrongtoken   = "Verkeerde token. Probeer verfrissend.";
        $usernotfound = "Gebruiker niet gevonden.";
        break;
    case "es":
        $wrongtoken   = "Símbolo equivocado. Trate refrescante..";
        $usernotfound = "Usuario no encontrado.";
        break;
    case "de":
        $wrongtoken   = "Falsche zeichen. Versuchen erfrischend.";
        $usernotfound = "Nicht gefunden.";
        break;
    case "jp":
        $wrongtoken   = "まちがったトークン。さわやかてみてください。";
        $usernotfound = "ユーザーがみつかりません。";
        break;
    default:
        $wrongtoken   = "Wrong token. Try refreshing.";
        $usernotfound = "User not found.";
        break; 
}

# Security Checks
if ( isset ( $_POST['token'] ) && isset ( $_POST['wow'] ) ) {

    # Sanitize variables
    $token = doSafe ( $_POST['token'] );
    $wow   = doSafe ( $_POST['wow'] );

    # Queries
    $user_query = mysqli_query ( wow ( ), "SELECT * FROM users WHERE username = '" . $wow . "' OR oldusrname = '" . $wow . "'" );
    $user_rows  = mysqli_num_rows ( $user_query );
    $user_array = mysqli_fetch_assoc ( $user_query );

    # More Language stuff
    switch ( $_POST['lang'] ) {
        case "jp":
            $userbanned      = "もうしわけありませんが、".$user_array['username']."はWOWMeterからきんしされている。";
            $alreadygaveawow = "すでにきょう".$user_array['username']."にワウたしました！<br>あしたもういちどおためしください！";
            $success         = "はワウせいこうし".$user_array['username']."にあたえられた！"; 
            break;
        case "fr":
            $userbanned      = "Désolé, " . $user_array['username'] . " est interdit de " . SITE_NAME;
            $alreadygaveawow = "Vous avez déjà donné un wow à " . $user_array['username'] . " aujourd'hui!<br>Essaye encore demain!";
            $success         = "WOW donné avec succès à " . $user_array['username'];
            break;
        case "es":
            $userbanned      = "Lo sentimos, " . $user_array['username'] . " tiene prohibido " . SITE_NAME . "!";
            $alreadygaveawow = "Ya has dado un wow de " . $user_array['username'] . " hoy!<br>Trata de nuevo mañana.";
            $success         = "WOW dado con éxito para " . $user_array['username'];
            break;
        case "tr":
            $userbanned      = "Maalesef, " . $user_array['username'] . " " . SITE_NAME . " yasaklandı.";
            $alreadygaveawow = "Zaten bir wow " . $user_array['username'] . " bugün verdik!<br>Yarın tekrar dene!";
            $success         = "WOW başarıyla " . $user_array['username'] . " verilen.";
            break;
        case "de":
            $userbanned      = "Sorry, " . $user_array['username'] . " wordt verbannen uit " . SITE_NAME . ".";
            $alreadygaveawow = "Je hebt al een wow te " . $user_array['username'] . " vandaag gegeven!<br>Probeer het morgen opnieuw!";
            $success         = "WOW succes gegeven aan " . $user_array['username'] . "!";
            break;
        case "gr":
            $userbanned      = "Συγνώμη, " . $user_array['username'] . " απαγορεύεται από " . SITE_NAME;
            $alreadygaveawow = "Έχετε ήδη δοθεί wow να " . $user_array['username'] . " σήμερα!<br>Ξαναπροσπάθησε αύριο!";
            $success         = "WOW επιτυχία δοθεί " . $user_array['username'] . "!";
            break;
        case "nl":
            $userbanned      = "Sorry, " . $user_array['username'] . " wordt verbannen uit " . SITE_NAME . ".";
            $alreadygaveawow = "Je hebt al een wow te " . $user_array['username'] . " vandaag gegeven!<br>Probeer het morgen opnieuw!";
            $success         = "WOW succes gegeven aan " . $user_array['username'] . "!";
            break;
        default:
            $userbanned      = "Sorry, ".$user_array['username']." is banned from '" . SITE_NAME . "'.";
            $alreadygaveawow = "You've already given a wow to ".$user_array['username']." today!<br>Try again tomorrow!";
            $success         = "WOW successfully given to ".$user_array['username']."!"; 
            break; 
    }

    # Verify if the token is valid
    if ( $token != hash ( 'sha512', $salt.$_SERVER['REMOTE_ADDR'] ) ) {
        die ( "<h3>$wrongtoken</h3><script>$(\".progress-bar\").toggleClass(\"progress-bar-success progress-bar-danger\")</script><span class='wow one'></span><span class='wow twosad'></span><span class='wow threesad'></span><span class='wow four'></span>" );
    }

    # Check if the user is valid
    else if ( $user_rows != 1 || preg_match('/[^\w-]+/i', $wow ) ) {
        die ( "<h3>$usernotfound :(</h3><script>$(\".progress-bar\").toggleClass(\"progress-bar-success progress-bar-danger\")</script><span class='wow one'></span><span class='wow twosad'></span><span class='wow threesad'></span><span class='wow four'></span>" );
    }

    # Check if the user is banned
    else if ( $user_array['is_banned'] == 1 ) {
        die ( "<h3>$userbanned</h3><script>$(\".progress-bar\").toggleClass(\"progress-bar-success progress-bar-danger\")</script><span class='wow one'></span><span class='wow twosad'></span><span class='wow threesad'></span><span class='wow four'></span><style>body:before{background: url(../images/saddoge.png)</style>" );
    }

    # Check if the WOWRequest is from a Tor connection
    else if ( doTorRequest ( ) || doProxy ( ) ) {
        die ( "<h4>Sorry, we have detected that your connection routed through a Tor node,<br>so we blocked you from<br>giving a wow in order to<br>stop people from cheating.</h4><script>$(\".progress-bar\").toggleClass(\"progress-bar-success progress-bar-danger\")</script><span class='wow one'></span><span class='wow twosad'></span><span class='wow threesad'></span><span class='wow four'></span><style>body:before{background: url(../images/saddoge.png)</style>" );
    }

    # Check if they already gave a wow today, and if not, give a wow
    else {

        $wow_query      = mysqli_query ( wow ( ), "SELECT DATE_FORMAT(wow_date, '%Y-%m-%d') FROM wow WHERE wow_to = '".$user_array['id']."' AND wow_from = '".$_SERVER['REMOTE_ADDR']."' AND DATE(wow_date) = CURDATE()");
        $wow_number     = mysqli_num_rows ( $wow_query );

        if ( $wow_number > 0 || $_COOKIE["wow_expire_" . $user_array['id']] == hash('sha512', "wow" . $user_array['id'] . "wow" ) ) {
            die ( "<h3>$alreadygaveawow</h3><script>$(\".progress-bar\").toggleClass(\"progress-bar-success progress-bar-danger\")</script><span class='wow one'></span><span class='wow twosad'></span><span class='wow threesad'></span><span class='wow four'></span><style>body:before{background: url(../images/saddoge.png)</style>" );
        } else {
            $givewow = mysqli_query ( wow ( ), "INSERT INTO wow ( 
                        wow_to, 
                        wow_from, 
                        wow_ref) 
                        VALUES ( 
                        '" . $user_array['id'] . "', 
                        '" . $_SERVER['REMOTE_ADDR'] . "', 
                        '" . doSafe ( $_POST['ref'] ) . "'
                        )");


              if ( !$givewow ) {
                echo "<h3>Crap! Unexpected database error. :(</h3><script>$(\".progress-bar\").toggleClass(\"progress-bar-success progress-bar-danger\")</script><span class='wow one'></span><span class='wow twosad'></span><span class='wow threesad'></span><span class='wow four'></span>";
              } else {

                $expire     = strtotime( 'tomorrow' );
                $wow_expire = hash ( 'sha512', "wow" . $user_array['id'] . "wow" );

                setcookie ("wow_expire_" . $user_array['id'], $wow_expire, $expire, "/" );

                echo "<h3>$success</h3><span class='wow one'></span><span class='wow two'></span><span class='wow three'></span><span class='wow four'></span>";
                
                if ( !$member_access )
                  echo "<h4 style='color:red'>vvv Do you want a " . SITE_NAME . " too? Join now! vvv</h4>";
              }

        }
    }


} else {
    die ( "The Doge Spaceship crashed into a wall, and we aren't sure why." );
}

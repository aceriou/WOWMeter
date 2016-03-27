<?php
require_once 'wow.php';
require_once 'header.php';

$wow      = doSafe ( $_GET['wow'] );

$query    = mysqli_query ( wow ( ), "SELECT * FROM users WHERE username = '" . $wow . "' OR oldusrname = '" . $wow . "'" );
$user     = mysqli_fetch_assoc ( $query );

$bgcolors = array (
        "orange"  => "F5D68F",
        "red"     => "F5928F",
        "lime"    => "D0F58F",
        "aqua"    => "8FF2F5",
        "blue"    => "8FAEF5",
        "fuchsia" => "F58FE1",
        "purple"  => "B48FF5",
        "gray"    => "778899",
			  "rainbow" => "F5928F"
);

if ( isset ( $bgcolors[$wow['bg_color']] ) ) {
  echo "<style type='text/css'>body{ background-color: #" . $bgcolors[$wow['bg_color']] . " !important;</style>";
}

switch ( $_GET['lang'] ) {
    case "fr":
        $givingawow = "Giving a wow...";
        $onlyenglish = "WOWMeter est uniquement disponible en anglais.";
        break;
    case "tr":
        $givingawow = "Giving a wow...";
        $onlyenglish = "WOWMeter'da sadece İngilizce mevcuttur.";
        break;
    case "gr":
        $givingawow = "Giving a wow...";
        $onlyenglish = "WOWMeter είναι διαθέσιμο μόνο στην αγγλική γλώσσα.";
        break;
    case "nl":
        $givingawow = "Giving a wow...";
        $onlyenglish = "WOWMeter is alleen beschikbaar in het Engels.";
        break;
    case "es":
        $givingawow = "Giving a wow...";
        $onlyenglish = "WOWMeter sólo está disponible en Inglés.";
        break;
    case "de":
        $givingawow = "Giving a wow...";
        $onlyenglish = "WOWMeter ist nur in Englisch verfügbar.";
        break;
    case "jp":
        $givingawow = "あたえるワウ...";
        $onlyenglish = "WOWMeterはえいごでのみりようかのうです。";
        break;
    default:
        $givingawow = "Giving a wow...";
        break;
}

?>


<script type="text/javascript">
$( document ).ready ( function ( ) {
    $( ".wow-give h3" ).html ( "<span class='wow-give-text'><h3><?=$givingawow?></h3><span class='wow one'></span><span class='wow two'></span><span class='wow three'></span><span class='wow four'></span></span><div class=\"progress progress-striped active\" style=\"margin:0\"><div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"0\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 35%\"></div></div>" );

    <?php if ( no_ajax_support ( ) ) { ?>
  
    $( ".progress" ).css ( "display", "none" );
    var r      = new XMLHttpRequest ( ); 
    var params = "token=<?=hash( 'sha512', $salt.$_SERVER['REMOTE_ADDR'] ) ?>&wow=<?=$wow?>&ref=<?=doSafe ( $_SERVER['HTTP_REFERER'] ) ?>";
    r.open( "POST", "give_process.php", true );
    r.onreadystatechange = function ( ) {
      $( ".wow-give" ).html ( r.responseText );
      if ( r.readyState != 4 || r.status != 200) $( ".wow-give" ).html("<h3>Oops, we can't connect to the server,<br>please try again in a few moments.</h3>" );
    };
    r.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    r.setRequestHeader ( "Content-length", params.length );
    r.setRequestHeader ( "Connection", "close" );
    r.send(params);
  
    <?php } else { ?>
    var form_data = {
      token: "<?php echo hash('sha512', $salt.$_SERVER['REMOTE_ADDR'] ); ?>",
      wow: "<?php echo $wow; ?>",
      ref: "<?php echo doSafe ( $_SERVER['HTTP_REFERER'] ); ?>",
      lang: "<?php echo doSafe ( $_GET['lang'] ); ?>"
    };
    $.ajax ({
      type: "POST",
      url: "/give_process.php",
      data: form_data,
      beforeSend: function ( )
      {
        $( ".progress-bar" ).css ( "width", "70%" );
      },
      success: function( response )
      {
        $( ".wow-give-text" ).html ( response );
        $( ".progress-bar" ).css ( "width", "100%" );
      },
      error:function ( ) {
        $( ".wow-give-text" ).html ( "<h3>Oops, we can't connect to the server,<br>please try again in a few moments.</h3>" );
        $( ".progress-bar" ).toggleClass ( "progress-bar-success progress-bar-danger" ).css ( "width", "100%" );
      }
    });

    <?php } ?>

});

</script>



<div class="box small no-title headline wow-give">
        <h3>
            <form action="give_process.php" method="POST">
                <input type="hidden" name="token" value="<?php echo hash ( 'sha512', $salt.$_SERVER['REMOTE_ADDR'] ); ?>">
                <input type="hidden" name="wow" value="<?php echo doSafe ( $_GET['wow'] ); ?>">
                <input type="hidden" name="ref" value="<?php echo doSafe ( $_SERVER['HTTP_REFERER'] ); ?>">
                <input type="hidden" name="lang" value="<?php echo doSafe ( $_GET['lang'] ); ?>">
                <input type="submit" value="Click here to give a wow to <?php echo doSafe ( $_GET['wow'] ); ?>">
            </form>
        </h3>
    </div>
    <?php if ( isset ( $onlyenglish ) ) echo "<p style='color:#555'>$onlyenglish</p>"; ?>

<?php require_once "main.php"; ?>

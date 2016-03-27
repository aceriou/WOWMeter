<!--<a href="https://github.com/Acerio/WOWMeter"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/52760788cde945287fbb584134c4cbc2bc36f904/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f77686974655f6666666666662e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png"></a>-->

<div class="box small no-title headline" style="padding: 5px;display: block">
        <strong>March 22nd 2016:</strong> This is some news. 
</div>

<?php

if ( $no_script != 1 ) {
        // Load GeoIP
        require_once 'geoip/geoipregionvars.php';
        require_once 'geoip/geoipcity.inc';
        require_once 'geoip/geoip.inc';
        $gi = geoip_open ( 'geoip/GeoLiteCity.dat', GEOIP_STANDARD );

?>

<script type="text/javascript">
    
    // Fix div height to match each other's.
    $( window ).load ( function ( ) {
      if ( window.outerWidth > 765 ) $( ".login, .col-md-offset-4" ).css ( 'min-height', Math.max ( $( ".login" ).outerHeight ( ), $( ".col-md-offset-4" ).outerHeight ( ) ) );
    } );
    

    // Language + Share buttons
    function changelang ( lang ) {
        var laang = lang;

        $( "#bbcode-code" ).html ( "[url=http://wowmeter.us/@<?php echo $username; ?>"+lang+"][img]http://wowmeter.us/$<?php echo $username; ?>"+lang+"[/img][/url]" );
        $( "#html-code" ).html ( "&lt;a href=\"http://wowmeter.us/@<?php echo $username; ?>"+lang+"\" target=\"_blank\"&gt;&lt;img src=\"http://wowmeter.us/$<?php echo $username; ?>"+lang+"\" alt=\"Give <?php echo $username; ?> a wow\"/&gt;&lt;/a&gt;" );
        $( "#direct-code" ).attr ( "value", "http://wowmeter.us/@<?php echo $username; ?>"+lang );
        $( "#sn-code" ).attr ( "value", "[wow=<?php echo $username; ?>"+lang+"]" );

        var lang2;

        switch ( laang ) {
            case "en":
            lang2 = "English";
            break;
            case "fr":
            lang2 = "Français";
            break;
            case "gr":
            lang2 = "ελληνική";
            break;
            case "tr":
            lang2 = "Türkçe";
            break;
            case "nl":
            lang2 = "Nederlands";
            break;
            case "es":
            lang2 = "Español";
            break;
            case "de":
            lang2 = "Deutsch";
            break;
            case "jp":
            lang2 = "日本語";
            break;
        }

        $( "#lang-btn" ).html ( "<img src=\"/images/flags/"+laang+".gif\"/> "+lang2+" <span class=\"caret\"></span>" );
        $( "#sig" ).attr ( "src", "/$<?php echo $username; ?>?lang="+laang );
        return false;
    }

    // Form submissions with/without Ajax
    $( document ).ready ( function ( ) {
        
        $( "#loginbutton" ).click ( function ( ) {
        if ( login_type == "register" ) {
                
            $( "input[type=email], .register-alert" ).toggle ( );
          $( "input[type=text]" ).attr( "placeholder", "Username or email" );
          
                document.getElementById ( "form" ).setAttribute ( "action", "doLogin.php" );
          
                login_type = "login";
                
          return false;
                
        } else {
            
                <?php if ( !no_ajax_support ( ) ) { ?>
                var formData = {
            'username' : $('input[name=username]').val(),
            'password' : $('input[name=password]').val()
            };
            
                $.ajax ({
                    type     : 'POST',
                    url      : 'doLogin.php',
                    data     : formData,
                    beforeSend: function ( ) {
              $( ".box.login" ).prepend ( "<i class='fa fa-spinner fa-spin fa-2x'></i>" );
              $( ".box.login > .fa-spinner" ).css ({
                'color': 'cyan',
                'position': 'absolute',
                'top': '5px',
                'right': '6px',
                'z-index': '1'
              });
            },
                    
                    success: function ( response ) {
              if ( response == 'success' ) {
                $( ".box.login > .fa-spinner" ).remove ( );
                $( ".box.login" ).prepend ( "<i class='fa fa-ok fa-2x' style='color: #fff;position: absolute;top: 5px;right: 6px;z-index: 1;'></i>" );
                document.location.href = "index.php";
              } else {
                if ( response == '' ) {
                  $( ".box.login > .fa-spinner" ).remove ( );
                  alert( "The server is not responding. Please try again later." );
                } else {
                  $( ".box.login > .fa-spinner" ).remove ( );
                  alert ( response );
                }
              }
            },
                    
            error: function ( xhr, ajaxOptions, thrownError ) {
              $( ".box.login > .fa-spinner" ).remove ( );
              alert("There was an error connecting to the server, please try again in a few moments.");
                        //alert(xhr.status);
                //alert(thrownError);
            }
                    

                })
                
                return false;
                
                <?php } ?>
            
            }
        })
        var login_type = "login";
        
        $( "#registerbutton1" ).click ( function ( ) {
            if ( login_type == "login" ) {
                
                $("input[type=email], .register-alert").toggle();
          $("input[type=text]").attr("placeholder", "Username");
                
          document.getElementById("form").setAttribute("action", "doRegister.php");
                
          login_type = "register";
                
                return false;
                
            } else {
                <?php if ( !no_ajax_support ( ) ) { ?>
                var formData = {
            'username' : $('input[name=username]').val(),
            'password' : $('input[name=password]').val(),
            'email'    : $('input[name=email]').val()
            };
            
                $.ajax ({
                    type     : 'POST',
                    url      : 'doRegister.php',
                    data     : formData,
                    beforeSend: function ( ) {
              $( ".box.login" ).prepend ( "<i class='fa fa-spinner fa-spin fa-2x'></i>" );
              $( ".box.login > .fa-spinner" ).css ({
                'color': 'cyan',
                'position': 'absolute',
                'top': '5px',
                'right': '6px',
                'z-index': '1'
              });
            },
                    
                    success: function ( response ) {
              if ( response == 'success' ) {
                $( ".box.login > .fa-spinner" ).remove ( );
                $( ".box.login" ).prepend ( "<i class='fa fa-ok fa-2x' style='color: #fff;position: absolute;top: 5px;right: 6px;z-index: 1;'></i>" );
                document.location.href = "index.php";
              } else {
                if ( response == '' ) {
                  $( ".box.login > .fa-spinner" ).remove ( );
                  alert( "The server is not responding. Please try again later." );
                } else {
                  $( ".box.login > .fa-spinner" ).remove ( );
                  alert ( response );
                }
              }
            },
                    
            error: function ( xhr, ajaxOptions, thrownError ) {
              $( ".box.login > .fa-spinner" ).remove ( );
              alert("There was an error connecting to the server, please try again in a few moments.");
                        //alert(xhr.status);
                //alert(thrownError);
            }
                    

                })
                
                return false;
                
                <?php } ?>
            }
            
        })
            
    })

</script>

<div class="row">
  <div class="box col-md-4 login">
        <?php if ( $member_access == false ) { ?>
    <div class="title">Login</div>
        <form action="doLogin.php" method="POST" id="form">
            <input type="email" class="form-control" placeholder="Email" name="email" style="display:none">
            <input type="text" class="form-control" placeholder="Username or email" name="username">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <button type="submit" class="button blue ico-right right" name="loginbutton" id="loginbutton">Log in</button>
            <button type="submit" class="button cosmo ico-left left" name="register" id="registerbutton1">Register</button>
            <!--<a href="/forgotpasswd.php" style="display: inline-block;">Forgot password</a>-->
            <div class="clearfix"></div>
            <p class="register-alert" style="display:none;color:#424854">By clicking register,<br>you agree to the <a href="tos.php">Terms of Service</a>.<br></p>
        <div class="clearfix"></div></form>

        <div>
        <strong>Register now</strong> to get<br>your own <strong><?php echo SITE_NAME; ?></strong> like these!<br>
        <br />
        <?php
        $randomuser_sql = mysqli_query ( wow ( ), "SELECT  a.*,  totalCount AS wow_count
                                                   FROM    users a 
                                                   LEFT JOIN 
                                                   (
                                                       SELECT  wow_to, COUNT(*) totalCount
                                                       FROM    wow
                                                       GROUP   BY wow_to
                                                   ) b ON  a.id = b.wow_to
                                                   ORDER BY RAND(), b.TotalCount LIMIT 6" );

        while ( $randomuser = mysqli_fetch_assoc ( $randomuser_sql ) ) {
            echo '<img src="/$'.$randomuser['username'].'" alt="'.$randomuser['username'].'\'s WOWMeter " title="'.$randomuser['username'].'\'s WOWMeter "/><br>';
        }

        ?>
        </div>

        <?php } else { ?>
        
        <div class="title">Your WOWMeter</div>
        
        <?php
        // Initialize WOWMeter user
        $wow_query  = mysqli_query ( wow ( ), "SELECT * FROM wow WHERE wow_to = '" . $session_array['id'] . "' ORDER BY wow_id DESC" );
        $wow_number = mysqli_num_rows ( $wow_query );
        $wow        = mysqli_fetch_assoc ( $wow_query );
    
        $ipaddress = $wow['wow_from'];
        $rsGeoData = geoip_record_by_addr ( $gi, $ipaddress );
        $city      = utf8_encode ( $rsGeoData->city );
        $state     = utf8_encode( $GEOIP_REGION_NAME[$rsGeoData->country_code][$rsGeoData->region] );
        $country   = htmlentities( $rsGeoData->country_name );
        
        $getwowfrom_sql    = mysqli_query ( wow ( ), "SELECT * FROM users WHERE ip = '".$wow['wow_from']."' ORDER BY regdate DESC") or die ( mysqli_error ( wow ( ) ) );
        $getwowfrom_number = mysqli_num_rows ( $getwowfrom_sql );
        $getwowfrom        = mysqli_fetch_assoc ( $getwowfrom_sql );
        
        if ( $getwowfrom_number && $wow['wow_from'] != "127.0.0.1" ) {
            $hex       = $getwowfrom['usrname_color'];
            $wow_from  = " by&nbsp;&nbsp;<span style='color:#$hex' class=\"table-color ". $getwowfrom["bg_color"] ." font-". $getwowfrom["sig_font"] ."\"";
            $wow_from .= "><img src='images/flags/".strtolower($rsGeoData->country_code).".gif' title='".htmlentities($rsGeoData->country_name)."' alt='".htmlentities($rsGeoData->country_name)."'/> ".$getwowfrom['username']."</span>";
        }
    
        if ( $city == $state ) $city == '';
        if ( $city != "" ) { $city .= ", "; } else { $city == ""; }
        if ( $state != "" ) { $state .= ", <br>"; } else { $state == ""; }
        if ( $country_name == "" ) $country_name = "Unknown";
    
        ?>
        
        <p>
            You have <strong><?php echo $wow_number; ?></strong> wows!
        </p>
        <p>
            Your last wow <?php if ( $wow_number == 0 ) { echo "was <strong title=':('>never given</strong>"; } else { echo "was given <br><strong title='".$wow['wow_date']."'>".nicetime ( $wow['wow_date'] )."</strong>";
            if ( !isset ( $wow_from ) ) { echo " from <strong>".$city.$state.$country." <img src='images/flags/".strtolower ( $rsGeoData->country_code ).".gif' title='".htmlentities ( $rsGeoData->country_name )."' alt='".htmlentities ( $rsGeoData->country_name )."'/></strong>"; } else { echo $wow_from; } } ?>.</p>
        
        </p>

        <p><h5>Share to collect much wows</h5>
        <img src="/$<?php echo $username; ?>" id="sig"/>
        <div class="share"><!--
        --><a class="fb" href="javascript:void(0)" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo urlencode("http://wowmeter.us/@".$username); ?>&t=<?php echo urlencode("WOWMeter - Giving a wow to ".$username)?>', 'sharer', 'toolbar=0, status=0, width=480, height=370')" title="Share through Facebook"></a><!--
        --><a class="tw" href="javascript:void(0)" onclick="window.open('https://twitter.com/intent/tweet?hashtags=wowmeter&text=Click%20here%20to%20give%20<?php echo urlencode($username); ?>%20a%20wow!&url=<?php echo urlencode("http://wowmeter.us/@".$username); ?>&via=aceriou', 'sharer', 'toolbar=0, status=0, width=480, height=260')" title="Share through Twitter"></a><!--
        --><a class="gp" href="javascript:void(0)" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode("http://wowmeter.us/@".$username); ?>', 'sharer', 'toolbar=0, status=0, width=490, height=470')" title="Share through Google+"></a><!--
        --><a class="tu" href="javascript:void(0)" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode("http://wowmeter.us/@".$username); ?>&name=<?php echo urlencode("WOWMeter - Giving a wow to ".$username); ?>&description=Click%20here%20to%20give%20<?php echo urlencode($username); ?>%20a%20wow!', 'sharer', 'toolbar=0, status=0, width=480, height=500')" title="Share through Tumblr"></a><!--
        --></div>
        <div class="btn-group" style="float:left">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" id="lang-btn">
        <img src="/images/flags/us.gif"/> English <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" style="text-align:left">
        <li><a href="javascript:changelang('en');void(0)"><img src="/images/flags/us.gif"/> English</a></li>
        <li><a href="javascript:changelang('es');void(0)"><img src="/images/flags/es.gif"/> Español</a></li>
        <li><a href="javascript:changelang('de');void(0)"><img src="/images/flags/de.gif"/> Deutsch</a></li>
        <li><a href="javascript:changelang('fr');void(0)"><img src="/images/flags/fr.gif"/> Français</a></li>
        <li><a href="javascript:changelang('gr');void(0)"><img src="/images/flags/gr.gif"/> ελληνική</a></li>
        <li><a href="javascript:changelang('jp');void(0)"><img src="/images/flags/jp.gif"/> 日本語</a></li>
        <li><a href="javascript:changelang('nl');void(0)"><img src="/images/flags/nl.gif"/> Nederlands</a></li>
        <li><a href="javascript:changelang('tr');void(0)"><img src="/images/flags/tr.gif"/> Türkçe</a></li>
        </ul>
        </div>
        <a href="javascript:window.open('/whichone.php','windowNew','width=320, height=400');void(0)" style="float:right">Which one do I use?</a>
        <table style="width:100%">
            <tr><td>BBCode </td><td><textarea id="bbcode-code" readonly>[url=http://wowmeter.us/@<?php echo $username; ?>][img]http://wowmeter.us/$<?php echo $username; ?>[/img][/url]</textarea></td></tr>
            <tr><td>HTML </td><td><textarea id="html-code" readonly>&lt;a href="http://wowmeter.us/@<?php echo $username; ?>" target="_blank"&gt;&lt;img src="http://wowmeter.us/$<?php echo $username; ?>" alt="Give <?php echo $username; ?> a wow"/&gt;&lt;/a&gt;</textarea></td></tr>
            <tr><td>Supporting &nbsp;<br>websites <a href="javascript:window.open('/supporting.php','windowNew','width=320, height=400');void(0)">(?)</a></td><td><input type="text" value="[wow=<?php echo $username; ?>]" id="sn-code" readonly/></td></tr><br>
            <tr><td>Direct link</td><td style="padding-bottom:4px"><input type="text" value="http://wowmeter.us/@<?php echo $username; ?>" id="direct-code" readonly/></td></tr>
        </table>
        </p>
        <p><a href="/settings" class="button red ico-cog left">Settings</a><a href="/logout.php" class="button blue ico-right right">Logout</a></p>
        
        <?php } ?>
    
  </div>
  <div class="box col-md-4 col-md-offset-4">
        <div class="title">About</div>
    
        WOWMeter is a loosely-tied community where you give and recieve "wows". When someone clicks on your signature, you get a wow, and vise versa. The more wows, the cooler you are.
        
        <br />
        <br />

        <?php
        $getusers_sql         = mysqli_query ( wow ( ), "SELECT * FROM users" );
        $getusers_number      = mysqli_num_rows ( $getusers_sql );
        $getwows_sql_all      = mysqli_query ( wow ( ), "SELECT * FROM wow" );
        $getwows_number_all   = mysqli_num_rows ( $getwows_sql_all );
        $getwows_sql_today    = mysqli_query ( wow ( ), "SELECT DATE_FORMAT(wow_date, '%Y-%m-%d') FROM wow WHERE DATE(wow_date) = CURDATE()" );
        $getwows_number_today = mysqli_num_rows ( $getwows_sql_today );
        $getwows_sql_last     = mysqli_query ( wow ( ), "SELECT * FROM wow ORDER BY wow_id DESC" );
        $getwows_last         = mysqli_fetch_assoc ( $getwows_sql_last );
        $lastwowuser_sql      = mysqli_query ( wow ( ), "SELECT * FROM users WHERE id = '".$getwows_last['wow_to']."'" );
        $lastwowuser          = mysqli_fetch_assoc ( $lastwowuser_sql );


        $ipaddress            = $getwows_last['wow_from'];
        $rsGeoData            = geoip_record_by_addr ( $gi, $ipaddress );
        $city                 = utf8_encode ( $rsGeoData->city );
        $state                = utf8_encode ( $GEOIP_REGION_NAME[$rsGeoData->country_code][$rsGeoData->region] );
        $country              = htmlentities ( $rsGeoData->country_name );
        $getwowfrom_sql       = mysqli_query ( wow ( ), "SELECT * FROM users WHERE ip = '".$getwows_last['wow_from']."' ORDER BY regdate DESC" ) or die ( mysqli_error ( wow ( ) ) );
        $getwowfrom_number    = mysqli_num_rows( $getwowfrom_sql );
        $getwowfrom           = mysqli_fetch_assoc ( $getwowfrom_sql );

        unset ( $wow_from );

        if ( $getwowfrom_number ){
            $hex = $getwowfrom['usrname_color'];
            $wow_from = " by&nbsp;&nbsp;<span style='color:#$hex' class=\"table-color ". $getwowfrom["bg_color"] ." font-". $getwowfrom["sig_font"] ."\"";
            $wow_from .= "><img src='/images/flags/".strtolower ( $rsGeoData->country_code ).".gif' title='".htmlentities ( $rsGeoData->country_name )."' alt='".htmlentities ( $rsGeoData->country_name )."'/> ".$getwowfrom['username']."</span>";
        }

        if ( $city == $state ) $city == '';
        if ( $city != "" ) { $city .= ", "; } else { $city == ""; }
        if ( $state != "" ) { $state .= ",<br>"; } else { $state == ""; }
        if ( $country_name == "" ) $country_name = "Unknown";

        $leaderboard_sql = mysqli_query ( wow ( ), "SELECT  a.*,  totalCount AS wow_count
                                            FROM    users a
                                            LEFT JOIN 
                                            (
                                                SELECT  wow_to, COUNT(*) totalCount
                                                FROM    wow
                                                GROUP   BY wow_to
                                            ) b ON  a.id = b.wow_to
                                            ORDER   BY b.TotalCount DESC, a.id ASC LIMIT 0,20" );
        ?>
        <strong><?php echo $getusers_number; ?></strong> users registered,<br>
        <strong><?php echo $getwows_number_all; ?></strong> wows given,<br>
        <strong><?php echo $getwows_number_today; ?></strong> given today.

        <br />

        <p>Last wow was given to  <?php
            $hex = $lastwowuser['usrname_color'];
            echo "<span style='color:#$hex' class=\"table-color ". $lastwowuser["bg_color"] ." font-". $lastwowuser["sig_font"] ."\"";
            $rsGeoData_lastusr = geoip_record_by_addr($gi, $lastwowuser['ip']);
            geoip_close($gi);
            echo "><img src='/images/flags/".strtolower($rsGeoData_lastusr->country_code).".gif' title='".htmlentities($rsGeoData_lastusr->country_name)."' alt='".htmlentities($rsGeoData_lastusr->country_name)."'/> ".$lastwowuser['username']."</span><br><strong title='".$getwows_last['wow_date']."'>".nicetime($getwows_last['wow_date'])."</strong>";
            if(!isset($wow_from)){echo " from <strong>".$city.$state.$country." <img src='/images/flags/".strtolower($rsGeoData->country_code).".gif' title='".htmlentities($rsGeoData->country_name)."' alt='".htmlentities($rsGeoData->country_name)."'/></strong>";}else{echo $wow_from;} ?>.</p>

        <h3>Leaderboard</h3>
        <table style="min-width:220px;margin:0 auto;text-align:left">
        <?php
        while ( $leaderboard = mysqli_fetch_assoc ( $leaderboard_sql ) )
        {
            $gi        = geoip_open ( "geoip/GeoLiteCity.dat", GEOIP_STANDARD );
            $rsGeoData = geoip_record_by_addr ( $gi, $leaderboard['ip'] );
            $hex = $leaderboard['usrname_color'];

            echo "<tr><td style='color:#$hex'>";
            echo "<span class=\"table-color ". $leaderboard["bg_color"] ." font-". $leaderboard["sig_font"] ."\">";
            if( $leaderboard['is_banned'] == 1 )
                echo "<s title='Banned'>";

            echo "<img src='/images/flags/".strtolower ( $rsGeoData->country_code ).".gif' title='".htmlentities ( $rsGeoData->country_name )."' alt='".htmlentities ( $rsGeoData->country_name )."'/> ".$leaderboard["username"];
            
            if( $leaderboard['is_banned'] == 1)
                echo "</s>";
            
            echo "</span></td><td style='text-align:right'>".$leaderboard["wow_count"]." wows</td></tr>";
        }
        ?>
        </table></div>

</div>
  
<?php } ?>
  
<h6 style="margin-bottom:30px;color:#424854">
  <a href="/tos.php">Terms of Service</a><br>
  <?php echo SITE_NAME; ?> is &copy; by 
  <a href="http://cammarata.info">Preston Cammarata</a>, <?php echo date ( "Y" ); ?>.<br>
  Made in Rhode Island<br>
  <span style="font-size:8px;font-family:'Small Fonts', sans-serif">
  <br>
  <?php
  $end = microtime ( true );
  $creationtime = ( $end - $start );
  printf( "<br>Render time: %.6fs.", $creationtime );
  ?>
  </span>
</h6>
<?php
require_once 'wow.php';

# Set the Content-Type
header( 'Content-Type: image/png' );

# Create the image
$im  = setBackground ( 5 );
$url = false;

# Turn on alpha
imagealphablending ( $im, true );
imagesavealpha ( $im, true );

# Set default font
setFont ( 2 );
if ( $_GET['debug'] == 1 ) {
    $im = setBackground( 1 );
    doImage ( );
}

# Get user data and wows
$getUser = doMysql ( "SELECT * FROM users WHERE username='" . doSafe ( $_GET['wow'] ) . "' OR oldusrname='" . doSafe ( $_GET['wow'] ) . "'" );
$getWows = doMysql ( "SELECT * FROM wow WHERE wow_to='" . doSafe ( $getUser['r']['id'] ) . "'" );

# Check if user exists, if not, display a message
if ( $getUser['c'] != 1 || preg_match( '/[^\w-]+/i', $_GET['wow'] ) ) {
    drawText ( "a", 16, "User not found :(", NULL, true );
    drawText ( "a", 36, "Register to wowmeter.us to", NULL, true );
    drawText ( "a", 56, "get your own WOWMeter!", NULL, true );
    drawText ( 106, 36, "wowmeter.us", alloColor( 66, 66, 202, 20 ), false );
    doImage ( );
}

# Check if user is banned, if it is, display a message
if ( $getUser['r']['is_banned'] == 1 ) {
    drawText( "a", 16, $getUser['r']['username'], NULL, true );
    drawText( "a", 36, "is banned from", NULL, true );
    drawText( "a", 56, "WOWMeter.us", NULL, true );
    doImage ( );
}
# Change the font into the user's preference
setFont( $getUser['r']['sig_font'] );

# Chance the background into the user's preference
if ( empty ( $getUser['r']['sig_url'] ) ) {
    $im = setBackground( $getUser['r']['sig_bg'], $getUser['r']['bg_color'] );
} else {
    $url = true;
        $im  = setBackground( $getUser['r']['sig_url'], $getUser['r']['bg_color'] );
}

# Draw the text
if ( $_GET['mask'] != 1 ) { # Only draw the username when the mask isn't applied
    drawText( "a", 16, $getUser['r']['username'], alloColor( $getUser['r']['usrname_color'], true ) );
    drawText ( "a", 36, getTrans ( "hasCollected" ), alloColor( $getUser['r']['text_color'], true ), true ); # has collected %c% wows.
    drawText ( "a", 56, getTrans ( "clickHere" ), alloColor( $getUser['r']['text_color'], true ), true ); # Click here to give a wow!
}

if ( $_GET['mask'] == 1 ) { # Apply a mask if it's set
    # Create the mask
    $mask = imagecreatetruecolor ( 240, 66 );
    imagefilledrectangle ( $mask, 0, 0, 240, 66, alloColor( "FFFFFF" ) );
    # Shadow
    drawText ( "a", 17, $getUser['r']['username'], alloColor( 0, 0, 0, 80 ), false, NULL, 12, 0, $im );
    drawText ( "a", 36, getTrans ( "hasCollected" ), alloColor( 0, 0, 0, 80 ), false, NULL, 12, 0, $im );
    drawText ( "a", 56, getTrans ( "clickHere" ), alloColor( 0, 0, 0, 80 ), false, NULL, 12, 0, $im );
    
    # Text in the mask
    drawText ( "a", 16, $getUser['r']['username'], alloColor( 0, 0, 0, 80 ), false, NULL, 12, 0, $mask );
    drawText ( "a", 36, getTrans ( "hasCollected" ), alloColor( 0, 0, 0, 80 ), false, NULL, 12, 0, $mask );
    drawText ( "a", 56, getTrans ( "clickHere" ), alloColor( 0, 0, 0, 80 ), false, NULL, 12, 0, $mask );
    
    # Apply the mask
    imageAlphaMask ( $im, $mask );
}

# Need to turn on alpha again
imagealphablending ( $im, false );
imagesavealpha ( $im, true );

# Output the image and quit
doImage ( );

# Functions

// Function for allocating colors (1 required variable, 4 optional variables)
// Returns a color identifier
function alloColor( $r, $g = NULL, $b = NULL, $alpha = 0, $image = NULL )
{
    global $im;

    if ( $image === NULL )
        $image = $im;

    if ( strlen( $r ) > 3 ) {
        $r        = preg_replace( "/[^0-9A-Fa-f]/", '', $r );
        $rgbArray = array( );
        $colorVal = hexdec( $r );
        return imagecolorallocatealpha( $image, 0xFF & ( $colorVal >> 0x10 ), 0xFF & ( $colorVal >> 0x8 ), 0xFF & $colorVal, $alpha );
    }

    return imagecolorallocatealpha( $image, $r, $g, $b, $alpha );

}

// Function for writing text (3 required variables, 6 optional variables)
// Returns true on success, false on failure
function drawText( $x, $y, $text, $color = NULL, $shadow = true, $f = NULL, $size = 12, $angle = 0, $image = NULL )
{
    global $im;
    global $font;

    if ( $color == NULL )
        $color = alloColor( 255, 255, 255 );

    if ( $f == NULL )
        $f = $font;

    if ( $image == NULL )
        $image = $im;

    if ( $x == "a" )
        $x = XCoord( $text );

    if ( $shadow == true && imagettftext( $image, $size, $angle, $x, $y + 1, alloColor( 0, 0, 0, 80 ), $f, $text ) )
        $shadow = false;

    if ( imagettftext( $image, $size, $angle, $x, $y, $color, $f, $text ) && $shadow == false )
        return true;

    return false;
}

// Function for doing MySQL queries (1 required variable, 1 optional variable)
// Returns an array including result rows and the row count on success, false on failure
function doMysql( $sql, $db = NULL )
{
    if ( $db == NULL )
        $db = wow ( );

    $query = mysqli_query( $db, $sql );

    if ( $query ) {

        return array(
             "r" => mysqli_fetch_assoc ( $query ),
             "c" => mysqli_num_rows ( $query ) 
        );
    }
    
    mysqli_close ( );

    return false;
}

// Function for setting font (1 required variable)
// Returns true on success
function setFont( $f )
{
    global $font;

    $fonts     = array(
         1 => "fonts/comic.ttf",             # Comic Sans
         2 => "fonts/Hand_Of_Sean_Demo.ttf", # Hand of Sean
         3 => "fonts/keifont.ttf",           # Maru Gothic (Japanese only)
         4 => "fonts/Pacifico.ttf",          # Pacifico
         5 => "fonts/Chewy.ttf"
    );

    $safeFonts = array(
        "en" => array(  # English
             1,
             2,
             3,
             4,
             5
        ),
        "es" => array( # Spanish
             1,
             2,
             3,
             4,
             5
        ),
        "de" => array( # German
             1,
             2,
             3,
             4,
             5
        ),
        "fr" => array( # French
             1,
             2 
        ),
        "gr" => array( # Greek
             1 
        ),
        "jp" => array( # Japanese
             3
        ),
        "nl" => array( # Dutch
             1,
             2 
        ),
        "tr" => array( # Turkish
             1,
        )
    );

    if ( !isset ( $_GET['lang'] ) )
        $_GET['lang'] = "en";

    if ( $_GET['lang'] == "jp" )
        $_GET['font'] = 3;

    if ( isset ( $_GET['font'] ) && isset ( $fonts[$_GET['font']] ) ) {
        $font = $fonts[$_GET['font']];
        return true;
    }

    if ( isset ( $fonts[$f] ) && isset( $safeFonts[$_GET['lang']][$f - 1] ) ) {
        $font = $fonts[$f];
        return true;
    }

    $font = $fonts[1];
    return true;
}

// Function for setting background (1 required variable, 2 optional variable)
// Returns an image identifier on success, false on failure
function setBackground( $bg, $bgcolor = "orange" )
{
    $backgrounds = array(
        1, # Normal doge
        2, # 8-bit doge
        3, # Neko doge
        4, # Flandre Scarlet doge
        5, # Snoop Dogge
        6, # Toontown doge
        7  # Cartoon Doge
    );
  
    $bgcolors    = array(
        "orange",
        "red",
        "lime",
        "aqua",
        "blue",
        "fuchsia",
        "purple",
        "gray",
        "rainbow"
    );
    // Create the base image and the overlay
    $im          = imagecreatefrompng( "images/bg/orange.png" );
    $overlay     = imagecreatefrompng( "images/bg/overlay.png" );
    $gloss       = imagecreatefrompng( "images/bg/gloss.png" );

    global $url;
    global $getUser;
    if ( $url && !$_GET['bgcolor'] ) {
        // Set it to the URL.
        $background = imagecreatefrompng ( $getUser['r']['sig_url'] );      
    } else {
    
        // If the supplied background is valid, set the current background to that
        if ( isset( $backgrounds[$bg - 1] ) )
            $background = imagecreatefrompng ( "images/bg/" . $bg . ".png" );

        // If there's a valid background already set in the URI, set the current background to that
        if ( isset( $backgrounds[$_GET['bg'] - 1] ) )
            $background = imagecreatefrompng ( "images/bg/" . $_GET['bg'] . ".png" );

        // If the current background is not set, report failure
        if ( !isset( $background ) )
            return false;
    }
    
    // If a valid background color is supplied in the function, use it
    if ( in_array( $bgcolor, $bgcolors ) )
        $im = imagecreatefrompng( "images/bg/" . $bgcolor . ".png" );

    // If a valid background color is supplied in the URI, use it
    if ( in_array( $_GET['bgcolor'], $bgcolors ) )
        $im = imagecreatefrompng( "images/bg/" . $_GET['bgcolor'] . ".png" );

    # Insert the components into the image

    // Background
    imagecopy( $im, $background, 0, 0, 0, 0, 240, 66 );
    
    // Overlay
    imagecopy( $im, $overlay, 0, 0, 0, 0, 240, 66 );
    
    // Gloss
    imagecopy( $im, $gloss, 0, 0, 0, 0, 240, 66 );
    
    // End
    return $im;

}

// Function for getting translated text (1 required variable)
// Returns the translated text on success, false on failure
function getTrans( $str )
{
    global $getWows;
    $translatedWords = array(
         "en" => array(
            "hasCollected" => "has collected " . $getWows['c'] . " wows.",
            "clickHere" => "Click here to give a wow!",
            "fontSize" => 12 
        ),
        "es" => array(
            "hasCollected" => "ha colectado " . $getWows['c'] . " wows.",
            "clickHere" => "¡Da click aquí para darle un wow!",
            "fontSize" => 6 
        ),
        "de" => array(
            "hasCollected" => "hat " . $getWows['c'] . " wows gesammelt.",
            "clickHere" => "Klicke hier um ein wow zu geben!",
            "fontSize" => 10 
        ),
        "fr" => array(
            "hasCollected" => "a collectée " . $getWows['c'] . " wows.",
            "clickHere" => "Clique ici pour donner un wow!",
            "fontSize" => 10 
        ),
        "gr" => array(
            "hasCollected" => "έχει συλλέξει " . $getWows['c'] . " wows.",
            "clickHere" => "Κάνε κλικ εδώ για να δώσεις ένα!",
            "fontSize" => 10 
        ),
        "jp" => array(
            "hasCollected" => "はワウ " . $getWows['c'] . " を収集した。",
            "clickHere" => "ワウ与えることをクリックします。",
            "fontSize" => 11 
        ),
        "nl" => array(
            "hasCollected" => "heeft " . $getWows['c'] . " wows verzameld.",
            "clickHere" => "Klik hier om een wow te geven!",
            "fontSize" => 10 
        ),
        "tr" => array(
            "hasCollected" => $getWows['c'] . " tane wow kazandı.",
            "clickHere" => "Wow vermek için buraya tıkla!",
            "fontSize" => 12 
        ) 
    );
    
    return $translatedWords[$_GET['lang']][$str];

}

// Function for calculating the X coordinate to center the text (1 required variable, 3 optional variables)
// Returns the X coordinate on success, false on failure
function XCoord( $text, $f = NULL, $s = 12, $a = 0 )
{
    global $font;

    if ( $f == NULL )
        $f = $font;

    $bbox = imagettfbbox( $s, $a, $f, $text );

    if ( $bbox )
        return 121 - $bbox[2] / 2;

    return false;
}

// Function for applying an alpha mask (2 required variables)
// Returns nothing
function imageAlphaMask( &$picture, $mask )
{
    // Get sizes and set up new picture
    $xSize      = imagesx( $picture );
    $ySize      = imagesy( $picture );
    $newPicture = imagecreatetruecolor( $xSize, $ySize );
    imagesavealpha( $newPicture, true );
    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );
    if ( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) {
        $tempPic = imagecreatetruecolor( $xSize, $ySize );
        imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
        imagedestroy( $mask );
        $mask = $tempPic;
    }
    for ( $x = 0; $x < $xSize; $x++ ) {
        for ( $y = 0; $y < $ySize; $y++ ) {
            $alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
            $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
            $alpha = 127 - floor( ( 127 - $color['alpha'] ) * ( $alpha['red'] / 255 ) );
            imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color['red'], $color['green'], $color['blue'], $alpha ) );
        }
    }
    imagedestroy( $picture );
    $picture = $newPicture;

}

// Function for outputting the image (2 optional variables)
// Returns nothing
function doImage( $doExit = true, $image = NULL )
{
    global $im;

    if ( $image == NULL )
        $image = $im;

    imagepng( $im );
    imagedestroy( $im );
    
    if ( $doExit )
        exit;
} 

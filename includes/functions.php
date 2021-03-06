<?php
$errors = array();
/*--------------------------------------------------------------*/
/* Function for Remove escapes special
/* characters in a string for use in an SQL statement
/*--------------------------------------------------------------*/
function real_escape($str)
{
    global $con;
    $escape = mysqli_real_escape_string($con, $str);
    return $escape;
}

/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
function remove_junk($str)
{
    $str = nl2br($str);
    $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
    return $str;
}

/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var)
{
    global $errors;
    foreach ($var as $field) {
        $val = remove_junk($_POST[$field]);
        if (isset($val) && $val == '') {
            $errors = $field . " can't be blank.";
            return $errors;
        }
    }
}

/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($str)
{
    $val = str_replace('-', " ", $str);
    $val = ucfirst($val);
    return $val;
}

/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo display_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg = '')
{
    $output = array();
    if (!empty($msg)) {
        foreach ($msg as $key => $value) {
            $output = "<div class=\"alert alert-{$key}\">";
            $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
            $output .= remove_junk(first_character($value));
            $output .= "</div>";
        }
        return $output;
    } else {
        return "";
    }
}
/*--------------------------------------------------------------*/
/* Function for updating antibody status
/*--------------------------------------------------------------*/
function verification_stock ($seuil , $quantite_stock){
    $marge = 2 * $seuil ;
    if ($quantite_stock <= $seuil)
    { return 'Rupture' ;}
    else if ( $quantite_stock > $seuil and $quantite_stock <= $marge)
    { return 'Risque';}
    else if ($quantite_stock  > $marge)
    { return 'Bon';}
}
?>
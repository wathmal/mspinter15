<!DOCTYPE html>
<!--


-->

<?php
include '../drupal/includes/password.inc';

$ini_array = parse_ini_file("mspconfig.ini");

$servername = $ini_array['servername'];
$username = $ini_array['username'];
$password = $ini_array['password'];
$dbname = $ini_array['dbname'];


/*
 * edited function from password.inc
 * can check if the hashed password and the plaintext password is equal
 */
function _user_check_password($password, $pass) {
    if (substr($pass, 0, 2) == 'U$') {
        // This may be an updated password from user_update_7000(). Such hashes
        // have 'U' added as the first character and need an extra md5().
        $stored_hash = substr($pass, 1);
        $password = md5($password);
    } else {
        $stored_hash = $pass;
    }

    $type = substr($stored_hash, 0, 3);
    switch ($type) {
        case '$S$':
            // A normal Drupal 7 password using sha512.
            $hash = _password_crypt('sha512', $password, $stored_hash);
            break;
        case '$H$':
        // phpBB3 uses "$H$" for the same thing as "$P$".
        case '$P$':
            // A phpass password generated using md5.  This is an
            // imported password or from an earlier Drupal version.
            $hash = _password_crypt('md5', $password, $stored_hash);
            break;
        default:
            return FALSE;
    }
    return ($hash && $stored_hash == $hash);
}
?>





<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <img src="http://www.coolfbcovers.com/covers-images/download/The%20Best%20Fb%20Cover.jpg" width="100%" alt="facebook cover"> 
        <?php

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!mysqli_connect_error()) {

            $res = mysqli_query($conn, "SELECT * FROM `users` WHERE name='wathmal'");

            if (mysqli_num_rows($res) == 0) {
                echo "user name is wrong!";
            } else {
                while ($row = $res->fetch_assoc()) {

                    // verifing happens here
                    if (_user_check_password("abc123", $row['pass'])) {
                        echo "password is correct";
                    }
                    else{
                        echo "wrong password";
                    }
                    //echo $row->pass;
                }
            }
        } else {
            
        }
        ?>
    </body>
</html>

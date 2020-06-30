<?php
/* Power By Yexs */
require_once __DIR__ . '/vendor/autoload.php';

use Laizerox\Wowemu\SRP\UserClient;

include 'db.php';
/* Connect to your CMaNGOS database. */
$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName, $port);

/* If the form has been submitted. */
if (isset($_POST['register'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $email = $_POST['email'];


    /* Grab the users IP address. */
    $ip = $_SERVER['REMOTE_ADDR'];

    /* Set the join date. */
    $joinDate = date('Y-m-d H:i:s');

    /* Set GM Level. */
    $gmLevel = '0';

    /* Set expansion pack - Wrath of the Lich King. */
    $expansion = '2';

    /* Create your v and s values. */
    $client = new UserClient($username);
    $salt = $client->generateSalt();
    $verifier = $client->generateVerifier($password);


    /* Function to get values from MySQL. */
    function getMySQLResult($query)
    {
        global $db;
        return $db->query($query)->fetch_object();
    }

    /* Get the salt and verifier from realmd.account for the user. */
    $query = "SELECT username,email FROM account WHERE username='$username' LIMIT 1";
    $result = getMySQLResult($query);
    $verifierFromDatabase = ($result);


    /* Compare $verifierFromDatabase and $verifier. */
    if ($verifierFromDatabase) {
        echo "exists";
        return;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        function post_captcha($user_response)
        {
            $fields_string = '';
            $fields = array(
                'secret' => '6Le2aKsZAAAAADovEIfYdevuuIHdJalLUZHfSnTr',
                'response' => $user_response
            );
            foreach ($fields as $key => $value)
                $fields_string .= $key . '=' . $value . '&';
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

            $result = curl_exec($ch);
            curl_close($ch);

            return json_decode($result, true);
        }

        // Call the function post_captcha
        $res = post_captcha($_POST['g-recaptcha-response']);

        if (!$res['success']) {
            // What happens when the CAPTCHA wasn't checked
            echo 'captcha';
        } else if(mysqli_query($db, "INSERT INTO account (username, v, s, gmlevel, email, joindate, last_ip, expansion) VALUES ('$username', '$verifier', '$salt',  '$gmLevel', '$email', '$joinDate', '$ip', '$expansion')"))
        {
            echo 'registered';
        }
    }

    /* Insert the data into the CMaNGOS database. */
}

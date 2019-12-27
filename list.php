<?php



$username=$_POST['auth'];
$secret=$_POST['secret'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_POST['api']);
curl_setopt($ch, CURLOPT_POST, 1);

if (empty($_POST['search'])) {
    curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClients',
            // See https://developers.whmcs.com/api/authentication
            'username' => $username,
            'password' => $secret,
            'limitnum' => $_POST['limit'],
            'responsetype' => 'json',
        )
    )
);

} else {
    curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClients',
            // See https://developers.whmcs.com/api/authentication
            'username' => $username,
            'password' => $secret,
            'search' => $_POST['search'],
            'limitnum' => $_POST['limit'],
            'responsetype' => 'json',
        )
    )
);
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
echo $response;
curl_close($ch);


?>
<?php
// Your Twilio Account SID and Auth Token
$account_sid = "your_account_sid";
$auth_token  = "your_auth_token";

// Your Twilio number
$twilio_number = "+15555555555";

// Twilio API endpoint
$url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json?To=" . urlencode($twilio_number);

// Make the request using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, $account_sid . ":" . $auth_token);

$response = curl_exec($ch);
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Collect unique senders
$senders = [];
foreach ($data['messages'] as $msg) {
    $from = $msg['from'];
    if (!in_array($from, $senders)) {
        $senders[] = $from;
    }
}

// Print results
echo "Numbers that sent you SMS:\n";
foreach ($senders as $sender) {
    echo $sender . "\n";
}
?>

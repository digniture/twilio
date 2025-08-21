<?php
// Your Twilio Account SID and Auth Token
$account_sid = "your_account_sid";
$auth_token  = "your_auth_token";

// Your Twilio number
$twilio_number = "+15555555555";

// The sender number you want to filter by
$sender_number = "+14445556666";

// Twilio API endpoint with filters
$url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json?To=" 
     . urlencode($twilio_number) 
     . "&From=" . urlencode($sender_number);

// Make the request using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, $account_sid . ":" . $auth_token);

$response = curl_exec($ch);
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Print all messages from that sender
echo "Messages from $sender_number:\n";
foreach ($data['messages'] as $msg) {
    echo "[" . $msg['date_sent'] . "] " . $msg['body'] . "\n";
}
?>

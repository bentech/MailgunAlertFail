<?php
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$client = new \Http\Adapter\Guzzle6\Client();
$mg = new Mailgun('<INSERT YOUR MAILGUN PRIVATE KEY>', $client);

$domain = "<INSERT YOUR MAILGUN DOMAIN";

$headers = json_decode( $_POST["message-headers"]);

$sender = NULL;

foreach($headers as $h)
{
    if($h[0] == "Sender"){
        $sender = $h[1];
    }
}

if(!(endsWith($sender, $domain) || endsWith($sender, $domain))){
    exit("Error wrong sender domain");//Prevents mails to different domains
}

$json_string = json_encode($data, JSON_PRETTY_PRINT);

$mg->sendMessage($domain, array('from'    => 'mailfail@'.$headers["domain"], 
                                'to'      => $sender, 
                                'subject' => 'Your mail didn\'t send!', 
                                'text'    => $json_string
                            ));


?>


<?php

$path =dirname(__DIR__)."/libraries/backend_libraries/vendor/autoload.php";
require_once "{$path}";
use Mailgun\Mailgun;

function sendEmailBatch($to, $from, $recipientVars,  $subject,$html_file,$parameters)
{
# Instantiate the client.
    $mgClient = new Mailgun(MAILGUN_API_KEY);
    $domain = MAILGUN_DOMAIN;

# Make the call to the client.
    $from = "KeywoPics <{$from}>";
    $result = $mgClient->sendMessage($domain, array(
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'html' => get_template($html_file, $parameters),
        'recipient-variables' => $recipientVars // json string
    ));

    if ($result->http_response_code == 200) {
        $errMsg = "Mails sent successfully.";
        return set_error_stack(-1,$errMsg);
    } else {
        $errMsg = "Failed to send email.";
        return set_error_stack(3);
    }


}


function sendEmail($to, $from, $subject,$html_file,$parameters)
{
# Instantiate the client.
    $mgClient = new Mailgun(MAILGUN_API_KEY);
    $domain = MAILGUN_DOMAIN;

# Make the call to the client.
    $from = "KeywoPics <{$from}>";
    $result = $mgClient->sendMessage($domain, array(
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'html' => get_template($html_file, $parameters)
    ));

    if ($result->http_response_code == 200) {
        $errMsg = "Mails sent successfully.";
        return set_error_stack(-1,$errMsg);
    } else {
        $errMsg = "Failed to send email.";
        return set_error_stack(3);
    }


}


function sendEmailAttachment($to, $from,  $subject,$html_file,$parameters, $attachmentPath)
{
# Instantiate the client.
    $mgClient = new Mailgun(MAILGUN_API_KEY);
    $domain = MAILGUN_DOMAIN;

# Make the call to the client.
    $from = "KeywoPics <{$from}>";
    $result = $mgClient->sendMessage($domain, array(
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'html' =>get_template($html_file, $parameters)
    ), array(
        'attachment' => array($attachmentPath, $attachmentPath)
    ));


    if ($result->http_response_code == 200) {
        $errMsg = "Mails sent successfully.";
        return set_error_stack(-1,$errMsg);
    } else {
        $errMsg = "Failed to send email.";
        return set_error_stack(3);
    }


}




function get_template($html_file, $parameters = "")
{
    if (!empty($html_file)) {
        if (file_exists(DIR_ASSETS_EMAIL_TEMPLATES.$html_file)) {
            $html = file_get_contents(DIR_ASSETS_EMAIL_TEMPLATES.$html_file);
            if (!empty($parameters) && is_array($parameters)) {
                foreach ($parameters as $key => $parameter) {
                    $html = str_replace("[$key]", $parameter, $html);
                }
                return $html;
            } else {
                return $html;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

?>
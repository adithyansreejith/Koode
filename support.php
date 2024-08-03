<?php

$email_to = 'koodehelp@gmail.com';
$email_subject = 'Support Form Submission';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = trim($_POST['formName']);
    $email = trim($_POST['formEmail1']);
    $message = trim($_POST['formMessage']);

    
    if (empty($name) || empty($email) || empty($message)) {
        echo 'Error: Please fill in all fields.';
        exit;
    }

    
    $headers = 'From: ' . $email . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $message, $headers);

    
    echo 'Thank you for contacting us! Your message has been sent.';
} else {

    include 'form.html';
}

?>

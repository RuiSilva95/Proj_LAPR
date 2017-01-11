<?php
require "../core/init.php";

// Check for empty fields
if(empty($_POST['name'])
    || empty($_POST['email'])
    || empty($_POST['phone'])
    || empty($_POST['message'])
    || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    echo "No arguments Provided!";
    return false;
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));


$result = mysqli_query($conn, "SELECT name FROM users");
while ($row = mysqli_fetch_array($result)) {
    $query = 'insert into message(de,para,title,message,date) values ("'.$_POST["email"].'","'.$row['name'].'","'.$_POST["phone"].'","'.$_POST["message"].'",curdate()) ';
    $result2 = mysqli_query($conn, $query);
}

// Create the email and send the message
/*$to = 'yourname@yourdomain.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";


mail($to, $email_subject, $email_body, $headers);*/
return true;
?>

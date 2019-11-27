<?php



    $site_owners_email = 'Itumeleng.tele@gmail.com'; // Replace this with your own email address

    $site_owners_name = 'Choco'; // replace with your name



    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    

    $error = "";



    if (strlen($name) < 2) {

        $error['name'] = "Please enter your name.";

    }



    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {

        $error['email'] = "Please enter a valid email address";

    }

    if (strlen($subject) < 2) {

        $error['subject'] = "Please enter a subject.";

    }



    if (strlen($message) < 2) {

        $error['message'] = "Please leave a message.";

    }



    if (!$error) {



        require_once('phpmailer/class.phpmailer.php');

        $mail = new PHPMailer();



        $mail->From = $email;

        $mail->FromName = $name;

        $mail->Subject = $subject;

        

        $mail->AddAddress($site_owners_email, $site_owners_name);

        $mail->IsHTML(true);

        $mail->Body = '<b>Sender Name:</b> '. $name .'<br/><b>Sender Phone:</b> '. $phone .'<br/><b>Sender Company:</b> '. $company .'<br/><b>Sender E-mail:</b> '. $email . '<br/><br/><b>Sender Message:</b><br/>' . $message;



        $mail->Send();

        

        $response = array("type" => "success", "content" => "<div class='alert alert-success' role='alert'>Thanks " . $name . ". Your message has been sent.</div>");



        echo json_encode($response);



    } # end if no error

    else {



        $response = (isset($error['name'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['name'] . "</div> \n" : null;

        $response .= (isset($error['email'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['email'] . "</div> \n" : null;
 
        $response .= (isset($error['subject'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['subject'] . "</div>" : null;

        $response .= (isset($error['message'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['message'] . "</div>" : null;

        

        $response = array('type' => 'error', 'content' => $response);



        echo json_encode($response);

    } # end if there was an error sending



?>


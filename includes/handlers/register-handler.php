<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function sanitizeFormPassword($inputText)
{

    $inputText = strip_tags($inputText);
    return $inputText;
}

function sanitizeFormUsername($inputText)
{

    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
}

function sanitizeFormString($inputText)
{

    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}

function sanitizeFullName($inputText)
{
    $inputText = strip_tags($inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}



$feedback = [];

try {
    //code...
    if (isset($_POST['registerButton'])) {
        //login button was pressed
        $username = sanitizeFormUsername($_POST['username']);
        $firstName = sanitizeFullName($_POST['firstName']);
        $email = sanitizeFormString($_POST['email']);
        $password = sanitizeFormPassword($_POST['password']);
        $password2 = sanitizeFormPassword($_POST['password2']);
        $userregStatus = "registered";


        //  our url is now stored as $_POST['location'] (posted from login.php). If it's blank, let's ignore it. Otherwise, let's do something with it.
        $redirect = NULL;
        if ($_POST['location'] != '') {
            $redirect = $_POST['location'];
        }

        $wasSuccessful =  $account->register($username, $firstName, $email, $password, $password2, $userregStatus);

        if ($wasSuccessful == true) {
            setcookie("userID",$username, time() +
                                    (10 * 365 * 24 * 60 * 60));
            $_SESSION['userLoggedIn'] = $username;
            if ($redirect) {
                header("Location:" . $redirect);
            } else {
                header("Location: index");
            }
        }
    } else if (isset($_POST['tryButton'])) {
        //login button was pressed

        $usernum = rand();
        $username = $usernum;
        $firstName = $usernum;
        $email = $usernum . "@mw.com";
        $password = $usernum;
        $password2 = $usernum;
        $userregStatus = "trial";

        //  our url is now stored as $_POST['location'] (posted from login.php). If it's blank, let's ignore it. Otherwise, let's do something with it.
        $redirect = NULL;
        if ($_POST['location'] != '') {
            $redirect = $_POST['location'];
        }


        $wasSuccessful =  $account->register($username, $firstName, $email, $password, $password2, $userregStatus);

        if ($wasSuccessful == true) {
            setcookie("userID",$username, time() +
                                    (10 * 365 * 24 * 60 * 60));
            $_SESSION['userLoggedIn'] = $username;

            if ($redirect) {
                header("Location:" . $redirect);
            } else {
                header("Location: index");
            }
        }
    }
} catch (\Throwable $th) {
    //throw $th;
    $feedback['success'] = false;
    $feedback['error'] = "Error With REgister Button";
    $feedback['error'] = $th->getMessage();
}
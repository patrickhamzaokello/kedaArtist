<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$feedback = [];

try {
    if (isset($_POST['loginButton'])) {
        //login button was pressed
        $username = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];

        $result = $account->login($username, $password);

        //  our url is now stored as $_POST['location'] (posted from login.php). If it's blank, let's ignore it. Otherwise, let's do something with it.
        $redirect = NULL;
        if ($_POST['location'] != '') {
            $redirect = $_POST['location'];
        }

        try {
            if ($result) {
                if ($result == true) {


                    $usernameFromemail = $account->getEmailtousername($username);
                    $username = $usernameFromemail->getUsernameemail();

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
            $feedback['error'] = $this->getMessage();
        }
    }
} catch (\Throwable $th) {
    $feedback['success'] = false;
    $feedback['error'] = "Error With Login Button";
    $feedback['error'] = $th->getMessage();
}
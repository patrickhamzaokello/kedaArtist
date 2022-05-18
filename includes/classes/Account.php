<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class Account
{
    private $con;
    private $errorArray;

    public function __construct($con)
    {
        $this->con = $con;
        $this->errorArray = array();
    }


    public function login($un, $pw)
    {
        $feedback = [];
        try {
            if ($this->con == null) {
                $feedback['success'] = false;
                $feedback['error'] = "Connection Problems, Check your Connection and Try again";
                array_push($this->errorArray, Constants::$ConnectionProblem);
            } else if ($this->con) {
                $encryptedpw = md5($pw);

                $statement = $this->con->prepare('SELECT * FROM users WHERE  email=? AND Password =? OR username=? AND Password =? ');
                $statement->bind_param('ssss', $un,$encryptedpw, $un, $encryptedpw);
                if ($statement->execute()) {
                    $statement->store_result();
                    $statement->fetch();
                    if ($statement->num_rows == 1) {
                        return true;
                    } else {
                        array_push($this->errorArray, Constants::$loginFailed);

                        return false;
                    }
                } else {
                    array_push($this->errorArray, Constants::$loginFailed);

                    return false;
                }
              
            }
        } catch (\Throwable $th) {
            $feedback['error'] = $th->getMessage();
        }
    }

    public function register($un, $fn, $em, $pw, $pw2, $userstatus)
    {
        $this->validateUsername($un);
        $this->validatefirstName($fn);
        $this->validateEmails($em);
        $this->validatePassword($pw, $pw2);

        if (empty($this->errorArray) == true) {
            //insert into db
            return $this->insertUserDetails($un, $fn, $em, $pw, $userstatus);
        } else {
            return false;
        }
    }

    public function getError($error)
    {
        if (!in_array($error, $this->errorArray)) {
            $error = "";
        }

        return "<span class='errorMessage'>$error</span>";
    }

    private function insertUserDetails($un, $fn, $em, $pw, $userstatus)
    {

        $encryptedpw = md5($pw); //encrypt password in md5
        $profilePic = "assets/images/profile-pics/user.png";
        $firstthreeletters = substr($un, 0,3);
        $id = "mw".uniqid().$firstthreeletters;
        $date = date("Y-m-d");
        $status = $userstatus;

        try {
            $result = mysqli_query($this->con, "INSERT INTO users(`id`,`username`,`Firstname`,`Email`,`Password`,`signUpDate`,`profilePic`,`status`) VALUES ('$id','$un','$fn','$em','$encryptedpw','$date','$profilePic','$status')");
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
            array_push($this->errorArray, Constants::$ConnectionProblem);
        }
    }



    public function getEmailtousername($userName){

        $userName = strip_tags($userName);

        return new User($this->con , $userName);
    }


    private function validateUsername($un)
    {
        if (strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        try {
            //code...
            //TODO: Check if username exists
            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username = '$un'");

            if (mysqli_num_rows($checkUsernameQuery) != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        } catch (\Throwable $th) {
            //throw $th;
            array_push($this->errorArray, Constants::$ConnectionProblem);
        }
    }

    private function validatefirstName($fn)
    {
        if (strlen($fn) > 100 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
            return;
        }
    }


    private function validateEmails($em)
    {

        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        try {
            //TODO : check that email hasn't been used.
            $checkEmailQuery = mysqli_query($this->con, "SELECT Email FROM users WHERE Email = '$em'");
            if (mysqli_num_rows($checkEmailQuery) != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        } catch (\Throwable $th) {
            //throw $th;
            array_push($this->errorArray, Constants::$ConnectionProblem);
        }
    }

    private function validatePassword($pw, $pw2)
    {

        if ($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNoMatch);
            return;
        }

        if (preg_match('/[^A-Za-z0-9]/', $pw)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if (strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }
}
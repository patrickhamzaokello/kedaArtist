<?php
session_start();

include("config/database.php");

$message = "";
if (count($_POST) > 0) {
    $result = mysqli_query($con, "SELECT * FROM artists WHERE  password = '" . $_POST["password"] . "' AND email='" . $_POST["emailUsername"] . "' or name='" . $_POST["emailUsername"] . "'");
    $row  = mysqli_fetch_array($result);
    if (is_array($row)) {
        $_SESSION["id"] = $row['id'];
        $_SESSION["name"] = $row['name'];
        $_SESSION["genre"] = $row['genre'];
        $_SESSION["tag"] = $row['tag'];
    } else {
        $message = "Invalid Username or Password!";
    }
}
if (isset($_SESSION["id"])) {

    if ($_SESSION["tag"] == 'music') {
        header("Location:managecontent");
    } elseif ($_SESSION["tag"] == 'podcast') {
        header("Location:managecontent");
    } elseif ($_SESSION["tag"] == 'poem') {
        header("Location:managecontent");
    } elseif ($_SESSION["tag"] == 'dj') {
        header("Location:managecontent");
    } else {
        header("Location:index");
    }

    // if ($_SESSION["tag"] == 'music') {
    //     header("Location:managecontent");
    // } elseif ($_SESSION["tag"] == 'podcast') {
    //     header("Location:podcastcollection");
    // } elseif ($_SESSION["tag"] == 'poem') {
    //     header("Location:poemcollection");
    // } elseif ($_SESSION["tag"] == 'dj') {
    //     header("Location:mixcollections");
    // } else {
    //     header("Location:index");
    // }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YNG3P75VXH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-YNG3P75VXH');
    </script>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="mask-icon" href="../assets/images/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="../browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- favicon end  -->

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- end of bootstrap -->



    <title>Artist Login</title>
    <link rel="stylesheet" href="mwonyacreate.css">

</head>


<body>

    <nav class="navbar navbar-inverse bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Mwonyaa Artist</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index">Home</a></li>
                    <li class="active"><a href="login">Login</a></li>
                    <li><a href="contentcreator">Register</a></li>

                </ul>

            </div>
        </div>
    </nav>


    <div class="backgroundcover">
        <div class="container">
            <div class="slide-in-right">
                <div class="loginforminner">

                    <h3>Mwonyaa Artist </h3>
                    <p>Login into your Account, or Signup on the link below</p>

                    <form name="frmUser" method="post" action="" autocomplete="off" class="">
                        <?php if ($message != "") {
                            echo "<div class='message'>
                                                " . $message . "
                                         </div>";
                        } ?>
                        <label class="artistlabel" for="email_textfield">Email / Username <span class="required">
                                *</span></label>

                        <input type="text" id="email_textfield" class="inputfield" name="emailUsername"
                            placeholder="Artist Username / Email" required>

                        <label class="artistlabel" for="passwordfield">Password <span class="required">*</span></label>
                        <input id="passwordfield" class=" inputfield" type="password" name="password"
                            placeholder="Password" required>
                        <br><br>
                        <button id="loginbutton" type="submit" name="submit" value="Submit">Log In</button>
                        <button id="clearbutton" type="reset">Clear Form</button>
                    </form>
                    <p class="signuplink">Need an Account? <a href="contentcreator">Register Here!</a></p>


                </div>
            </div>
        </div>
    </div>





    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>

</body>

</html>
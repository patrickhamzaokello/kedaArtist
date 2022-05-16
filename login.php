<?php
session_start();

include("config/database.php");

$message = "";
if (count($_POST) > 0) {
    if (!empty($con)) {
        $result = mysqli_query($con, "SELECT * FROM artists WHERE  password = '" . $_POST["password"] . "' AND email='" . $_POST["emailUsername"] . "' or name='" . $_POST["emailUsername"] . "'");
    }
    $row = mysqli_fetch_array($result);
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
 <meta name="theme-color" content="#381b56" />
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
    <meta name="msapplication-config" content="assets/favicon/browserconfig.xml">
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">


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


    <div class="SidePanelWrapper_wrapper__2Qh_A">
        <div class="SidePanelWrapper_dialog__ERXxW">

            <div class="SidePanelWrapper_scrollable-wrapper__26f9j">
                <div class="loginformui">
                    <div class="loginscreeen">
                        <h3>Mwonyaa Artist </h3>
                        <p>Login into your Account, or Signup on the link below</p>

                        <div class="LoginForm_container__sUvUd">
                            <form name="frmUser" method="post" action="" autocomplete="off" class="loginform_new">
                                <?php if ($message != "") {
                                    echo "<div class='message'>
                                                " . $message . "
                                         </div>";
                                } ?>
                                <label class="artistlabel" for="email_textfield">Email / Username <span class="required">
                                        *</span></label>

                                <input type="text" id="email_textfield" class="inputfield" name="emailUsername" placeholder="Artist Username / Email" required>

                                <label class="artistlabel" for="passwordfield">Password <span class="required">*</span></label>
                                <input id="passwordfield" class=" inputfield" type="password" name="password" placeholder="Password" required>
                                <br><br>
                                <button id="loginbutton" type="submit" name="submit" value="Submit">Log In</button>
                            </form>
                            <p class="signuplink">Need an Account? <a href="contentcreator">Register Here!</a></p>

                        </div>


                    </div>



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
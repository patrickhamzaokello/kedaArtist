<!DOCTYPE html>


<html lang="en">

<?php

include("config/global.php");
include("uploadscripts/artistupload.php");


?>


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

    <link rel="stylesheet" href="mwonyacreate.css">
    <script src="mwonyacreate.js"></script>

    <title>Mwonyaa Artist Creation</title>

    <style>
        .socialdetails {
            margin: 2em 0;
        }

        .socialdetails h1,
        p {
            margin: 0;
            padding: 0;
        }
    </style>


</head>

<body>

    <div class="SidePanelWrapper_wrapper__2Qh_A">
        <div class="SidePanelWrapper_dialog__ERXxW">

            <div class="SidePanelWrapper_scrollable-wrapper__26f9j">
                <div class="loginformui">
                    <div class="loginscreeen">

                        <!-- Display response messages -->
                        <?php if (!empty($resMessage)) { ?>
                            <div class="alert <?php echo $resMessage['status'] ?>">
                                <?php echo $resMessage['message'] ?>
                            </div>
                        <?php } ?>

                        <?php

                        //Our select statement. This will retrieve the data that we want.
                        $sqlgenre = "SELECT id, name FROM genres ORDER BY `genres`.`name` ASC";

                        //Prepare the select statement.
                        $stmtgrenre = $conn->prepare($sqlgenre);




                        //Execute the statement.
                        $stmtgrenre->execute();


                        //Retrieve the rows using fetchAll.
                        $genres = $stmtgrenre->fetchAll();



                        ?>


                        <div class="contheadingtile">
                            <h4>Artist Signup </h4>
                            <p>Become a content creator on Mwonyaa and start Sharing your Content on the Mwonyaa Stream
                                Platform
                            </p>
                        </div>

                        <p class="signuplink">Have an Account? <a href="login">Login</a></p>


                        <form class="artistform" action="" method="post" enctype="multipart/form-data" class="mb-3">



                            <label class="artistlabel" for="artistusername">Artist Name <span class="required">*</span></label>
                            <input type="text" name="Artistname" class="inputfield " id="artistusername" aria-describedby="nameHelp" placeholder="Enter Artist Name" required>
                            <label class="artistlabel" for="artistLabel"> Artist Label <span class="required">*</span></label>
                            <input type="text" name="artistLabel" class="inputfield" id="artistLabel" aria-describedby="nameHelp" placeholder="Enter Artist Label" required>
                            <label class="artistlabel" for="artistphone">Artist Phone no <span class="required">*</span></label>
                            <input type="number" name="artistphone" class="inputfield" id="artistphone" aria-describedby="nameHelp" placeholder="Enter Artist Phone" required>
                            <label class="artistlabel" for="artistemail"> Artist Email <span class="required">*</span></label>
                            <input type="email" name="Artistemail" class="inputfield" id="artistemail" aria-describedby="nameHelp" placeholder="Enter Artist Email" required>

                            <div class="form-group">
                                <label for="songGenre">Artist Genre <span class="required">*</span></label>
                                <select id="songGenre" name="songGenre" required class="inputfield">
                                    <option value="">Choose Genre</option>
                                    <?php foreach ($genres as $genre) : ?>
                                        <option value="<?= $genre['id']; ?>"><?= $genre['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="socialdetails">
                                <h1>Social Details</h1>
                                <p>Social media account links</p>
                            </div>
                            <div class="form-group">
                                <label class="artistlabel" for="artistFacebookurl">Facebook Url </label>
                                <input type="text" name="artistFacebookurl" class="inputfield" id="artistFacebookurl" aria-describedby="nameHelp" placeholder="Facebook Url">
                                <label class="artistlabel" for="artistInstagramurl">Instagram Url</label>
                                <input type="text" name="artistInstagramurl" class="inputfield" id="artistInstagramurl" aria-describedby="nameHelp" placeholder="Instagram Url">

                                <label class="artistlabel" for="artistTwitterurl">Twitter Url</label>
                                <input type="text" name="artistTwitterurl" class="inputfield" id="artistTwitterurl" aria-describedby="nameHelp" placeholder="Twitter Url">
                            </div>



                            <div class="socialdetails">
                                <h1>Profile Images</h1>
                                <p>Artist account photo</p>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <label class="artistlabel" class="custom-file-label" for="chooseFile">Artist
                                        Profile Image</label>

                                    <input type="file" name="fileUpload" class="custom-file-input inputfield" id="chooseFile" accept="image/*">
                                </div>

                                <div class="custom-file">
                                    <label class="artistlabel" class="artistlabel" class="custom-file-label" for="chooseCoverFile">Artist Cover
                                        Image</label>

                                    <input type="file" name="coverUpload" accept="image/*" class="custom-file-input inputfield" id="chooseCoverFile">
                                </div>
                            </div>




                            <div class="socialdetails">
                                <h1>Account Auth</h1>
                                <p>Artist account Authentication</p>
                            </div>
                            <div class="form-group">
                                <label class="artistlabel" for="artistpassword">Password <span class="required">*</span></label>
                                <input type="password" name="Artistpassword" class="inputfield" id="artistpassword" aria-describedby="nameHelp" placeholder="Password" required>
                                <label class="artistlabel" for="artistconfirmpassword">Confirm Password <span class="required">*</span></label>
                                <input type="password" name="Artistconfirmpassword" class="inputfield" id="artistconfirmpassword" aria-describedby="nameHelp" placeholder="Confirm Password" required>

                            </div>


                            <button type="submit" name="submit" class="createartistbutton">
                                Create Artist
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="leftsideupload">


        <div id="imageholdingdiv" style="position: relative; left: 0; top: 0; width:100%; height:200px">
            <img src="..." id="coverplaceholder" class="coverimage" />
            <img src="..." id="imgPlaceholder" class="artist" />
        </div>


    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script>
        var errorarray = [];

        function _(id) {
            return document.getElementById(id);
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                $('#imageholdingdiv').css('display', 'block');
                reader.onload = function(e) {
                    $('#imgPlaceholder').attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        function readCoverURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                $('#imageholdingdiv').css('display', 'block');
                reader.onload = function(e) {
                    $('#coverplaceholder').attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(document).click(function(click) {
            var target = $(click.target);

            if (target.hasClass("inputfield")) {
                $('#artistconfirmpassword').css('border', '1px solid lightblue;');
                $('#artistemail').css('border', '1px solid lightblue;');
                $('#exampleInputEmail1').css('border', '1px solid lightblue;');
            }
        });


        function nextStep() {

            var name = _("exampleInputEmail1").value;
            var email = _("artistemail").value;
            var password = _("artistpassword").value;
            var confirmpassword = _("artistconfirmpassword").value;


            if (name == '') {
                $('#exampleInputEmail1').css('border', '2px solid red');

                errorarray.push("empty name");
            } else if (email == '') {
                $('#artistemail').css('border', '2px solid red');


            } else if (password != confirmpassword) {
                $('#artistpassword').css('border', '2px solid red');
                $('#artistconfirmpassword').css('border', '2px solid red');


            } else {

                $('#artistconfirmpassword').css('border', 'none');
                $('#artistemail').css('border', 'none');
                $('#exampleInputEmail1').css('border', 'none');


                $('#step1form').css('display', 'none');
                $('#step2form').css('display', 'block');
                $('#step3form').css('display', 'none');

            }


        }

        function nextStep2() {
            $('#step1form').css('display', 'none');
            $('#step2form').css('display', 'none');
            $('#step3form').css('display', 'block');


        }

        function nextStep2back() {
            $('#step1form').css('display', 'block');
            $('#step2form').css('display', 'none');
            $('#step3form').css('display', 'none');
        }

        function nextStep3back() {
            $('#step1form').css('display', 'none');
            $('#step2form').css('display', 'block');
            $('#step3form').css('display', 'none');
        }

        $("form").on("change", ".file-upload-field", function() {
            $(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));
        });

        $("#chooseFile").change(function() {
            readURL(this);
        });

        $("#chooseCoverFile").change(function() {
            readCoverURL(this);
        });
    </script>


</body>

</html>
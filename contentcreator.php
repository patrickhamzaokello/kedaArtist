<!DOCTYPE html>


<html lang="en">

<?php

include("config/global.php");
// echo $artistname;

// echo $artistid;
// echo $contenttag;
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

    <link rel="stylesheet" href="mwonyacreate.css">
    <script src="mwonyacreate.js"></script>

    <title>Mwonyaa Artist Creation</title>

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
                    <li><a href="login">Login</a></li>
                    <li class="active"><a href="contentcreator">Register</a></li>

                </ul>

            </div>
        </div>
    </nav>


    <div class="backgroundcover">
        <div class="container">

            <div class="slide-in-right">
                <div class="loginforminner">

                    <!-- Display response messages -->
                    <?php if (!empty($resMessage)) { ?>
                        <div class="alert <?php echo $resMessage['status'] ?>">
                            <?php echo $resMessage['message'] ?>
                        </div>
                    <?php } ?>


                    <div class="contheadingtile">
                        <h4>Mwonyaa Stream Artist </h4>
                        <p>Create An Artist Account to get Started with Sharing your Content on the Mwonyaa Stream
                            Platform
                        </p>
                    </div>

                    <p class="signuplink">Have an Account? <a href="login">Login</a></p>


                    <form class="artistform" action="" method="post" enctype="multipart/form-data" class="mb-3">

                        <div id="step1form" class="slide-in-right">


                            <label class="artistlabel" for="artistusername">Artist Name <span class="required">*</span></label>
                            <input type="text" name="Artistname" class="form-control inputfield " id="artistusername" aria-describedby="nameHelp" placeholder="Enter Artist Name" required>
                            <label class="artistlabel" for="artistemail">Email <span class="required">*</span></label>
                            <input type="email" name="Artistemail" class="form-control inputfield" id="artistemail" aria-describedby="nameHelp" placeholder="Enter Artist Email" required>

                            <label class="artistlabel" for="artistpassword">Password <span class="required">*</span></label>
                            <input type="password" name="Artistpassword" class="form-control inputfield" id="artistpassword" aria-describedby="nameHelp" placeholder="Password" required>
                            <label class="artistlabel" for="artistconfirmpassword">Confirm Password <span class="required">*</span></label>
                            <input type="password" name="Artistconfirmpassword" class="form-control inputfield" id="artistconfirmpassword" aria-describedby="nameHelp" placeholder="Confirm Password" required>





                        </div>


                        <div class="form-group">
                            <label class="artistlabel" for="inputState">Artist Genre <span class="required">*</span></label>
                            <select name="taskOption" id="inputState" class="inputfield" required>
                                <option value="">Choose Genre</option>
                                <?php foreach ($genres as $genre) : ?>
                                    <option value="<?= $genre['id']; ?>"><?= $genre['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="artistlabel" for="artistType">Content Type <span class="required">*</span></label>
                            <select name="artistType" id="artistType" class="inputfield" required>
                                <option value="">Choose Content Type</option>
                                <option value="music">Music</option>
                                <option value="podcast">Podcast</option>
                                <option value="poem">Poem</option>
                                <option value="dj">DJ</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label class="artistlabel" for="Artistdescription">Artist Description <span class="required">*</span></label>
                            <textarea id="artistdesc" type="password" name="Artistdescription" class="" id="Artistdescription" aria-describedby="nameHelp" placeholder="Description" required> </textarea>
                        </div>




                        <div class="form-group">
                            <div class="custom-file">
                                <label class="artistlabel" class="custom-file-label" for="chooseFile">Select Artist
                                    Image</label>

                                <input type="file" name="fileUpload" class="custom-file-input inputfield" id="chooseFile" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <label class="artistlabel" class="artistlabel" class="custom-file-label" for="chooseCoverFile">Select Artist Cover
                                    Image</label>

                                <input type="file" name="coverUpload" accept="image/*" class="custom-file-input inputfield" id="chooseCoverFile">
                            </div>
                        </div>


                        <button type="submit" name="submit" class="createartistbutton">
                            Create Artist
                        </button>
                        <button type="reset" name="cancel" class="cancelartistbutton">
                            Clear Form
                        </button>

                    </form>



                </div>





            </div>



            <div class="leftsideupload">


                <div id="imageholdingdiv" style="position: relative; left: 0; top: 0; width:100%; height:200px">
                    <img src="..." id="coverplaceholder" class="coverimage" />
                    <img src="..." id="imgPlaceholder" class="artist" />
                </div>


            </div>
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
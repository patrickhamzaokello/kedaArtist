<?php
include("config/global.php");
// echo $artistname;
// echo $artistid;
include("uploadscripts/collectionupload.php");

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- end of bootstrap -->


    <link rel="stylesheet" href="mwonyacreate.css">
    <title>New Media Collection</title>

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


                    <?php
                    if ($contenttag == "music") {
                        echo " 
                        <li   class='active'><a class='nav-link' href='createcollection'>New Media Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Songs</a></li>
                        <li><a class='nav-link' href='managecontent'>Manage Content</a></li>
                     
                        ";
                    } else if ($contenttag == "podcast") {
                        echo "
                       <li class='active'><a class='nav-link' href='createcollection'>Create Podcast Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Podcast</a></li>
                        <li><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
                    } else if ($contenttag == "dj") {
                        echo "
                        <li  class='active'><a class='nav-link' href='createcollection'>Create Mixtape Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Mixtape</a></li>
                        <li ><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
                    } else if ($contenttag == "poem") {

                        echo " 
                       <li  class='active'><a class='nav-link' href='createcollection'>Create Poem Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Poem</a></li>
                        <li><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
                    } else {
                        echo " ";
                    }

                    ?>


                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <?php
                    if (isset($_SESSION["name"])) {

                        echo "

                        <li><a href='logout' tite='Logout'><span class='glyphicon glyphicon-log-out'></span> Logout</a>
                        </li> ";
                    } else {
                        echo "
                        <li><a href='contentcreator'><span class='glyphicon glyphicon-user'></span> Sign Up</a></li>
                        <li><a href='login' tite='Login'><span class='glyphicon glyphicon-log-in'></span> Login</a>

                        </li>

                        ";
                    }


                    ?>

                </ul>
            </div>
        </div>
    </nav>


    <div id="loginbody">
        <div class="container">
            <form id="createform" action="" method="post" enctype="multipart/form-data">

                <div class="formcontainer slide-in-right">



                    <div class="loginforminner">

                        <div class="cardtitle">
                            <h1>Create New Media Collection</h1>
                            <p>Provide the Required information when creating a new collection</p>
                        </div>
                        <!-- Display response messages -->
                        <?php if (!empty($resMessage)) { ?>
                            <div class="alert <?php echo $resMessage['status'] ?>">
                                <?php echo $resMessage['message'] ?>
                            </div>
                        <?php } ?>
                        <div class="inputformelement">
                            <input type="text" name="contenttype" required class="inputarea disabledinput" readonly id="albumtag" aria-describedby="nameHelp" value="<?= $contenttag ?>">
                        </div>

                        <div class="inputformelement">
                            <label for="exampleInputEmail1">Collection Title <span class="required">*</span></label>
                            <input type="text" name="AlbumTitle" required class="inputarea" id="exampleInputEmail1" aria-describedby="nameHelp" placeholder="Enter Album Title">
                        </div>

                        <div class="inputformelement">
                            <label for="exampleInputdescription">Collection Description <span class="required">*</span></label>
                            <textarea type="textarea" required name="description" class="inputarea" id="exampleInputdescription" aria-describedby="descriptionHelp" placeholder="Album Description"></textarea>
                        </div>

                        <div class="inputformelement">

                            <div class="custom-file">
                                <label class="custom-file-label" for="chooseFile">Select Album Cover <span class="required">*</span></label>

                                <input type="file" accept=".jpg, .png, .jpeg" name="fileUpload" class="inputfield custom-file-input" id="chooseFile">
                            </div>
                        </div>




                        <p class="helptext">+ Add Image and the upload button will show up</p>


                    </div>

                    <div class="card">


                        <div id="imageholdingdiv" class="user-image mb-3 text-center slide-in-right">


                            <div class="albumtitletext">
                                <h5>Album Preview</h5>
                                <p>This shows how the artwork will appear on your Page</p>

                            </div>
                            <div class="imageholder">
                                <img src="" class="figure-img img-fluid rounded contentimage" id="imgPlaceholder" alt="">
                            </div>

                            <div class="albumtitletext">

                                <p>Album Title: <span id="putalbumname">Album Name</span></p>

                            </div>

                            <button type="submit" name="submit" class="createbutton">
                                Create Album
                            </button>



                            <button type="reset" name="clear" class="cancelbutton">
                                Clear Form
                            </button>

                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                // $(".formcontainer").css({

                //     "display": "grid",
                //     "grid-template-columns": "repeat(2, auto)",
                //     "grid-gap": "6em",
                //     "place-content": "center",
                // });


                var reader = new FileReader();
                $('#imageholdingdiv').css('display', 'block');

                reader.onload = function(e) {
                    $('#imgPlaceholder').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string








            }

        }

        $("form").on("change", ".file-upload-field", function() {
            $(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));

        });

        $("#exampleInputEmail1").change(function() {
            var alname = document.getElementById("exampleInputEmail1").value;

            document.getElementById("putalbumname").innerHTML = alname;
        });

        $("#chooseFile").change(function() {
            readURL(this);
        });


        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</body>

</html>
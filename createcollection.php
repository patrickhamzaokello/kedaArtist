<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    include("config/global.php");
    include("config/database.php");
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");
    include("includes/classes/LikedSong.php");
    include("uploadscripts/collectionupload.php");


    if (isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_GET['userLoggedIn']);
    } else {
        echo "username variable was not passed into the page check the openPage js function";
        exit();
    }
} else {
    include("managecontent.php");


    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    exit();
}




?>


<div class="create_media_container">

    <div class="mediaCreationheading">
        <h5>Media Creation Form</h5>
        <p style="font-size: 0.7em;color: #8b7097;">This is where you add a single, EP, Album, Mixtape or Podcast</p>
        <!-- <h5>EP (Extended Play) Creation Form</h5> -->

    </div>
    <form id="createform" action="" method="post" enctype="multipart/form-data">

        <div class="formcontainer slide-in-right">



            <div class="loginforminner">

                <!-- Display response messages -->
                <?php if (!empty($resMessage)) { ?>
                    <div class="alert <?php echo $resMessage['status'] ?>">
                        <?php echo $resMessage['message'] ?>
                    </div>
                <?php } ?>

                <div class="inputformelement">
                    <label for="exampleInputEmail1" class="submitedlable">Title <span class="required">*</span></label>
                    <input type="text" name="AlbumTitle" required class="mediauploadInput" id="exampleInputEmail1" aria-describedby="nameHelp" placeholder="Enter Album Title">
                </div>

                <div class="inputformelement">
                    <label for="exampleInputdescription" class="submitedlable">Description <span class="required">*</span></label>
                    <textarea type="textarea" rows="5" required name="description" class="mediauploadInput" id="exampleInputdescription" aria-describedby="descriptionHelp" placeholder="Album Description"></textarea>
                </div>

                <div class="inputformelement">

                    <div class="custom-file">
                        <label class="submitedlable" for="chooseFile">Select Album Cover <span class="required">*</span></label>

                        <input type="file" accept=".jpg, .png, .jpeg" name="fileUpload" class="mediaFileinput" id="chooseFile">
                    </div>
                </div>




                <p class="helptext">+ Add Image and the upload button will show up</p>


            </div>

            <div class="card">


                <div id="imageholdingdiv" class="user-image mb-3 text-center slide-in-right">


                    <div class="albumtitletext">
                        <h5>Preview</h5>
                        <p>This shows how the artwork will appear on your Page</p>

                        <div class="albumtitletext" style="padding: 1em 0; color:burlywood;">

                            <p><span id="putalbumname">Media Title</span></p>

                        </div>

                    </div>
                    <div class="imageholder">
                        <img src="" class="figure-img img-fluid rounded contentimage" id="imgPlaceholder" alt="">
                    </div>



                    <button type="submit" name="submit" class="createbutton">
                        Create
                    </button>



                    <button type="reset" name="clear" class="cancelbutton">
                        Clear Form
                    </button>

                </div>
            </div>

        </div>

    </form>

</div>





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
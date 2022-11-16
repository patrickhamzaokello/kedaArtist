<?php
include("config/global.php");
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
    <meta name="description" content="Mwonyaa is Home to Ugandan Music, Live Radio, Podcasts,Dj Mixes and Poems. All available on the go and whenever you need them. This is also the best Place to Discover upcoming and new Talented Ugandan Content Creators">
    <meta name="keywords" content="Mwonyaa, Mwonyaa Music, Ugandan Streaming Platform, Mwonyaa Music Streaming Platform">

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- end of bootstrap -->


    <script src="mwonyacreate.js"></script>


    <link rel="stylesheet" href="mwonyacreate.css">

    <title>Mwonyaa Creation Tool</title>

</head>

<body>

    

    <div class="intropge">

    <nav class="mcontainer navbar navbar-inverse bg-dark">
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
               
                <ul class="headingdisplay nav navbar-nav navbar-right">

                    <?php
                    if (isset($_SESSION["name"])) {

                        echo "
                        <li><a href='home'>Dashboard</a></li>

                        <li><a href='logout' tite='Logout'><span class='glyphicon glyphicon-log-out'></span> Logout</a>
                        </li> ";
                    } else {
                        echo "
                        <li><a class='heroactive' href='index'>Home</a></li>
                        <li><a href='contentcreator'> Sign Up</a></li>
                        <li><a href='login' tite='Login'> Login</a>
                        </li>

                        ";
                    }


                    ?>

                </ul>
            </div>
        </div>
    </nav>

        <div class="content bounce-top mcontainer">

            <div class="lefthero">
                <h6 class="smallheading">Mwonyaa</h6>
                <div class="bigheading">
                    <h1>ARTIST / LABEL</h1>
                </div>

                <div class="secondheading">
                    <h2 class="smallbigheading">Management Platform</h2>
                    <p class="herodescription">For Music, Podcast, Poems and Dj Content Management and Sharing</p>

                </div>


                <div class="herobuttons">
                    <button class="newartistbutton"><a href="contentcreator">Signup</a></button>
                    <button class="enjoymusicbutton"><a href="../index">Stream</a></button>
                </div>


            </div>

            <div class="righthero">
                <img src="heorimage.svg" alt="">
            </div>

            <div class="herodesignsvg">
                <img src="herocircledesign.svg" alt="">
            </div>

        </div>
    </div>


    <section class="sectioncontent newfeatured">
        <div class="mcontainer sectionbody">

            <div class="lefttextsection">
                <h1>Your music. Your fans. Your team. All together now.</h1>
                <div class="PageBreakerModule__Subtext-sc-1tdblud-4 fNjyUY">All the tools you need to build your
                    following and career on Mwonya, all in one place.</div>
            </div>


            <div class="righttextsection">
                <div class="PageBreakerModule__CTAContainer-sc-1tdblud-6 dvQXBu"><a class="Link__defaultComponent-sc-1r1ecbd-0 gxGsAw  Link-sc-1r1ecbd-1 kLLZZe Button-oyfj48-0 bVxZMa PageBreakerModule__CTABtn-sc-1tdblud-7 FsZCZ" href="/claim">Join your team</a></div>
            </div>

        </div>
    </section>

    <section class="sectioncontent">

        <div class=" mcontainer sectionbody">

            <div class="lefttextsection">
                <h1>Built For Artists</h1>
                <div class="PageBreakerModule__Subtext-sc-1tdblud-4 fNjyUY">Showcasing your artistry goes deeper with
                    Mwonyaa for Artists. With our profile tools, you can change
                    your bio
                    and photos whenever inspiration strikes. Let fans into your world with Artist Pick, featured
                    playlists, and
                    fundraising links — and by adding looping visuals to your tracks with Canvas.</div>
                <p>Whether you’re a bigger artist or just developing, Mwonyaa for Artists helps you find your fans and
                    market
                    better to them..</p>
            </div>
        </div>


    </section>

    <div class="testimony">
        <div class="mcontainer ">
            <div class=" mycontainer">
                <div class="quote">
                    <h5>Mwonyaa Songs</h5>
                    <p>Be Able to add a song to a particular album for an Artist. All Songs should be within the required size
                        and format </p>

                </div>

                <div class="quote">
                    <h5>Mwonyaa Podcasts</h5>

                    <p>Add Podcast Episode to the Already Created Podcast Album. Add Podcast Episode Descescription to Enable
                        users to be more interested in your work </p>
                </div>
                <div class="quote">
                    <h5>Mwonyaa Poems</h5>

                    <p>Add your Poems with this tool and make sure to include elaborate Details to help users understand your
                        work. </p>
                </div>
                <div class="quote">
                    <h5>Mwonyaa Dj Mixtapes</h5>

                    <p>All Dj Mixtapes and Nonstops are added through this button and please check the input fields carefully.

                    </p>
                </div>
            </div>




        </div>
    </div>




</body>

</html>

</body>

</html>
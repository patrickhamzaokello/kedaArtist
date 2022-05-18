</div>

<!-- <div id="addisplay" class="adsectioncontainer">
  <div class="slideshow-container">
    <div class="adsmySlides fadeslide">
      <div class="slidenumbertext">1 / 3</div>
      <img class="slideimage" src="mwonyaastreamsad.gif" style="width: 100%;height: 100%;" />
    </div>
    <div class="adsmySlides fadeslide">
      <div class="slidenumbertext">2 / 3</div>
      <img class="slideimage" src="njozasolutions.gif" style="width: 100%;height: 100%;" />
    </div>

    <div class="adsmySlides fadeslide">
      <div class="slidenumbertext">3 / 3</div>
      <img class="slideimage" src="kakebead.gif" style="width: 100%;height: 100%;" />
    </div>

  </div>
</div> -->

</div>


</section>

<?php

require "includes/nowPlayingContainer.php";

?>

<div class="mobilenavigation">
  <span id="mobilealbumnavitem" href="#" class="nav__link nav__link--active" onclick="openPage('index'); ">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Home</span>
  </span>
  <span id="mobileartistnavitem" href="#" class="nav__link" onclick="openPage('library');  ">
    <i class="material-icons nav__icon">library_music</i>
    <span class="nav__text">Library</span>
  </span>
  <span id="mobilepodcastnavitem" href="#" class="nav__link" onclick="openPage('podcasts'); ">
    <i class="material-icons nav__icon">podcasts</i>
    <span class="nav__text">Podcast</span>
  </span>
  <span id="mobiledjmixnavitem" href="#" class="nav__link" onclick="openPage('liveshows'); ">
    <i class="material-icons nav__icon">live_tv</i>
    <span class="nav__text">Live</span>
  </span>
  <span id="mobilepoemnavitem" href="#" class="nav__link" onclick="openPage('shop'); ">
    <i class="material-icons nav__icon">shopping_bag</i>
    <span class="nav__text">Shop</span>
  </span>
</div>






<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/8.3.0/nouislider.min.js'></script>




<script>
  // work in progress - needs some refactoring and will drop JQuery i promise 

  var slideIndex = 0;
  var adslidecontainer = document.getElementById("addisplay");

  showadSlides();

  function showadSlides() {
    var i;
    var slides = document.getElementsByClassName("adsmySlides");

    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
      slideIndex = 1;
      adslidecontainer.style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showadSlides, 15000); // Change image every 2 seconds
  }

  var instance = $(".hs__wrapper");
  $.each(instance, function(key, value) {

    var arrows = $(instance[key]).find(".arrow"),
      prevArrow = arrows.filter('.arrow-prev'),
      nextArrow = arrows.filter('.arrow-next'),
      box = $(instance[key]).find(".hs"),
      x = 0,
      mx = 0,
      maxScrollWidth = box[0].scrollWidth - (box[0].clientWidth / 2) - (box.width() / 2);

    $(arrows).on('click', function() {

      if ($(this).hasClass("arrow-next")) {
        x = ((box.width() / 2)) + box.scrollLeft() - 10;
        box.animate({
          scrollLeft: x,
        })
      } else {
        x = ((box.width() / 2)) - box.scrollLeft() - 10;
        box.animate({
          scrollLeft: -x,
        })
      }

    });

    $(box).on({
      mousemove: function(e) {
        var mx2 = e.pageX - this.offsetLeft;
        if (mx) this.scrollLeft = this.sx + mx - mx2;
      },
      mousedown: function(e) {
        this.sx = this.scrollLeft;
        mx = e.pageX - this.offsetLeft;
      },
      scroll: function() {
        toggleArrows();
      }
    });

    $(document).on("mouseup", function() {
      mx = 0;
    });

    function toggleArrows() {
      if (box.scrollLeft() > maxScrollWidth - 10) {
        // disable next button when right end has reached 
        nextArrow.addClass('disabled');
      } else if (box.scrollLeft() < 10) {
        // disable prev button when left end has reached 
        prevArrow.addClass('disabled')
      } else {
        // both are enabled
        nextArrow.removeClass('disabled');
        prevArrow.removeClass('disabled');
      }
    }

  });
</script>


</body>

</html>
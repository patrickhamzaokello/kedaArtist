var artistname;
var userLoggedIn;
var timer = 2;

$(document).click(function (click) {
  var target = $(click.target);

  if (!target.hasClass("item") && !target.hasClass("ion-more")) {
    hideOptionsMenu();
  }
});

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

function openPage(url) {
  if (timer != null) {
    clearTimeout(timer);
  }

  if (url.indexOf("?") == -1) {
    url = url + "?";
  }
  var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
  $("#albumSection").load(encodedUrl);
  $("body").scrollTop(0);
  history.pushState(null, null, url);
}

function hideOptionsMenu() {
  var menu = $(".optionsMenu");
  if (menu.css("display") != "none") {
    menu.css("display", "none");
  }
}

function showOptionsMenu(button) {
  var songId = $(button).prevAll(".songId").val();

  var menu = $(".optionsMenu");
  var menuWidth = menu.width();
  menu.find(".songId").val(songId);

  var scrollTop = $(window).scrollTop(); //distrance from top of window to top of document
  var elementOffset = $(button).offset().top; //distance from top of document

  var top = elementOffset - scrollTop;
  var left = $(button).position().left;

  menu.css({
    top: top + "px",
    left: left - menuWidth + "px",
    display: "inline",
  });
}

function renamealbum(albumID) {
  var popup = prompt("New Album Name");

  if (popup != null) {
    $.post("logic/renamealbum.php", {
      name: popup,
      albumID: albumID,
      username: userLoggedIn,
    }).done(function (error) {
      if (error != "") {
        alert(error);
        return;
      }

      //do something when ajax returns
      hideOptionsMenu();
      location.reload();
    });
  }
}

function deleteAlbum(albumID, artworkPath) {
  var prompt = confirm("Are you sure you want to delete this Album?");

  if (prompt == true) {
    $.post("logic/deletealbum.php", {
      albumID: albumID,
      artworkPath: artworkPath,
      username: userLoggedIn,
    }).done(function (error) {

      if (error != "") {
        alert(error);
        return;
      }

      //do something when ajax returns
      hideOptionsMenu();
      location.reload();
    });
  }
}

function changeartwork(albumID) {
  var prompt = confirm("Change Media Artwork?");

  if (prompt == true) {
    $.post("logic/changemediaartwork.php", {
      albumID: albumID,
      username: userLoggedIn,
    }).done(function (error) {
      if (error != "") {
        alert(error);
        return;
      }

      //do something when ajax returns
      hideOptionsMenu();
      location.reload();
    });
  }
}

function renameAlbumsong(button, albumID) {
  var songtitle = prompt("New Song Title");
  var songId = $(button).prevAll(".songId").val();


  if (songtitle != null) {
    $.post("logic/renamealbumsong.php", {
      songtitle: songtitle,
      albumID: albumID,
      songId: songId,
      userLoggedIn: userLoggedIn,
    }).done(function (error) {
      if (error != "") {
        alert(error);
        return;
      }

      //do something when ajax returns
      hideOptionsMenu();
      location.reload();
    });
  }
}

function deleteAlbumsong(button, albumID) {
  var prompt = confirm("Are you sure you want to delete this song?");
  var songId = $(button).prevAll(".songId").val();


  if (prompt == true) {
    $.post("logic/deletealbumsong.php", {
      songId: songId,
      albumID: albumID,
      username: userLoggedIn,
    }).done(function (error) {

      if (error != "") {
        alert(error);
        return;
      }

      //after ajax returns success
      hideOptionsMenu();
      location.reload();
    });
  }
}

function renameartistname(artistID) {
  var popup = prompt("Rename Artist");

  if (popup != null) {
    $.post("logic/renameartist.php", {
      name: popup,
      artistID: artistID,
      username: userLoggedIn,
    }).done(function (error) {
      if (error != "") {
        alert(error);
        return;
      }

      //do something when ajax returns
      hideOptionsMenu();
      location.reload();
    });
  }
}

function _(id) {
  return document.getElementById(id);
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML =
    "uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0;
  _("upload_form").reset();
}

function changeprofileimage(artistidgot) {
  var prompt = confirm("Change Profile Image?");

  if (prompt == true) {
    var formdata = new FormData();
    var userfiles = document.getElementsByName("filegroup");
    for (var i = 0; i < userfiles.length; i++) {
      var file = userfiles[i].files[0];
      if (file) {
        formdata.append("file_" + i, file);
        // file.name (name | size | type)
      }
    }

    formdata.append("artistidgot", artistidgot);

    formdata.append("username", userLoggedIn);

    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.open("POST", "logic/artistprofileedit.php");
    ajax.send(formdata);
    location.reload();
  }
}

function changecoverimage(artistidgot) {
  var prompt = confirm("Change Cover Image?");

  if (prompt == true) {
    var formdata = new FormData();
    var userfiles = document.getElementsByName("filegroup");
    for (var i = 0; i < userfiles.length; i++) {
      var file = userfiles[i].files[0];
      if (file) {
        formdata.append("file_" + i, file);
        // file.name (name | size | type)
      }
    }

    formdata.append("artistidgot", artistidgot);

    formdata.append("username", userLoggedIn);

    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.open("POST", "logic/artistcoveredit.php");
    ajax.send(formdata);
    location.reload();
  }
}

let latitude;
let longitude;

var jarak;

window.onload = getLocation;


function getLocation() {
  document.getElementById("keterangan").innerHTML ="Mendapatkan data dari GPS";
  setTimeout(redirect,60000);

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      alert("Peramban yang anda gunakan tidak mengizinkan deteksi lokasi.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Informasi Lokasi tidak tersedia");
      break;
    case error.TIMEOUT:
      alert(
        "Permintaan untuk mendapatkan lokasi pengguna telah habis waktunya."
      );
      break;
    case error.UNKNOWN_ERROR:
      alert("Error tidak diketahui");
      break;
  }
}

function showPosition(position) {
  latitude = position.coords.latitude;
  longitude = position.coords.longitude;
  // alert(latitude+'-'+longitude);
  // document.getElementById('Latitude').innerHTML="Latitude: " +latitude
  // document.getElementById('Longitude').innerHTML="Longitude: " +longitude
  hitungjarak(latSMK1, longSMK1, latitude, longitude);
}

function hitungjarak(lat1, long1, lat2, long2, unit = "kilometers") {

  console.log(lat1, long1, lat2, long2, unit);
  let theta = long1 - long2;
  let distance =60 *1.1515 *(180 / Math.PI) *Math.acos(
      Math.sin(lat1 * (Math.PI / 180)) * Math.sin(lat2 * (Math.PI / 180)) +
        Math.cos(lat1 * (Math.PI / 180)) *
          Math.cos(lat2 * (Math.PI / 180)) *
          Math.cos(theta * (Math.PI / 180))
    );
  if (unit == "miles") {
    jarak = Math.round(distance);
  } else if (unit == "kilometers") {
    jarak = Math.round(distance * 1.609344 * 1000);
  }
  if(jarak<jarak_maksimal){
    // alert(jarak);
    document.getElementById("konten").style.display = "block";
    document.getElementById("loading").style.display = "none";

  }else{
    document.getElementById("luar-jarak").style.display = "block";
    document.getElementById("loading").style.display = "none";
    document.getElementById("jarak").innerHTML = jarak;
  }
}


// Webcam
var cameras = new Array(); //create empty array to later insert available devices
navigator.mediaDevices
  .enumerateDevices() // get the available devices found in the machine
  .then(function (devices) {
    devices.forEach(function (device) {
      var i = 0;
      if (device.kind === "videoinput") {
        //filter video devices only
        cameras[i] = device.deviceId; // save the camera id's in the camera array
        i++;
      }
    });
  });

Webcam.set({
  width: 450,
  height: 600,
  image_format: "jpeg",
  jpeg_quality: 80,
  flip_horiz: true,
  fps: 30,
  sourceId: cameras[0],
});

Webcam.attach(".webcam-capture");

function ambil_foto() {
  var shutter = new Audio();
  shutter.autoplay = false;
  shutter.src = navigator.userAgent.match(/Firefox/)
    ? "shutter.ogg"
    : "shutter.mp3";

  Webcam.snap(function (data_uri) {
    shutter.play();
    $(".image-tag").val(data_uri);
    document.kirim_foto.submit();
  });
}


function redirect(){
  if(jarak)
    {
      return;
    }else{

      document.getElementById("keterangan").innerHTML="Data GPS Anda bermasalah, Silahkan RESTART GPS Anda";
      alert('Silahkan RESTART GPS Anda');
      setTimeout(reload,2500);
    }
}

function reload(){
  location.reload();
}
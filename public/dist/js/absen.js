let latitude;
let longitude;

var jarak;

window.onload = getLocation;


function getLocation() {
  document.getElementById("keterangan").innerHTML = "Mendapatkan data dari GPS";
  setTimeout(redirect, 60000);

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
  let distance = 60 * 1.1515 * (180 / Math.PI) * Math.acos(
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
  if (jarak < jarak_maksimal) {
    // alert(jarak);
    document.getElementById("konten").style.display = "block";
    document.getElementById("loading").style.display = "none";

  } else {
    document.getElementById("luar-jarak").style.display = "block";
    document.getElementById("loading").style.display = "none";
    document.getElementById("jarak").innerHTML = jarak;
  }
}

const video = document.getElementById('webcam');
const frame = document.getElementById('frame');
const statusText = document.getElementById('status');
const previewContainer = document.getElementById('preview-container');
const previewImg = document.getElementById('preview-img');

let isCaptured = false;
let blinkDetected = false;

// 1. Akses Kamera Depan HP
async function startCamera() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: { facingMode: "user", width: { ideal: 640 }, height: { ideal: 480 } }
    });
    video.srcObject = stream;
    statusText.innerText = "Arahkan wajah ke lingkaran";
  } catch (err) {
    statusText.innerText = "Gagal mengakses kamera depan: " + err.message;
  }
}

// 2. Hitung Jarak 2 Titik Koordinat
function getDistance(p1, p2) {
  return Math.hypot(p1.x - p2.x, p1.y - p2.y);
}

// 3. Deteksi Kedip Mata (EAR - Eye Aspect Ratio)
function checkBlink(landmarks) {
  // Mata Kiri
  const leftDistV = getDistance(landmarks[159], landmarks[145]);
  const leftDistH = getDistance(landmarks[33], landmarks[133]);
  const leftEAR = leftDistV / leftDistH;

  // Mata Kanan
  const rightDistV = getDistance(landmarks[386], landmarks[374]);
  const rightDistH = getDistance(landmarks[362], landmarks[263]);
  const rightEAR = rightDistV / rightDistH;

  return ((leftEAR + rightEAR) / 2) < 0.18; // Ambang batas mata tertutup
}
// Tambahkan fungsi untuk mengecek apakah wajah tertutup masker
function checkMask(landmarks) {
  // Titik Bibir Atas (13), Bibir Bawah (14), Ujung Kiri Mulut (61), Ujung Kanan Mulut (291)
  const mouthHeight = getDistance(landmarks[13], landmarks[14]);
  const mouthWidth = getDistance(landmarks[61], landmarks[291]);

  // Hitung rasio proporsi mulut
  const mouthRatio = mouthHeight / mouthWidth;

  // Jika rasio mulut mendekati 0 atau tidak bergeming sama sekali, 
  // atau koordinat bibir tidak natural (karena terhalang kain masker)
  if (mouthRatio < 0.05 || isNaN(mouthRatio)) {
    return true; // Bermasker / Mulut tidak terdeteksi jelas
  }
  return false; // Wajah terbuka (Bebas Masker)
}

// 4. Logika Deteksi Wajah & Liveness (DIUBAH)
function onResults(results) {
  if (isCaptured) return;

  if (results.multiFaceLandmarks && results.multiFaceLandmarks.length > 0) {
    const landmarks = results.multiFaceLandmarks[0];

    // 1. Cek Posisi Wajah di Tengah
    const nose = landmarks[1];
    const isCentered = nose.x > 0.35 && nose.x < 0.65 && nose.y > 0.35 && nose.y < 0.65;

    // 2. Cek Penggunaan Masker
    const isWearingMask = checkMask(landmarks);

    if (!isCentered) {
      frame.classList.remove('valid');
      statusText.innerText = "Posisikan wajah tepat di tengah";
    } else if (isWearingMask) {
      // BLOKIR JIKA PAKAI MASKER
      frame.classList.remove('valid');
      statusText.innerText = "HARAP LEPAS MASKER ANDA!";
      statusText.style.color = "#ff4757"; // Warna merah
    } else {
      frame.classList.add('valid');
      statusText.style.color = "#ffa500";

      // 3. Cek Liveness (Kedip) jika masker sudah dilepas
      if (!blinkDetected) {
        statusText.innerText = "Silakan KEDIPKAN MATA";
        if (checkBlink(landmarks)) {
          blinkDetected = true;
        }
      } else {
        statusText.innerText = "Berhasil! Mengambil foto...";
        capturePhoto();
      }
    }
  } else {
    frame.classList.remove('valid');
    statusText.innerText = "Wajah tidak terdeteksi";
  }
}

// 4. Logika Deteksi Wajah & Liveness
function onResults(results) {
  if (isCaptured) return;

  if (results.multiFaceLandmarks && results.multiFaceLandmarks.length > 0) {
    const landmarks = results.multiFaceLandmarks[0];

    // Cek Posisi Wajah (Hidung harus di area tengah)
    const nose = landmarks[1];
    const isCentered = nose.x > 0.35 && nose.x < 0.65 && nose.y > 0.35 && nose.y < 0.65;

    if (!isCentered) {
      frame.classList.remove('valid');
      statusText.innerText = "Posisikan wajah tepat di tengah";
    } else {
      frame.classList.add('valid');

      // Cek Liveness (Kedip)
      if (!blinkDetected) {
        statusText.innerText = "Silakan KEDIPKAN MATA";
        if (checkBlink(landmarks)) {
          blinkDetected = true;
        }
      } else {
        statusText.innerText = "Berhasil! Mengambil foto...";
        capturePhoto();
      }
    }
  } else {
    frame.classList.remove('valid');
    statusText.innerText = "Wajah tidak terdeteksi";
  }
}

// 5. Fungsi Capture Gambar
function capturePhoto() {
  isCaptured = true;

  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const ctx = canvas.getContext('2d');

  // Gambar dari video ke canvas
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  const dataURL = canvas.toDataURL('image/jpeg', 0.8);

  // efek suara shutter
  const shutter = new Audio();
  shutter.autoplay = false;
  shutter.src = navigator.userAgent.match(/Firefox/)
    ? "shutter.ogg"
    : "shutter.mp3";
  shutter.play();

  // kirim foto ke input hidden form
  $(".image-tag").val(dataURL);

  // submit form
  document.getElementById("kirim_foto").submit();

  previewImg.src = dataURL;
  previewContainer.style.display = 'block';
  frame.style.display = 'none';

}

// 6. Inisialisasi MediaPipe FaceMesh
const faceMesh = new FaceMesh({
  locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
});

faceMesh.setOptions({
  maxNumFaces: 1,
  refineLandmarks: true,
  minDetectionConfidence: 0.5
});

faceMesh.onResults(onResults);

// Loop pendeteksian frame
async function processFrame() {
  if (video.readyState >= 2 && !isCaptured) {
    await faceMesh.send({ image: video });
  }
  requestAnimationFrame(processFrame);
}

// Jalankan Pertama Kali
startCamera().then(() => {
  video.onloadeddata = () => processFrame();
});



function redirect() {
  if (jarak) {
    return;
  } else {

    document.getElementById("keterangan").innerHTML = "Data GPS Anda bermasalah, Silahkan RESTART GPS Anda";
    alert('Silahkan RESTART GPS Anda');
    setTimeout(reload, 2500);
  }
}

function reload() {
  location.reload();
}
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

const video = document.getElementById('webcam');
const frame = document.getElementById('frame');
const statusText = document.getElementById('status');
const brightnessStatus = document.getElementById('brightness-status');
const previewContainer = document.getElementById('preview-container');
const previewImg = document.getElementById('preview-img');

let isCaptured = false;
let blinkDetected = false;
let mouthOpened = false; // Flag tambahan untuk buka mulut

function updateBrightnessStatus(brightness) {
  if (!brightnessStatus) return;

  brightnessStatus.textContent = `Kecerahan: ${brightness.toFixed(1)}`;
  brightnessStatus.style.color = brightness < 60 ? '#fc0217' : '#1d4ed8';
}

// 1. Akses Kamera Depan HP
async function startCamera() {
  if (!video) return;

  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: { facingMode: "user", width: { ideal: 640 }, height: { ideal: 480 } }
    });
    video.srcObject = stream;
    if (statusText) {
      statusText.innerText = "Arahkan wajah ke lingkaran";
    }
  } catch (err) {
    if (statusText) {
      statusText.innerText = "Gagal mengakses kamera depan: " + err.message;
    }
  }
}

// 2. Hitung Jarak 2 Titik Koordinat
function getDistance(p1, p2) {
  return Math.hypot(p1.x - p2.x, p1.y - p2.y);
}

// 3. Deteksi Kedip Mata
function checkBlink(landmarks) {
  const leftDistV = getDistance(landmarks[159], landmarks[145]);
  const leftDistH = getDistance(landmarks[33], landmarks[133]);
  const rightDistV = getDistance(landmarks[386], landmarks[374]);
  const rightDistH = getDistance(landmarks[362], landmarks[263]);
  const avgEAR = ((leftDistV / leftDistH) + (rightDistV / rightDistH)) / 2;
  return avgEAR < 0.18;
}

// 4. Deteksi Buka Mulut (Memaksa User Lepas Masker)
function checkMouthOpen(landmarks) {
  const mouthHeight = getDistance(landmarks[13], landmarks[14]);
  const mouthWidth = getDistance(landmarks[61], landmarks[291]);
  const mouthRatio = mouthWidth > 0 ? mouthHeight / mouthWidth : 0;

  // Cek dengan ambang yang lebih toleran agar tidak gagal saat ada cahaya kuat
  return mouthRatio > 0.28 || mouthHeight > 0.08;
}

// Fungsi mengecek rata-rata kecerahan frame (Skala 0 - 255)
function getBrightness(videoElement) {
  const canvasTemp = document.createElement('canvas');
  canvasTemp.width = 100;  // Dikecilkan agar proses komputasi sangat cepat
  canvasTemp.height = 100;
  const ctx = canvasTemp.getContext('2d');

  // Ambil piksel frame saat ini
  ctx.drawImage(videoElement, 0, 0, 100, 100);
  const imageData = ctx.getImageData(0, 0, 100, 100);
  const data = imageData.data;

  let totalLuma = 0;
  // Hitung tingkat kecerahan setiap piksel menggunakan rumus Luma standar
  for (let i = 0; i < data.length; i += 4) {
    const r = data[i];
    const g = data[i + 1];
    const b = data[i + 2];
    // Rumus standar kecerahan perseptual (Luma)
    totalLuma += (0.299 * r + 0.587 * g + 0.114 * b);
  }

  // Kembalikan rata-rata nilai kecerahan
  return totalLuma / (100 * 100);
}

// 5. Logika Deteksi Wajah & Dual Liveness
function onResults(results) {
  if (isCaptured || !video || !frame || !statusText) return;

  // const brightness = getBrightness(video);
  // updateBrightnessStatus(brightness);

  // if (brightness < 50) {
  //   frame.classList.remove('valid');
  //   statusText.style.color = "#fc0217";
  //   statusText.innerText = "Wajah terlalu gelap! Hindari membelakangi cahaya";
  //   return;
  // }

  // if (brightness > 220) {
  //   frame.classList.remove('valid');
  //   statusText.style.color = "#f59e0b";
  //   statusText.innerText = "Cahaya terlalu terang! Kurangi sumber cahaya di depan wajah";
  //   return;
  // }

  if (results.multiFaceLandmarks && results.multiFaceLandmarks.length > 0) {
    const landmarks = results.multiFaceLandmarks[0];

    // Cek Posisi Wajah
    const nose = landmarks[1];
    const isCentered = nose.x > 0.35 && nose.x < 0.65 && nose.y > 0.35 && nose.y < 0.65;

    if (!isCentered) {
      frame.classList.remove('valid');
      statusText.innerText = "Posisikan wajah tepat di tengah";
    } else {
      frame.classList.add('valid');

      // TAHAP 1: Cek Kedip Mata
      if (!blinkDetected) {
        statusText.innerText = "Verifikasi: Silakan KEDIPKAN MATA";
        if (checkBlink(landmarks)) {
          blinkDetected = true;
        }
      } 
      // TAHAP 2: Cek Buka Mulut (Masker dipastikan harus lepas)
      // else if (!mouthOpened) {
      //   statusText.innerText = "Langkah 2/2: BUKA MULUT (Lepas Masker)";
      //   if (checkMouthOpen(landmarks)) {
      //     mouthOpened = true;
      //   }
      // } 
      // KEDUA TAHAP LOLOS -> CAPTURE
      else {
        statusText.innerText = "Verifikasi Berhasil! Mengambil foto...";
        capturePhoto();
      }
    }
  } else {
    frame.classList.remove('valid');
    statusText.innerText = "Wajah tidak terdeteksi";
  }
}

// 6. Fungsi Capture Gambar
function capturePhoto() {
  isCaptured = true;

  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const ctx = canvas.getContext('2d');

  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  const dataURL = canvas.toDataURL('image/jpeg', 0.8);

  const shutter = new Audio();
  shutter.autoplay = false;
  shutter.src = navigator.userAgent.match(/Firefox/) ? "shutter.ogg" : "shutter.mp3";
  shutter.play();

  $(".image-tag").val(dataURL);
  document.getElementById("kirim_foto").submit();

  previewImg.src = dataURL;
  previewContainer.style.display = 'block';
  frame.style.display = 'none';
}

// 7. Inisialisasi MediaPipe
const faceMesh = new FaceMesh({
  locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
});

faceMesh.setOptions({
  maxNumFaces: 1,
  refineLandmarks: true,
  minDetectionConfidence: 0.5
});

faceMesh.onResults(onResults);

async function processFrame() {
  if (video.readyState >= 2 && !isCaptured) {
    await faceMesh.send({ image: video });
  }
  requestAnimationFrame(processFrame);
}

startCamera().then(() => {
  video.onloadeddata = () => processFrame();
});
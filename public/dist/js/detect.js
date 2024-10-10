// please note,
// that IE11 now returns undefined again for window.chrome
// and new Opera 30 outputs true for window.chrome
// but needs to check if window.opr is not undefined
// and new IE Edge outputs to true now for window.chrome
// and if not iOS Chrome check
// so use the below updated condition
var isChromium =window.chrome != null && window.navigator.vendor === "Google Inc.";
var winNav = window.navigator;
var vendorName = winNav.vendor;
var isOpera = typeof window.opr !== "undefined";
var isFirefox = winNav.userAgent.indexOf("Firefox") > -1;
var isIEedge = winNav.userAgent.indexOf("Edg") > -1;
var isIOSChrome = winNav.userAgent.match("CriOS");
var isGoogleChrome =
  typeof winNav.userAgentData !== "undefined"
    ? winNav.userAgentData.brands[2].brand === "Google Chrome"
    : vendorName === "Google Inc.";

function checkBrowser() {
  if (isIOSChrome) {
    // is Google Chrome on IOS
  } else if (
    isChromium !== null &&
    typeof isChromium !== "undefined" &&
    vendorName === "Google Inc." &&
    isFirefox === false &&
    isOpera === false &&
    isIEedge === false 
  ) {
    return true;
  } else {
    return false;
  }
}


function isMobile() {
    const regex = /Mobi|Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
    return regex.test(navigator.userAgent);
  }
  
function checkMobile(){
    if (isMobile()) {
        return true;
      } else {
       return false;
      }
}

if(checkMobile() === false ){
    document.getElementById('body').style.display='none';
    alert("Anda menggunakan perangkat (device) yang tidak didukung!");
}else{
    if(checkBrowser()===false){
        document.getElementById('body').style.display='none';
        alert("Anda menggunakan peramban (browser) yang tidak didukung!");
    }
}




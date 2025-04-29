<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <div id="output"></div>
    <div id="browser"></div>

    <script>
        // please note,
        // that IE11 now returns undefined again for window.chrome
        // and new Opera 30 outputs true for window.chrome
        // but needs to check if window.opr is not undefined
        // and new IE Edge outputs to true now for window.chrome
        // and if not iOS Chrome check
        // so use the below updated condition
        var isChromium = window.chrome != null && window.navigator.vendor === "Google Inc.";
        var winNav = window.navigator;
        var vendorName = winNav.vendor;
        var isOpera = typeof window.opr !== "undefined";
        var isFirefox = winNav.userAgent.indexOf("Firefox") > -1;
        var isIEedge = winNav.userAgent.indexOf("Edg") > -1;
        var isIOSChrome = winNav.userAgent.match("CriOS");
        var isGoogleChrome =
            typeof winNav.userAgentData !== "undefined" ?
            winNav.userAgentData.brands[2].brand === "Google Chrome" :
            vendorName === "Google Inc.";
        // alert(isGoogleChrome);
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
            // is Google Chrome
            console.log("is Google Chrome");
            document.querySelector("#browser").textContent = "is Google Chrome";
        } else {
            // not Google Chrome
            console.log("not Google Chrome");
            document.querySelector("#browser").textContent = "not Google Chrome";
        }

        function isMobile() {
            const regex = /Mobi|Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
            return regex.test(navigator.userAgent);
        }

        if (isMobile()) {
            console.log("Mobile device detected");
            document.querySelector("#output").textContent = " Mobile Device";
        } else {
            console.log("Desktop device detected");
            document.querySelector("#output").textContent = " Desktop Device";
        }
    </script>
</body>

</html>

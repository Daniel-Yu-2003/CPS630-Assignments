function detectBrowser() {
    var userAgent = navigator.userAgent;  
    var browserName = "Unknown"; 

    // Detect Brave Browser
    if (navigator.brave) {
        browserName = "Brave";
    }
    // Detect Google Chrome (excluding Edge or Brave)
    else if (userAgent.indexOf("Chrome") !== -1 && userAgent.indexOf("Edg") === -1) {
        browserName = "Google Chrome";
    }
    // Detect Microsoft Edge
    else if (userAgent.indexOf("Edg") !== -1) {
        browserName = "Microsoft Edge";
    }
    // Detect Firefox
    else if (userAgent.indexOf("Firefox") !== -1) {
        browserName = "Firefox";
    }
    // Detect Internet Explorer
    else if (userAgent.indexOf("Trident") !== -1 || userAgent.indexOf("MSIE") !== -1) {
        browserName = "Internet Explorer";
    }

    // Display the correct format
    document.getElementById("browser-info").innerHTML = `© 2025 Electro | Browser: ${browserName}`;
}

// Run the function
detectBrowser();

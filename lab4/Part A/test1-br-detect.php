<!DOCTYPE html>
<head>
    <TITLE>how to detect browser using PHP</TITLE>
</head>
<body>
    <h1> Display Cross Browsers Compatibility Issues line1</h1>
    <p> Display Cross Browsers Compatibility Issues line2</p>
    <?php
    echo "Trying to detect Browser name! <br/>";

    function brdetect()
    {
        $res = $_SERVER['HTTP_USER_AGENT'];  // Get the browser info from user agent
        echo "User-Agent: " . $res . "<br/><br/>";  

        // Detect Google Chrome (but not Edge)
        if (strpos($res, "Chrome") !== false && strpos($res, "Edg") === false) {
            echo "Browser: Google Chrome";  // If it's Chrome and not Edge
        }
        // Detect Microsoft Edge
        else if (strpos($res, "Edg") !== false) {
            echo "Browser: Microsoft Edge";  
        }
        // Detect Firefox
        else if (strpos($res, "Firefox") !== false) {
            echo "Browser: Firefox";  
        }
        // Detect Internet Explorer
        else if (strpos($res, "Trident") !== false || strpos($res, "MSIE") !== false) {
            echo "Browser: Internet Explorer";  
        }
        // Default if no known browser is detected
        else {
            echo "Browser: Unknown";
        }
    }

    brdetect();  // Call the function to run the browser detection
    ?>
</body>
</html>

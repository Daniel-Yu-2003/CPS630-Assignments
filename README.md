Lab 2-3: Step by Step to run the program

  1. Dowload XAMPP: https://www.apachefriends.org/download.html
  2. Start Apache & MySQL from XAMPP Control PaneL
  3. Open browser → Go to http://localhost/phpmyadmin/
  4. Click on Databases → Create new database (give it a database name).
  5. Create artwork Table and Run this SQL query inside phpMyAdmin → SQL Tab

     CREATE TABLE artwork (
              id INT AUTO_INCREMENT PRIMARY KEY,
              genre VARCHAR(255),
              type VARCHAR(255),
              subject VARCHAR(255),
              specification VARCHAR(255),
              museum VARCHAR(255),
              year INT
     );
     
  7. Put all the files in the folder (Lab2-3)  inside htdocs (C:\xampp\htdocs\lab2-3) at your local computer
  8. After that, open http://localhost/artwork/artwork.php in your browser
  9. Done - Test the program



Lab 4:
## Requirements:
- **XAMPP** (or any local PHP server)
- A modern **web browser** (Chrome, Firefox, Edge, Brave, etc.)

## Steps to Run the Project:

### **Part A: PHP (Server-Side) Browser Detection**

1. **Install XAMPP**:
   - Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/).
   - Start **Apache** in the XAMPP control panel.

2. **Set up the Project**:
   - Clone this repository or download the files to your local machine.
   - Move the project folder to the **`htdocs`** directory in your XAMPP installation (e.g., `C:\xampp\htdocs\`).

3. **Run the PHP File**:
   - Open your browser and navigate to:
     ```
     http://localhost/browser-detection/test1-br-detect.php
     ```
   - This will run the PHP browser detection code and display the detected browser.

### **Part B: JavaScript (Client-Side) Browser Detection**

1. **Open the HTML File**:
   - Open `browser-detect.html` in your preferred web browser (e.g., Chrome, Firefox, Edge).
   
2. **Test the Detection**:
   - The browser detection results will be displayed directly on the page.

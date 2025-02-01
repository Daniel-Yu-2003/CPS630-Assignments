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
     
  7. Put all the files in the folder (Lab2-3)  inside htdocs (C:\xampp\htdocs\artwork) at your local computer
  8. After that, open http://localhost/artwork/artwork.php in your browser
  9. Done - Test the program

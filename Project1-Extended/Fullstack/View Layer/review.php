<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <style>
        .container {
            max-width: 700px;
            margin: auto;
            padding: 0 0 50px 0;
        }

        .text-center {
            margin-bottom: 25px;
        }

        .product-reviews {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .review-box {
            background: white;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        h2, h3 {
            text-align: center;
        }

        button {
            width: 100%;
        }
    </style>
    </style>
</head>
<body>

    <div id="nav-container">
        <h2 id="logo">Electro</h2>
        <nav>
            <a href="./home.php">Home</a>
            <a href="./about-us.php">About Us</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="profile.php">Profile</a>
                <a href="./logout.php">Log Out</a>
            <?php else: ?>
                <a href="../Controller Layer/sign-in.php">Sign In</a>
                <a href="../Controller Layer/register.php">Sign Up</a>
            <?php endif; ?>
            <a href="./review.php" class="active">Reviews</a>
            <a href="#services">Services</a>
        </nav>
    </div>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="container mt-4">
            <h2 class="text-center">Product Reviews</h2>
            <div id="reviews-container"></div>
            <div class="mt-5">
                <h4>Add a Review</h4>
                <select id="product-select" class="form-control">
                    <option value="iPhone 15">iPhone 15</option>
                    <option value="MacBook Air">MacBook Air</option>
                    <option value="Samsung Galaxy A06">Samsung Galaxy A06</option>
                    <option value="Apple Watch SE">Apple Watch SE</option>
                    <option value="Apple iPad">Apple iPad</option>
                </select>

                <textarea id="review-text" class="form-control mt-2" placeholder="Write your review..." required></textarea>

                <label class="mt-2">Rating:</label>
                <select id="review-rating" class="form-control">
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>

                <button class="btn btn-primary mt-3" onclick="addReview()">Submit Review</button>
            </div>
        </div>
    <?php else: ?>
        <div class="container mt-4">
            <h2 class="text-center">Product Reviews</h2>
            <div id="reviews-container"></div>
            <div class="mt-5">
                <h4>Add a Review</h4>
                <p>You must be signed in to add a review.</p>
            </div>
        </div>
    <?php endif; ?>
    
    
    <footer style="background-color:#333; color:white; text-align:center; padding:30px; bottom:0; width:100%;">
        <div id="browser-info"></div>    
    </footer>
    

    <script>
        const reviews = document.getElementById('reviews-container');

        const sampleReviews = {
            "iPhone 15": [
                { text: "Amazing phone! The camera is outstanding.", rating: 5 },
                { text: "Battery life could be better.", rating: 4 },
                { text: "Overpriced, but smooth performance.", rating: 3 }
            ],
            "MacBook Air": [
                { text: "Super lightweight and powerful.", rating: 5 },
                { text: "Wish it had more ports.", rating: 4 }
            ],
            "Samsung Galaxy A06": [
                { text: "Great budget phone with decent specs.", rating: 4 },
                { text: "Good battery life for the price.", rating: 4 }
            ],
            "Apple Watch SE": [
                { text: "Best value Apple Watch!", rating: 5 },
                { text: "No always-on display, but still great.", rating: 4 }
            ],
            "Apple iPad": [
                { text: "Perfect for students and casual users.", rating: 5 },
                { text: "Very smooth and responsive.", rating: 5 }
            ]
        };

        Object.entries(sampleReviews).forEach(([product, reviewsList]) => {
            reviewsList.forEach(review => {
                reviews.innerHTML += `
                    <div class="product-reviews">
                        <h3>${product}</h3> 
                        <div class="review-box">
                            <p>${review.text}</p>
                            <p><strong>Rating:</strong> ${"⭐".repeat(review.rating)}</p>
                        </div>
                    </div>
                `;
            });
        });

        
        
    </script>

    <script src="../../browserDetect.js"></script>
</body>
</html>

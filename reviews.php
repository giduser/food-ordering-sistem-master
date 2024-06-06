<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Menyambungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_food_order";

// Membuat koneksi
$db = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if (!$db) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lakukan proses pengiriman review dan rating di sini

    // Setelah berhasil mengirim review, alihkan pengguna kembali ke halaman index.php
    header("Location: index.php");
    exit();
}
if (isset($_GET['dish_id'])) {
    $dish_id = $_GET['dish_id'];
} else {
    // Handle the case when dish_id is not provided
    // For example, redirect to another page or show an error message
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the rating and review from the form
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Use the $dish_id and the user's ID or any other session data as needed to save the review to the database
    // Example query to insert the review into the database
    $query_insert_review = "INSERT INTO reviews (dish_id, rating, review) VALUES ('$dish_id', '$rating', '$review')";
    // Execute the query
    mysqli_query($db, $query_insert_review);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Review Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .star-rating {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .star {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s;
        }

        .star:hover,
        .star.selected {
            color: #FFD700;
        }

        #review {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #FFD700;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #F0C800;
        }

        /* CSS untuk reviews */
        .reviews-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .review {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .review .name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .review .rating {
            margin-bottom: 10px;
        }

        .review .rating i {
            color: #FFD700;
            margin-left: 5px;
        }

        .review .comment {
            line-height: 1.6;
        }

        .no-reviews {
            font-style: italic;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Submit Your Review</h1>
        <form action="submit_review.php" method="POST">
            <input type="hidden" name="dish_id" value="<?php echo $dish_id; ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" readonly><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly><br>

            <label for="rating">Rating:</label><br>
            <div class="star-rating" id="starRating">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" id="rating" name="rating" value="0" required>
            <br><br>

            <label for="review">Review:</label><br>
            <textarea id="review" name="review" rows="4" required></textarea><br>

            <input type="submit" value="Submit">
        </form>

    </div>
    <div class="reviews-container">
        <h2>Reviews</h2>

        <?php
        // Query untuk mengambil review dari database berdasarkan dish_id
        $query_reviews = "SELECT * FROM reviews WHERE dish_id = '$dish_id'";
        $result_reviews = mysqli_query($db, $query_reviews);

        // Periksa apakah ada review yang ditemukan
        if (mysqli_num_rows($result_reviews) > 0) {
            // Loop melalui hasil query untuk menampilkan setiap review
            while ($row_review = mysqli_fetch_assoc($result_reviews)) {
                // Tampilkan informasi review
                echo "<div class='review'>";
                echo "<p class='name'><strong>Name:</strong> " . $row_review['name'] . "</p>";
                echo "<p class='rating'><strong>Rating:</strong> " . $row_review['rating'] . " <i class='fa fa-star' style='color: #FFD700;'></i></p>";
                echo "<p class='comment'><strong>Review:</strong> " . $row_review['review'] . "</p>";
                echo "</div>";
            }
        } else {
            // Tampilkan pesan jika tidak ada review yang ditemukan
            echo "<p>No reviews yet.</p>";
        }
        ?>
    </div>


</body>

</html>


<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                let rating = star.getAttribute('data-value');
                ratingInput.value = rating;
                stars.forEach(s => {
                    s.classList.remove('selected');
                });
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.add('selected');
                }
            });
        });
    });
</script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<?php
include("connection/connect.php");
session_start();
$search_term = '';

if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    // Perform SQL query to search for dishes with title or slogan matching the search term
    $query_res = mysqli_query($db, "SELECT * FROM dishes WHERE title LIKE '%$search_term%' OR slogan LIKE '%$search_term%'");
} else {
    // If search term is not set, fetch all dishes
    $query_res = mysqli_query($db, "SELECT * FROM dishes");
}
?>

<?php include("includes/head.php") ?>

<body class="home">

    <!-- header section -->
    <?php include("includes/navbar.php") ?>
    <!-- header section end -->

    <!-- banner part starts -->
    <section class="hero bg-image" data-image-src="images/img/banner.jpg">
        <div class="hero-inner">
            <div class="container text-center hero-text font-white">
                <h1>Warung Cah Bagus </h1>
                <h5 class="font-white space-xs">Makan enak nggak perlu capek</h5>
                <div class="p-3 steps">
                    <div class="step-item step1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 483 483" width="512" height="512">
                            <!-- Icon for step 1 -->
                        </svg>
                        <h4><span>1. </span>Choose Meals</h4>
                    </div>
                    <!-- end:Step -->
                    <div class="step-item step2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 380.721 380.721">
                            <!-- Icon for step 2 -->
                        </svg>
                        <h4><span>2. </span>Order Food</h4>
                    </div>
                    <!-- end:Step -->
                    <div class="step-item step3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 612.001 612">
                            <!-- Icon for step 3 -->
                        </svg>
                        <h4><span>3. </span>Delivery</h4>
                    </div>
                    <!-- end:Step -->
                </div>
            </div>
        </div>
        <!--end:Hero inner -->
    </section>
    <!-- banner part ends -->

    <!-- Popular block starts -->
    <section class="popular">
        <div class="container">
            <div class="title text-xs-center m-b-30">
                <h2 class="title">Best Seller in this Month</h2>
                <p class="subTitle">Our top selling dishes this month</p>
                <form method="post" action="">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search for dishes...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">Cari</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <?php
                // Display search results or popular dishes
                $count = 0; // variabel untuk menghitung jumlah data yang sudah ditampilkan
                while ($r = mysqli_fetch_array($query_res)) {
                    // Query untuk mengambil rating dan review dari tabel reviews
                    $review_query = mysqli_query($db, "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE dish_id = '$r[d_id]'");
                    $review_data = mysqli_fetch_assoc($review_query);

                    // Tampilkan informasi hidangan, rating, dan review
                    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
        <div class="food-item-wrap box">
            <div class="figure-wrap bg-image" data-image-src="admin/Res_img/dishes/' . $r['img'] . '">
                <div class="review pull-right"><a href="reviews.php?dish_id=' . $r['d_id'] . '" class="review-link">View Reviews</a></div>
            </div>
            <div class="content">
                <h5><a href="dishes.php?res_id=' . $r['rs_id'] . '">' . $r['title'] . '</a></h5>
            </div>
            <div class="product-name">' . $r['slogan'] . '</div>
            <div class="price-btn-block"> 
                <span class="price">Rp.' . $r['price'] . '</span> 
                <a href="dishes.php?res_id=' . $r['rs_id'] . '" class="btn ctaBtn pull-right">Order Now</a> 
                <br>  <br>  <br> 
                <div class="rating" style="display: flex; align-items: center;">
                    <span>' . number_format($review_data['avg_rating'], 1) . '</span>
                    <i class="fas fa-star" style="color: yellow;"></i>
                    <span>(' . $review_data['total_reviews'] . ')</span>
                </div>
            </div>
        </div>
    </div>';

                    // Menambahkan 1 ke hitung
                    $count++;

                    // Memeriksa apakah sudah menampilkan 3 data
                    if ($count >= 3) {
                        break; // Keluar dari loop
                    }
                }
                ?>

            </div>
        </div>
    </section>
    <!-- Popular block ends -->

    <!-- FOOTER SECTION ----------------------- -->
    <?php include("includes/footer.php"); ?>
    <!-- FOOTER SECTION END----------------- -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script src="js/theme.js"></script>

    <style>
        .review-link {
            color: yellow;
            font-weight: bold;
            background-color: orange;
            /* Example background color */
            padding: 5px 10px;
            /* Add padding for better visibility */
            border-radius: 5px;
            /* Optional: Add rounded corners */
            animation: pulse 1s infinite;
            /* Example animation */
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
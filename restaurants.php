<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>

<?php include("includes/head.php"); ?>

<body>
    <!--header starts-->
    <?php include("includes/navbar.php") ?>
    <!-- header end -->

    <div class="page-wrapper">
        <!-- top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="restaurants.php">Choose Meals</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your favorite food</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->
        <!-- start inner page hero -->
        <div class="inner-page-hero bg-image" data-image-src="images/jengkol_balado.jpg">
            <div class="container"> </div>
            <!-- end:Container -->
        </div>
        <section class="featured-restaurants">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-block pull-left">
                            <h4 class="title">Filter Meals</h4>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <!-- restaurants filter nav starts -->
                        <div class="restaurants-filter text-center">
                            <form method="GET" action="">
                                <div class="form-group d-inline-block">
                                    <label for="filter_title">Filter by Title (Category):</label>
                                    <select name="filter_title" id="filter_title" class="form-control">
                                        <option value="">All</option>
                                        <?php
                                        $res = mysqli_query($db, "SELECT * FROM res_category");
                                        while ($row = mysqli_fetch_array($res)) {
                                            $selected = (isset($_GET['filter_title']) && $_GET['filter_title'] == $row['c_name']) ? 'selected' : '';
                                            echo '<option value="' . $row['c_name'] . '" ' . $selected . '>' . $row['c_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group d-inline-block">
                                    <label for="filter_rating">Filter by Rating:</label>
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="">All</option>
                                        <option value="1" <?php if (isset($_GET['rating']) && $_GET['rating'] == '1') echo 'selected'; ?>>1</option>
                                        <option value="2" <?php if (isset($_GET['rating']) && $_GET['rating'] == '2') echo 'selected'; ?>>2</option>
                                        <option value="3" <?php if (isset($_GET['rating']) && $_GET['rating'] == '3') echo 'selected'; ?>>3</option>
                                        <option value="4" <?php if (isset($_GET['rating']) && $_GET['rating'] == '4') echo 'selected'; ?>>4</option>
                                        <option value="5" <?php if (isset($_GET['rating']) && $_GET['rating'] == '5') echo 'selected'; ?>>5</option>
                                    </select>
                                </div>
                                <div class="form-group d-inline-block">
                                    <label for="filter_alphabet">Sort by Alphabet:</label>
                                    <select name="filter_alphabet" id="filter_alphabet" class="form-control">
                                        <option value="">None</option>
                                        <option value="A-Z" <?php if (isset($_GET['filter_alphabet']) && $_GET['filter_alphabet'] == 'A-Z') echo 'selected'; ?>>A-Z</option>
                                        <option value="Z-A" <?php if (isset($_GET['filter_alphabet']) && $_GET['filter_alphabet'] == 'Z-A') echo 'selected'; ?>>Z-A</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </form>
                        </div>
                        <!-- restaurants filter nav ends -->
                    </div>
                </div>
                <!-- restaurants listing starts -->
                <div class="row">
                    <div class="restaurant-listing">
                        <?php
                        // Ambil nilai filter dari form
                        $filter_title = isset($_GET['filter_title']) ? $_GET['filter_title'] : '';
                        $filter_rating = isset($_GET['rating']) ? $_GET['rating'] : '';
                        $filter_alphabet = isset($_GET['filter_alphabet']) ? $_GET['filter_alphabet'] : '';

                        // Mulai query
                        $query = "SELECT restaurant.*, 
                                  AVG(dishes.rating) as avg_rating 
                                  FROM restaurant 
                                  LEFT JOIN dishes ON restaurant.rs_id = dishes.rs_id ";

                        // Tambahkan kondisi untuk filter title (category)
                        if (!empty($filter_title)) {
                            $query .= "LEFT JOIN res_category ON restaurant.c_id = res_category.c_id 
                                       WHERE res_category.c_name = '$filter_title' ";
                        }

                        // Tambahkan GROUP BY dan HAVING untuk filter rating
                        $query .= " GROUP BY restaurant.rs_id";
                        if (!empty($filter_rating)) {
                            $lower_bound = $filter_rating;
                            $upper_bound = $filter_rating + 0.9;
                            $query .= " HAVING avg_rating BETWEEN $lower_bound AND $upper_bound";
                        }

                        // Tambahkan pengurutan berdasarkan filter
                        if (!empty($filter_alphabet)) {
                            $query .= " ORDER BY restaurant.title " . ($filter_alphabet == 'A-Z' ? 'ASC' : 'DESC');
                        }

                        $ress = mysqli_query($db, $query);
                        if (mysqli_num_rows($ress) > 0) {
                            while ($rows = mysqli_fetch_array($ress)) {
                                $query = mysqli_query($db, "SELECT * FROM res_category WHERE c_id='" . $rows['c_id'] . "'");
                                $rowss = mysqli_fetch_array($query);
                                echo '<div class="col-xs-12 col-sm-12 col-md-6 single-restaurant all ' . $rowss['c_name'] . '">
                                        <div class="restaurant-wrap">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 text-xs-center">
                                                    <a class="restaurant-logo" href="dishes.php?res_id=' . $rows['rs_id'] . '" > <img src="admin/Res_img/' . $rows['image'] . '" alt="Restaurant logo"> </a>
                                                </div>
                                                <!--end:col -->
                                                <div class="col-xs-12 col-sm-9 col-md-12 col-lg-9">
                                                    <h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . '</a></h5><span class="price">' . $rows['description'] . '</span>
                                                    <div class="bottom-part">
                                                        <div class="rating">
                                                            <div class="average-rating">
                                                                <span>' . number_format($rows['avg_rating'], 1) . '</span>
                                                                <i class="fas fa-star" style="color: yellow;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end:col -->
                                            </div>
                                            <!-- end:row -->
                                        </div>
                                        <!--end:Restaurant wrap -->
                                    </div>';
                            }
                        } else {
                            echo '<div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        No restaurants found matching your criteria.
                                    </div>';
                        }
                        ?>
                    </div>
                </div>
                <!-- restaurants listing ends -->
            </div>
        </section>

        <!-- FOOTER SECTION ----------------------- -->
        <?php include("includes/footer.php"); ?>
        <!-- FOOTER SECTION END----------------- -->

    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>

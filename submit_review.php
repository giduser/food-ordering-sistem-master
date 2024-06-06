<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root"; // Sesuaikan dengan username MySQL Anda
$password = ""; // Sesuaikan dengan password MySQL Anda
$dbname = "online_food_order";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data dari form dan validasi
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$review = isset($_POST['review']) ? $_POST['review'] : '';
$d_id = isset($_POST['dish_id']) ? intval($_POST['dish_id']) : 0;

// Validasi data yang diambil
if (empty($name) || empty($email) || $rating <= 0 || $rating > 5 || empty($review) || $d_id <= 0) {
    echo "Invalid input data.";
    exit();
}

// Query to retrieve dish_id from dishes table based on d_id
$sql_get_dish_id = "SELECT d_id FROM dishes WHERE d_id = ?";
$stmt_get_dish_id = $conn->prepare($sql_get_dish_id);
$stmt_get_dish_id->bind_param("i", $d_id);
$stmt_get_dish_id->execute();
$result_dish_id = $stmt_get_dish_id->get_result();

if ($result_dish_id->num_rows > 0) {
    $row = $result_dish_id->fetch_assoc();
    $dish_id = $row['d_id'];

    // Menyiapkan dan menjalankan SQL statement untuk menyimpan ulasan
    $sql_insert_review = "INSERT INTO reviews (name, email, rating, review, dish_id) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_review = $conn->prepare($sql_insert_review);
    $stmt_insert_review->bind_param("ssisi", $name, $email, $rating, $review, $dish_id);

    // Menjalankan SQL statement untuk menyimpan ulasan
    if ($stmt_insert_review->execute()) {
        // Ambil ulasan baru untuk menghitung rata-rata rating dan jumlah ulasan per menu makanan
        $sql_get_reviews = "SELECT dish_id, AVG(rating) AS avg_rating, COUNT(*) AS num_reviews FROM reviews WHERE dish_id = ? GROUP BY dish_id";
        $stmt_get_reviews = $conn->prepare($sql_get_reviews);
        $stmt_get_reviews->bind_param("i", $dish_id);
        $stmt_get_reviews->execute();
        $result_get_reviews = $stmt_get_reviews->get_result();

        // Perbarui nilai-nilai di tabel dishes
        if ($result_get_reviews->num_rows > 0) {
            $row = $result_get_reviews->fetch_assoc();
            $avg_rating = $row['avg_rating'];
            $num_reviews = $row['num_reviews'];

            $sql_update_dishes = "UPDATE dishes SET rating = ?, num_reviews = ? WHERE d_id = ?";
            $stmt_update_dishes = $conn->prepare($sql_update_dishes);
            $stmt_update_dishes->bind_param("dii", $avg_rating, $num_reviews, $dish_id);
            $stmt_update_dishes->execute();
            $stmt_update_dishes->close();
        }

        // Menutup statement untuk mengambil reviews
        $stmt_get_reviews->close();

        // Alihkan kembali ke halaman index.php setelah ulasan berhasil disimpan
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql_insert_review . "<br>" . $conn->error;
    }

    // Menutup statement untuk mengambil dish_id
    $stmt_get_dish_id->close();
} else {
    echo "Error: No dish found for the provided d_id.";
}

// Menutup statement untuk menyimpan ulasan jika ada
if (isset($stmt_insert_review)) {
    $stmt_insert_review->close();
}

// Menutup koneksi
$conn->close();

<?php
// visited.php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle marking a temple as visited
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['temple_id'])) {
    $temple_id = intval($_POST['temple_id']);  // Ensure the temple_id is an integer
    $visit_date = date('Y-m-d');

    // Check if the temple is already marked as visited
    $check_query = "SELECT * FROM visited WHERE user_id = ? AND temple_id = ?";
    if ($stmt = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $temple_id);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) == 0) {
            // Mark temple as visited
            $insert_query = "INSERT INTO visited (user_id, temple_id, visit_date) VALUES (?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $insert_query)) {
                mysqli_stmt_bind_param($stmt, "iis", $user_id, $temple_id, $visit_date);
                mysqli_stmt_execute($stmt);

                // Fetch temple points
                $points_query = "SELECT gamification_points FROM divya_desam WHERE id = ?";
                if ($stmt2 = mysqli_prepare($conn, $points_query)) {
                    mysqli_stmt_bind_param($stmt2, "i", $temple_id);
                    mysqli_stmt_execute($stmt2);
                    $points_result = mysqli_stmt_get_result($stmt2);
                    $points = mysqli_fetch_assoc($points_result)['gamification_points'];

                    // If points exist, update the user's total points
                    if ($points > 0) {
                        $update_points_query = "UPDATE users SET points = points + ? WHERE id = ?";
                        if ($stmt3 = mysqli_prepare($conn, $update_points_query)) {
                            mysqli_stmt_bind_param($stmt3, "ii", $points, $user_id);
                            mysqli_stmt_execute($stmt3);
                        }
                    }
                }
            }
        }
    }
}

// Fetch visited temples for the user
$visited_query = "
    SELECT d.name, d.location, d.description, d.latitude, d.longitude, d.image, v.visit_date, d.gamification_points
    FROM visited v
    JOIN divya_desam d ON v.temple_id = d.id
    WHERE v.user_id = ?
";
if ($stmt = mysqli_prepare($conn, $visited_query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $visited_result = mysqli_stmt_get_result($stmt);
}

// Fetch all temples for marking as visited
$all_temples_query = "SELECT * FROM divya_desam";
$all_temples_result = mysqli_query($conn, $all_temples_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visited Temples</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('srirangam-temple.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        nav {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .visited-temples, .mark-as-visited {
            margin: 20px auto;
            max-width: 800px;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
            border-radius: 10px;
        }
        .temple {
            margin-bottom: 15px;
            border-bottom: 1px solid white;
            padding-bottom: 10px;
        }
        .temple img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="visited.php">Visited</a>
        <a href="punya_points.php">Punya Points</a>
        <a href="planner.php">Planner</a>
    </nav>

    <h1 style="text-align:center; margin-top: 20px;">Visited Temples</h1>

    <div class="visited-temples">
        <h2>Temples You Have Visited</h2>
        <?php if (mysqli_num_rows($visited_result) > 0): ?>
            <?php while ($temple = mysqli_fetch_assoc($visited_result)): ?>
                <div class="temple">
                    <h3><?php echo htmlspecialchars($temple['name']); ?></h3>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($temple['location']); ?></p>
                    <p><?php echo htmlspecialchars($temple['description']); ?></p>
                    <p><strong>Visited On:</strong> <?php echo htmlspecialchars($temple['visit_date']); ?></p>
                    <p><strong>Points Earned:</strong> <?php echo htmlspecialchars($temple['gamification_points']); ?></p>
                    <img src="<?php echo htmlspecialchars($temple['image']); ?>" alt="Temple Image">
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't visited any temples yet.</p>
        <?php endif; ?>
    </div>

    <div class="mark-as-visited">
        <h2>Mark a Temple as Visited</h2>
        <form action="" method="POST">
            <select name="temple_id" required>
                <option value="">Select a Temple</option>
                <?php while ($temple = mysqli_fetch_assoc($all_temples_result)): ?>
                    <option value="<?php echo $temple['id']; ?>">
                        <?php echo htmlspecialchars($temple['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Mark as Visited</button>
        </form>
    </div>
</body>
</html>

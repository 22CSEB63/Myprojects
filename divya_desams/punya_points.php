<?php
// punya_points.php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's total points
$total_points_query = "SELECT points FROM users WHERE id = '$user_id'";
$total_points_result = mysqli_query($conn, $total_points_query);
$total_points = mysqli_fetch_assoc($total_points_result)['points'];

// Fetch breakdown of points earned by temple
$points_breakdown_query = "
    SELECT d.name, d.location, d.gamification_points, v.visit_date 
    FROM visited v
    JOIN divya_desam d ON v.temple_id = d.id
    WHERE v.user_id = '$user_id'
";
$points_breakdown_result = mysqli_query($conn, $points_breakdown_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punya Points</title>
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
        .points-container {
            margin: 20px auto;
            max-width: 800px;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }
        .temple {
            margin-bottom: 15px;
            border-bottom: 1px solid white;
            padding-bottom: 10px;
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

    <h1 style="text-align:center; margin-top: 20px;">Your Punya Points</h1>

    <div class="points-container">
        <h2>Total Points: <?php echo htmlspecialchars($total_points); ?></h2>

        <h3>Points Breakdown</h3>
        <?php if (mysqli_num_rows($points_breakdown_result) > 0): ?>
            <?php while ($temple = mysqli_fetch_assoc($points_breakdown_result)): ?>
                <div class="temple">
                    <h4><?php echo htmlspecialchars($temple['name']); ?></h4>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($temple['location']); ?></p>
                    <p><strong>Points Earned:</strong> <?php echo htmlspecialchars($temple['gamification_points']); ?></p>
                    <p><strong>Visited On:</strong> <?php echo htmlspecialchars($temple['visit_date']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't earned any Punya Points yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>

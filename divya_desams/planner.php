<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

// Fetch temples from divya_desam table for planner
$query = "SELECT * FROM divya_desam";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Handle planning a visit
if (isset($_GET['temple_id'])) {
    $temple_id = $_GET['temple_id'];
    $user_id = $_SESSION['user_id'];
    $planned_date = date('Y-m-d');  // Today's date for the planned visit

    // Check if the user has already planned a visit to this temple
    $check_query = "SELECT * FROM planner WHERE user_id = '$user_id' AND temple_id = '$temple_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Insert the planned visit into the planner table
        $plan_query = "INSERT INTO planner (user_id, temple_id, planned_date) 
                       VALUES ('$user_id', '$temple_id', '$planned_date')";
        $plan_result = mysqli_query($conn, $plan_query);

        if ($plan_result) {
            // Increment user's punya points by a certain amount (e.g., 10 points)
            $update_points_query = "UPDATE users SET points = points + 10 WHERE id = '$user_id'";
            mysqli_query($conn, $update_points_query);

            // Provide feedback to the user
            echo "<script>alert('Visit planned successfully! Punya points have been added.'); window.location.href='planner.php';</script>";
        } else {
            echo "<script>alert('Error planning visit. Please try again.'); window.location.href='planner.php';</script>";
        }
    } else {
        // Inform the user that the temple is already in their planner
        echo "<script>alert('You have already planned a visit to this temple.'); window.location.href='planner.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divya Desams - Planner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('srirangam-temple.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        /* Header styles */
        header {
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 0;
            text-align: center;
        }
        header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
            margin: 0 10px;
            border-radius: 5px;
        }
        header a:hover {
            background-color: #007BFF;
        }
        .container {
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .temple-card {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            margin: 20px auto;
            padding: 15px;
            max-width: 600px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }
        .temple-card h2 {
            margin: 0 0 10px;
        }
        .temple-card img {
            width: 100%;
            border-radius: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header>
        <a href="home.php">Home</a>
        <a href="planner.php">Planner</a>
        <a href="visited.php">Visited Temples</a>
        <a href="punya_points.php">Punya Points</a>
        <a href="logout.php">Logout</a>
    </header>

    <div class="container">
        <h1>Your Temple Planner</h1>
        <?php while ($temple = mysqli_fetch_assoc($result)) { ?>
            <div class="temple-card">
                <h2><?php echo htmlspecialchars($temple['name']); ?></h2>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($temple['location']); ?></p>
                <p><?php echo htmlspecialchars($temple['description']); ?></p>
                <?php if (!empty($temple['image'])) { ?>
                    <img src="images/<?php echo htmlspecialchars($temple['image']); ?>" alt="<?php echo htmlspecialchars($temple['name']); ?>">
                <?php } ?>
                <!-- Add a button to plan a visit -->
                <a href="planner.php?temple_id=<?php echo $temple['id']; ?>" class="button">Plan Visit</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>

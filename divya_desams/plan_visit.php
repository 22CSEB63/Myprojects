<?php
session_start();
require 'db.php';  // Include your DB connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all temples to display
$query = "SELECT * FROM divya_desam";
$result = mysqli_query($conn, $query);

// Handle temple visit planning
if (isset($_POST['visit'])) {
    $temple_id = $_POST['temple_id'];
    $user_id = $_SESSION['user_id'];
    $visit_date = date('Y-m-d');  // Today's date

    // Insert visit record into the visited table
    $insert_query = "INSERT INTO visited (user_id, temple_id, visit_date) 
                     VALUES ('$user_id', '$temple_id', '$visit_date')";
    mysqli_query($conn, $insert_query);

    // Increment user's punya points by a certain value
    $update_points_query = "UPDATE users SET points = points + 10 WHERE id = '$user_id'";
    mysqli_query($conn, $update_points_query);

    // Redirect after successful visit
    header("Location: planner.php?status=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Visit</title>
</head>
<body>
    <h1>Plan Your Visit</h1>
    <p>Choose a temple to visit and earn punya points!</p>

    <!-- Display all temples -->
    <table>
        <thead>
            <tr>
                <th>Temple Name</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($temple = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $temple['name']; ?></td>
                    <td><?php echo $temple['location']; ?></td>
                    <td>
                        <form method="POST" action="plan_visit.php">
                            <input type="hidden" name="temple_id" value="<?php echo $temple['id']; ?>">
                            <button type="submit" name="visit">Plan Visit</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>

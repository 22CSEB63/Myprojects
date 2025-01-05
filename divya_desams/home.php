<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

// Fetch temple details from the divya_desam table
$query = "SELECT * FROM divya_desam";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divya Desams - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('srirangam-temple.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            overflow-x: hidden;
        }

        /* Title section */
        .title-section {
            background-color: #003366; /* Dark blue background */
            color: white;
            padding: 30px 0;
            text-align: center;
            font-size: 3em;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .title-section:hover {
            transform: scale(1.05);
        }

        /* Navigation links below the title */
        .nav-links {
            text-align: center;
            margin-top: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px 15px;
            background-color: #004b80; /* A slightly different blue */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #007BFF; /* Lighter blue on hover */
        }

        .container {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .temple-card {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 15px;
            max-width: 300px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .temple-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .temple-card h2 {
            margin: 0 0 10px;
            font-size: 1.8em;
            color: #fff;
        }

        .temple-card p {
            font-size: 1em;
            color: #ccc;
        }

        .temple-card img {
            width: 100%;
            border-radius: 10px;
            margin-top: 15px;
            transition: transform 0.3s ease;
        }

        .temple-card img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>
    <!-- Title Section -->
    <div class="title-section">
        Welcome to the 108 Divya Desams
    </div>

    <!-- Navigation Links Below Title -->
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="planner.php">Planner</a>
        <a href="visited.php">Visited Temples</a>
        <a href="punya_points.php">Punya Points</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <?php while ($temple = mysqli_fetch_assoc($result)) { ?>
            <div class="temple-card">
                <h2><?php echo htmlspecialchars($temple['name']); ?></h2>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($temple['location']); ?></p>
                <p><?php echo htmlspecialchars($temple['description']); ?></p>
                <?php if (!empty($temple['image'])) { ?>
                    <img src="images/<?php echo htmlspecialchars($temple['image']); ?>" alt="<?php echo htmlspecialchars($temple['name']); ?>">
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <script>
        // Function to check if an element is in the viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return rect.top >= 0 && rect.bottom <= window.innerHeight;
        }

        // Add "pop in" effect on scroll
        const templeCards = document.querySelectorAll('.temple-card');

        function handleScroll() {
            templeCards.forEach(card => {
                if (isInViewport(card)) {
                    card.classList.add('visible');
                }
            });
        }

        // Run on page load
        handleScroll();

        // Add scroll event listener
        window.addEventListener('scroll', handleScroll);
    </script>
</body>
</html>

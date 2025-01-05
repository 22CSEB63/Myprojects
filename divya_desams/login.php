<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .tabs button {
            padding: 10px;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-size: 16px;
        }
        .tabs button.active {
            border-bottom: 2px solid #007BFF;
            color: #007BFF;
        }
        .form-container {
            display: none;
        }
        .form-container.active {
            display: block;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tabs">
            <button id="login-tab" class="active" onclick="showForm('login')">Login</button>
            <button id="register-tab" onclick="showForm('register')">Register</button>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="form-container active">
            <form action="auth.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>

        <!-- Register Form -->
        <div id="register-form" class="form-container">
            <form action="auth.php" method="POST">
                <label for="new_username">Username:</label>
                <input type="text" name="new_username" id="new_username" required>
                <label for="new_password">Password:</label>
                <input type="password" name="new_password" id="new_password" required>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <button type="submit" name="register">Register</button>
            </form>
        </div>

        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <?php if (!empty($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
    </div>

    <script>
        function showForm(formType) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');

            if (formType === 'login') {
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
            } else {
                loginForm.classList.remove('active');
                registerForm.classList.add('active');
                loginTab.classList.remove('active');
                registerTab.classList.add('active');
            }
        }
    </script>
</body>
</html>

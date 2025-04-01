<?php
session_start();

// Initialize error arrays for login and signup
$loginErrors = [];
$signupErrors = [];

// Track success messages
$signupSuccess = $loginSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Login form was submitted
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validate email for Gmail format
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
            $loginErrors['email'] = "Invalid email format. Only Gmail addresses are allowed.";
        }

        // Check if the email and password match the session-stored user
        if (isset($_SESSION['user']) && ($_SESSION['user']['email'] === $email && $_SESSION['user']['password'] === $password)) {
            $loginSuccess = true;
        } else {
            $loginErrors['general'] = "Invalid email or password.";
        }
    } elseif (isset($_POST['signup'])) {
        // Signup form was submitted
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate each field
        if (empty($first_name)) {
            $signupErrors['first_name'] = "First name is required.";
        }
        if (empty($last_name)) {
            $signupErrors['last_name'] = "Last name is required.";
        }
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
            $signupErrors['email'] = "Email must be a valid Gmail address (e.g., example@gmail.com).";
        }
        if (strlen($password) < 8) {
            $signupErrors['password'] = "Password must be at least 8 characters long.";
        }
        if ($password !== $confirm_password) {
            $signupErrors['confirm_password'] = "Passwords do not match.";
        }

        // If no errors, store the credentials in session for login
        if (empty($signupErrors)) {
            $_SESSION['user'] = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password
            ];
            $signupSuccess = true;
        }
    }
}

   
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Azzouzi Shop</title>
    <link rel="stylesheet" href="css/styles.css">
    <style type="text/css">
        .hero {
            background-image: url('home.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            color: #fff;
        }
        
    </style>
</head>
<body>
    
      <?php if ($signupSuccess): ?>
        alert("Sign-up successful! Please log in.");
    <?php elseif ($loginSuccess): ?>
        alert("Login successful!");
    <?php endif; ?>
     
    <?php if (isset($loginSuccess)) echo "<p>$loginSuccess</p>"; ?>
    <?php if (isset($loginError)) echo "<p style='color:red;'>$loginError</p>"; ?>
    <?php if (isset($signupSuccess)) echo "<p>$signupSuccess</p>"; ?>
    <?php if (isset($signupError)) echo "<p style='color:red;'>$signupError</p>"; ?>


    <div class="header">
        <div class="container">
            <div class="nav">
                <a href="index.html" target="_blank">HOME</a>
                <a href="ABOUT.html" target="_blank">ABOUT</a>
                <a href="SHOP.html" target="_blank">SHOP</a>
                <a href="CONTACT.html" target="_blank">CONTACT</a>
            </div>
            <div class="auth-buttons">
                <button onclick="showLogin(), hideSignup()" ondblclick="hideLogin()">LOGIN</button>
                <button onclick="showSignup(), hideLogin()" ondblclick="hideSignup()">SIGN UP</button>
            </div>
        </div>
    </div>
    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to Azzouzi Shop!</h1>
            <p>Your one-stop shop for the best products</p>
            <a href="shop.html" target="_blank">
                <button>Start Shopping</button>
            </a>
        </div>
    </div>
    <div class="content">
        <h2>About Our Shop</h2><br>
        <p>At My E-Commerce Site, we offer a wide range of high-quality products to meet all your needs. From the latest in fashion to cutting-edge tech gadgets, our shop has it all. We are committed to providing the best online shopping experience, with excellent customer service and unbeatable prices.</p><br><br>
        <br><br><h2>Sneak Peek at Our Shop</h2>
        <div class="sneak-peek">
            <div class="product" style="transition: transform 0.3s ease;">
                <img src="images/1.jpg" alt="Product 1">
                <h3>Infinix smart 7 HD X6516</h3>
                <p>6,6" - 64 Gb + 4 GB (2+2GB) - 6,6" - Bleu</p>
                <a href="shop.html" target="_blank">
                    <button>View Details</button>
                </a>
            </div>
            <div class="product" style="transition: transform 0.3s ease;">
                <img src="images/2.jpg" alt="Product 2">
                <h3>NIVEA MEN Déodorant Silver Protect</h3>
                <p>150ml</p>
                <a href="shop.html" target="_blank">
                    <button>View Details</button>
                </a>
            </div>
            <div class="product" style="transition: transform 0.3s ease;">
                <img src="images/3.jpg" alt="Product 3">
                <h3>TCL Smart TV 32" Android™ officielle FHD</h3>
                <p>Google Assistant™ - Bluetooth™ + Support</p>
                <a href="shop.html" target="_blank">
                    <button>View Details</button>
                </a>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 Azzouzi Shop. All rights reserved.</p>
    </div>

   
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="login-popup" style="display: <?= isset($loginErrors) && !empty($loginErrors) ? 'block' : 'none' ?>;">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="hidden" name="login" value="1">
            <input type="email" name="email" placeholder="Email (must end with @gmail.com)" required>
            <?php if (isset($loginErrors['email'])) echo "<p style='color:red;'>{$loginErrors['email']}</p>"; ?>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (isset($loginErrors['general'])) echo "<p style='color:red;'>{$loginErrors['general']}</p>"; ?>
            <button type="submit">Login</button>
            <br>
            <button type="button" onclick="document.getElementById('login-popup').style.display='none'">Cancel</button>
        </form>
    </div>

    
    <div class="popup" id="signup-popup" style="display: <?= isset($signupErrors) && !empty($signupErrors) ? 'block' : 'none' ?>;">
        <h2>Sign Up</h2>
        <form method="POST" action="">
            <input type="hidden" name="signup" value="1">

            <input type="text" name="first_name" placeholder="First Name" required>
            <?php if (isset($signupErrors['first_name'])) echo "<p style='color:red;'>{$signupErrors['first_name']}</p>"; ?>

            <input type="text" name="last_name" placeholder="Last Name" required>
            <?php if (isset($signupErrors['last_name'])) echo "<p style='color:red;'>{$signupErrors['last_name']}</p>"; ?>

            <input type="email" name="email" placeholder="Email (must end with @gmail.com)" required>
            <?php if (isset($signupErrors['email'])) echo "<p style='color:red;'>{$signupErrors['email']}</p>"; ?>

            <input type="password" name="password" placeholder="Password (8+ characters)" required>
            <?php if (isset($signupErrors['password'])) echo "<p style='color:red;'>{$signupErrors['password']}</p>"; ?>

            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <?php if (isset($signupErrors['confirm_password'])) echo "<p style='color:red;'>{$signupErrors['confirm_password']}</p>"; ?>

            <button type="submit">Sign Up</button>
            <br>
            <button type="button" onclick="document.getElementById('signup-popup').style.display='none'">Cancel</button>
        </form>
    </div>

    <script>
        const existingUsers = [
    { username: 'mehdi', password: 'pass', email: 'mehdi@gmail.com' },
];

document.querySelector('.auth-buttons button:nth-child(1)').addEventListener('click', function() {
    showLogin();
});

function showLogin() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('login-popup').style.display = 'block';
}

function hideLogin() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('login-popup').style.display = 'none';
}

document.querySelector('.auth-buttons button:nth-child(2)').addEventListener('click', function() {
    showSignup();
});

function showSignup() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('signup-popup').style.display = 'block';
}

function hideSignup() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('signup-popup').style.display = 'none';
}

function login() {
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    const user = existingUsers.find(user => user.username === username && user.password === password);

    if (user) {
        alert('Login successful!');
        hideLogin();
    } else {
        alert('Invalid username or password.');
    }
    return false; 
}

function signup() {
    const username = document.getElementById('signup-username').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;

    if (password.length < 8) {
        alert('Password must contain at least 8 characters!');
        return false;
    }

    const emailExists = existingUsers.some(user => user.email === email);
    if (emailExists) {
        alert('Email already exists!');
        return false; 
    }

    const usernameExists = existingUsers.some(user => user.username === username);
    if (usernameExists) {
        alert('Username already exists!');
        return false; 
    }

    
    existingUsers.push({ username, password, email });

    alert('Sign up successful!');
    hideSignup();
    return false; 
}


    </script>


</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assests/css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="hero-card">
            <h1>The Scholar Schools Manshera</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit...</p>
        </div>
        <div class="login-box">
            <header class="login-header">
                <h1>Admin Login</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
            </header>
            <main class="login">
                <form action="./Backend/login.php" method="POST">
                    <div>
                        <input type="text" id="username" name="username" placeholder="Email" required />
                    </div>
                    <div>
                        <input type="password" id="password" name="password" placeholder="Password" required />
                    </div>
                    <button type="submit" class="form-button">Login</button>
                </form>
                <?php if (isset($error)) : ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
            </main>
            <footer class="signup-footer">
                <p><a href="#">Don't have an account?</a></p>
            </footer>
        </div>
    </div>
</body>
</html>

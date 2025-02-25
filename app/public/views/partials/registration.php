<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register Form</title>
    <link rel="stylesheet" href="../../assets/css/registrationStyle.css"/>
</head>
<body>
    <div class="registration-container">
        <h1>Create an Account</h1>

        <!-- Display registration error message if exists -->
        <?php
        if (isset($_SESSION['register_error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['register_error']; ?></p>
            <?php unset($_SESSION['register_error']); 
        endif; ?>

        <form action="/registration" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required/>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required/>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required/>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="captcha">Enter Captcha</label>
                <input type="text" id="captcha" name="captcha" required/>
                <div class="captcha-code"><?php echo $_SESSION['captcha_question']; ?></div>
            </div>
            
            <button type="submit">Register</button>
        </form>

        <div class="login-links">
            <a href="/login">Already have an account? Login</a>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="../../assets/css/registrationStyle.css"/>
</head>
<body>
    <div class="registration-container">
        <h1>Email Verification</h1>
        
        <?php if (isset($_SESSION['verification_status'])): ?>
            <div class="verification-message <?php echo strpos($_SESSION['verification_status'], 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo $_SESSION['verification_status']; ?>
            </div>
            
            <?php if (strpos($_SESSION['verification_status'], 'successfully') !== false): ?>
                <a href="/login" class="btn">Go to Login</a>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="verification-message">
                Processing your verification...
            </div>
        <?php endif; ?>
    </div>
</body>
</html>



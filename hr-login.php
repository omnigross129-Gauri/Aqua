<?php
session_start();

// If HR already logged in
if (isset($_SESSION['hr'])) {
    header("Location: manage_jobs.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // HR credentials (move to DB later)
    $hrUser = "hr";
    $hrPass = "hr123";

    if ($username === $hrUser && $password === $hrPass) {
        session_regenerate_id(true);
        $_SESSION['hr'] = $username;
        header("Location: hr_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HR Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Card */
.login-box {
    background: #fff;
    width: 100%;
    max-width: 380px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

/* Title */
.login-box h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* Inputs */
.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 15px;
}

.login-box input:focus {
    border-color: #667eea;
    outline: none;
}

/* Button */
.login-box button {
    width: 100%;
    padding: 12px;
    background: #667eea;
    border: none;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.login-box button:hover {
    background: #5563d6;
}

/* Error */
.error {
    background: #ffe1e1;
    color: #b30000;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}

/* Footer text */
.login-footer {
    text-align: center;
    margin-top: 15px;
    font-size: 13px;
    color: #777;
}

/* Mobile */
@media (max-width: 480px) {
    .login-box {
        padding: 25px 20px;
    }
}
</style>
</head>

<body>

<div class="login-box">
    <h2>HR Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="HR Username" required>
        <input type="password" name="password" placeholder="HR Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="login-footer">
        © <?= date('Y') ?> HR Portal
    </div>
</div>

</body>
</html>

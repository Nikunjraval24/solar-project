<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>
*{
    box-sizing:border-box;
}
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

/* Login Card */
.login-card{
    width:380px;
    padding:45px 40px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(18px);
    border-radius:24px;
    box-shadow:0 30px 70px rgba(0,0,0,0.6);
    color:white;
}

/* Heading */
.login-card h2{
    text-align:center;
    margin-bottom:35px;
    font-size:26px;
    letter-spacing:1px;
}

/* Input Group */
.input-group{
    margin-bottom:18px;
}
.input-group input{
    width:100%;
    padding:14px 16px;
    border-radius:14px;
    border:none;
    outline:none;
    font-size:15px;
}
.input-group input:focus{
    box-shadow:0 0 0 2px rgba(34,197,94,.5);
}
.input-group input::placeholder{
    color:#777;
}

/* Button */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:30px;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
    transition:0.3s ease;
}
button:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(34,197,94,.6);
}

/* Error Message */
.error{
    background:#fee2e2;
    color:#b91c1c;
    padding:12px;
    border-radius:12px;
    text-align:center;
    margin-bottom:18px;
    font-size:14px;
}

/* Footer */
.footer-text{
    text-align:center;
    margin-top:25px;
    font-size:13px;
    color:#dbeafe;
}
</style>
</head>

<body>

<div class="login-card">
    <h2>🔐 Admin Login</h2>

    <?php if(isset($_GET['error'])){ ?>
        <div class="error">❌ Invalid Username or Password</div>
    <?php } ?>

    <form method="POST" action="login_check.php">
        <div class="input-group">
            <input type="text" name="username" placeholder="Admin Username" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Admin Password" required>
        </div>

        <button type="submit">Login to Dashboard</button>
    </form>

    <div class="footer-text">
        ☀ Sun Solar Management System
    </div>
</div>

</body>
</html>

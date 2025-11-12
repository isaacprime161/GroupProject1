<!DOCTYPE html>
<html lang="en">
`;<head>
<meta charset="UTF-8">
<title>Simple Login Page</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: purpl;

    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.login-box {
    background:grey;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    width: 300px;
}
.login-box h2 {
    text-align: center;
    color: #1c2418ff;
}
.login-box input[type="text"],
.login-box input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.login-box input[type="submit"] {
    width: 100%;
    background: #007BFF;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 15px;
}
.login-box input[type="submit"]:hover {
    background: #0056b3;
}
</style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <form action="" method="post">
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>

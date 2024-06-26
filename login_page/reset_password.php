<?php
session_start();
include('../config/dbcon.php');

$errors = ""; 
$db = new db(); // Create an instance of the db class

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (empty($email)) {
        $errors = "Email is required!";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $db->getdata('*', 'users', "email='$email'");

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $_SESSION['reset_user_id'] = $row['user_id'];
                header("Location: confirm_password.php");
            } else {
                $errors = "No user found with that email.";
            }
        } else {
            $errors = "Error: " . $db->getconnection()->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>

    
      body {
     
    font-family: Arial, sans-serif;
    background-image: url('../assests/images/back9.jpg');
     background-size: cover;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center; /* Center the content */
}


.container {
    display: inline-block; /* To make form elements display inline */
    margin-right:7%;
    max-width: 500px;
  margin: auto;
  margin-left: 60vw;
  box-shadow: 0 4px 7px rgba(0, 0, 0, 0.3);
  color: #fff;
  background-color:rgba(75, 40, 30, 0.7);
    
}

label {
    font-weight: bold;
    margin-bottom: 8px;
    color: #555;
    display: block; /* Ensure label appears on a new line */
    border: 3px solid #ccc;
}

input[type="text"] {
    padding: 12px;
    margin-bottom: 16px;
    border: 3px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%; /* Make input field fill the container */
}

input[type="submit"] {
    padding: 12px 24px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;

    border-radius: 15px;
      color:white;
      width:35%;
      background-color:#4b281e;
      border:none;
      border-radius:10px;
}

input[type="submit"]:hover {
  background-color:#4b281e;
}
 /* Bootstrap error message styling */
 .error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid transparent;
            border-radius: .25rem;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php if(!empty($errors)): ?>
            <div class="error"><?php echo $errors; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="email" id="email" placeholder="Enter your email">
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>

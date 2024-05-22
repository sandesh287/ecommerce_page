<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - SueMe</title>
    <link rel="stylesheet" href="website.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,200;0,300;0,500;0,600;0,700;1,100;1,300&family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b498c53a4a.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- headings -->
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.php"><img src="images/logo.jpg" width="125px"></a>
            </div>
            <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.html">Product</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contactform.html">Contact Us</a></li>
                        <li><a href="account.php">Account</a></li>
                        <li class="nav-item">
                            <a href="cart.html" class="nav-link add-to-cart-button" id="cartValue"></a>
                            <i class="fa-solid fa-cart-shopping"> 0</i>
                        </li>
                    </ul>
                </nav>
        </div>           
    </div>

    <!-- login/register -->
    <div class="account-page">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <img src="images/logo2.jpg" width="100%">
                </div>

                <div class="col-2">
                    <div class="form-container">
                        <div class="form-btn">
                            <span onclick="Login()">Login</span>
                            <span onclick="register()">Register</span>
                            <hr id="Indicator">
                        </div>

                        <form method="post" id="LoginForm">
                            <input type="text" name="username" placeholder="Username or Email"> 
                            <input type="password" name="password" placeholder="Password">
                            <button type="submit" class="btn" class="btn" >Login</button>
                            <a href="#">Forgot Password</a>
                        </form>

                        <form id="RegForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username">
                        
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email">
                        
                            <label for="phone">Phone Number:</label>
                            <input type="text" id="phone" name="phone">
                        
                            <label for="text">Address:</label>
                            <input type="text" id="address" name="address">
                        
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password">
                        
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password">
                        
                            <button type="submit" name="submit">Sign Up</button>                  
                        </form>
                        <!-- Login Validation -->
                        
                        <!-- login php -->
                        <?php
                            $username = $password  = '';
                            if(isset($_POST['btn'])){
                                $err = [];
                                if(isset($_POST['username']) && !empty($_POST['username']) && trim($_POST['username'])){
                                    $username = trim($_POST['username']);
                                } else {
                                    $err['username'] = 'Enter username';
                                }
                                if(isset($_POST['password']) && !empty($_POST['password'])){
                                    $password = $_POST['password'];
                                } else {
                                    $err['password'] = 'Enter password';
                                }
                                //if error not occured
                                if(count($err) == 0){
                                    //check valid username and password
                                    if($username == 'Sanskriti98' && $password == 'Sanskriti123'){
                                        alert("succefull!");
                                        window.location.assign("index.php");
                                    }else {
                                        echo 'Login failed';
                                    }
                                }
                            }
                            ?>


                        <!-- Display errors or success message -->
                        <?php
                        if(isset($_POST['submit'])){
                            $server = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "store";

                            $con = mysqli_connect($server, $username, $password, $database);

                            if (!$con) {
                                die("Connection to database failed: " . mysqli_connect_error());
                            }

                            $uname = $_POST["username"];
                            $umail = $_POST["email"];
                            $uphone = $_POST["phone"];
                            $uaddress = $_POST["address"];
                            $upw = $_POST["password"];
                            $upwc = $_POST["confirm_password"];
                            $accCheck = "SELECT * FROM user WHERE email = '$umail' OR phone='$uphone'";
                            $result = $con->query($accCheck);

                            $errors = array(); // Store validation errors
                            $success_message = ''; // Store success message

                            if (empty($uname) || empty($umail) || empty($uphone) || empty($uaddress) || empty($upw) || empty($upwc)) {
                                $errors[] = "Please fill in all fields!";
                            } else {
                                // Perform other validations
                                if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $uname) || strlen($uname) < 3 || strlen($uname) > 20) {
                                    $errors[] = "Invalid name format or length (3 to 20 characters, starting with an alphabet)!";
                                } elseif (!filter_var($umail, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $umail)) {
                                    $errors[] = "Invalid email format or not a Gmail address!";
                                } elseif (!preg_match('/^(98|97)\d{8}/', $uphone)) {
                                    $errors[] = "Enter a valid phone number!!";
                                } elseif (!preg_match("/^[a-zA-Z0-9\s,'-]*$/", $uaddress)) {
                                    $errors[] = "Address should contain only alphabets, numbers, spaces, commas, apostrophes, and hyphens.";
                                } elseif (strlen($upw) < 6 || !preg_match('/[A-Z]/', $upw) || !preg_match('/[0-9]/', $upw)) {
                                    $errors[] = "Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!";
                                } elseif ($upw !== $upwc) {
                                    $errors[] = "The passwords do not match";
                                } elseif ($result->num_rows > 0) {
                                    $errors[] = "An account with this email or phone number already exists!";
                                } else {
                                    $sql = "INSERT INTO user (username, Email, Password, phone, address) VALUES ('$uname', '$umail', '$upw', '$uphone', '$uaddress')";

                                    if ($con->query($sql) === true) {
                                        $success_message = "Account created successfully!";
                                    } else {
                                        $errors[] = "Failure: " . $con->error;
                                    }
                                }
                            }

                            $con->close();
                        }
                        ?>

                        <?php if (!empty($errors)): ?>
                            <div class="error">
                                <?php foreach ($errors as $error): ?>
                                    <p><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success_message)): ?>
                            <div class="success">
                                <p><?php echo $success_message; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- footer -->
<div class="footer">
    <div class="container-footer">
        <div class="row">
            
            </div>
            <div class="footer-col-2">
                <img src="images/logo.jpg" width="180" height="150">
            
            </div>
            <div class="footer-col-4">
                <h3>Follow Us</h3>
                <ul>
                    <li>Facebook</li>

                </ul>
            </div>
        </div>
        <hr>
        
    </div>
</div>

    <!-- js for toggle form -->
    <script>
        var loginForm = document.getElementById("LoginForm");
        var RegForm = document.getElementById("RegForm");
        var Indicator = document.getElementById("Indicator");

        function register(){
            RegForm.style.transform = "translatex(0px)";
            loginForm.style.transform = "translatex(0px)";
            Indicator.style.transform = "translatex(100px)";
            loginForm.style.opacity = "0.1";
            RegForm.style.opacity = "99";
        }

        function Login(){
            RegForm.style.transform = "translatex(300px)";
            loginForm.style.transform = "translatex(300px)";
            Indicator.style.transform = "translatex(0px)";
            RegForm.style.opacity = "0.1";
            loginForm.style.opacity = "99";
        }
    </script>
</body>
</html>
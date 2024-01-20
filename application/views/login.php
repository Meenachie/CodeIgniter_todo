<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="icon" type="image/x-icon" href="images/favicon1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
        <div class="container-fluid">
            <ul class="navbar-nav">
            <li class="nav-item">
            <a class=" navbar-brand" href="welcome"><img src="images/home.png" style="width:40px; height:auto" alt="Home"></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" style="color:#E74E35; font-size:20px;" href="welcome"><b>Taskify</b></a>
            </li>
            </ul>
        <form class="d-flex">
            <a href=""><button class="btn me-3" style="background-color:#E74E35; color:white;" type="button">Login</button></a>
            <a href="signup"><button class="btn btn-light me-2" type="button">Signup</button></a>
        </form>
        </div>
    </nav><br><br><p></p><br><br>
    <div class="container mt-5">
        <div class="shadow-lg p-4 mb-4 bg-white">
            <center><p class="h3">Log In</p></center>
        <div class="container mt-3">
            <form action="<?php echo base_url('login');?>" method="post">
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
                    <label for="email">Email</label>
                    <small class="text-danger"><?php echo form_error('email'); ?></small>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
                    <label for="password">Password</label>
                    <small class="text-danger"><?php echo form_error('password'); ?></small>
                </div>
                    <center><button type="submit" name="login" class="btn" style="width: 150px;background-color:#E74E35; color:white;">Log In</button><center>
                    <hr>
                    <p>Don't have an account?&nbsp;<a href="signup" style="text-decoration:none;color:#E74E35;">Sign Up</a></p>
            </form>
        </div>
        </div>
    </div>     
</body>
</html>
<?php

    define("TITLE", "FrontBlow | Login");
    include("Header.php");


    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = testInput($_POST['username']);
        $password = testInput($_POST['password']);

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        $results = getAdminRecords();
        while($result = mysqli_fetch_array($results))
        {
            if($result['username'] == $username && $result['password'] == $password)
            { 
            ?>
            <div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                    <h3 class="popup__content__title">
                        Success 
                    </h3>
                    <p> Welcome  
                        <?php  
                            echo $username;
                        ?>  
                    </p>
                    <p>
                        <?php echo "<script>setTimeout(\"location.href = 'Dashboard.php';\",2000);</script>";?>
                    </p>
                </div>
            </div>

            <?php
            break;
            }
            else
            {
            ?>
                <div class="popup popup--icon -error js_error-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title">
                            Error 
                        </h3>
                        <p> Incorrect Username and Password </p>
                        <p>
                            <a href="login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                        </p>
                    </div>
                </div>   
            <?php
            }
        }
    }


?>


<link rel="stylesheet" href="../Assets/LoginStyle.css">

<section class="form my-4 mx-5">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-5">
                <img src="../Assets/Pictures/Login.jpg" alt="" class="img-fluid">
            </div>
            <div class="col-lg-7 px-5 pt-5">
                <h1 class="font-weight-bold py-3 mt-5 mb-3">FrontBlow Event Ticketing System</h1>
                <form method="post">
                    <div class="form-row">
                        <div class="col-lg-7">
                            <input type="text" Required placeholder="Username" class="form-control my-4 p-2" name="username" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-7">
                            <input type="password" Required placeholder="Password" class="form-control my-4 p-2" name="password" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-7">
                            <input type="submit" class="btn1 mt-3 mb-5" value="Login"></input>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


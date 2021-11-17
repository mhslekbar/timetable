<?php 
    session_start();
    $noNavbar = "";
    $pageTitle = "Login";

    if(isset($_SESSION['username'])){
        header("Location: Emploi.php"); 
    }

    include 'init.php';  
    
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $stmt = $con->prepare("SELECT * FROM users WHERE zuser = ? and zpass=? ");
        $stmt->execute(array($user,$pass));
        $count = $stmt->rowCount();
        if($count == 1){
            header("Location: Emploi.php"); 
            $_SESSION['username'] = $user;
        }
        else {
            $errorConn = '<div class="alert alert-danger alert-login"> Username Or Password Is Wrong</div>';
        }
    }

?>

    <div class="login">
        <h1 class='text-center'>Login</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='POST'>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block submit">Submit</button>
        </form>
        <?php
        if(isset($errorConn)):
            echo $errorConn;
        endif;   
        ?>
    </div>


<?php 
    include $tpl . "footer.php";
?>
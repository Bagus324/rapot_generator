<?php

session_start();
$conn = mysqli_connect("localhost", "root", "", "rapot");
if (isset($_SESSION['login_status'])) {
    header("Location: home.php");
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $result = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] === $password) {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['login_status'] = true;
            $_SESSION['role'] = $row['role'];
            header("Location: siswa.php");
            exit;
        }
        
    }

    $error = true;
}

?>
<?php
include 'parts/bs.php';
include 'parts/head.php';
?>

<body class="bg-gradient-primary">

    <div class="container pt-5">

        <!-- Outer Row -->
        <div class="row justify-content-center pt-5">

            <div class="col-6 pt-5">

                <div class="card o-hidden border-0 shadow-lg my-5">

                        <!-- Nested Row within Card Body -->

                            <div class="col-lg-13">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                                    </div>
                                    <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                    Username atau Password Salah
                                    </div>
                                    <?php endif; ?>

                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username" 
                                                placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit" name="login">
                                            Login
                                        </button>
                                        <a class="btn btn-info btn-user btn-block">
                                            Register
                                        </a>
                                </div>
                            </div>
                </div>

            </div>

        </div>

    </div>


</body>

</html>
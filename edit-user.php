<?php require_once('./includes/header.php'); ?>
<body>
    <div class="container">
        <h2 class="pt-4">User Update</h2>
        <?php 

            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                header("Location: index.php");
            } else {
                $user_id = $_POST['val'];
                $sql = 'SELECT * FROM users WHERE user_id = ?';
                $stmt = mysqli_stmt_init($link);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    die("Failed");
                } else {
                    mysqli_stmt_bind_param($stmt, 'i', $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        $user_id = $row['user_id'];
                        $user_name = $row['user_name'];
                        $user_email = $row['user_email'];
                        $user_password = $row['user_password'];
                    }   
                }
            }
        ?>
        <?php 
            if (isset($_POST['submit'])) {
                $id = $_POST['val'];
                $user_name = trim($_POST['name']);
                $user_email = trim($_POST['email']);
                $user_password = trim($_POST['password']);
                if(empty($user_name) || empty($user_email) || empty($user_password)) {
                    echo "<div class='alert alert-danger'>Field can't be empty!</div>";
                } else {
                    $sql = "UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?";
                    $stmt = mysqli_stmt_init($link);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        die("Query Failed");
                    } else {
                        mysqli_stmt_bind_param($stmt, 'sssi', $user_name, $user_email, $user_password, $id);
                        mysqli_stmt_execute($stmt);
                        header("Location: index.php");
                    }
                }
            }
        ?>
        <form class="py-2" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="name" class="form-control" id="username" value="<?php echo $user_name; ?>" placeholder="Desired username">
                <input type="hidden" name="val" value="<?php echo $user_id ?>">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $user_email; ?>" placeholder="Desired email address">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" value="<?php echo $user_password; ?>" placeholder="Enter new password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php require_once('./includes/footer.php'); ?>
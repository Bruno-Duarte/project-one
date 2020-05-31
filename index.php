<?php require_once('./includes/header.php'); ?>

    <div class="container">

        <?php
            if (isset($_POST['submit'])) {
                $user_name = trim($_POST['username']);
                $user_email = trim($_POST['useremail']);
                $user_password = 'SECRET';
                if (empty($user_name) || empty($user_email)) {
                    $error = true;
                } else {
                    $sql = 'INSERT INTO users SET user_name = ?, user_email = ?, user_password = ?';
                    $stmt = mysqli_stmt_init($link);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        die("Query Failed");
                    } else {
                        mysqli_stmt_bind_param($stmt, 'sss', $user_name, $user_email, $user_password);
                        mysqli_stmt_execute($stmt);
                    }
                }
            }
        ?>
        <form class="py-4" action="index.php" method="POST">
            <div class="row">
                <div class="col">
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="col">
                    <input type="text" name="useremail" class="form-control" placeholder="Email Address">
                </div>
                <div class="col">
                    <input type="submit" name="submit" class="form-control btn btn-secondary" value="Add New User">
                    <?php echo isset($error) ? "<p>Field can't be blank</p>" : ''; ?>
                </div>
            </div>
        </form>

        <h2>All Users</h2>
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>

              <?php 

                $sql = 'SELECT user_id, user_name, user_email FROM users';
                
                $stmt = mysqli_stmt_init($link);
                
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "Failed";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $user_id = $row['user_id'];
                        $user_name = $row['user_name'];
                        $user_email = $row['user_email']; ?>
                        
                        <tr>
                            <td><?php echo $user_id; ?></td>
                            <td><?php echo $user_name; ?></td>
                            <td><?php echo $user_email; ?></td>
                            <td>
                                <form action="edit-user.php" method="POST">
                                    <input type="hidden" name="val" value="<?php echo $user_id; ?>" >
                                    <input class="btn btn-link" type="submit" name="edit" value="Edit" >
                                </form>
                            </td>
                            <td>
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="val" value="<?php echo $user_id; ?>" >
                                    <input class="btn btn-link" type="submit" name="delete" value="Delete" >
                                </form>
                            </td>
                        </tr>

                    <?php }
                }

              ?>
            </tbody>
        </table>
        <?php 
            /*if (isset($_GET['del'])) {
                $user_id = $_GET['del'];
                $sql = 'DELETE FROM users WHERE user_id = ?';
                $stmt = mysqli_stmt_init($link);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    die("Failed");
                } else {
                    mysqli_stmt_bind_param($stmt, 'i', $user_id);
                    mysqli_stmt_execute($stmt);
                    header("Location: http://localhost/projectone/index.php");
                }
            }*/

            if (isset($_POST['delete'])) {
                $user_id = $_POST['val'];
                $sql = 'DELETE FROM users WHERE user_id = ?';
                $stmt = mysqli_stmt_init($link);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    die("Failed");
                } else {
                    mysqli_stmt_bind_param($stmt, 'i', $user_id);
                    mysqli_stmt_execute($stmt);
                    header("Location: http://localhost/projectone/index.php");
                }
            }
        ?>
    </div>
<?php require_once('./includes/footer.php'); ?>
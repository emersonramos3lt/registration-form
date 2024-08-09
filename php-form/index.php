<?php
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Welcome</h1>

    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

    <div>
    <label>User</label>
    <input class="input" type="text" name="user"><br>
    </div>

    <div>
    <label>Password</label>
    <input class="input" type="password" name="pass"><br>
    </div>

    <div>
    <input class="button" type="submit" name="submit" value="Register">
    </div>
    </form>

</body>
</html>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($user)) {
            echo '<p class="p-echo">Please enter a user</p>';
        }

        elseif(empty($pass)) {
            echo '<p class="p-echo">Please enter a password</p>';
        }

        else { // PROTEÇÃO DE SENHA
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (user, password) VALUES ('$user', '$hash')";

            try {
                mysqli_query($conn, $sql); {
                echo '<p class="p-sucess">You are now registered</p>';
                }
            }

            catch(mysqli_sql_exception) {
                echo '<p class="p-fail">That username is taken</p>';
            }
        }
    }

    mysqli_close($conn);
?>
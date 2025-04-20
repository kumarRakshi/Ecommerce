<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = sha1($_POST['pass']);  // Note: Using SHA-1 is not recommended for secure password hashing. Consider using bcrypt or Argon2.

    // Check if the email already exists handled by the trigger in the database

    $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES (?, ?, ?)");
    $insert_user->execute([$name, $email, $password]);

    // Check if the registration was successful
    if ($insert_user->rowCount() > 0) {
        $message[] = 'Registered successfully. Please log in.';
    } else {
        $message[] = 'Registration failed. Please try again.';
    }
}

// <?php

// include 'components/connect.php';

// session_start();

// if (isset($_SESSION['user_id'])) {
//     $user_id = $_SESSION['user_id'];
// } else {
//     $user_id = '';
// }

// if (isset($_POST['submit'])) {
//     $name = $_POST['name'];
//     $name = filter_var($name, FILTER_SANITIZE_STRING);
//     $email = $_POST['email'];
//     $email = filter_var($email, FILTER_SANITIZE_STRING);
//     $pass = sha1($_POST['pass']);
//     $pass = filter_var($pass, FILTER_SANITIZE_STRING);
//     $cpass = sha1($_POST['cpass']);
//     $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

//     try {
//         $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES (?, ?, ?)");
//         $insert_user->execute([$name, $email, $cpass]);
//         $message[] = 'Registered successfully, login now please!';
//     } catch (PDOException $e) {
//         if ($e->getCode() == '45000') {
//             $message[] = 'User with the same email already exists. Multiple registrations are not allowed.';
//         } else {
//             // Handle other exceptions if needed
//             $message[] = 'Error: ' . $e->getMessage();
//         }
//     }
// }

//

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">

   
<form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account?</p>
      <a href="user_login.php" class="option-btn">login now</a>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
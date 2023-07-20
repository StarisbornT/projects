<?php 
session_start();
include 'database.php';

$error =  "";
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
   
    // Check if any field is empty
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Check if email format is valid
        $error = 'Invalid Email Format';
    } else {
        // Check if the email already exists in the database
        $existingQuery = "SELECT * FROM users WHERE email = '$email'";
        $existingResult = $conn->query($existingQuery);
        if ($existingResult->num_rows > 0) {
            $error = "This email is already registered.";
        } else {
            // Generate MD5 hash for the password
            $hashedPassword = md5($password);
            $sql = "INSERT INTO users (names, email, passwords) VALUES ('$name', '$email', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['id'];
                header("Location: index.php");
                exit(); // Terminate the script after redirecting
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "All Fields are Required";
    }
        else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid Email Format';
        }else {
            // Generate MD5 hash for the password
    $hashedPassword = md5($password);

    // Prepare and execute the SQL query to fetch user data
    $sql = "SELECT * FROM users WHERE email = '$email' AND passwords = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php");
        
    } else {
        // User not found, login failed
        $error = "Invalid email or password!";
    }
        }
        
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePost'])) {
    // Check if the postId parameter is present
    if (isset($_POST['postId'])) {
        // Get the postId value
        $postId = $_POST['postId'];

        $query = "DELETE FROM tasks WHERE id = $postId";

        // Execute the delete query
        if (mysqli_query($conn, $query)) {
            // Deletion successful
            echo "<script>alert('Post deleted successfully.');</script>";
            header("Location: index.php");
            exit();
        } else {
            // Deletion failed
            echo "<script>alert('Failed to delete post.');</script>";
        }
    }
}

if (isset($_POST['update_task'])) {
    $postId = $_POST['postId'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    if (empty($title) || empty($description)) {
        echo "All Fields required";
    } else {
        // No image file uploaded, update the blog post without changing the image
        $query = "UPDATE tasks SET title = '$title', descriptions = '$description' WHERE id = $postId";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Successfully Updated');</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
            exit();
        }
    }
}
?>
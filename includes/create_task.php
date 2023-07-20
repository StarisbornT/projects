<?php
include 'database.php';

$error = "";
if (isset($_POST['create_task'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    if (empty($description) || empty($title)) {
        $error = "All Fields are Required";
    }else {
            $query = "INSERT INTO tasks (title, descriptions) VALUES ('$title', '$description')";
            mysqli_query($conn, $query);
            echo "
                <script>
                    alert('Successfully Added');
                    window.location.href = 'index.php';
                </script>";
            exit();
        }
    }

    $title = '';
    $description = '';
    
    // Check if the editId parameter is present
    if (isset($_GET['editId'])) {
        $editId = $_GET['editId'];
    
        // Fetch the blog post from the database based on the ID
        $query = "SELECT * FROM tasks WHERE id = $editId";
        $result = mysqli_query($conn, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $blogPost = mysqli_fetch_assoc($result);
            // Extract the necessary data from $blogPost
            $title = $blogPost['title'];
            $description = $blogPost['descriptions'];
        } else {
            // Blog post with the specified ID was not found
            echo "Blog post not found.";
        }
    }
 ?> 

<div class="container" style="margin-top:100px; margin-bottom:50px;">
        <div class="row">
            <div class="col-md-6 mx-auto">
            <?php if (isset($editId)) : ?>
            <h2 class="text-center">Edit Task</h2>
          <?php else : ?>
            <h2 class="text-center">Create task</h2>
          <?php endif; ?>
                <form class="text-left clearfix mt-50" action="index.php?create_task" method="POST">
                <?php if (isset($editId)) : ?>
              <input type="hidden" name="postId" value="<?php echo $editId; ?>">
            <?php endif; ?>
                <div class="form-group">
                            <input type="text" class="form-control" name="title"  placeholder="Task Title" value="<?php echo $title; ?>">
                        </div>
                        <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea"><?php echo $description; ?></textarea>
                        
                        <?php if (isset($editId)) : ?>
                        <button type="submit" name="update_task" class="btn btn-primary text-center">Update Task</button>
                        <?php else : ?>
                        <button type="submit" name="create_task" class="btn btn-primary" >Submit</button>
                        <?php endif; ?>
                    </form>
</div>
</div>
</div>
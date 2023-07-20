	<!-- start banner Area -->
    <section class="banner-area relative" id="home" data-parallax="scroll" data-image-src="img/b1.jpg">
				<div class="overlay-bg overlay"></div>
				<div class="container">
					<div class="row fullscreen">
						<div class="banner-content d-flex align-items-center col-lg-12 col-md-12">
							<h1>
								Create And Manage <br>
								Administrative Task.								
							</h1>
						</div>	
																	
					</div>
				</div>
			</section>
			<!-- End banner Area -->	
            <div class="post-wrapper pt-100">
                <?php 
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true):
                 ?>
            <a href="index.php?create_task" class="btn btn-primary">Create Task</a>

          <?php endif; ?>
        <!-- Start post Area -->
        <section class="post-area">
        <?php
$i = 1;
$rows = mysqli_query($conn, "SELECT * FROM tasks ORDER BY id DESC")
?>
            <div class="container">
                <div class="row justify-content-center d-flex">
                    <div class="col-lg-8">
                    <?php foreach ($rows as $row): ?>               
                        <div class="post-lists">
                            <div class="single-list flex-row d-flex">
                                
                                <div class="detail">
                                    <a href="#"><h4 class="pb-20"><?php echo $row['title']; ?>
                                    </h4></a>
                                    <p>
                                    <?php echo $row['descriptions']; ?>
                                    </p>
                                    <div class="row">
                                        <div class="col">
                                            <?php 
                                            $taskId = $row['id'];
                                            $editTaskUrl = "index.php?create_task&editId=" . $taskId;
                                            ?>
                                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
                                        <a href="<?php echo $editTaskUrl; ?>" class="btn btn-secondary">Edit Task</a>
                                    </div>
                                <form action="server.php" method="POST">
                                    <div class="col">
                                    <input type="hidden" name="postId" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="deletePost">Delete</button>
                                    </form>
                                    </div>
                                    </div>
                            <?php endif; ?> 
                                </div>
                               
                            </div>
                            
                            <?php endforeach; ?>
                                                                                                
                        </div>
                                                 
                    </div>
                    
                </div>
            </div>    
        </section>
        <!-- End post Area -->  
    </div>


			
			
			
			
			
<?php

include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");

if (isset($_POST["post"])) {
    $post = new Post($connection, $userLoggedIn);
    $post->submitPost($_POST["post_text"], "none");
}

 ?>

<div class="user_details column">

    <a href="<?php echo $userLoggedIn ?>">
        <img src="<?php echo $user["profile_pic"]; ?>" alt="profile picture">
    </a>

    <div class="user_details_left_right">
        <a href="<?php echo $userLoggedIn ?>">
        <?php

            echo $user["firstName"] .  " " . $user["lastName"];

         ?>
        </a>

        <?php

            echo "Posts: " . $user["num_posts"] . "<br>";
            echo "Likes: " . $user["num_likes"] . "<br>";

         ?>
    </div>

</div>

<div class="main_column column">
    <form class="post_form" action="index.php" method="post">
        <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
        <input type="submit" name="post" id="post_button" value="Post">
        <hr>
    </form>

    <?php

        $user_obj = new User($connection, $userLoggedIn);
        echo $user_obj->getFirstAndLastName();

     ?>

</div>

</div> <!-- wrapper from header.php -->


</body>
</html>
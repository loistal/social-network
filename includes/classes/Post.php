<?php

class Post{
	private $user_obj;
	private $con;

	public function __construct($con, $user) {
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	public function submitPost($body, $user_to) {
		$body = strip_tags($body);
		$body = mysqli_escape_string($this->con, $body); // escapes the single quotes so they are not mistaken for a new string in queries
		$check_empty = preg_replace("/\s+/", "", $body); // deletes spaces

		if ($check_empty != "") {
			// current date and time
			$date_added = date("Y-m-d H:i:s");
			$added_by = $this->user_obj->getFirstAndLastName();

			// if user is on own profile, user_to is none
			if ($user_to == $added_by) {
				$user_to = "none";
			}

			echo $body;

			// insert post
			$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
			$returned_id = mysqli_insert_id($this->con);

			// insert notification

			// update num posts
			$num_posts = $this->user_obj->getNumPosts();
			$num_posts++;
			$update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

		}
	}
}

?>
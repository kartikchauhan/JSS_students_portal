<?php

require_once'Core/init.php';

$user = new User;

if(Input::exists('get'))
{
	if(Input::get('blog_id'))
	{
		$blogId = Input::get('blog_id');
		$blog = new Blog;	// creating an Instance of Blog so that we could update the views
		$blog->getBlog('blogs', array('id', '=', $blogId));
		if(!$blog->count())
		{
			Redirect::to(404);
		}
		$author = DB::getInstance()->join(array('users', 'blogs'), array('id', 'users_id'), array('id', '=', $blogId))->first(); // fetching the author of the blog and his corresponding details
		$views = $blog->data()->views + 1;
		try
		{
			if($blog->update('blogs', $blogId, array('views' => $views)) != 1)	// if number of records returned are not equal to 1
				throw new Exception("Unable to update views of the blog.");
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$date=strtotime($blog->data()->created_on);
		if($user->isLoggedIn())
		{
			$userLoggedIn = true;
			$blogStatus = DB::getInstance()->getAnd('users_blogs_status', array('user_id' => $user->data()->id, 'blog_id' => $blogId));
			$blogStatusCount = $blogStatus->count();
			if($blogStatusCount)
			{
				$blogStatus = $blogStatus->first()->blog_status;
			}
		}
		else
		{
			$userLoggedIn = false;
		}
	}
	else
	{
		Redirect::to('index.php');
	}
}
else
{
	Redirect::to('index.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
	
		<link rel="preload" as="script" href="Includes/js/materialize.min.js">
    	<link rel="preload" as="script" href="https://use.fontawesome.com/819d78ad52.js">
    	<link rel="preload" as="script" href="Includes/js/jquery.min.js">
    	<link rel="preload" as="style" href="http://fonts.googleapis.com/icon?family=Material+Icons">
    	<link rel="preload" as="script" href="vendor/tinymce/tinymce/tinymce.min.js">
		<title>View Blog</title>
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="<?php echo $blog->data()->title; ?>" />
		<meta property="og:description"   content="<?php echo $blog->data()->description; ?>" />
		<meta property="og:image"         content="http://uvmbored.com/wp-content/uploads/2015/05/blog.jpg">
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="@TechWit" />
		<meta name="twitter:title" content="<?php echo $blog->data()->title; ?>" />
		<meta name="twitter:description" content="<?php echo $blog->data()->description; ?>" />
		<meta name="twitter:image:src" content="http://uvmbored.com/wp-content/uploads/2015/05/blog.jpg" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
	    <style type="text/css">
	        nav
	        {
	            border-bottom: 1px white solid;
	        }
	        .logo
	        {
	            height: auto;
	            width: 50%;
	        }
	        input[type="search"]
	        {
	  			height: 64px !important; /* or height of nav */
			}
			p
			{
				font-size: 16px;
			}
			a
			{
				cursor: pointer;
				text-decoration: none;
				color: none;
			}
			.tabs .indicator
			{
				background-color: #2196F3 !important; 
			}
			.col.s12 > .btn
			{
				width: 100%;
			}
			nav ul .dropdown-button
	        {
	            width: 200px !important;
	        }
	        div .section
	        {
	        	padding-bottom: 0rem !important;
	        }
	    </style>

	</head>
	<body>
		<?php 

			include'header.php';

		?>
		<!-- facebook SDK for sharing button -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  	var js, fjs = d.getElementsByTagName(s)[0];
		  	if (d.getElementById(id)) return;
		  	js = d.createElement(s); js.id = id;
		  	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1145090692169938";
		  	fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<script type="text/javascript">
	    	document.getElementById('nav-bar').classList.remove('transparent');
	    </script>

		<header class="blue">
			<section>
				<div class="container">
					<div class="section">
						<div class="row">
							<div class="col s10 l10">
								<h1 class="white-text thin"> <?php echo strtoupper($blog->data()->title); ?></h1>
							</div>
						</div>
						<div class="row">
							<div class="col s10">
								<h5 class="white-text thin"> <?php echo ucfirst($blog->data()->description); ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="col s10">
								<div class="row">
									<div class="col s4 l4">
										<h6 class="white-text"><?php echo date('M d, Y', $date); ?></h6>
									</div>
									<div class="col s6 offset-s2 l6 offset-l2">
										<h6 class="white-text" >Written by - <?php echo ucwords($author->name) ?></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</header>

		<article>
			<section>
				<div class="container">
					<div class="section">
						<div class="row">
							<div class="col s12 l8">
								<p class="flow-text"><?php echo $blog->data()->blog; ?></p>
								<div class="section">
									<div class="row">
										<div class="col s6 offset-s1 l5 offset-l2">
											<h6 class="center-align">Was this article helpful?</h6>
										</div>									
										<div class="_token" id="_token" data-attribute="<?php echo Token::generate(); ?>"></div>
										<?php 
											if($userLoggedIn)
											{
												if($blogStatusCount)
												{
													if($blogStatus == 1)
													{
														echo 
														"<div class='col s1'>
															<a class='likes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: green'></i></a>
														</div>
														<div class='col s1 offset-s1 m1 l1'>
															<a class='dislikes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: grey'></i></a>
														</div>";
													}
													else if($blogStatus == -1)
													{
														echo 
														"<div class='col s1'>
															<a class='likes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: grey'></i></a>
														</div>
														<div class='col s1 offset-s1 m1 l1'>
															<a class='dislikes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: red'></i></a>
														</div>";
													}
													else if($blogStatus == 0)
													{
														echo
														"<div class='col s1'>
															<a class='likes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: grey'></i></a>
														</div>
														<div class='col s1 offset-s1 m1 l1'>
															<a class='dislikes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: grey'></i></a>
														</div>";
													}
												}
												else
												{
													echo
													"<div class='col s1'>
														<a class='likes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: grey'></i></a>
													</div>
													<div class='col s1 offset-s1 m1 l1'>
														<a class='dislikes' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: grey'></i></a>
													</div>";
												}

											}
											else
											{
												echo
												"<div class='col s1'>
													<a class='likes-not-logged-in' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: grey'></i></a>
												</div>
												<div class='col s1 offset-s1 m1 l1'>
													<a class='dislikes-not-logged-in' data-attribute=".$blog->data()->id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: grey'></i></a>
												</div>";
											}
										?>
									</div>
									<div class="row">
										<div class="col s12 l10 offset-l2">
											<div class="row">
												<div class="col s12 l5">
													<div class="hide-on-med-and-up center-align">
														<h5>Share this blog</h5>
													</div>
													<div class="hide-on-small-only">
														<h5>Share this blog</h5>
													</div>
												</div>
												<div class="col s4 l2">
													<div class="g-plus" data-action="share" data-annotation="none" data-height="30" data-href="<?php echo Config::get('url/current_url'); ?>"></div>
												</div>
												<div class="col s4 l2">
													<a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="Check Out this blog" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
												</div>
												<div class="col s4 l2">
													<div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">	
					<h5>Comments</h5>
					<div class="row">
						<div class="col s12 l8">
						<?php

							if($userLoggedIn)
							{
								echo
								"<form acion='' method='post'>
									<label for='comment'>Add a Comment</label>
									<div class='section'>
										<textarea class='materialize-textarea' id='comment' name='comment' data-attribute='".$blogId."'></textarea>
									</div>
									<div class='row'>
										<div class='col s12 l6'>
											<button type='button' class='btn waves-effect waves-light blue' name='send_comment' id='send_comment'>Post your comment</button>
										</div>
									</div>
								</form>";
							}
							else
							{

								echo
								"<div class='center-align'>
									<h6><a href='login.php' class='login-to-comment'>Login</a> to post a comment</h6>
								</div>";
							}

						?>
						</div>
					</div>
					<div class="row">
				    	<div class="col s12 l8">
				      		<ul class="tabs">
				        		<li class="tab col s6 l4"><a href="" class='active blue-text popular_comments' id="popular_comments" data-attribute="<?php echo $blogId; ?>">Popular Comments</a></li>
				        		<li class="tab col s6 l4"><a href="" class='blue-text new_comments' id="new_comments" data-attribute="<?php echo $blogId; ?>">New Comments</a></li>
				    	  	</ul>
				    	</div>
				  	</div>
					<div class="row">
						<div class="col s12 l8">
							<div class="comment-section" id="comment-section">
								<?php
								// getting all the comments posted on the current blog in DESCENDING order
								$comments = DB::getInstance()->joinSortComments(array('users', 'comments', 'blogs'), array('id', 'user_id', 'id', 'blog_id'), array('likes', 'DESC'), array('id', '=', $blogId), array('id', 'comment_id', 'created_on', 'comment_created_on', 'likes', 'comment_likes', 'dislikes', 'comment_dislikes'));

								// if there's any comment on the current blog, show it otherwise print no comments
								if($comments->count())
								{
									$comments = $comments->results();
									$counter = 1;	// initiating counter, later used for designing
									if($userLoggedIn)	// if user is logged in, enable the functionality of voting
									{
										foreach($comments as $comment)
										{
											$commentStatus = DB::getInstance()->getAnd('users_comments_status', array('user_id' => $user->data()->id, 'comment_id' => $comment->comment_id));
											$commentStatusCount = $commentStatus->count();
											if($commentStatusCount)
											{
												$commentStatus = $commentStatus->first()->comment_status;
											}
											$date = strtotime($comment->comment_created_on);
											if($counter%2)	// if counter%2 != 0, not adding offset-s1 class to the div
											{
												echo
													"<div class='row deletable-comments' data-attribute=".$comment->comment_id.">
														<div class='col s11 blue z-depth-2'>
															<div class='white-text'>"
																.$comment->comment.
															"</div>
															<div class='divider'></div>
															<div class='section white-text'>
																<div class='row white-text'>
																	<div class='col s2 l4'>
																		<img class='responsive-img materialboxed' style='height:50px' width='50px' src='".Config::get('url/upload_dir').'/'.$comment->image_url."'>".$comment->username."
																	</div>													
																	<div class='col s5 offset-s1 l4'>
																		<div class='row'>";
																			if($commentStatusCount)
																			{
																				if($commentStatus == 1)
																				{
																					echo 
																					"<div class='col s3'>
																						<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: green'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																					</div>
																					<div class='col s3'>
																						<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																					</div>";
																				}
																				else if($commentStatus == -1)
																				{
																					echo 
																					"<div class='col s3'>
																						<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																					</div>
																					<div class='col s3'>
																						<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: red'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																					</div>";
																				}
																				else if($commentStatus == 0)
																				{
																					echo
																					"<div class='col s3'>
																						<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																					</div>
																					<div class='col s3'>
																						<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																					</div>";
																				}
																			}
																			else
																			{
																				echo
																				"<div class='col s3'>
																					<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																				</div>
																				<div class='col s3'>
																					<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																				</div>
																				<div class='col s3'>
																					<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																				</div>
																				<div class='col s3'>
																					<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																				</div>";
																			}
																		echo
																		"</div>
																	</div>
																	<div class='col s3 offset-s1'>
																		<div class='row'>
																			<div class='col s12'>"
																				.date('M d Y', $date).
																			"</div>
																		</div>";
																		if($user->data()->id === $comment->user_id)
																		{
																			echo
																			"<div class='row'>
																				<div class='col s2 push-s4'>
																					<a class='delete-comment'><i class='fa fa-trash fa-2x' aria-hidden='true' style='color: white'></i></a>
																				</div>
																			</div>";
																		}
																	echo
																	"</div>
																</div>
															</div>
														</div>
													</div>";
											}
											else    // if counter%2 == 0, adding offset-s1 class to the div, to make zig-zag pattern
											{
												echo
													"<div class='row deletable-comments' data-attribute=".$comment->comment_id.">
														<div class='col s11 blue offset-s1 z-depth-2'>
															<div class='white-text'>"
																.$comment->comment.
															"</div>
															<div class='divider'></div>
															<div class='section white-text'>
																<div class='row white-text'>
																	<div class='col s2 l4'>
																		<img class='responsive-img materialboxed' style='height: 50px' width='50px' src='".Config::get('url/upload_dir').'/'.$comment->image_url."'>".$comment->username."
																	</div>													
																	<div class='col s5 offset-s1 l4'>
																		<div class='row'>";
																			if($commentStatusCount)
																			{
																				if($commentStatus == 1)
																				{
																					echo 
																					"<div class='col s3'>
																						<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: green'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																					</div>
																					<div class='col s3'>
																						<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																					</div>";
																				}
																				else if($commentStatus == -1)
																				{
																					echo 
																					"<div class='col s3'>
																						<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																					</div>
																					<div class='col s3'>
																						<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: red'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																					</div>";
																				}
																				else if($commentStatus == 0)
																				{
																					echo
																					"<div class='col s3'>
																						<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																					</div>
																					<div class='col s3'>
																						<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																					</div>
																					<div class='col s3'>
																						<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																					</div>";
																				}
																			}
																			else
																			{
																				echo
																				"<div class='col s3'>
																					<a class='comment-like' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																				</div>
																				<div class='col s3'>
																					<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																				</div>
																				<div class='col s3'>
																					<a class='comment-dislike' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																				</div>
																				<div class='col s3'>
																					<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																				</div>";
																			}
																		echo
																		"</div>
																	</div>
																	<div class='col s3 offset-s1'>
																		<div class='row'>
																			<div class='col s12'>"
																				.date('M d Y', $date).
																			"</div>
																		</div>";
																		if($user->data()->id === $comment->user_id)
																		{
																			echo
																			"<div class='row'>
																				<div class='col s2 push-s4'>
																					<a class='delete-comment'><i class='fa fa-trash fa-2x' aria-hidden='true' style='color: white'></i></a>
																				</div>
																			</div>";
																		}
																	echo
																	"</div>
																</div>
															</div>
														</div>
													</div>";
											}
											++$counter;
										}
									}
									else    // if user is not logged in, disable the functionality of voting, giving response "You need to log in to vote" through JS
									{
										foreach($comments as $comment)
										{
											$date = strtotime($comment->comment_created_on);	// fetching date of comments to converting them into suitable format
											if($counter%2)
											{
												echo
													"<div class='row' data-attribute=".$comment->comment_id.">
														<div class='col s11 blue z-depth-2'>
															<div class='white-text'>"
																.$comment->comment.
															"</div>
															<div class='divider'></div>
															<div class='section white-text'>
																<div class='row white-text'>
																	<div class='col s2 l4'>
																		<img class='responsive-img materialboxed' style='height: 50px' width='50px' src='".Config::get('url/upload_dir').'/'.$comment->image_url."'>".$comment->username."
																	</div>													
																	<div class='col s5 offset-s1 l4'>
																		<div class='row'>
																			<div class='col s3'>
																				<a class='comment-like-not-logged-in' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																			</div>
																			<div class='col s3'>
																				<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																			</div>
																			<div class='col s3'>
																				<a class='comment-dislike-not-logged-in' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																			</div>
																			<div class='col s3'>
																				<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																			</div>
																		</div>
																	</div>
																	<div class='col s3 offset-s1'>"
																		.date('M d Y', $date).
																	"</div>
																</div>
															</div>
														</div>
													</div>";
											}
											else
											{
												echo
													"<div class='row' data-attribute=".$comment->comment_id.">
														<div class='col s11 blue offset-s1 z-depth-2'>
															<div class='white-text'>"
																.$comment->comment.
															"</div>
															<div class='divider'></div>
															<div class='section white-text'>
																<div class='row white-text'>
																	<div class='col s2 l4'>
																		<img class='responsive-img materialboxed' style='height: 50px' width='50px' src='".Config::get('url/upload_dir').'/'.$comment->image_url."'>".$comment->username."
																	</div>													
																	<div class='col s5 offset-s1 l4'>
																		<div class='row'>
																			<div class='col s3'>
																				<a class='comment-like-not-logged-in' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color: white'></i></a>
																			</div>
																			<div class='col s3'>
																				<div class='white-text comment-count-likes'>".$comment->comment_likes."</div>
																			</div>
																			<div class='col s3'>
																				<a class='comment-dislike-not-logged-in' data-attribute=".$comment->comment_id."><i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color: white'></i></a>
																			</div>
																			<div class='col s3'>
																		  		<div class='white-text comment-count-dislikes'>".$comment->comment_dislikes."</div>
																			</div>
																		</div>
																	</div>
																	<div class='col s3 offset-s1'>"
																		.date('M d Y', $date).
																	"</div>
																</div>
															</div>
														</div>
													</div>";
											}
											++$counter;
										}
									}
								}
								else
								{
									echo
									"<div class='center-align no_comment'>No comments</div>";
								}

								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</article>
		<!-- Place the tag where you want the button to render -->
<!-- <div class="g-plus" data-action="share" data-annotation="none" data-height="24" data-href="http://localhost/Blog_temp2/view_blog.php"></div> -->

		<footer class="page-footer blue lighten-1">
			<div class="container">
				<div class="row">
					<div class="col s8 offset-s2 l5">
						<div class="row">
							<div class="col s12 l8">
								<img class="materialboxed responsive-img z-depth-2" style="height: 200px" data-caption="<?php echo ucwords($author->name); ?>" src="<?php echo Config::get('url/upload_dir').'/'.$author->image_url?>"> <!-- <?php //echo Config::get('url/upload_dir').'/'.$user->data()->image_url ?> -->
							</div>
						</div>
						<div class="row hide-on-small-only">
							<div class="col s1 l1 offset-s1 offset-l2">
								<a href="https://www.github.com/<?php echo $author->github_username; ?>" target="_blank"><i class="fa fa-github-square fa-3x" aria-hidden="true" style="color:white"></i></a> 	<!-- author's github url -->
							</div>
							<div class="col s1 l1 offset-s1 offset-l1">
								<a href="https://www.facebook.com/<?php echo $author->facebook_username; ?>" target="_blank"><i class="fa fa-facebook-square fa-3x" aria-hidden="true" style="color:white"></i></a>	<!-- author's facebook url -->
							</div>
						</div>
					</div>
					<div class="col s12 l7">
						<div class="row">
							<div class="col l12 hide-on-small-only">
								<h5 class="white-text center-align">Writer's Info</h5>
							</div>
						</div>
						<div class="row">
							<div class="col s8 offset-s2 l12 center-align">
								<h5 class="white-text"><?php echo ucwords($author->name); ?></h5>	<!-- author's name of the blog -->
							</div>
						</div>
						<div class="row">
							<div class="col s12 l12">
								<p class="white-text"><?php echo ucfirst($author->user_description); ?></p>	
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<h6 class="white-text">Email: <?php echo $author->email; ?></h6>
							</div>
						</div>
						<?php
							if($author->twitter_username !== '')
							{
								echo
								"<div class='row'>
									<div class='col s6'>
										<a class='twitter-follow-button' href='https://twitter.com/".$author->twitter_username."' data-size='large'> Follow @".$author->twitter_username."</a>
									</div>
								</div>";
							}
						?>
						<div class="row hide-on-med-and-up">
							<div class="col s2 offset-s4">
								<a href="https://www.github.com/<?php echo $author->github_username; ?>" target="_blank"><i class="fa fa-github-square fa-3x" aria-hidden="true" style="color:black"></i></a> 	<!-- author's github url -->
							</div>
							<div class="col s2">
								<a href="https://www.facebook.com/<?php echo $author->facebook_username; ?>" target="_blank"><i class="fa fa-facebook-square fa-3x" aria-hidden="true" style="color:black"></i></a>	<!-- author's facebook url -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				<div class="container center-align">
					© 2017 Software Incubator
				</div>
			</div>
		</footer>

		<script src="Includes/js/jquery.min.js"></script>
	    <script src="https://use.fontawesome.com/819d78ad52.js"></script>
	    <script type="text/javascript" src="Includes/js/materialize.min.js"></script>
	    <script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
	    <script src="https://apis.google.com/js/platform.js" async defer></script>
	    <script>
	    	if(typeof(Storage) !== "undefined")
	        {
	            if(sessionStorage.getItem("flashMessage") !== null)
	            {
	                Materialize.toast(sessionStorage.getItem("flashMessage"), 5000 ,'green');
	                sessionStorage.removeItem('flashMessage');
	            }
	        }
	    	$(document).ready(function(){
	    		// $('.nav-bar').removeClass('transparent');

	    		$(".button-collapse").sideNav();
	    		
	    			tinymce.init({
	                    selector: '#comment',
	                    height: 100,
	                    theme: 'modern',
	                    plugins: [
	                      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	                      'searchreplace wordcount visualblocks visualchars code fullscreen',
	                      'insertdatetime media nonbreaking save table contextmenu directionality',
	                      'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
	                    ],
	                    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	                    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
	                    image_advtab: true,
	                    templates: [
	                      { title: 'Test template 1', content: 'Test 1' },
	                      { title: 'Test template 2', content: 'Test 2' }
	                    ],
	                    content_css: [
	                      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	                      '//www.tinymce.com/css/codepen.min.css'
	                    ]
	                });

	    		$('.likes-not-logged-in, .dislikes-not-logged-in').click(function(e){	// if user is not logged in, restrict him from voting
	    			e.preventDefault();
	    			Materialize.toast("You need to login to vote", 5000, "red");
	    		});

	    		// $('.delete-comment').click(function(e) {
	    			$('.comment-section').on('click', '.delete-comment', function(e) {
	    			e.preventDefault();
	    			var user_response = confirm("Are you sure you want to delete this blog?");
					if(user_response == true)
					{
						var object = $(this);
						console.log(object);
		    			var comment_id = $(this).parents('.deletable-comments').attr('data-attribute');
		    			console.log(comment_id);
		    			$.ajax({
		    				type: 'POST',
		    				url: 'delete_comment.php',
		    				data: {comment_id: comment_id},
		    				dataType: "json",
		    				cache: false,
		    				success: function(response)
		    				{
		    					console.log(response);
		    					if(response.error_status)
		    					{
		    						console.log(response.error);
		    						Materialize.toast(response.error, 5000, "red");
		    					}
		    					else
		    					{
		    						object.parents('.deletable-comments').remove();
		    					}
		    				}
		    			});
	    			}
	    			else
	    			{
	    				return true;
	    			}

	    		});

	    		$('.likes, .dislikes').click(function(e){
	                e.preventDefault();
	                var object = $(this);
	                
	                var blog_id = $(this).attr('data-attribute');
	                // var _token = $('#_token').attr('data-attribute');
	                var className = getClassName(this);

	                $.ajax({
	                    type: 'POST',
	                    url: 'blog_attributes.php',
	                    data: {blog_id: blog_id, field: className},
	                    dataType: "json",
	                    cache: false,
	                    success: function(response)
	                    {
	                        // var response = JSON.parse(response);
	                        console.log(response);
	                        // $('#_token').attr('data-attribute', response._token);
	                        if(response.error_status)
	                        {
	                            console.log(response.error);
	                            Materialize.toast(response.error, 5000, 'red');
	                            // return false;
	                        }
	                        else
	                        {
	                            if(response.blog_status == 1)
	                            {
	                            	$('.likes').find('i').css('color', 'green');
	                            	$('.dislikes').find('i').css('color', 'grey');
	                            }
	                            else if(response.blog_status == -1)
	                            {
	                            	$('.dislikes').find('i').css('color', 'red');
	                            	$('.likes').find('i').css('color', 'grey');
	                            }
	                            else
	                            {
	                            	$('.likes').find('i').css('color', 'grey');
	                            	$('.dislikes').find('i').css('color', 'grey');
	                            }
	                        }
	                    }
	                });
	            });

				$('.comment-like-not-logged-in, .comment-dislike-not-logged-in').click(function(e){	// if user is not logged in, restrict him from voting
	    			e.preventDefault();
	    			Materialize.toast("You need to login to vote", 5000, "red");
	    		});

				$('.comment-section').on('click', '.comment-like, .comment-dislike', function(e){	// request server to check if the request is valid, if valid add the user's reponse
	                e.preventDefault();
	                var object = $(this);	// anchor tag, user just clicked
	                
	                var comment_id = $(this).attr('data-attribute');	// comment_id of the comment, user wants to vote
	                // var _token = $('#_token').attr('data-attribute');
	                var className = getClassName(this);		// checking if user clicked on comment-like or comment-dislike
	                console.log('like or dislike button got clicked');

	                $.ajax({
	                    type: 'POST',
	                    url: 'comment_attributes.php',
	                    data: {comment_id: comment_id, field: className},
	                    dataType: "json",
	                    cache: false,
	                    success: function(response)
	                    {
	                        // var response = JSON.parse(response);
	                        console.log(response);
	                        console.log(response.error_status);
	                        console.log(response.comment_status);
	                        // $('#_token').attr('data-attribute', response._token);
	                        if(response.error_status)
	                        {
	                            console.log(response.error);
	                            Materialize.toast(response.error, 5000, 'red');
	                            // return false;
	                        }
	                        else
	                        {
	                            if(response.comment_status == 1)
	                            {
	                            	$(object).parent().parent().find('.comment-like').find('i').css('color', 'green');	// changing the color of the icons according to the received response
	                            	$(object).parent().parent().find('.comment-dislike').find('i').css('color', 'white');
	                            	$(object).parent().parent().find('.comment-count-likes').html(response.count_likes);	// changing the counts of likes and dislikes of a comment according to the received response
	                            	$(object).parent().parent().find('.comment-count-dislikes').html(response.count_dislikes);
	                            }
	                            else if(response.comment_status == -1)
	                            {
	                            	$(object).parent().parent().find('.comment-like').find('i').css('color', 'white');
	                            	$(object).parent().parent().find('.comment-dislike').find('i').css('color', 'red');
	                            	$(object).parent().parent().find('.comment-count-likes').html(response.count_likes);
	                            	$(object).parent().parent().find('.comment-count-dislikes').html(response.count_dislikes);
	                            }
	                            else if(response.comment_status == 0)
	                            {
	                            	$(object).parent().parent().find('.comment-like').find('i').css('color', 'white');
	                            	$(object).parent().parent().find('.comment-dislike').find('i').css('color', 'white');
	                            	$(object).parent().parent().find('.comment-count-likes').html(response.count_likes);
	                            	$(object).parent().parent().find('.comment-count-dislikes').html(response.count_dislikes);
	                            }
	                        }
	                    }
	                });
	            });			

				$('#send_comment').on('click', function(){
					var blog_id = $('#comment').attr('data-attribute');
					var comment = tinyMCE.activeEditor.getContent();
					var _token = $('#_token').attr('data-attribute');
					$.ajax({
						type: 'POST',
						url: 'send_comment.php',
						data: {blog_id: blog_id, comment: comment, _token: _token},
						dataType: "json",
						success: function(response)
						{
							// var response = JSON.parse(response);
							console.log(response);
							$('#_token').attr('data-attribute', response._token);
							if(response.error_status === false)
							{
								$('#_token').attr('data-attribute', response._token);
								$('.no_comment').remove();
								$('.comment-section').prepend(response.content);
								// Materialize.toast('Your comment has been added successfully', 5000, 'green');
							}
							else
							{
								if(response.error_code != 1)
				        		{
				        			$('#_token').attr('data-attribute', response._token);
				        		}
								Materialize.toast(response.error, 5000, "red");
							}
						}

					});
				});

				$('.popular_comments').on('click', function(e){
					e.preventDefault();
					var className = "popular_comments";
					// var _token = $('#_token').attr('data-attribute');
					var blog_id = $(this).attr('data-attribute');
					$.ajax({
						url: 'sort_comments.php',
						data: {blog_id: blog_id, field: className},
						dataType: "json",
						type: 'POST',
						// datatype : "application/json; charset=utf-8",
						// contentType: "html",
						success: function(response)
						{
							// var response = JSON.parse(response);
							// $('#_token').attr('data-attribute', response._token);
							console.log(response);
							$('.comment-section').html(response.content);
						}
					});
				});

				$('.new_comments').on('click', function(e){
					e.preventDefault();
					var className = 'new_comments';
					// var _token = $('#_token').attr('data-attribute');
					var blog_id = $(this).attr('data-attribute');
					$.ajax({
						type: 'POST',
						url: 'sort_comments.php',
						data: {blog_id: blog_id, field: className},
						dataType: "json",
						// datatype : "application/json; charset=utf-8",
						// contentType: "html",
						// processData: false,
						success: function(response)
						{
							// var response = JSON.parse(response);
							// $('#_token').attr('data-attribute', response._token);
							console.log(response);
							$('.comment-section').html(response.content);
						}
					});
				});

				$('.login-to-comment').on('click', function(e){
					e.preventDefault();
					if(typeof(Storage) !== "undefined")
					{
						sessionStorage.setItem('Redirect', document.URL);
						window.location = 'login.php';
					}

				});

				function getClassName(object)
	            {
	                var className = $(object).attr('class');
	                if(className === 'likes')
	                {
	                    className = 'likes';
	                }
	                else if(className === 'dislikes')
	                {
	                    className = 'dislikes';
	                }
	                else if(className === 'popular_comments')
	                {
	                	className = 'popular_comments';
	                }
	                else if(className === 'new_comments')
	                {
	                	className = 'new_comments';
	                }
	                return className;
	            }
	    	

	    	});
	    </script>
	</body>
</html>
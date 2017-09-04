<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','kubrick'); ?></p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->
<?php
/*Get option*/
global $gcb_option;
$date_format = $gcb_option['comment-date-format'];
?>


<?php if ($comments) : ?>
<div id="comments">

<?php foreach ($comments as $comment) : ?>

<div class="main-comment">
<div class="well com-text <?php 
global $post;
if( ($comment->user_id === $post->post_author) || (1 == $comment->user_id) ) {
   echo "bg-admin-comment";
} ?>">

<?php //echo get_avatar( $comment, 45 ); ?>

<b>
<?php
if( ($comment->user_id === $post->post_author) || (1 == $comment->user_id) ) {
    $user=get_userdata($comment->user_id);
    echo '<i class="fa fa-user"></i> '.$user->nickname;
}
else {
	
	$comment = get_comment( $comment_ID );
    $author  = get_comment_author( $comment );
	
    echo '<i class="fa fa-drivers-license-o"></i> '.$author;
}
?>
 : <?php //_e('&#1711;&#1601;&#1578;&#1607; :','kubrick'); ?></b>
<?php if ($comment->comment_approved == '0') : ?>
<em><?php _e('&#1606;&#1592;&#1585; &#1605;&#1606;&#1578;&#1592;&#1585; &#1578;&#1575;&#1610;&#1610;&#1583; &#1605;&#1610; &#1576;&#1575;&#1588;&#1583;','kubrick'); ?></em>
			<?php endif; ?>

<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""></a> <span class="date-comment"> <?php per_number(comment_date(__($date_format,'kubrick'))) ?> </span><?php //_e(' &#1583;&#1585; ','kubrick'); ?> <?php //comment_time() ?> <?php edit_comment_link(__('&#1608;&#1610;&#1585;&#1575;&#1610;&#1588;','kubrick'),'&nbsp;&nbsp;',''); ?></small>

<?php 
if( ($comment->user_id === $post->post_author) || (1 == $comment->user_id) ) {
   echo "<span class='admin-comment-text'>";
} ?>

<?php comment_text() ?>

<?php 
if( ($comment->user_id === $post->post_author) || (1 == $comment->user_id) ) {
   echo "</span>";
} ?>

</div>




</div>


	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
	?>

	<?php endforeach; /* end for each comment */ ?>
</div>
<div style="margin-bottom:15px;"></div>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">__(Comments are closed.,'kubrick')</p>

	<?php endif; ?>
<?php endif; ?>

<style>


</style>



<?php if ('open' == $post->comment_status) : ?>

<div class="title-center" style="margin-top:0px;">

</div>
<div class="main-post">

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be','kubrick'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in','kubrick'); ?></a> <?php _e('to post a comment.','kubrick'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" autocomplete="off" style="margin-top:20px;">

<?php if ( $user_ID ) : ?>

<p><?php _e('&#1608;&#1585;&#1608;&#1583; &#1576;&#1575; &#1606;&#1575;&#1605; ','kubrick'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('&#1582;&#1585;&#1608;&#1580; &#1575;&#1586; &#1575;&#1705;&#1575;&#1606;&#1578;','kubrick'); ?>"><?php _e('&#1582;&#1585;&#1608;&#1580;','kubrick'); ?> &raquo;</a></p>

<?php else : ?>






<table>

<tr>
<td width="110">نام و نام خانوادگی</td>
<td>
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" class="" placeholder="نام و نام خانوادگی" dir="rtl" />
</td>
</tr>


<tr><td></td><td></td></tr>

<tr>
<td width="110">پست الکترونیک</td>
<td>
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" class="ltr-input" placeholder="Email@example.com" style="direction:ltr;" />
</td></tr>

<tr><td></td><td></td></tr>

<!--<tr><td width="110">وب سایت</td><td>

<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" placeholder="http://www.your-site.com" class="ltr-input" style="direction:ltr;" />
</td></tr>

<tr><td></td><td></td></tr>-->



<tr><td width="110">کد امنیتی</td><td>
<?php do_action('comment_form', $post->ID); ?>
</td></tr>



<tr><td></td><td></td></tr>



</table>




<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:','kubrick'); ?> <code><?php echo allowed_tags(); ?></code></small></p>-->


<textarea name="comment" style="width: 100%; height: 150px; padding:6px; margin-top:15px;"   rows="1"  tabindex="4" placeholder="متن پیام ..."></textarea>
<input class="btn" name="submit" type="submit" value="<?php _e('&#1575;&#1585;&#1587;&#1575;&#1604; &#1583;&#1740;&#1583;&#1711;&#1575;&#1607;','dnld'); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</form>

</div>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>

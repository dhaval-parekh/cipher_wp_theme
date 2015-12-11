</div> <!-- / main container --> 

<!-- Footer
	================================================== --> 

<!-- Change to class="container footerwrap full" for a full-width footer -->
<div class="container footerwrap">
	<div class="footer">
		<div class="sixteen columns footer-widget">
			<?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('footer-widgets'); } ?>
			<!--<div class="four columns widget alpha">
				<h5>Latest Projects</h5>
				<div class="widget_portfolio">
					<ul>
						<li class="clearfix"><a href="#" class="borderhover"><img src="images/thumbs/pop_folio1.jpg" alt="" /></a></li>
						<li class="clearfix"><a href="#" class="borderhover"><img src="images/thumbs/pop_folio2.jpg" alt="" /></a></li>
						<li class="clearfix"><a href="#" class="borderhover"><img src="images/thumbs/pop_folio3.jpg" alt="" /></a></li>
						<li class="clearfix"><a href="#" class="borderhover"><img src="images/thumbs/pop_folio4.jpg" alt="" /></a></li>
						<li class="clearfix"><a href="#" class="borderhover"><img src="images/thumbs/pop_folio5.jpg" alt="" /></a></li>
						<li class="clearfix"><a href="#" class="borderhover"><img src="images/thumbs/pop_folio6.jpg" alt="" /></a></li>
					</ul>
				</div>
			</div>
			<div class="four columns cleafix widget">
				<h5>Twitter Feed</h5>
				With the Twitter API 1.1 you need to go <a href="https://twitter.com/settings/widgets" target="_blank">here</a> to create a twitter widget.<br/>
				Paste the generated code here! 
			</div>
			<div class="four columns widget">
				<h5>Popular Blog Posts</h5>
				<div class="widget_blogposts">
					<ul>
						<li class="clearfix"> <a href="#" class="borderhover"><img src="images/thumbs/pop_blog1.jpg" alt="" /></a>
							<div class="postlink"><a href="#">Pretty Widgets</a></div>
							<div class="subline">January 23, 2012</div>
						</li>
						<li class="clearfix"> <a href="#" class="borderhover"><img src="images/thumbs/pop_blog2.jpg" alt="" /></a>
							<div class="postlink"><a href="#">Convenient Structure</a></div>
							<div class="subline">January 21, 2012</div>
						</li>
						<li class="clearfix"> <a href="#" class="borderhover"><img src="images/thumbs/pop_blog3.jpg" alt="" /></a>
							<div class="postlink"><a href="#">Another Blog Post</a></div>
							<div class="subline">January 17, 2012</div>
						</li>
						<li class="clearfix"> <a href="#" class="borderhover"><img src="images/thumbs/pop_blog4.jpg" alt="" /></a>
							<div class="postlink"><a href="#">Responsive Layout</a></div>
							<div class="subline">January 3, 2012</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="four columns widget omega">
				<h5>Quick Contact</h5>
				<div>
					<form id="quickcontact" method="post" action="#">
						<input type="text" name="name" id="quickcontact_name" class="requiredfield" onFocus="if(this.value == 'Name *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Name *'; }" value='Name *'/>
						<input type="text" name="email" id="quickcontact_email" class="requiredfield" onFocus="if(this.value == 'Email *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Email *'; }" value='Email *'/>
						<textarea name="message" id="quickcontact_message" class="requiredfield" onFocus="if(this.value == 'Message *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Message *'; }">Message *</textarea>
						<button type="submit" name="send">Send</button>
						<span class="errormessage">Error! Please correct marked fields.</span> <span class="successmessage">Message send successfully!</span> <span class="sendingmessage">Sending...</span>
					</form>
				</div>
			</div>-->
			<div class="clear"></div>
		</div>
	</div>
</div>
<!-- container --> 


<!-- Sub-Footer ================================================== --> 
<!-- Change to class="container subfooterwrap full" for a full-width subfooter -->
<div class="container subfooterwrap">
	<div class="subfooter">
		<div class="eight columns">© 2015 Apex Responsive Portfolio Template</div>
		<div class="eight columns">
			<ul class="socialicons">
				<li><a href="#" class="social_facebook"></a></li>
				<li><a href="#" class="social_twitter"></a></li>
				<li><a href="#" class="social_googleplus"></a></li>
				<li><a href="#" class="social_vimeo"></a></li>
				<li><a href="#" class="social_rss"></a></li>
			</ul>
			<div class="socialtext">Stay in Touch via Social Networks.</div>
		</div>
	</div>
</div>
<div>
	<?php wp_footer(); ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/app.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.animate-colors-min.js"></script>
	<!--/***********************************************
		* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
	***********************************************/-->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ddsmoothmenu.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cssAnimate.mini.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.fitvids.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider-min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/screen.js"></script>
</div>
</body>

</html>
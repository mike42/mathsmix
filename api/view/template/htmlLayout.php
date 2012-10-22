<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en-US"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html
	class=" js no-flexbox canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"
	lang="en-US">
<!--<![endif]-->
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" id="responsive-style-css" href="style/style.css"	type="text/css" media="all">
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="style/js/responsive-modernizr.js"></script>
	
	<title>MathsMix</title>
</head>

<body class="home blog">
	<div id="container" class="hfeed">
		<div id="header">
			<div id="logo">
				<a href="<?php echo core::constructURL('page', 'view', array('home'), 'html'); ?>"><img
					src="style/images/default-logo.png" alt="MathsMix home"
					height="100" width="300"></a>
			</div>
			<!-- end of #logo -->

			<ul class="menu l_tinynav1">
				<li><a href="<?php echo core::constructURL('page', 'view', array('home'), 'html'); ?>"
					title="Home">Home</a></li>
				<li><a
					href="<?php echo core::constructURL('user', 'login', array(''), 'html'); ?>">Log in</a></li>
				<li><a
					href="<?php echo core::constructURL('page', 'view', array('about'), 'html'); ?>">About</a>
					<ul class="children">
						<li class="page_item page-item-49"><a
							href="<?php echo core::constructURL('page', 'view', array('signup'), 'html'); ?>">Sign up</a></li>
							<li class="page_item page-item-49"><a
							href="<?php echo core::constructURL('page', 'view', array('privacy'), 'html'); ?>">Privacy policy</a></li>
							<li class="page_item page-item-49"><a
							href="<?php echo core::constructURL('page', 'view', array('contact'), 'html'); ?>">Contact</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- end of #header -->

		<div id="wrapper" class="clearfix">
<?php include(dirname(__FILE__)."/$template.inc"); ?>
		</div>
		<!-- end of #wrapper -->
	</div>
	<!-- end of #container -->

	<div id="footer" class="clearfix">

		<div id="footer-wrapper">

			<div class="grid col-940">

				<div class="grid col-540"></div>
				<!-- end of col-540 -->

				<div class="grid col-380 fit">
					<ul class="social-icons"></ul>
					<!-- end of .social-icons -->
				</div>
				<!-- end of col-380 fit -->

			</div>
			<!-- end of col-940 -->

			<div class="grid col-300 copyright">
				MathsMix is operated by <a href="http://bitrevision.com/">bitrevision</a>
			</div>
			<!-- end of .copyright -->

			<div class="grid col-300 scroll-top">
				<a href="#scroll-top" title="scroll to top">↑</a>
			</div>

			<div class="grid col-300 fit powered">
				Privacy Policy | Contact
			</div>
			<!-- end .powered -->

		</div>
		<!-- end #footer-wrapper -->

	</div>
	<!-- end #footer -->

	<script type="text/javascript" src="style/js/responsive-scripts.js"></script>
	<script type="text/javascript" src="style/js/responsive-plugins.js"></script>

</body>
</html>
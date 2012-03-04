<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>AWESOME IT :: <?php echo $page['title']; ?></title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/theme/css/awesome.css">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/uploads/icon.ico" />
  <meta name="description" content="<?php echo $page['description']; ?>">

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-28967500-1']);
    _gaq.push(['_trackPageview']);

    (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  				  })();
  
  </script>
</head>
<body>
<div class='container'>
<div id='header'>
  <h1 id='title'><a href='<?php echo BASE_URL; ?>'>A.W.E.S.O.M.E I.T 2012</a></h1>
  <div id="slideshow">
    <img src="<?php echo BASE_URL;?>/uploads/awesomeit.png" alt="AWESOME IT 2012: The Future Edition" class="active" />
    <img src="<?php echo BASE_URL;?>/uploads/slide1.png" alt="Ben Kr&#246;se - Future Home Care" />
    <img src="<?php echo BASE_URL;?>/uploads/slide2.png" alt="Kevin Warwick - Cybernetics" />
    <img src="<?php echo BASE_URL;?>/uploads/slide3.png" alt="Jacobijn Sandberg - Mobile Learning" />
    <img src="<?php echo BASE_URL;?>/uploads/slide5.png" alt="Theo Gevers - Interactive Advertising" />
    <img src="<?php echo BASE_URL;?>/uploads/slide6.png" alt="Augmented Reality" />
    <img src="<?php echo BASE_URL;?>/uploads/slide7.png" alt="Rejo Zenger - Network Neutrality" />
    <img src="<?php echo BASE_URL;?>/uploads/slide8.png" alt="Dariu Gavrilla - Autonomous Cars" />
  </div><!-- slideshow -->
</div> <!-- header -->
<div id='menu'>
  <?php include('menu.php'); ?>
</div><!-- menu -->
<div id='content'>

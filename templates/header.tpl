<?php


/**
 * Standard header file for the site
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      27 December 2012
 */


/**
 * Define the global nav
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      27 December 2012
 */
$globalNav = array(
    '/' => 'Home',
    'events' => 'Events',
    'padiving' => 'Central PA Diving',
    'about' => 'About',
    'contact' => 'Contact',
);

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title?> :: Blue Lion Divers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="State College-based SCUBA club of divers interested in going diving">
    <meta name="author" content="Paul Rentschler">

    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/common.css" rel="stylesheet" media="screen">
    <link href="/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link href="/css/responsive.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <?php if (isset($body_attributes)) { ?>
    <body <?php echo $body_attributes?>>
  <?php } else { ?>
    <body>
  <?php } ?>
    <?php if ($_SERVER['HTTP_HOST'] == 'blueliondivers.com') { ?>
      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-322602-13', 'blueliondivers.com');
        ga('send', 'pageview');
      </script>
    <?php } ?>
    <div class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">Blue Lion Divers</a>
          <a class="btn btn-navbar" data-toggle="collapse"
             data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <?php foreach ($globalNav as $url => $label) { ?>
                <?php if ($url == $page_active_url) { ?>
                  <li class="active">
                <?php } else { ?>
                  <li>
                <?php } ?>
                  <?php $url = ((substr($url, 0, 1) == '/') ? $url : '/'.$url) ?>
                  <a href="<?php echo $url?>"><?php echo $label?></a>
                </li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


    <div class="container" id="container">

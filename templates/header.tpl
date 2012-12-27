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
    'index.php' => 'Home',
    'events.php' => 'Events',
    'contact.php' => 'Contact',
);

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title?> :: Blue Lion SCUBA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="State College-based SCUBA club not affiliated with Penn State">
    <meta name="author" content="Paul Rentschler">
    
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link href="css/common.css" rel="stylesheet" media="screen">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="index.php">Blue Lion SCUBA</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <?php foreach ($globalNav as $url => $label) { ?>
                <?php if ($url == $page_active_url) { ?>
                  <li class="active">
                <?php } else { ?>
                  <li>
                <?php } ?>
                  <a href="<?php echo $url?>"><?php echo $label?></a>
                </li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    
    <div class="container">

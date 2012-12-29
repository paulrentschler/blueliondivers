<h1><?php echo $page_title?></h1>
<p class="lead">
  We want to hear from you. Please fill out the form below and someone
  will get back to you just as soon as possible.
</p>

<?php echo $page->displayUserMessages()?>

<form action="contact.php" method="post">
  <input type="hidden" name="submitted" value="ok">
  
  <ul class="unstyled">
    <?php foreach ($page->widgets as $index => $widget) { ?>
      <li><?php echo $widget->render()?></li>
    <?php } ?>
    
    <li class="submit">
      <input type="submit"
             name="submit"
             class="btn btn-primary"
             value="Send" />
    </li>
  </ul>
</form>

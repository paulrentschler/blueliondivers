<?php

/**
 * Landing page for State College Magazine Readers
 *
 * In the June 2013 issue of State College Magazine they did an article
 * on summer activities in the State College-area. One of those activities
 * was scuba diving/learning to scuba dive. Blue Lion Divers was mentioned
 * in that article and a link to the site was provided since JonL and I
 * helped provide some information and JonL facilitated and starred in
 * the cover photo.
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      27 May 2013
 */


$page_title = 'Welcome State College Magazine Readers';
$page_active_url = 'state-college-magazine.php';

include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/header.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/state-college-magazine.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/footer.tpl';


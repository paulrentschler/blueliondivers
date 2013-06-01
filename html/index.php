<?php

/**
 * Home page of the Blue Lion SCUBA site
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      27 December 2012
 */


$page_title = 'Home';
$page_active_url = '/';

include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/header.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/index.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/footer.tpl';


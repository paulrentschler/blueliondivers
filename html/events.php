<?php

/**
 * List of Blue Lion SCUBA events
 *
 * @author     Paul Rentschler <paul@rentschler.ws>
 * @since      27 December 2012
 */


$page_title = 'Events';
$page_active_url = 'events';
$body_attributes = 'data-target=".monthSidebar" data-spy="scroll"';

include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/header.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/events.tpl';
include dirname($_SERVER['DOCUMENT_ROOT']).'/templates/footer.tpl';


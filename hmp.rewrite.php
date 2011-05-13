<?php

$template = get_template_directory() . '/archive-hmp-entry.php';
$portfolio_base = get_option('hmp_url_base', 'portfolio');
hm_add_rewrite_rule( "^$portfolio_base(/page/([0-9]*))?/?$", 'post_type=hmp-entry&paged=$matches[2]' );

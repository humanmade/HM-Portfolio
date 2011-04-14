<?php

$portfolio_base = get_option('hmp_url_base', 'portfolio');
tj_add_rewrite_rule( "^$portfolio_base(/page/([0-9]*))?/?$", 'post_type=hmp-entry&paged=$matches[2]' );

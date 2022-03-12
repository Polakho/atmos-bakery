<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', 'public/views/home/index.php');

get('/about', 'public/views/about/index.php');


// The 404.php has access to $_GET and $_POST
any('/404','public/errors/404.php');
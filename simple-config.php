<?php

/**
 * Simple Configuration Example - Pretty URLs
 *
 * This example shows exactly what you requested:
 * All page loads go to a specified file with configurable path
 */

return [
	'htaccess_config' => [

		// Basic settings
		'domain' => 'mywebsite.com',
		'force_https' => true,

		// Enable pretty URLs
		'pretty_urls' => true,
		'pretty_urls_config' => [
			// This is the file that handles all requests
			'handler_file' => 'index.php',  // Change this to your preferred file

			// Use front-controller mode (all requests go to handler_file)
			'mode' => 'front-controller',

			// Exclude these directories from routing (serve files directly)
			'excluded_directories' => [
				'assets',   // Static assets
				'css',      // Stylesheets
				'js',       // JavaScript files
				'images',   // Images
				'uploads'   // User uploads
			],

			// Pass the URL to your handler file as a parameter
			'query_string_passthrough' => true,
			'url_parameter_name' => 'url'  // $_GET['url'] will contain the requested path
		]
	]
];

/*
GENERATED .HTACCESS WILL INCLUDE:

RewriteCond %{REQUEST_URI} !^/(assets|css|js|images|uploads)(/.*)?$ [NC]
RewriteCond %{REQUEST_URI} !\.(css|js|png|jpg|jpeg|gif|ico|txt|xml|json|pdf|zip|svg|woff|woff2|ttf|eot)$ [NC]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

WHAT THIS MEANS:
- /about → index.php?url=about
- /blog/post-title → index.php?url=blog/post-title
- /contact?message=hello → index.php?url=contact&message=hello
- /css/style.css → served directly (not routed)
- /images/logo.png → served directly (not routed)

IN YOUR index.php FILE:
<?php
$requestedUrl = $_GET['url'] ?? '';
echo "Requested URL: " . $requestedUrl;

// Route the request
switch ($requestedUrl) {
    case '':
    case 'home':
        include 'pages/home.php';
        break;
    case 'about':
        include 'pages/about.php';
        break;
    case 'contact':
        include 'pages/contact.php';
        break;
    default:
        http_response_code(404);
        include 'pages/404.php';
}
?>
*/
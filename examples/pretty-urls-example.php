<?php

/**
 * Pretty URLs Configuration Examples
 *
 * This file shows different ways to configure pretty URLs for various use cases.
 */

// ===================================
// EXAMPLE 1: MODERN FRAMEWORK SETUP
// ===================================
$frameworkConfig = [
	'htaccess_config' => [
		'domain' => 'myapp.com',

		// Enable pretty URLs with front controller pattern
		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'index.php',
			'mode' => 'front-controller',
			'excluded_directories' => [
				'assets',
				'css',
				'js',
				'images',
				'uploads',
				'admin',
				'api',
				'vendor'  // For Composer dependencies
			],
			'excluded_extensions' => [
				'.css', '.js', '.png', '.jpg', '.jpeg', '.gif', '.ico',
				'.txt', '.xml', '.json', '.pdf', '.zip', '.svg',
				'.woff', '.woff2', '.ttf', '.eot', '.map'
			],
			'force_trailing_slash' => false,
			'query_string_passthrough' => true,
			'url_parameter_name' => 'route'
		],

		// Additional settings
		'force_https' => true,
		'security_headers' => true,
		'compression' => true
	]
];

// ===================================
// EXAMPLE 2: SYMFONY-STYLE SETUP
// ===================================
$symfonyConfig = [
	'htaccess_config' => [
		'domain' => 'symfony-app.com',

		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'public/index.php',  // Symfony public directory
			'mode' => 'front-controller',
			'excluded_directories' => [
				'bundles',
				'css',
				'js',
				'images',
				'fonts',
				'build'
			],
			'force_trailing_slash' => true,  // Symfony typically uses trailing slashes
			'query_string_passthrough' => true,
			'url_parameter_name' => 'pathinfo'
		]
	]
];

// ===================================
// EXAMPLE 3: TRADITIONAL PHP SITE
// ===================================
$traditionalConfig = [
	'htaccess_config' => [
		'domain' => 'traditional-site.com',

		'pretty_urls' => true,
		'pretty_urls_config' => [
			'mode' => 'extension-removal',  // Remove .php/.html extensions but keep direct file access
			'excluded_directories' => [
				'admin',
				'assets',
				'images',
				'css',
				'js'
			],
			'force_trailing_slash' => false,
			'query_string_passthrough' => true
		]
	]
];

// ===================================
// EXAMPLE 4: HYBRID APPROACH
// ===================================
$hybridConfig = [
	'htaccess_config' => [
		'domain' => 'hybrid-site.com',

		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'router.php',  // Custom router file
			'mode' => 'both',  // Combines front-controller and extension-removal
			'excluded_directories' => [
				'static',
				'assets',
				'uploads',
				'admin',
				'legacy'  // Keep legacy pages as-is
			],
			'excluded_extensions' => [
				'.css', '.js', '.png', '.jpg', '.gif',
				'.pdf', '.zip', '.xml', '.txt'
			],
			'force_trailing_slash' => false,
			'query_string_passthrough' => true,
			'url_parameter_name' => 'path'
		]
	]
];

// ===================================
// EXAMPLE 5: API + FRONTEND COMBO
// ===================================
$apiConfig = [
	'htaccess_config' => [
		'domain' => 'api-app.com',

		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'app.php',
			'mode' => 'front-controller',
			'excluded_directories' => [
				'api',        // API endpoints served directly
				'admin',      // Admin panel served directly
				'assets',
				'public'
			],
			'force_trailing_slash' => false,
			'query_string_passthrough' => true,
			'url_parameter_name' => 'request_uri'
		],

		// CORS for API
		'cors_headers' => true,
		'cors_domains' => [
			'frontend.api-app.com',
			'admin.api-app.com'
		]
	]
];

// ===================================
// EXAMPLE 6: WORDPRESS-STYLE ROUTING
// ===================================
$wordpressStyleConfig = [
	'htaccess_config' => [
		'domain' => 'custom-cms.com',

		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'index.php',
			'mode' => 'front-controller',
			'excluded_directories' => [
				'wp-admin',     // WordPress admin (if mixed)
				'wp-content',   // WordPress content
				'wp-includes',  // WordPress core
				'admin',        // Custom admin
				'assets',
				'uploads'
			],
			'excluded_extensions' => [
				'.css', '.js', '.png', '.jpg', '.jpeg', '.gif',
				'.ico', '.txt', '.xml', '.json', '.pdf'
			],
			'force_trailing_slash' => true,
			'query_string_passthrough' => true,
			'url_parameter_name' => 'pagename'
		],

		// WordPress protection
		'protect_wp_admin' => true,
		'protect_sensitive_files' => true
	]
];

// ===================================
// EXAMPLE ROUTER.PHP FILE
// ===================================
/*
<?php
// Example router.php for handling pretty URLs

// Get the requested path
$requestPath = $_GET['path'] ?? '';
$requestPath = trim($requestPath, '/');

// Route definitions
$routes = [
    '' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php',
    'blog' => 'pages/blog.php',
    'blog/(.+)' => 'pages/blog-post.php',
    'products' => 'pages/products.php',
    'products/(.+)' => 'pages/product-detail.php'
];

// Find matching route
$matchedRoute = null;
$parameters = [];

foreach ($routes as $pattern => $file) {
    if ($pattern === $requestPath) {
        $matchedRoute = $file;
        break;
    }

    // Check for regex patterns
    if (preg_match("#^{$pattern}$#", $requestPath, $matches)) {
        $matchedRoute = $file;
        $parameters = array_slice($matches, 1);
        break;
    }
}

// Include the matched file or show 404
if ($matchedRoute && file_exists($matchedRoute)) {
    // Make parameters available to the included file
    $_ROUTE_PARAMS = $parameters;
    include $matchedRoute;
} else {
    http_response_code(404);
    include 'pages/404.php';
}
?>
*/

// Return the configuration you want to use
return $frameworkConfig;  // Change this to test different configs
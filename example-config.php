<?php

/**
 * Simple Example Configuration for .htaccess Generator
 *
 * This is a basic example showing common settings for a typical website.
 * Copy this file to create your own configuration.
 */

return [
	'htaccess_config' => [

		// Basic site information
		'domain' => 'mywebsite.com',

		// CDN domains (if you use a CDN)
		'cdn_domains' => [
			'cdn.mywebsite.com',
			'assets.mywebsite.com'
		],

		// Enable essential security and performance features
		'force_https' => true,
		'security_headers' => true,
		'content_security_policy' => true,
		'compression' => true,
		'enable_caching' => true,

		// Block malicious traffic
		'block_bad_bots' => true,
		'protect_sensitive_files' => true,
		'request_rate_limiting' => true,
		'max_requests_per_second' => 15,

		// URL preferences
		'www_redirection' => 'non-www',  // Redirect www.mywebsite.com to mywebsite.com

		// Cache settings for better performance
		'cache_html_duration' => '1 week',
		'cache_images_duration' => '1 year',
		'cache_css_duration' => '1 month',
		'cache_js_duration' => '1 month',

		// Custom error pages
		'error_pages' => [
			'404' => '/404.html',
			'500' => '/500.html'
		],

		// Disable features we don't need
		'protect_wp_admin' => false,  // Only enable if using WordPress
		'wildcard_subdomains' => false,
		'directory_indexing' => false,
		'follow_symlinks' => false
	]
];
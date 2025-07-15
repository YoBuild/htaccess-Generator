<?php

/**
 * Simple Example Configuration for .htaccess Generator
 *
 * This is a basic example showing common settings for a typical website.
 * Copy this file to create your own configuration.
 */

$domain = 'example.com';

return [
	'htaccess_config' => [

		// Basic site information
		'domain' => $domain,

		// CDN domains (if you use a CDN)
		'cdn_domains' => [
			'cdn.'.$domain,
			'assets.'.$domain,
		],

		'directory_indexing' => false,
		'follow_symlinks' => false,

		// Enable essential security and performance features
		'force_https' => true,
		'security_headers' => true,
		'content_security_policy' => true,
		'compression' => true,
		'enable_caching' => true,
		'enable_gzip_compression' => true,

		// Block malicious traffic
		'block_bad_bots' => true,
		'protect_sensitive_files' => true,
		'request_rate_limiting' => true,
		'max_requests_per_second' => 15,

		// URL preferences
		'www_redirection' => 'non-www',  // Redirect www.example.com to example.com

		// Cache settings for better performance
		'cache_html_duration' => '1 week',
		'cache_images_duration' => '1 year',
		'cache_css_duration' => '6 months',
		'cache_js_duration' => '6 months',
		'use_webp' => true,

		// Custom error pages
		//'error_pages' => [
		//	'404' => '/404',
		//	'500' => '/500'
		//],

		// Disable features we don't need
		'protect_wp_admin' => false,  // Only enable if using WordPress
		'wildcard_subdomains' => true,

		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'app.php',
			'mode' => 'front-controller',
			//'excluded_directories' => [
			//	'api',        // API endpoints served directly
			//	'admin',      // Admin panel served directly
			//	'assets',
			//	'public'
			//],
			'force_trailing_slash' => true,
			'query_string_passthrough' => true,
			'url_parameter_name' => 'request_uri'
		],
	]
];
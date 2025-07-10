<?php

/**
 * Comprehensive .htaccess Generator Configuration
 *
 * This file contains ALL available configuration options with examples and descriptions.
 * Each option is documented with:
 * - Description of what it does
 * - Possible values (if limited)
 * - Examples
 * - Default value
 */

return [
	'htaccess_config' => [

		// ================================
		// BASIC OPTIONS
		// ================================

		/**
		 * Main domain for the site
		 * Type: string
		 * Example: 'example.com', 'mywebsite.org'
		 * Default: ''
		 */
		'domain' => 'example.com',

		/**
		 * List of CDN domains allowed to serve assets
		 * Type: array of strings
		 * Example: ['cdn.example.com', 'assets.example.com', 'static.example.com']
		 * Default: []
		 */
		'cdn_domains' => [
			'cdn.example.com',
			'assets.example.com',
			'static.example.com'
		],

		/**
		 * List of domains allowed for CORS (Cross-Origin Resource Sharing)
		 * Type: array of strings
		 * Example: ['api.example.com', 'app.example.com']
		 * Default: []
		 */
		'cors_domains' => [
			'api.example.com',
			'app.example.com',
			'mobile.example.com'
		],

		// ================================
		// FEATURE FLAGS
		// ================================

		/**
		 * Allow following symbolic links
		 * Type: boolean
		 * Values: true = Enable FollowSymLinks, false = Disable
		 * Default: false
		 * Security Note: Only enable if you specifically need it
		 */
		'follow_symlinks' => false,

		/**
		 * Allow directory listing when no index file exists
		 * Type: boolean
		 * Values: true = Show directory contents, false = Hide directory contents
		 * Default: false
		 * Security Note: Should almost always be false for security
		 */
		'directory_indexing' => false,

		/**
		 * Force HTTPS redirects for all traffic
		 * Type: boolean
		 * Values: true = Redirect HTTP to HTTPS, false = Allow both HTTP and HTTPS
		 * Default: true
		 * Recommended: true for production sites
		 */
		'force_https' => true,

		/**
		 * Enable pretty URLs/URL rewriting (remove file extensions)
		 * Type: boolean
		 * Values: true = Enable URL rewriting, false = Use standard URLs
		 * Default: false
		 * Example: /page instead of /page.php
		 */
		'pretty_urls' => true,

		/**
		 * Pretty URLs configuration
		 * Type: array
		 */
		'pretty_urls_config' => [
			/**
			 * Handler file for pretty URLs
			 * Type: string
			 * Values:
			 *   'index.php' = Route all requests to index.php (most common)
			 *   'app.php' = Route to app.php (Symfony style)
			 *   'router.php' = Route to custom router file
			 *   'public/index.php' = Route to subdirectory file
			 * Default: 'index.php'
			 * Example: All requests like /about, /contact, /blog/post-title go to this file
			 */
			'handler_file' => 'index.php',

			/**
			 * Pretty URLs mode
			 * Type: string
			 * Values:
			 *   'front-controller' = All requests go to handler file (recommended for frameworks)
			 *   'extension-removal' = Remove file extensions (.php, .html) but keep direct file access
			 *   'both' = Combine both approaches
			 * Default: 'front-controller'
			 */
			'mode' => 'front-controller',

			/**
			 * Excluded directories from pretty URL rewriting
			 * Type: array of strings
			 * Example: ['admin', 'api', 'assets', 'uploads']
			 * Default: ['assets', 'css', 'js', 'images', 'uploads', 'admin']
			 * Note: These directories will serve files directly without rewriting
			 */
			'excluded_directories' => [
				'assets',
				'css',
				'js',
				'images',
				'uploads',
				'admin',
				'api'
			],

			/**
			 * Excluded file extensions from pretty URL rewriting
			 * Type: array of strings
			 * Example: ['.css', '.js', '.png', '.jpg', '.gif', '.ico', '.txt', '.xml']
			 * Default: ['.css', '.js', '.png', '.jpg', '.jpeg', '.gif', '.ico', '.txt', '.xml', '.json']
			 * Note: These file types will be served directly
			 */
			'excluded_extensions' => [
				'.css',
				'.js',
				'.png',
				'.jpg',
				'.jpeg',
				'.gif',
				'.ico',
				'.txt',
				'.xml',
				'.json',
				'.pdf',
				'.zip',
				'.svg',
				'.woff',
				'.woff2',
				'.ttf',
				'.eot'
			],

			/**
			 * Force trailing slash
			 * Type: boolean
			 * Values: true = Add trailing slash to URLs (/about/), false = Remove trailing slash (/about)
			 * Default: false
			 * SEO Note: Choose one approach and stick with it for consistency
			 */
			'force_trailing_slash' => false,

			/**
			 * Enable query string passthrough
			 * Type: boolean
			 * Values: true = Pass query strings to handler file, false = Ignore query strings
			 * Default: true
			 * Example: /page?id=123 becomes index.php?id=123&url=page
			 */
			'query_string_passthrough' => true,

			/**
			 * Custom query parameter name for the URL
			 * Type: string
			 * Default: 'url'
			 * Example: With 'route', /about becomes index.php?route=about
			 * Note: The handler file can access the original URL via $_GET[$this_parameter]
			 */
			'url_parameter_name' => 'url'
		],

		/**
		 * Enable Gzip compression for faster loading
		 * Type: boolean
		 * Values: true = Enable compression, false = No compression
		 * Default: true
		 * Recommended: true for better performance
		 */
		'compression' => true,

		/**
		 * Enable WebP image format support
		 * Type: boolean
		 * Values: true = Serve WebP when available, false = Use original formats
		 * Default: true
		 * Note: Requires WebP images to be available
		 */
		'use_webp' => true,

		/**
		 * Force UTF-8 character encoding
		 * Type: boolean
		 * Values: true = Force UTF-8, false = Use server default
		 * Default: true
		 * Recommended: true for international content
		 */
		'utf8_charset' => true,

		/**
		 * Enable wildcard subdomain support
		 * Type: boolean
		 * Values: true = Allow any subdomain, false = Specific subdomains only
		 * Default: false
		 * Security Note: Be cautious with this setting
		 */
		'wildcard_subdomains' => false,

		/**
		 * Enable browser caching headers
		 * Type: boolean
		 * Values: true = Set cache headers, false = No cache headers
		 * Default: false
		 */
		'enable_caching' => true,

		/**
		 * Cache duration for HTML files
		 * Type: string
		 * Values: '1 month', '6 months', '1 year', '1 week', '1 day'
		 * Default: '1 month'
		 */
		'cache_html_duration' => '1 month',

		/**
		 * Cache duration for image files
		 * Type: string
		 * Values: '1 month', '6 months', '1 year', '1 week', '1 day'
		 * Default: '1 year'
		 * Recommended: '1 year' for images (they change less frequently)
		 */
		'cache_images_duration' => '1 year',

		/**
		 * Cache duration for CSS files
		 * Type: string
		 * Values: '1 month', '6 months', '1 year', '1 week', '1 day'
		 * Default: '1 month'
		 */
		'cache_css_duration' => '1 month',

		/**
		 * Cache duration for JavaScript files
		 * Type: string
		 * Values: '1 month', '6 months', '1 year', '1 week', '1 day'
		 * Default: '1 month'
		 */
		'cache_js_duration' => '1 month',

		/**
		 * Enable Gzip compression (alternative setting)
		 * Type: boolean
		 * Values: true = Enable Gzip, false = Disable Gzip
		 * Default: false
		 * Note: Similar to 'compression' but more specific
		 */
		'enable_gzip_compression' => true,

		// ================================
		// WWW/NON-WWW REDIRECTION
		// ================================

		/**
		 * WWW/Non-WWW redirection preference
		 * Type: string
		 * Values:
		 *   'none' = No redirection
		 *   'www' = Always redirect to www version (example.com → www.example.com)
		 *   'non-www' = Always redirect to non-www version (www.example.com → example.com)
		 * Default: 'none'
		 */
		'www_redirection' => 'non-www',

		// ================================
		// ENHANCED SECURITY OPTIONS
		// ================================

		/**
		 * Enable comprehensive security headers
		 * Type: boolean
		 * Values: true = Add security headers, false = No security headers
		 * Default: true
		 * Recommended: true for all production sites
		 */
		'security_headers' => true,

		/**
		 * Enable Content Security Policy (CSP) for XSS protection
		 * Type: boolean
		 * Values: true = Enable CSP, false = No CSP
		 * Default: true
		 * Recommended: true for preventing XSS attacks
		 */
		'content_security_policy' => true,

		/**
		 * Enable CORS (Cross-Origin Resource Sharing) headers
		 * Type: boolean
		 * Values: true = Enable CORS, false = No CORS headers
		 * Default: true
		 * Note: Works with 'cors_domains' setting
		 */
		'cors_headers' => true,

		/**
		 * Block known bad bots and crawlers
		 * Type: boolean
		 * Values: true = Block bad bots, false = Allow all bots
		 * Default: true
		 * Recommended: true to prevent malicious crawling
		 */
		'block_bad_bots' => true,

		/**
		 * Protect sensitive files from direct access
		 * Type: boolean
		 * Values: true = Protect sensitive files, false = No protection
		 * Default: true
		 * Protects: .htaccess, .env, wp-config.php, logs, etc.
		 */
		'protect_sensitive_files' => true,

		/**
		 * Block PHP file upload execution in upload directories
		 * Type: boolean
		 * Values: true = Block PHP execution, false = Allow PHP execution
		 * Default: true
		 * Recommended: true to prevent malicious uploads
		 */
		'block_php_upload_exec' => true,

		/**
		 * Protect against malicious file uploads
		 * Type: boolean
		 * Values: true = Block dangerous file types, false = Allow all uploads
		 * Default: true
		 * Blocks: .php, .exe, .pl, .py, .jsp, .asp, etc.
		 */
		'file_upload_protection' => true,

		/**
		 * WordPress-specific admin area protection
		 * Type: boolean
		 * Values: true = Protect wp-admin, false = No WP protection
		 * Default: false
		 * Note: Only enable for WordPress sites
		 */
		'protect_wp_admin' => false,

		/**
		 * Protect PHP files from direct access
		 * Type: boolean
		 * Values: true = Block direct PHP access, false = Allow direct access
		 * Default: true
		 * Recommended: true for security
		 */
		'protect_php_files' => true,

		/**
		 * Hide server information in headers
		 * Type: boolean
		 * Values: true = Hide server info, false = Show server info
		 * Default: true
		 * Recommended: true to prevent information disclosure
		 */
		'sanitize_server_tokens' => true,

		/**
		 * Enable XSS (Cross-Site Scripting) protection
		 * Type: boolean
		 * Values: true = Enable XSS protection, false = No XSS protection
		 * Default: true
		 * Recommended: true for all sites
		 */
		'xss_protection' => true,

		/**
		 * Enable clickjacking protection
		 * Type: boolean
		 * Values: true = Prevent iframe embedding, false = Allow iframe embedding
		 * Default: true
		 * Recommended: true unless you need iframe embedding
		 */
		'clickjacking_protection' => true,

		/**
		 * Protect against MIME type sniffing
		 * Type: boolean
		 * Values: true = Prevent MIME sniffing, false = Allow MIME sniffing
		 * Default: true
		 * Recommended: true for security
		 */
		'mime_sniffing_protection' => true,

		/**
		 * Enable request rate limiting
		 * Type: boolean
		 * Values: true = Limit request rate, false = No rate limiting
		 * Default: true
		 * Recommended: true to prevent DoS attacks
		 */
		'request_rate_limiting' => true,

		/**
		 * Maximum requests per second per IP address
		 * Type: integer
		 * Values: Any positive integer (1-1000)
		 * Default: 10
		 * Examples: 5 = Very strict, 10 = Normal, 20 = Lenient
		 */
		'max_requests_per_second' => 10,

		/**
		 * Enable additional security enhancements
		 * Type: boolean
		 * Values: true = Extra security headers, false = Basic security only
		 * Default: false
		 */
		'additional_security_headers' => true,

		// ================================
		// IP ACCESS CONTROL
		// ================================

		/**
		 * List of IP addresses to block
		 * Type: array of strings
		 * Format: ['192.168.1.1', '10.0.0.0/8', '172.16.0.1']
		 * Examples:
		 *   '192.168.1.100' = Block specific IP
		 *   '192.168.1.0/24' = Block entire subnet
		 *   '10.0.0.0/8' = Block large network range
		 */
		'ip_blacklist' => [
			'192.168.1.100',
			'10.0.0.0/8',
			'203.0.113.0/24'
		],

		/**
		 * List of IP addresses to allow (blocks all others)
		 * Type: array of strings
		 * Format: Same as ip_blacklist
		 * Note: If set, ONLY these IPs can access the site
		 * Use case: Admin-only sections, staging sites
		 */
		'ip_whitelist' => [
			// '192.168.1.10',
			// '203.0.113.50'
		],

		/**
		 * List of country codes to block
		 * Type: array of strings
		 * Format: Two-letter ISO country codes
		 * Examples: ['CN', 'RU', 'KP'] = Block China, Russia, North Korea
		 * Note: Requires GeoIP module on server
		 */
		'country_blacklist' => [
			// 'CN',
			// 'RU'
		],

		// ================================
		// SSL/TLS REQUIREMENTS
		// ================================

		/**
		 * SSL/TLS configuration
		 * Type: array
		 */
		'ssl_requirements' => [
			/**
			 * Minimum TLS version to accept
			 * Values: 'TLSv1.2', 'TLSv1.3'
			 * Default: 'TLSv1.2'
			 * Recommended: 'TLSv1.3' for maximum security
			 */
			'min_version' => 'TLSv1.3',

			/**
			 * Enforce HTTP Strict Transport Security (HSTS)
			 * Values: true = Enforce HTTPS, false = Optional HTTPS
			 * Default: true
			 * Recommended: true for production sites
			 */
			'enforce_hsts' => true,

			/**
			 * HSTS maximum age in seconds
			 * Values: 31536000 (1 year), 63072000 (2 years), 15768000 (6 months)
			 * Default: 31536000
			 * Recommended: 31536000 (1 year) minimum
			 */
			'hsts_max_age' => 31536000,

			/**
			 * Apply HSTS to all subdomains
			 * Values: true = Include subdomains, false = Main domain only
			 * Default: true
			 * Recommended: true if all subdomains support HTTPS
			 */
			'include_subdomains' => true,

			/**
			 * Add site to HSTS preload list
			 * Values: true = Enable preload, false = No preload
			 * Default: true
			 * Note: Requires manual submission to browsers
			 */
			'preload' => true
		],

		/**
		 * SSL forcing configuration
		 * Type: string
		 * Values:
		 *   'none' = No SSL forcing
		 *   'entire-site' = Force HTTPS for entire site
		 *   'specific-sections' = Force HTTPS for specific areas only
		 * Default: 'none'
		 */
		'ssl_forcing' => 'entire-site',

		// ================================
		// ERROR PAGES
		// ================================

		/**
		 * Custom error page configurations
		 * Type: array
		 * Format: [error_code => '/path/to/error/page.html']
		 * Set to null to use server defaults
		 */
		'error_pages' => [
			/**
			 * 400 Bad Request error page
			 * Example: '/errors/400.html', '/error.php?code=400'
			 */
			'400' => '/errors/400.html',

			/**
			 * 401 Unauthorized error page
			 * Example: '/errors/401.html', '/login.php'
			 */
			'401' => '/errors/401.html',

			/**
			 * 403 Forbidden error page
			 * Example: '/errors/403.html', '/access-denied.html'
			 */
			'403' => '/errors/403.html',

			/**
			 * 404 Not Found error page
			 * Example: '/errors/404.html', '/not-found.php'
			 */
			'404' => '/errors/404.html',

			/**
			 * 500 Internal Server Error page
			 * Example: '/errors/500.html', '/server-error.php'
			 */
			'500' => '/errors/500.html'
		],

		// ================================
		// ACCESS CONTROL
		// ================================

		/**
		 * Enable advanced access control
		 * Type: boolean
		 * Values: true = Enable access control, false = No access control
		 * Default: false
		 */
		'access_control_enabled' => false,

		/**
		 * Access control list (IPs and User Agents)
		 * Type: array of strings
		 * Examples:
		 *   '192.168.1.1' = IP address
		 *   'BadBot' = User agent string
		 *   'Googlebot' = Specific bot
		 */
		'access_control_list' => [
			'192.168.1.100',
			'BadBot',
			'malicious-scanner'
		],

		// ================================
		// CUSTOM MIME TYPES
		// ================================

		/**
		 * Enable custom MIME type definitions
		 * Type: boolean
		 * Values: true = Add custom MIME types, false = Use server defaults
		 * Default: false
		 */
		'custom_mime_types_enabled' => true,

		/**
		 * Custom MIME type definitions
		 * Type: array of strings
		 * Format: ['.extension application/mime-type']
		 * Examples:
		 */
		'custom_mime_types' => [
			'.json application/json',
			'.webp image/webp',
			'.woff2 font/woff2',
			'.svg image/svg+xml',
			'.webm video/webm',
			'.mp4 video/mp4'
		],

		// ================================
		// REDIRECT MANAGEMENT
		// ================================

		/**
		 * Enable redirect management
		 * Type: boolean
		 * Values: true = Process redirects, false = No redirects
		 * Default: false
		 */
		'redirect_management_enabled' => true,

		/**
		 * List of redirects
		 * Type: array of strings
		 * Format: ['/old-path /new-path redirect-code']
		 * Redirect codes:
		 *   301 = Permanent redirect (SEO-friendly)
		 *   302 = Temporary redirect
		 *   307 = Temporary redirect (preserves method)
		 */
		'redirect_list' => [
			'/old-page /new-page 301',
			'/temp-page /final-page 302',
			'/legacy/products /products 301',
			'/blog/old-post /blog/new-post 301'
		],

		// ================================
		// HOTLINK PROTECTION
		// ================================

		/**
		 * Enable hotlink protection (prevent image theft)
		 * Type: boolean
		 * Values: true = Block hotlinking, false = Allow hotlinking
		 * Default: false
		 */
		'hotlink_protection_enabled' => true,

		/**
		 * Domains allowed to hotlink your content
		 * Type: array of strings
		 * Example: ['partner.com', 'affiliate.com']
		 * Note: Your own domain is automatically allowed
		 */
		'hotlink_protection_list' => [
			'trusted-partner.com',
			'affiliate-site.com'
		],

		// ================================
		// CUSTOM OPTIONS
		// ================================

		/**
		 * Custom document root path
		 * Type: string|null
		 * Example: '/public_html/subdirectory', '/var/www/custom'
		 * Default: null (use server default)
		 */
		'custom_document_root' => null,

		/**
		 * Default image placeholder for missing images
		 * Type: string|null
		 * Example: '/images/placeholder.png', '/assets/no-image.jpg'
		 * Default: null
		 */
		'image_placeholder' => '/images/placeholder.png',

		/**
		 * Custom htaccess rules (advanced users)
		 * Type: array of strings
		 * Each string is a raw htaccess directive
		 * Examples:
		 */
		'custom_rules' => [
			'# Custom rule for API rate limiting',
			'<LocationMatch "^/api/">',
			'    SetEnvIf Request_URI "^/api/" api_request',
			'    RewriteRule ^api/ - [E=API:1]',
			'</LocationMatch>',
			'',
			'# Custom cache control for specific files',
			'<FilesMatch "\.(ico|pdf|flv|swf)$">',
			'    Header set Cache-Control "max-age=31536000, public"',
			'</FilesMatch>'
		]
	]
];
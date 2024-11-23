<?php

namespace Yohns\Generators;

/**
 * Enhanced Security Htaccess Generator with comprehensive protection measures
 */
class HtaccessGenerator
{
	/** @var array Default configuration values */
	private array $config = [
		// Basic Options
		'domain' => '',					// Main domain for the site
		'cdn_domains' => [],			  // List of CDN domains allowed to serve assets
		'cors_domains' => [],			 // List of domains allowed for CORS

		// Feature Flags
		'follow_symlinks' => false,	   // Allow following symbolic links
		'directory_indexing' => false,	// Allow directory listing
		'force_https' => true,			// Force HTTPS redirects
		'pretty_urls' => false,		   // Enable pretty URLs/URL rewriting
		'compression' => true,			// Enable Gzip compression
		'use_webp' => true,			  // Enable WebP image support
		'utf8_charset' => true,		   // Force UTF-8 charset
		'wildcard_subdomains' => false,   // Enable wildcard subdomain support
		'enable_caching' => false,  // Enable caching headers
		'enable_gzip_compression' => false,  // Enable Gzip compression
		'cache_html_duration' => '1 month',  // Caching duration for HTML files
		'cache_images_duration' => '1 year',  // Caching duration for image files
		'cache_css_duration' => '1 month',  // Caching duration for CSS files
		'cache_js_duration' => '1 month',  // Caching duration for JavaScript files

		// Enhanced Security Options
		'security_headers' => true,	   // Enable security headers
		'content_security_policy' => true, // Enable CSP
		'cors_headers' => true,		   // Enable CORS headers
		'block_bad_bots' => true,		 // Block known bad bots
		'protect_sensitive_files' => true, // Protect sensitive files
		'ip_blacklist' => [],			// List of IPs to block
		'ip_whitelist' => [],			// List of IPs to allow
		'country_blacklist' => [],		// List of country codes to block
		'request_rate_limiting' => true,   // Enable rate limiting
		'max_requests_per_second' => 10,   // Maximum requests per second per IP
		'file_upload_protection' => true,  // Protect against malicious file uploads
		'xss_protection' => true,		 // Enable XSS protection
		'clickjacking_protection' => true, // Enable clickjacking protection
		'mime_sniffing_protection' => true, // Protect against MIME sniffing
		'ssl_requirements' => [		   // SSL/TLS requirements
			'min_version' => 'TLSv1.2',
			'enforce_hsts' => true,
			'hsts_max_age' => 31536000,
			'include_subdomains' => true,
			'preload' => true
		],
		// SSL Forcing
		'ssl_forcing' => 'none',           // SSL forcing option

		'protect_wp_admin' => false,	  // WordPress-specific protection
		'protect_php_files' => true,	  // Protect PHP files from direct access
		'block_php_upload_exec' => true,  // Block PHP file uploads execution
		'sanitize_server_tokens' => true, // Hide server information
		'additional_security_headers' => false,  // Enable additional security headers

		// Error Pages
		'error_pages' => [
			'400' => null,
			'401' => null,
			'403' => null,
			'404' => null,
			'500' => null
		],

		// Custom Options
		'custom_document_root' => null,   // Custom document root path
		'image_placeholder' => null,	  // Path to default image placeholder
		'custom_rules' => [],			// Array of custom htaccess rules

		// WWW/Non-WWW Redirection
		'www_redirection' => 'none',       // WWW/Non-WWW redirection option

		// Access Control
		'access_control_enabled' => false,  // Enable access control
		'access_control_list' => [],  // List of IPs/User Agents for access control

		// Custom MIME Types
		'custom_mime_types' => [],  // Custom MIME types

		// Redirect Management
		'redirect_management_enabled' => false,  // Enable redirect management
		'redirect_list' => [],  // List of redirects

		// Hotlink Protection
		'hotlink_protection_enabled' => false,  // Enable hotlink protection
	];

	/**
	 * Constructor to initialize configuration
	 */
	public function __construct(array $config = [])
	{
		$this->config = array_merge($this->config, $config);
	}

	/**
	 * Set a configuration option
	 */
	public function setOption(string $key, mixed $value): void
	{
		if (array_key_exists($key, $this->config)) {
			$this->config[$key] = $value;
		}
	}

	/**
	 * Generate the htaccess content
	 */
	public function generate(): string
	{
		$lines = [];

		// Server Tokens
		if ($this->config['sanitize_server_tokens']) {
			$lines[] = 'ServerSignature Off';
			$lines[] = 'ServerTokens Prod';
		}

		// Basic Options
		if ($this->config['follow_symlinks']) {
			$lines[] = 'Options +FollowSymLinks';
		}

		if (!$this->config['directory_indexing']) {
			$lines[] = 'Options -Indexes -MultiViews';
		}

		// UTF-8 Charset
		if ($this->config['utf8_charset']) {
			$lines[] = 'AddDefaultCharset utf-8';
			$lines[] = 'AddCharset utf-8 .atom .css .js .json .rss .vtt .xml';
		}

		// Rewrite Engine
		$lines[] = 'RewriteEngine On';
		$lines[] = 'RewriteBase /';

		// IP Blocking
		if (!empty($this->config['ip_blacklist'])) {
			$lines[] = 'Order Allow,Deny';
			$lines[] = 'Allow from all';
			foreach ($this->config['ip_blacklist'] as $ip) {
				$nip = $ip ?? '';
				$lines[] = "Deny from $nip";
			}
		}

		// IP Whitelisting (Override)
		if (!empty($this->config['ip_whitelist'])) {
			$lines[] = 'Order Deny,Allow';
			$lines[] = 'Deny from all';
			foreach ($this->config['ip_whitelist'] as $ip) {
				$nip = $ip ?? '';
				$lines[] = "Allow from $nip";
			}
		}

		// Country Blocking
		if (!empty($this->config['country_blacklist'])) {
			$lines[] = 'SetEnvIf GEOIP_COUNTRY_CODE ^('.implode('|', $this->config['country_blacklist']).')$ BlockCountry';
			$lines[] = 'Deny from env=BlockCountry';
		}

		// HTTPS Redirect with HSTS
		if ($this->config['force_https']) {
			$lines[] = 'RewriteCond %{HTTPS} off';
			$lines[] = 'RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]';

			if ($this->config['ssl_requirements']['enforce_hsts']) {
				$hsts = "max-age={$this->config['ssl_requirements']['hsts_max_age']}";
				if ($this->config['ssl_requirements']['include_subdomains']) {
					$hsts .= '; includeSubDomains';
				}
				if ($this->config['ssl_requirements']['preload']) {
					$hsts .= '; preload';
				}
				$lines[] = "Header always set Strict-Transport-Security \"$hsts\"";
			}
		}

		// Rate Limiting
		if ($this->config['request_rate_limiting']) {
			$lines[] = '<IfModule mod_ratelimit.c>';
			$lines[] = "RateLimitPerSecond {$this->config['max_requests_per_second']}";
			$lines[] = '</IfModule>';
		}

		// Protect Sensitive Files
		if ($this->config['protect_sensitive_files']) {
			$lines[] = '<FilesMatch "^(\.htaccess|\.htpasswd|\.git|\.env|wp-config\.php|config\.php|configuration\.php|\.log|\.ini|\.json)$">';
			$lines[] = 'Order allow,deny';
			$lines[] = 'Deny from all';
			$lines[] = '</FilesMatch>';
		}

		// Block Bad Bots
		if ($this->config['block_bad_bots']) {
			$lines[] = 'RewriteCond %{HTTP_USER_AGENT} ^.*(robot|spider|crawler|wget|curl|uniform|loader|grab|slurp|Bot|bot|python|harvest|scan|winhttp|clshttp|loader|email|extract|fetch).*$ [NC]';
			$lines[] = 'RewriteRule ^ - [F,L]';
		}

		// Protect Against PHP File Upload Execution
		if ($this->config['block_php_upload_exec']) {
			$lines[] = '<FilesMatch "\.(?i:php|php3|php4|php5|phtml|phptml)$">';
			$lines[] = 'RewriteCond %{REQUEST_URI} !^/index\.php$';
			$lines[] = 'RewriteCond %{DOCUMENT_ROOT}/uploads/ -preg "^(.*)$"';
			$lines[] = 'RewriteRule .* - [F,L]';
			$lines[] = '</FilesMatch>';
		}

		// File Upload Protection
		if ($this->config['file_upload_protection']) {
			$lines[] = "\t<FilesMatch \"(?i)\\.(php|php3|php4|php5|phtml|phptml|exe|pl|py|jsp|asp|htm|shtml|sh|cgi|dll)$\">";
			$lines[] = "\t\tOrder Deny,Allow";
			$lines[] = "\t\tDeny from All";
			$lines[] = "\t</FilesMatch>";
		}

		// WordPress Admin Protection
		if ($this->config['protect_wp_admin']) {
			$lines[] = "\t<Files wp-login.php>";
			$lines[] = "\t\tOrder Deny,Allow";
			$lines[] = "\t\tDeny from all";
			$lines[] = "\t\tAllow from " . implode(' ', $this->config['ip_whitelist']);
			$lines[] = "\t</Files>";
		}

		// Enhanced and Additional Security Headers
		if ($this->config['security_headers'] || $this->config['additional_security_headers']) {
			$lines[] = "\t<IfModule mod_headers.c>";
			$lines[] = "\t\tHeader set X-Content-Type-Options \"nosniff\"";
			$lines[] = "\t\tHeader set X-Frame-Options \"SAMEORIGIN\"";
			$lines[] = "\t\tHeader set X-XSS-Protection \"1; mode=block\"";
			if ($this->config['security_headers']) {
				$lines[] = "\t\tHeader set Referrer-Policy \"strict-origin-when-cross-origin\"";
				$lines[] = "\t\tHeader set Permissions-Policy \"geolocation=(), midi=(), sync-xhr=(), microphone=(), camera=(), magnetometer=(), gyroscope=(), fullscreen=(self), payment=()\"";
				$lines[] = "\t\tHeader set Cross-Origin-Embedder-Policy \"require-corp\"";
				$lines[] = "\t\tHeader set Cross-Origin-Opener-Policy \"same-origin\"";
				$lines[] = "\t\tHeader set Cross-Origin-Resource-Policy \"same-origin\"";
			}
			$lines[] = "\t</IfModule>";
		}

		// Enhanced Content Security Policy
		if ($this->config['content_security_policy']) {
			$csp = [
				"\tdefault-src 'self'",
				"\tscript-src 'self' 'strict-dynamic' 'nonce-{RANDOM}' 'unsafe-inline' 'unsafe-eval'",
				"\tstyle-src 'self' 'unsafe-inline'",
				"\timg-src 'self' data: https:",
				"\tfont-src 'self'",
				"\tconnect-src 'self'",
				"\tmedia-src 'self'",
				"\tobject-src 'none'",
				"\tframe-src 'self'",
				"\tworker-src 'self'",
				"\tframe-ancestors 'self'",
				"\tform-action 'self'",
				"\tbase-uri 'self'",
				"\tmanifest-src 'self'",
				"\tupgrade-insecure-requests",
				"\tblock-all-mixed-content"
			];

			if (!empty($this->config['cdn_domains']) && is_array($this->config['cdn_domains'])) {
				$cdn_list = implode(' ', $this->config['cdn_domains']);
				$csp[1] .= " {$cdn_list}";
				$csp[2] .= " {$cdn_list}";
				$csp[3] .= " {$cdn_list}";
			}

			$lines[] = "\tHeader set Content-Security-Policy '" . implode('; ', $csp) . "'";
			$lines[] = "# Note: Replace 'nonce-{RANDOM}' with an actual nonce value if using nonces";
		}
		
		// CORS Headers with Enhanced Security
		if ($this->config['cors_headers'] && !empty($this->config['cors_domains']) && is_array($this->config['cors_domains'])) {
			$domains = implode('|', array_map('preg_quote', $this->config['cors_domains']));
			$lines[] = '<IfModule mod_headers.c>';
			$lines[] = "SetEnvIf Origin \"^https://([^/]+)$\" CORS_DOMAIN=$0";
			$lines[] = "Header set Access-Control-Allow-Origin %{CORS_DOMAIN}e env=CORS_DOMAIN";
			$lines[] = "Header set Access-Control-Allow-Methods \"GET, POST, OPTIONS\"";
			$lines[] = "Header set Access-Control-Allow-Headers \"Content-Type, Authorization, X-Requested-With\"";
			$lines[] = "Header set Access-Control-Allow-Credentials true";
			$lines[] = "Header set Access-Control-Max-Age 3600";
			$lines[] = "Header set Vary \"Origin\"";
			$lines[] = '</IfModule>';
		}

		// Protection Against Common Attacks
		$lines[] = '# Prevent Apache from serving .ht* files';
		$lines[] = '<FilesMatch "^\.ht">';
		$lines[] = 'Order allow,deny';
		$lines[] = 'Deny from all';
		$lines[] = 'Satisfy All';
		$lines[] = '</FilesMatch>';

		// Block Access to Backup and Source Files
		$lines[] = '<FilesMatch "(\.(bak|config|sql|fla|psd|ini|log|sh|inc|swp|dist)|~)$">';
		$lines[] = 'Order allow,deny';
		$lines[] = 'Deny from all';
		$lines[] = 'Satisfy All';
		$lines[] = '</FilesMatch>';

		// Prevent Directory Browsing
		$lines[] = 'Options All -Indexes';

		// Gzip Compression
		if ($this->config['enable_gzip_compression'] || $this->config['compression']) {
			$lines[] = '<IfModule mod_deflate.c>';
			$lines[] = 'SetOutputFilter DEFLATE';
			$lines[] = 'AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/x-javascript application/xml application/xml+rss application/xhtml+xml application/rss+xml application/json';
			$lines[] = 'SetEnvIfNoCase Request_URI \\.(?:gif|jpe?g|png|pdf)$ no-gzip dont-vary';
			$lines[] = '</IfModule>';
		}

		// Access Control
		if ($this->config['access_control_enabled']) {
			foreach ($this->config['access_control_list'] as $entry) {
				$lines[] = 'Require not ip ' . $entry; // Example for IP control
				// $lines[] = 'BrowserMatchNoCase "' . $entry . '" bad_bot'; // Example for User Agent control
			}
		}

		// Custom MIME Types
		foreach ($this->config['custom_mime_types'] as $mime_type) {
			list($extension, $type) = explode(' ', $mime_type);
			$lines[] = 'AddType ' . $type . ' ' . $extension;
		}

		// WWW/Non-WWW Redirection
		if ($this->config['www_redirection'] === 'www') {
			$lines[] = 'RewriteCond %{HTTP_HOST} !^www\. [NC]';
			$lines[] = 'RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]';
		} elseif ($this->config['www_redirection'] === 'non-www') {
			$lines[] = 'RewriteCond %{HTTP_HOST} ^www\. [NC]';
			$lines[] = 'RewriteRule ^(.*)$ http://%{HTTP_HOST}/$1 [R=301,L]';
		}

		// SSL Forcing
		if ($this->config['ssl_forcing'] === 'entire-site') {
			$lines[] = 'RewriteCond %{HTTPS} off';
			$lines[] = 'RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]';
		} elseif ($this->config['ssl_forcing'] === 'specific-sections') {
			// Example: Add specific logic for sections
			// $lines[] = "RewriteCond %{REQUEST_URI} ^/secure/ [NC]";
			// $lines[] = "RewriteCond %{HTTPS} off";
			// $lines[] = "RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]";
		}

		// Custom Error Pages
		foreach ($this->config['error_pages'] as $code => $path) {
			if ($path !== null) {
				$path = $path ?? '';
				$lines[] = "ErrorDocument $code $path";
			}
		}

		// Custom Rules
		if (!empty($this->config['custom_rules'])) {
			$lines = array_merge($lines, $this->config['custom_rules']);
		}

		// Redirect Management
		if ($this->config['redirect_management_enabled']) {
			foreach ($this->config['redirect_list'] as $redirect) {
				list($old_url, $new_url, $type) = explode(' ', $redirect);
				$lines[] = 'Redirect ' . $type . ' ' . $old_url . ' ' . $new_url;
			}
		}

		// Hotlink Protection
		if ($this->config['hotlink_protection_enabled']) {
			$lines[] = 'RewriteEngine on';
			$lines[] = 'RewriteCond %{HTTP_REFERER} !^$';
			$lines[] = 'RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?yourdomain.com [NC]';
			$lines[] = 'RewriteRule \.(jpg|jpeg|png|gif)$ - [F,NC]';
		}

		return implode("\n", $lines);
	}

	/**
	 * Save the generated content to a file
	 */
	public function saveToFile(string $filePath): void
	{
		$content = $this->generate();
		file_put_contents($filePath, $content);
	}
}
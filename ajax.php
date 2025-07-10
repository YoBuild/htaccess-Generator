<?php
use YoBuild\Generators\HtaccessGenerator;

require_once 'src/HtaccessGenerator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$config = [
		'domain'                      => $_POST['domain'] ?? '',
		'cdn_domains'                 => $_POST['cdn_domains'] ?? '',
		'cors_domains'                => $_POST['cors_domains'] ?? '',
		'follow_symlinks'             => isset($_POST['follow_symlinks']),
		'directory_indexing'          => isset($_POST['directory_indexing']),
		'force_https'                 => isset($_POST['force_https']),
		'pretty_urls'                 => isset($_POST['pretty_urls']),
		'compression'                 => isset($_POST['compression']),
		'use_webp'                    => isset($_POST['use_webp']),
		'utf8_charset'                => isset($_POST['utf8_charset']),
		'wildcard_subdomains'         => isset($_POST['wildcard_subdomains']),
		'enable_caching'              => isset($_POST['enable_caching']),
		'enable_gzip_compression'     => isset($_POST['enable_gzip_compression']),
		'access_control_enabled'      => isset($_POST['access_control_enabled']),
		'custom_mime_types_enabled'   => isset($_POST['custom_mime_types_enabled']),
		'redirect_management_enabled' => isset($_POST['redirect_management_enabled']),
		'hotlink_protection_enabled'  => isset($_POST['hotlink_protection_enabled']),
		'security_enhancements'       => isset($_POST['security_enhancements']),
		'additional_security_headers' => isset($_POST['additional_security_headers']),
		'content_security_policy'     => isset($_POST['content_security_policy']),
		'cors_headers'                => isset($_POST['cors_headers']),
		'block_bad_bots'              => isset($_POST['block_bad_bots']),
		'protect_sensitive_files'     => isset($_POST['protect_sensitive_files']),
		'block_php_upload_exec'       => isset($_POST['block_php_upload_exec']),
		'file_upload_protection'      => isset($_POST['file_upload_protection']),
		'protect_wp_admin'            => isset($_POST['protect_wp_admin']),
		'protect_php_files'           => isset($_POST['protect_php_files']),
		'sanitize_server_tokens'      => isset($_POST['sanitize_server_tokens']),
		'xss_protection'              => isset($_POST['xss_protection']),
		'clickjacking_protection'     => isset($_POST['clickjacking_protection']),
		'mime_sniffing_protection'    => isset($_POST['mime_sniffing_protection']),
		'request_rate_limiting'       => isset($_POST['request_rate_limiting']),
		'security_headers'            => isset($_POST['security_headers']),
		'custom_document_root'        => $_POST['custom_document_root'] ?? '',
		'image_placeholder'           => $_POST['image_placeholder'] ?? '',
		'custom_rules'                => $_POST['custom_rules'] ?? '',
		'ip_blacklist'                => $_POST['ip_blacklist'] ?? '',
		'ip_whitelist'                => $_POST['ip_whitelist'] ?? '',
		'country_blacklist'           => $_POST['country_blacklist'] ?? '',
		'max_requests_per_second'     => $_POST['max_requests_per_second'] ?? 0,
		'error_400'                   => $_POST['error_400'] ?? '',
		'error_401'                   => $_POST['error_401'] ?? '',
		'error_403'                   => $_POST['error_403'] ?? '',
		'error_404'                   => $_POST['error_404'] ?? '',
		'error_500'                   => $_POST['error_500'] ?? '',
	];

	$generator = new HtaccessGenerator($config);
	$htaccessContent = $generator->generate();

	echo json_encode(['htaccess' => $htaccessContent]);
} else {
	echo json_encode(['error' => 'Invalid request method.']);
}

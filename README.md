# .htaccess Generator

This project is an .htaccess generator that provides enhanced security and performance configurations for your web application. Below are the configuration options available and their default settings.

## Configuration Options

- **domain**: The main domain for the site. Default is an empty string.
- **cdn_domains**: List of CDN domains allowed to serve assets. Default is an empty array.
- **cors_domains**: List of domains allowed for CORS. Default is an empty array.
- **follow_symlinks**: Allow following symbolic links. Default is `false`.
- **directory_indexing**: Allow directory listing. Default is `false`.
- **force_https**: Force HTTPS redirects. Default is `true`.
- **pretty_urls**: Enable pretty URLs/URL rewriting. Default is `false`.
- **compression**: Enable Gzip compression. Default is `true`.
- **use_webp**: Enable WebP image support. Default is `true`.
- **utf8_charset**: Force UTF-8 charset. Default is `true`.
- **wildcard_subdomains**: Enable wildcard subdomain support. Default is `false`.
- **enable_caching**: Enable caching headers. Default is `false`.
- **enable_gzip_compression**: Enable Gzip compression. Default is `false`.
- **access_control_enabled**: Enable access control. Default is `false`.
- **custom_mime_types_enabled**: Enable custom MIME types. Default is `false`.
- **redirect_management_enabled**: Enable redirect management. Default is `false`.
- **hotlink_protection_enabled**: Enable hotlink protection. Default is `false`.
- **security_enhancements**: Enable security enhancements. Default is `false`.
- **additional_security_headers**: Enable additional security headers. Default is `false`.
- **content_security_policy**: Enable Content Security Policy (CSP). Default is `true`.
- **cors_headers**: Enable CORS headers. Default is `false`.
- **block_bad_bots**: Block known bad bots. Default is `true`.
- **protect_sensitive_files**: Protect sensitive files. Default is `true`.
- **block_php_upload_exec**: Block PHP file uploads execution. Default is `true`.
- **file_upload_protection**: Protect against malicious file uploads. Default is `true`.
- **protect_wp_admin**: WordPress-specific protection. Default is `false`.
- **protect_php_files**: Protect PHP files from direct access. Default is `true`.
- **sanitize_server_tokens**: Hide server information. Default is `true`.
- **xss_protection**: Enable XSS protection. Default is `true`.
- **clickjacking_protection**: Enable clickjacking protection. Default is `true`.
- **mime_sniffing_protection**: Protect against MIME sniffing. Default is `true`.
- **request_rate_limiting**: Enable rate limiting. Default is `true`.
- **security_headers**: Enable security headers. Default is `true`.
- **custom_document_root**: Custom document root path. Default is an empty string.
- **image_placeholder**: Path to default image placeholder. Default is an empty string.
- **custom_rules**: Array of custom htaccess rules. Default is an empty array.
- **ip_blacklist**: List of IPs to block. Default is an empty array.
- **ip_whitelist**: List of IPs to allow. Default is an empty array.
- **country_blacklist**: List of country codes to block. Default is an empty array.
- **max_requests_per_second**: Maximum requests per second per IP. Default is `10`.
- **error_pages**: Custom error pages for HTTP status codes 400, 401, 403, 404, and 500. Default is `null` for each.

## Usage

To use this generator, configure the options in the `ajax.php` file and submit the form. The generated `.htaccess` content will be returned in the response.

# .htaccess Generator - Configuration File Usage

This enhanced version of the .htaccess generator uses PHP configuration files and a command-line script for easy automation and version control.

## Quick Start

### 1. Setup Files

Ensure you have these files in your project:
```
your-project/
├── config.php                    # Your configuration file
├── generate-htaccess.php          # Command-line script
├── src/
│   └── HtaccessGenerator.php      # Enhanced generator class
├── example-config.php             # Example configuration
└── .htaccess                      # Generated output file
```

### 2. Create Your Configuration

Copy the example configuration:
```bash
cp example-config.php my-config.php
```

Edit `my-config.php` with your settings:
```php
<?php
return [
    'htaccess_config' => [
        'domain' => 'yourwebsite.com',
        'force_https' => true,
        'security_headers' => true,
        // ... more settings
    ]
];
```

### 3. Generate .htaccess File

Run the generator:
```bash
# Use default config.php and output to .htaccess
php generate-htaccess.php

# Use custom config file
php generate-htaccess.php my-config.php

# Use custom config and output file
php generate-htaccess.php my-config.php output/.htaccess
```

## Configuration Options

### Basic Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `domain` | string | `''` | Your website's main domain |
| `cdn_domains` | array | `[]` | List of CDN domains for CSP |
| `cors_domains` | array | `[]` | Domains allowed for CORS requests |

### Security Features

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `force_https` | boolean | `true` | Redirect HTTP to HTTPS |
| `security_headers` | boolean | `true` | Add security headers |
| `content_security_policy` | boolean | `true` | Enable CSP protection |
| `block_bad_bots` | boolean | `true` | Block malicious crawlers |
| `request_rate_limiting` | boolean | `true` | Limit requests per IP |
| `max_requests_per_second` | integer | `10` | Max requests per IP per second |

### Performance Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `compression` | boolean | `true` | Enable Gzip compression |
| `enable_caching` | boolean | `false` | Set browser cache headers |
| `cache_html_duration` | string | `'1 month'` | HTML cache duration |
| `cache_images_duration` | string | `'1 year'` | Image cache duration |
| `use_webp` | boolean | `true` | Enable WebP image support |

### Access Control

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `ip_blacklist` | array | `[]` | IPs to block |
| `ip_whitelist` | array | `[]` | IPs to allow (blocks all others) |
| `country_blacklist` | array | `[]` | Country codes to block |

### URL Management

| Option | Type | Values | Description |
|--------|------|--------|-------------|
| `www_redirection` | string | `'none'`, `'www'`, `'non-www'` | WWW redirection preference |
| `pretty_urls` | boolean | `false` | Remove file extensions from URLs |
| `redirect_management_enabled` | boolean | `false` | Enable custom redirects |
| `redirect_list` | array | `[]` | List of redirects |

### File Protection

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `protect_sensitive_files` | boolean | `true` | Protect config files, logs, etc. |
| `file_upload_protection` | boolean | `true` | Block dangerous file uploads |
| `protect_wp_admin` | boolean | `false` | WordPress admin protection |
| `hotlink_protection_enabled` | boolean | `false` | Prevent image hotlinking |

## Advanced Configuration Examples

### High-Security Website
```php
return [
    'htaccess_config' => [
        'domain' => 'secure-site.com',
        'force_https' => true,
        'security_headers' => true,
        'additional_security_headers' => true,
        'content_security_policy' => true,
        'request_rate_limiting' => true,
        'max_requests_per_second' => 5,
        'ip_blacklist' => ['192.168.1.100', '10.0.0.0/8'],
        'country_blacklist' => ['CN', 'RU'],
        'ssl_requirements' => [
            'min_version' => 'TLSv1.3',
            'enforce_hsts' => true,
            'hsts_max_age' => 63072000, // 2 years
            'include_subdomains' => true,
            'preload' => true
        ]
    ]
];
```

### Performance-Optimized Website
```php
return [
    'htaccess_config' => [
        'domain' => 'fast-site.com',
        'compression' => true,
        'enable_gzip_compression' => true,
        'enable_caching' => true,
        'cache_html_duration' => '1 week',
        'cache_images_duration' => '1 year',
        'cache_css_duration' => '6 months',
        'cache_js_duration' => '6 months',
        'use_webp' => true,
        'cdn_domains' => [
            'cdn1.fast-site.com',
            'cdn2.fast-site.com',
            'images.fast-site.com'
        ]
    ]
];
```

### WordPress Website
```php
return [
    'htaccess_config' => [
        'domain' => 'myblog.com',
        'force_https' => true,
        'protect_wp_admin' => true,
        'protect_sensitive_files' => true,
        'block_php_upload_exec' => true,
        'pretty_urls' => true,
        'www_redirection' => 'non-www',
        'ip_whitelist' => ['203.0.113.50'], // Admin IP only for wp-admin
        'error_pages' => [
            '404' => '/404.php'
        ]
    ]
];
```

### E-commerce Website
```php
return [
    'htaccess_config' => [
        'domain' => 'mystore.com',
        'force_https' => true,
        'security_headers' => true,
        'content_security_policy' => true,
        'cors_headers' => true,
        'cors_domains' => ['api.mystore.com', 'checkout.mystore.com'],
        'ssl_requirements' => [
            'min_version' => 'TLSv1.2',
            'enforce_hsts' => true,
            'hsts_max_age' => 31536000
        ],
        'custom_mime_types_enabled' => true,
        'custom_mime_types' => [
            '.json application/json',
            '.webp image/webp'
        ],
        'redirect_management_enabled' => true,
        'redirect_list' => [
            '/old-shop /shop 301',
            '/products/old-category /products/new-category 301'
        ]
    ]
];
```

## Command Line Options

### Basic Usage
```bash
# Generate with default settings
php generate-htaccess.php

# Use specific config file
php generate-htaccess.php production-config.php

# Specify output location
php generate-htaccess.php config.php /var/www/html/.htaccess
```

### Advanced Usage
```bash
# Development environment
php generate-htaccess.php dev-config.php dev/.htaccess

# Production environment
php generate-htaccess.php prod-config.php dist/.htaccess

# Staging environment
php generate-htaccess.php staging-config.php staging/.htaccess
```

## Validation and Error Handling

The generator includes comprehensive validation:

- **IP Address Validation**: Checks blacklist/whitelist IPs
- **Domain Format Validation**: Validates domain names
- **Country Code Validation**: Ensures 2-letter ISO codes
- **Redirect Format Validation**: Validates redirect syntax
- **File Path Validation**: Checks error page paths

If validation fails, the script will show detailed error messages:

```bash
❌ Configuration validation failed:
   • Invalid IP address in blacklist: 999.999.999.999
   • Invalid country code: USA (must be 2-letter ISO code)
   • Invalid redirect format: /old /new (should be 'old_url new_url redirect_code')
```

## Integration with Version Control

### Git Integration
Add these to your `.gitignore`:
```gitignore
# Include config templates but not actual configs
config.php
*-config.php
!example-config.php

# Generated files
.htaccess
```

### Environment-Specific Configs
```bash
config/
├── base-config.php         # Shared settings
├── development-config.php  # Dev-specific settings
├── staging-config.php      # Staging settings
└── production-config.php   # Production settings
```

### Build Scripts
Create deployment scripts:
```bash
#!/bin/bash
# deploy.sh
ENVIRONMENT=${1:-production}
php generate-htaccess.php "config/${ENVIRONMENT}-config.php" ".htaccess"
echo "Generated .htaccess for $ENVIRONMENT environment"
```

## Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   chmod +x generate-htaccess.php
   chmod 755 src/
   ```

2. **Class Not Found**
   - Ensure `src/HtaccessGenerator.php` exists
   - Check file permissions
   - Verify namespace declarations

3. **Invalid Configuration**
   - Check array syntax in config file
   - Validate boolean values (true/false)
   - Ensure required quotes around strings

### Debug Mode
Add debug information to your config:
```php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Best Practices

1. **Security First**: Always enable basic security features
2. **Test Locally**: Test generated .htaccess files in development
3. **Backup**: Keep backups of working .htaccess files
4. **Documentation**: Comment your configuration choices
5. **Version Control**: Track configuration changes
6. **Environment Separation**: Use different configs for dev/staging/production

## Support

For questions about specific Apache directives, consult the [Apache HTTP Server Documentation](https://httpd.apache.org/docs/).

For issues with this generator, check that your server supports the required Apache modules:
- mod_rewrite
- mod_headers
- mod_deflate
- mod_expires

---

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

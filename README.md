# .htaccess Generator

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.2-blue)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![Composer](https://img.shields.io/badge/Composer-Package-orange)](https://packagist.org)

A comprehensive, security-focused .htaccess generator with advanced configuration options, pretty URLs support, and enterprise-level security features.

## 🚀 Features

- **🔒 Advanced Security**: Content Security Policy, HSTS, XSS protection, rate limiting
- **⚡ Performance Optimization**: Gzip compression, browser caching, WebP support
- **🌐 Pretty URLs**: Multiple routing modes (front-controller, extension-removal, hybrid)
- **🛡️ Access Control**: IP blacklisting/whitelisting, country blocking, bot protection
- **⚙️ Highly Configurable**: PHP configuration files with validation
- **🖥️ CLI Tool**: Command-line interface with colored output and progress tracking
- **📱 Web Interface**: Bootstrap-based form for visual configuration
- **🔄 Multiple Formats**: Support for various deployment scenarios

## 📦 Installation

### Via Composer (Recommended)

```bash
composer require yobuild/htaccess-generator
```

### Manual Installation

```bash
git clone https://github.com/YoBuild/htaccess-generator.git
cd htaccess-generator
```

## 🎯 Quick Start

### 1. CLI Usage (Recommended)

```bash
# Using Composer
vendor/bin/generate-htaccess examples/simple-config.php .htaccess

# Using Composer scripts
composer run generate examples/simple-config.php .htaccess

# Manual usage
php bin/generate-htaccess examples/simple-config.php .htaccess
```

### 2. PHP Code Usage

```php
<?php
require_once 'vendor/autoload.php';

use YoBuild\Generators\HtaccessGenerator;

$config = [
	'domain' => 'mywebsite.com',
	'force_https' => true,
	'security_headers' => true,
	'pretty_urls' => true,
	'pretty_urls_config' => [
		'handler_file' => 'index.php',
		'mode' => 'front-controller'
	]
];

$generator = new HtaccessGenerator($config);
$htaccessContent = $generator->generate();

// Save to file
$generator->saveToFile('.htaccess');
```

### 3. Web Interface Usage

1. Open `index.html` in your web browser
2. Configure options using the Bootstrap form interface
3. Click "Generate .htaccess" to create your configuration
4. Copy the generated content to your `.htaccess` file

## 📋 Configuration Options

### Basic Configuration

```php
return [
	'htaccess_config' => [
		// Essential settings
		'domain' => 'mywebsite.com',
		'force_https' => true,
		'security_headers' => true,
		'compression' => true,

		// CDN and CORS
		'cdn_domains' => ['cdn.mywebsite.com', 'assets.mywebsite.com'],
		'cors_domains' => ['api.mywebsite.com', 'app.mywebsite.com'],

		// Performance
		'enable_caching' => true,
		'cache_html_duration' => '1 week',
		'cache_images_duration' => '1 year',
		'use_webp' => true,

		// Security
		'block_bad_bots' => true,
		'request_rate_limiting' => true,
		'max_requests_per_second' => 15,
	]
];
```

### Pretty URLs Configuration

The generator supports three routing modes for pretty URLs:

#### Front Controller (Most Common)
```php
'pretty_urls' => true,
'pretty_urls_config' => [
	'handler_file' => 'index.php',
	'mode' => 'front-controller',
	'excluded_directories' => ['assets', 'css', 'js', 'images', 'uploads'],
	'url_parameter_name' => 'url' // $_GET['url'] contains the path
]
```

**Generated Rewrite Rules:**
```apache
RewriteCond %{REQUEST_URI} !^/(assets|css|js|images|uploads)(/.*)?$ [NC]
RewriteCond %{REQUEST_URI} !\.(css|js|png|jpg|jpeg|gif|ico|txt|xml|json)$ [NC]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**URL Examples:**
- `/about` → `index.php?url=about`
- `/blog/post-title` → `index.php?url=blog/post-title`
- `/contact?message=hello` → `index.php?url=contact&message=hello`

#### Extension Removal
```php
'pretty_urls_config' => [
	'mode' => 'extension-removal' // Remove .php/.html extensions
]
```

#### Hybrid Mode
```php
'pretty_urls_config' => [
	'mode' => 'both' // Combines front-controller and extension-removal
]
```

### Security Configuration

```php
'security_headers' => true,
'content_security_policy' => true,
'cors_headers' => true,
'block_bad_bots' => true,
'protect_sensitive_files' => true,
'file_upload_protection' => true,
'request_rate_limiting' => true,
'max_requests_per_second' => 10,

// IP Access Control
'ip_blacklist' => ['192.168.1.100', '10.0.0.0/8'],
'ip_whitelist' => ['203.0.113.50'], // Restrictive - only these IPs allowed
'country_blacklist' => ['CN', 'RU'], // Block by country (requires GeoIP)

// SSL/TLS Configuration
'ssl_requirements' => [
	'min_version' => 'TLSv1.3',
	'enforce_hsts' => true,
	'hsts_max_age' => 31536000,
	'include_subdomains' => true,
	'preload' => true
]
```

## 📖 Configuration Examples

### Simple Website
```php
return [
	'htaccess_config' => [
		'domain' => 'mywebsite.com',
		'force_https' => true,
		'security_headers' => true,
		'compression' => true,
		'www_redirection' => 'non-www'
	]
];
```

### Modern Framework (Laravel/Symfony Style)
```php
return [
	'htaccess_config' => [
		'domain' => 'myapp.com',
		'pretty_urls' => true,
		'pretty_urls_config' => [
			'handler_file' => 'public/index.php', // Framework structure
			'mode' => 'front-controller',
			'excluded_directories' => ['assets', 'vendor', 'storage'],
			'url_parameter_name' => 'pathinfo'
		],
		'force_https' => true,
		'security_headers' => true
	]
];
```

### High-Security Website
```php
return [
	'htaccess_config' => [
		'domain' => 'secure-site.com',
		'force_https' => true,
		'security_headers' => true,
		'additional_security_headers' => true,
		'request_rate_limiting' => true,
		'max_requests_per_second' => 5,
		'ip_blacklist' => ['192.168.1.100'],
		'country_blacklist' => ['CN', 'RU'],
		'ssl_requirements' => [
			'min_version' => 'TLSv1.3',
			'enforce_hsts' => true,
			'hsts_max_age' => 63072000 // 2 years
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
		'www_redirection' => 'non-www',
		'error_pages' => ['404' => '/404.php']
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
		'cors_headers' => true,
		'cors_domains' => ['api.mystore.com', 'checkout.mystore.com'],
		'ssl_requirements' => [
			'min_version' => 'TLSv1.2',
			'enforce_hsts' => true
		],
		'redirect_management_enabled' => true,
		'redirect_list' => [
			'/old-shop /shop 301',
			'/products/old-category /products/new-category 301'
		]
	]
];
```

## 🖥️ CLI Tool Features

The command-line tool provides rich output with validation and progress tracking:

```bash
🚀 Starting .htaccess generation...

📁 Loading configuration from: examples/config.php
✅ Configuration loaded successfully!
🔍 Validating configuration...
✅ Configuration is valid!

📋 Configuration Summary:
─────────────────────────
Domain              : mywebsite.com
Force HTTPS         : ✅ Yes
Security Headers    : ✅ Enabled
Pretty URLs         : ✅ Enabled (front-controller → index.php)
Rate Limiting       : ✅ Enabled (15 req/sec)
WWW Redirection     : non-www
CDN Domains         : ✅ 2 domains

⚙️  Generating .htaccess content...
✅ .htaccess content generated successfully!
💾 Writing to file: .htaccess
✅ File written successfully!

🎉 Generation completed successfully!
─────────────────────────────────
📄 Output file: .htaccess
📊 File size: 4.2 KB
📝 Lines: 156

📖 Preview (first 15 lines):
─────────────────────────
 1: # Generated by Enhanced .htaccess Generator
 2: # Generated on: 2025-07-11 15:30:45 UTC
 3: # Domain: mywebsite.com
 4:
 5: # Hide server information
 6: ServerSignature Off
 7: ServerTokens Prod
 8:
 9: # ================================
10: # BASIC APACHE OPTIONS
11: # ================================
12: Options -Indexes -MultiViews
13:
14: # Force UTF-8 encoding
15: AddDefaultCharset utf-8
... (and 141 more lines)

✨ .htaccess file is ready for deployment!
```

### CLI Command Options

```bash
# Help
vendor/bin/generate-htaccess --help

# Version
vendor/bin/generate-htaccess --version

# Debug mode
vendor/bin/generate-htaccess config.php --debug

# Different environments
vendor/bin/generate-htaccess config/development.php dev/.htaccess
vendor/bin/generate-htaccess config/production.php .htaccess
```

## 🔧 Configuration Reference

### Core Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `domain` | string | `''` | Main website domain |
| `force_https` | boolean | `true` | Redirect HTTP to HTTPS |
| `security_headers` | boolean | `true` | Add security headers |
| `compression` | boolean | `true` | Enable Gzip compression |
| `enable_caching` | boolean | `false` | Set browser cache headers |

### Pretty URLs Options

| Option | Type | Values | Description |
|--------|------|--------|-------------|
| `pretty_urls` | boolean | `false` | Enable URL rewriting |
| `mode` | string | `'front-controller'`, `'extension-removal'`, `'both'` | Routing mode |
| `handler_file` | string | `'index.php'` | Front controller file |
| `url_parameter_name` | string | `'url'` | Query parameter name |
| `force_trailing_slash` | boolean | `false` | Add/remove trailing slashes |

### Security Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `content_security_policy` | boolean | `true` | Enable CSP headers |
| `block_bad_bots` | boolean | `true` | Block malicious crawlers |
| `protect_sensitive_files` | boolean | `true` | Protect config files |
| `request_rate_limiting` | boolean | `true` | Limit requests per IP |
| `max_requests_per_second` | integer | `10` | Rate limit threshold |

### Performance Options

| Option | Type | Values | Description |
|--------|------|--------|-------------|
| `cache_html_duration` | string | `'1 month'` | HTML cache duration |
| `cache_images_duration` | string | `'1 year'` | Image cache duration |
| `use_webp` | boolean | `true` | WebP image support |
| `enable_gzip_compression` | boolean | `false` | Alternative Gzip setting |

## 📂 Project Structure

```
yobuild/htaccess-generator/
├── src/
│   └── HtaccessGenerator.php    # Main generator class
├── bin/
│   └── generate-htaccess        # CLI executable
├── examples/
│   ├── config.php               # Full configuration example
│   ├── simple-config.php        # Basic configuration
│   ├── example-config.php       # Detailed example
│   ├── pretty-urls-example.php  # Pretty URLs examples
│   └── my-config.php            # Custom configuration
├── index.html                   # Web interface
├── ajax.php                     # Web interface backend
├── composer.json                # Composer configuration
├── .editorconfig               # Code style configuration
├── .gitignore                  # Git ignore rules
├── LICENSE                     # MIT license
└── README.md                   # This file
```

## 🛠️ Integration Examples

### Router Implementation (index.php)

```php
<?php
// Get the requested URL from pretty URLs
$requestPath = $_GET['url'] ?? '';
$requestPath = trim($requestPath, '/');

// Define routes
$routes = [
	'' => 'pages/home.php',
	'about' => 'pages/about.php',
	'contact' => 'pages/contact.php',
	'blog' => 'pages/blog.php',
	'blog/(.+)' => 'pages/blog-post.php'
];

// Route matching
foreach ($routes as $pattern => $file) {
	if ($pattern === $requestPath) {
		include $file;
		exit;
	}

	// Regex patterns
	if (preg_match("#^{$pattern}$#", $requestPath, $matches)) {
		$_ROUTE_PARAMS = array_slice($matches, 1);
		include $file;
		exit;
	}
}

// 404 fallback
http_response_code(404);
include 'pages/404.php';
```

### Environment-Specific Deployment

```bash
#!/bin/bash
# deploy.sh
ENVIRONMENT=${1:-production}

echo "Deploying for $ENVIRONMENT environment..."
vendor/bin/generate-htaccess "config/${ENVIRONMENT}.php" ".htaccess"
echo "✅ .htaccess generated for $ENVIRONMENT"

# Upload to server
if [ "$ENVIRONMENT" = "production" ]; then
	rsync -av .htaccess user@server:/var/www/html/
fi
```

## 🔍 Validation and Error Handling

The generator includes comprehensive validation:

- **Domain Format**: Validates domain name syntax
- **IP Addresses**: Validates IPv4/IPv6 and CIDR notation
- **Country Codes**: Ensures 2-letter ISO country codes
- **File Paths**: Validates error page and handler file paths
- **Configuration Syntax**: Checks array structure and types

Example validation output:
```bash
❌ Configuration validation failed:
   • Invalid IP address in blacklist: 999.999.999.999
   • Invalid country code: USA (must be 2-letter ISO code)
   • pretty_urls_config.handler_file must be a valid PHP file path
```

## 🔧 Advanced Features

### Custom MIME Types
```php
'custom_mime_types_enabled' => true,
'custom_mime_types' => [
	'.json application/json',
	'.webp image/webp',
	'.woff2 font/woff2'
]
```

### Hotlink Protection
```php
'hotlink_protection_enabled' => true,
'hotlink_protection_list' => [
	'trusted-partner.com',
	'affiliate-site.com'
]
```

### Custom Error Pages
```php
'error_pages' => [
	'404' => '/errors/404.html',
	'500' => '/errors/500.html',
	'403' => '/errors/forbidden.html'
]
```

### Custom .htaccess Rules
```php
'custom_rules' => [
	'# Custom API rate limiting',
	'<LocationMatch "^/api/">',
	'    SetEnvIf Request_URI "^/api/" api_request',
	'</LocationMatch>'
]
```

## 🚀 Best Practices

1. **Security First**: Always enable basic security features
2. **Test Locally**: Test generated `.htaccess` files in development
3. **Backup**: Keep backups of working `.htaccess` files
4. **Environment Separation**: Use different configs for dev/staging/production
5. **Version Control**: Track configuration changes in git
6. **Documentation**: Comment your configuration choices

## 🧪 Testing

Test your generated `.htaccess` file:

```bash
# Check Apache syntax
apache2ctl configtest

# Test specific URLs
curl -I https://yourdomain.com/test-url

# Check security headers
curl -I https://yourdomain.com/
```

## 📋 Requirements

- **PHP**: 8.2 or higher
- **Apache Modules**: mod_rewrite, mod_headers, mod_deflate, mod_expires
- **Composer**: For package installation (optional)

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Follow the coding standards (tabs, PHP 8.2+, OOP)
4. Add tests for new features
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Documentation**: Check this README and example configurations
- **Issues**: [GitHub Issues](https://github.com/YoBuild/htaccess-generator/issues)
- **Apache Docs**: [Apache HTTP Server Documentation](https://httpd.apache.org/docs/)

## 🔗 Related Resources

- [Apache mod_rewrite Documentation](https://httpd.apache.org/docs/current/mod/mod_rewrite.html)
- [Content Security Policy Guide](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)
- [HTTP Security Headers](https://owasp.org/www-project-secure-headers/)

---

Made with ❤️ by [Yohn](https://github.com/Yohn) | [YoBuild](https://github.com/YoBuild)
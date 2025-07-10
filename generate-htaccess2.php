<?php

/**
 * Command Line .htaccess Generator Script
 *
 * Usage:
 *   php generate-htaccess.php [config-file] [output-file]
 *
 * Examples:
 *   php generate-htaccess.php config.php .htaccess
 *   php generate-htaccess.php custom-config.php output/.htaccess
 *   php generate-htaccess.php (uses config.php and outputs to .htaccess)
 */

declare(strict_types=1);

require_once __DIR__ . '/src/HtaccessGenerator.php';

use Yohns\Generators\HtaccessGenerator;

/**
 * Display usage information
 */
function displayUsage(): void
{
	echo "\n";
	echo "╔══════════════════════════════════════════════════════════════╗\n";
	echo "║                    .htaccess Generator                       ║\n";
	echo "╠══════════════════════════════════════════════════════════════╣\n";
	echo "║ Usage: php generate-htaccess2.php [config-file] [output-file] ║\n";
	echo "║                                                              ║\n";
	echo "║ Arguments:                                                   ║\n";
	echo "║   config-file  : Path to configuration file (default: config.php) ║\n";
	echo "║   output-file  : Path to output file (default: .htaccess)   ║\n";
	echo "║                                                              ║\n";
	echo "║ Examples:                                                    ║\n";
	echo "║   php generate-htaccess2.php                                  ║\n";
	echo "║   php generate-htaccess2.php config.php                      ║\n";
	echo "║   php generate-htaccess2.php config.php .htaccess            ║\n";
	echo "║   php generate-htaccess2.php custom.php output/.htaccess     ║\n";
	echo "╚══════════════════════════════════════════════════════════════╝\n";
	echo "\n";
}

/**
 * Display colored console output
 */
function colorOutput(string $text, string $color = 'white'): void
{
	$colors = [
		'red'     => "\033[31m",
		'green'   => "\033[32m",
		'yellow'  => "\033[33m",
		'blue'    => "\033[34m",
		'magenta' => "\033[35m",
		'cyan'    => "\033[36m",
		'white'   => "\033[37m",
		'reset'   => "\033[0m"
	];

	echo $colors[$color] . $text . $colors['reset'];
}

/**
 * Load and validate configuration file
 */
function loadConfig(string $configFile): array
{
	if (!file_exists($configFile)) {
		colorOutput("❌ Error: Configuration file '$configFile' not found!\n", 'red');
		exit(1);
	}

	$config = require $configFile;

	if (!is_array($config)) {
		colorOutput("❌ Error: Configuration file must return an array!\n", 'red');
		exit(1);
	}

	if (!isset($config['htaccess_config'])) {
		colorOutput("❌ Error: Configuration must contain 'htaccess_config' key!\n", 'red');
		exit(1);
	}

	return $config['htaccess_config'];
}

/**
 * Process string arrays (convert comma-separated strings to arrays)
 */
function processStringArrays(array $config): array
{
	$arrayFields = [
		'cdn_domains',
		'cors_domains',
		'ip_blacklist',
		'ip_whitelist',
		'country_blacklist',
		'access_control_list',
		'custom_mime_types',
		'redirect_list',
		'hotlink_protection_list',
		'custom_rules'
	];

	foreach ($arrayFields as $field) {
		if (isset($config[$field]) && is_string($config[$field])) {
			$config[$field] = array_filter(
				array_map('trim', explode(',', $config[$field])),
				fn($item) => !empty($item)
			);
		}
	}

	return $config;
}

/**
 * Validate configuration values
 */
function validateConfig(array $config): array
{
	$errors = [];

	// Validate www_redirection
	if (isset($config['www_redirection']) &&
		!in_array($config['www_redirection'], ['none', 'www', 'non-www'])) {
		$errors[] = "www_redirection must be 'none', 'www', or 'non-www'";
	}

	// Validate ssl_forcing
	if (isset($config['ssl_forcing']) &&
		!in_array($config['ssl_forcing'], ['none', 'entire-site', 'specific-sections'])) {
		$errors[] = "ssl_forcing must be 'none', 'entire-site', or 'specific-sections'";
	}

	// Validate cache durations
	$validDurations = ['1 day', '1 week', '1 month', '6 months', '1 year'];
	$durationFields = ['cache_html_duration', 'cache_images_duration', 'cache_css_duration', 'cache_js_duration'];

	foreach ($durationFields as $field) {
		if (isset($config[$field]) && !in_array($config[$field], $validDurations)) {
			$errors[] = "$field must be one of: " . implode(', ', $validDurations);
		}
	}

	// Validate max_requests_per_second
	if (isset($config['max_requests_per_second']) &&
		(!is_numeric($config['max_requests_per_second']) || $config['max_requests_per_second'] < 1)) {
		$errors[] = "max_requests_per_second must be a positive integer";
	}

	// Validate SSL requirements
	if (isset($config['ssl_requirements'])) {
		if (isset($config['ssl_requirements']['min_version']) &&
			!in_array($config['ssl_requirements']['min_version'], ['TLSv1.2', 'TLSv1.3'])) {
			$errors[] = "ssl_requirements.min_version must be 'TLSv1.2' or 'TLSv1.3'";
		}

		if (isset($config['ssl_requirements']['hsts_max_age']) &&
			(!is_numeric($config['ssl_requirements']['hsts_max_age']) || $config['ssl_requirements']['hsts_max_age'] < 1)) {
			$errors[] = "ssl_requirements.hsts_max_age must be a positive integer";
		}
	}

	return $errors;
}

/**
 * Display configuration summary
 */
function displayConfigSummary(array $config): void
{
	colorOutput("\n📋 Configuration Summary:\n", 'cyan');
	colorOutput("─────────────────────────\n", 'blue');

	$summary = [
		'Domain' => $config['domain'] ?? 'Not set',
		'Force HTTPS' => ($config['force_https'] ?? false) ? '✅ Yes' : '❌ No',
		'Security Headers' => ($config['security_headers'] ?? false) ? '✅ Enabled' : '❌ Disabled',
		'Compression' => ($config['compression'] ?? false) ? '✅ Enabled' : '❌ Disabled',
		'Pretty URLs' => ($config['pretty_urls'] ?? false) ?
			'✅ Enabled (' . ($config['pretty_urls_config']['mode'] ?? 'front-controller') .
			' → ' . ($config['pretty_urls_config']['handler_file'] ?? 'index.php') . ')' : '❌ Disabled',
		'Rate Limiting' => ($config['request_rate_limiting'] ?? false) ?
			'✅ Enabled (' . ($config['max_requests_per_second'] ?? 10) . ' req/sec)' : '❌ Disabled',
		'WWW Redirection' => $config['www_redirection'] ?? 'none',
		'IP Blacklist' => !empty($config['ip_blacklist']) ?
			'✅ ' . count($config['ip_blacklist']) . ' IPs blocked' : '❌ None',
		'CDN Domains' => !empty($config['cdn_domains']) ?
			'✅ ' . count($config['cdn_domains']) . ' domains' : '❌ None',
		'Custom Rules' => !empty($config['custom_rules']) ?
			'✅ ' . count($config['custom_rules']) . ' rules' : '❌ None'
	];

	foreach ($summary as $key => $value) {
		printf("%-20s: %s\n", $key, $value);
	}

	echo "\n";
}

/**
 * Main execution function
 */
function main(): void
{
	global $argv;

	// Parse command line arguments
	$configFile = $argv[1] ?? 'config.php';
	$outputFile = $argv[2] ?? '.htaccess';

	// Display header
	colorOutput("🚀 Starting .htaccess generation...\n\n", 'green');

	// Load configuration
	colorOutput("📁 Loading configuration from: $configFile\n", 'yellow');
	try {
		$config = loadConfig($configFile);
		colorOutput("✅ Configuration loaded successfully!\n", 'green');
	} catch (Exception $e) {
		colorOutput("❌ Failed to load configuration: " . $e->getMessage() . "\n", 'red');
		exit(1);
	}

	// Process string arrays
	$config = processStringArrays($config);

	// Validate configuration
	colorOutput("🔍 Validating configuration...\n", 'yellow');
	$errors = validateConfig($config);

	if (!empty($errors)) {
		colorOutput("❌ Configuration validation failed:\n", 'red');
		foreach ($errors as $error) {
			colorOutput("   • $error\n", 'red');
		}
		exit(1);
	}

	colorOutput("✅ Configuration is valid!\n", 'green');

	// Display configuration summary
	displayConfigSummary($config);

	// Generate .htaccess content
	colorOutput("⚙️  Generating .htaccess content...\n", 'yellow');
	try {
		$generator = new HtaccessGenerator($config);

		// Validate config using generator's validation
		$generatorErrors = $generator->validateConfig();
		if (!empty($generatorErrors)) {
			colorOutput("❌ Generator validation failed:\n", 'red');
			foreach ($generatorErrors as $error) {
				colorOutput("   • $error\n", 'red');
			}
			exit(1);
		}

		$htaccessContent = $generator->generate();
		colorOutput("✅ .htaccess content generated successfully!\n", 'green');
	} catch (Exception $e) {
		colorOutput("❌ Failed to generate .htaccess: " . $e->getMessage() . "\n", 'red');
		exit(1);
	}

	// Create output directory if it doesn't exist
	$outputDir = dirname($outputFile);
	if ($outputDir !== '.' && !is_dir($outputDir)) {
		colorOutput("📁 Creating output directory: $outputDir\n", 'yellow');
		if (!mkdir($outputDir, 0755, true)) {
			colorOutput("❌ Failed to create output directory!\n", 'red');
			exit(1);
		}
	}

	// Write to file
	colorOutput("💾 Writing to file: $outputFile\n", 'yellow');
	try {
		if (file_put_contents($outputFile, $htaccessContent) === false) {
			throw new Exception("Failed to write file");
		}
		colorOutput("✅ File written successfully!\n", 'green');
	} catch (Exception $e) {
		colorOutput("❌ Failed to write file: " . $e->getMessage() . "\n", 'red');
		exit(1);
	}

	// Display completion summary
	$fileSize = filesize($outputFile);
	$lineCount = substr_count($htaccessContent, "\n") + 1;

	colorOutput("\n🎉 Generation completed successfully!\n", 'green');
	colorOutput("─────────────────────────────────\n", 'blue');
	colorOutput("📄 Output file: $outputFile\n", 'cyan');
	colorOutput("📊 File size: " . formatBytes($fileSize) . "\n", 'cyan');
	colorOutput("📝 Lines: $lineCount\n", 'cyan');

	// Display preview
	colorOutput("\n📖 Preview (first 15 lines):\n", 'magenta');
	colorOutput("─────────────────────────\n", 'blue');
	$lines = explode("\n", $htaccessContent);
	for ($i = 0; $i < min(15, count($lines)); $i++) {
		printf("%2d: %s\n", $i + 1, $lines[$i]);
	}

	if (count($lines) > 15) {
		colorOutput("... (and " . (count($lines) - 15) . " more lines)\n", 'blue');
		colorOutput("\n💡 Tip: View the complete file with: cat $outputFile\n", 'yellow');
	}

	colorOutput("\n✨ .htaccess file is ready for deployment!\n", 'green');

	// Display deployment tips
	colorOutput("📋 Next Steps:\n", 'cyan');
	colorOutput("1. Review the generated file: cat $outputFile\n", 'white');
	colorOutput("2. Test in a development environment first\n", 'white');
	colorOutput("3. Backup your existing .htaccess file\n", 'white');
	colorOutput("4. Upload to your web server's document root\n", 'white');
	colorOutput("5. Test your website functionality\n\n", 'white');
}

/**
 * Format bytes into human readable format
 */
function formatBytes(int $bytes, int $precision = 2): string
{
	$units = ['B', 'KB', 'MB', 'GB'];

	for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
		$bytes /= 1024;
	}

	return round($bytes, $precision) . ' ' . $units[$i];
}

/**
 * Handle script arguments and help
 */
function handleArguments(): void
{
	global $argv;

	if (isset($argv[1]) && in_array($argv[1], ['-h', '--help', 'help'])) {
		displayUsage();
		exit(0);
	}

	if (isset($argv[1]) && in_array($argv[1], ['-v', '--version', 'version'])) {
		colorOutput("🔧 .htaccess Generator v2.0\n", 'green');
		colorOutput("Enhanced configuration-based generator\n", 'white');
		colorOutput("Built with PHP " . PHP_VERSION . "\n\n", 'blue');
		exit(0);
	}
}

/**
 * Perform system checks
 */
function performSystemChecks(): bool
{
	$errors = [];

	// Check if we're running from command line
	if (php_sapi_name() !== 'cli') {
		$errors[] = "This script must be run from the command line!";
	}

	// Check PHP version
	if (version_compare(PHP_VERSION, '8.2.0', '<')) {
		$errors[] = "PHP 8.2 or higher is required. Current version: " . PHP_VERSION;
	}

	// Check if HtaccessGenerator class exists
	if (!file_exists(__DIR__ . '/src/HtaccessGenerator.php')) {
		$errors[] = "HtaccessGenerator class file not found: src/HtaccessGenerator.php";
	}

	// Check write permissions
	if (!is_writable('.')) {
		$errors[] = "Current directory is not writable. Please check permissions.";
	}

	if (!empty($errors)) {
		colorOutput("❌ System Check Failed:\n", 'red');
		foreach ($errors as $error) {
			colorOutput("   • $error\n", 'red');
		}
		return false;
	}

	return true;
}

/**
 * Display startup banner
 */
function displayBanner(): void
{
	colorOutput("\n", 'white');
	colorOutput("╔════════════════════════════════════════════════════════════════╗\n", 'blue');
	colorOutput("║                      .htaccess Generator                       ║\n", 'blue');
	colorOutput("║                    Enhanced Edition v2.0                      ║\n", 'blue');
	colorOutput("╠════════════════════════════════════════════════════════════════╣\n", 'blue');
	colorOutput("║  🔒 Advanced Security  🚀 Performance  ⚙️  Highly Configurable ║\n", 'blue');
	colorOutput("╚════════════════════════════════════════════════════════════════╝\n", 'blue');
	colorOutput("\n", 'white');
}

// ===================================
// MAIN EXECUTION
// ===================================

try {
	// Handle help and version flags
	handleArguments();

	// Display banner
	displayBanner();

	// Perform system checks
	if (!performSystemChecks()) {
		exit(1);
	}

	// Check if HtaccessGenerator class is available
	if (!class_exists('Yohns\Generators\HtaccessGenerator')) {
		colorOutput("❌ HtaccessGenerator class not found!\n", 'red');
		colorOutput("   Please ensure src/HtaccessGenerator.php exists and is accessible.\n", 'yellow');
		colorOutput("   Current working directory: " . getcwd() . "\n", 'yellow');
		exit(1);
	}

	// Run the main function
	main();

} catch (Throwable $e) {
	colorOutput("\n❌ Unexpected error occurred:\n", 'red');
	colorOutput("   Message: " . $e->getMessage() . "\n", 'red');
	colorOutput("   File: " . $e->getFile() . "\n", 'yellow');
	colorOutput("   Line: " . $e->getLine() . "\n", 'yellow');

	if (isset($argv) && in_array('--debug', $argv)) {
		colorOutput("\n🐛 Debug Stack Trace:\n", 'magenta');
		colorOutput($e->getTraceAsString() . "\n", 'yellow');
	} else {
		colorOutput("\n💡 Run with --debug flag for detailed stack trace\n", 'cyan');
	}

	exit(1);
}
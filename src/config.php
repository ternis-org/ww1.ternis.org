<?php

declare(strict_types=1);

/**
 * Application Configuration for ternis.org
 * Loads .env variables if present, falling back to sensible defaults.
 */

(function () {
    $envFile = dirname(__DIR__) . '/.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines !== false) {
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }
                if (str_contains($line, '=')) {
                    [$key, $val] = explode('=', $line, 2);
                    $key = trim($key);
                    $val = trim($val, " \t\n\r\0\x0B\"'");
                    if (!array_key_exists($key, $_ENV)) {
                        $_ENV[$key] = $val;
                        putenv("{$key}={$val}");
                    }
                }
            }
        }
    }
})();

return [
    'app_name'      => getenv('APP_NAME') ?: 'ternis.org',
    'app_env'       => getenv('APP_ENV') ?: 'production',
    'app_debug'     => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'app_url'       => getenv('APP_URL') ?: 'https://ternis.org',
    'repo_url'      => getenv('REPO_URL') ?: 'https://github.com/ternis-org/ww1.ternis.org',
    'org_github'    => getenv('ORG_GITHUB') ?: 'https://github.com/ternis-org',
    'contact_email' => getenv('CONTACT_EMAIL') ?: 'contact@ternis.dev',
    'edv_email'     => getenv('EDV_EMAIL') ?: 'edv@ternismail.de',
];

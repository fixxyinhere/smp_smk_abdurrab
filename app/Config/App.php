<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Application configuration
 */
class App extends BaseConfig
{
    /**
     * Base site URL
     */
    public string $baseURL = 'http://localhost:8080/';

    /**
     * Allowed Hostnames in the Site URL other than the hostname in the baseURL.
     * If you want to accept multiple Hostnames, set this.
     *
     * E.g.,
     * When your site URL ($baseURL) is 'http://example.com/', and your site
     * also accepts 'http://media.example.com/' and
     * 'http://accounts.example.com/':
     *   ['media.example.com', 'accounts.example.com']
     *
     * @var string[]
     */
    public array $allowedHostnames = [];

    /**
     * Index File
     */
    public string $indexPage = '';

    /**
     * URI PROTOCOL
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * Default Locale
     */
    public string $defaultLocale = 'en';

    /**
     * Negotiate Locale
     */
    public bool $negotiateLocale = false;

    /**
     * Supported Locales
     */
    public array $supportedLocales = ['en'];

    /**
     * Application Timezone
     */
    public string $appTimezone = 'UTC';

    /**
     * Default Character Set
     */
    public string $charset = 'UTF-8';

    /**
     * Force Global Secure Requests
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * Session Variables
     */
    public array $sessionExpiration = [
        'sessionCookieName'     => 'ci_session',
        'sessionExpiration'     => 7200,
        'sessionSavePath'       => null,
        'sessionMatchIP'        => false,
        'sessionTimeToUpdate'   => 300,
        'sessionRegenerateDestroy' => false,
    ];

    /**
     * Security
     */
    public array $security = [
        'csrfTokenName'  => 'csrf_token_name',
        'csrfHeaderName' => 'X-CSRF-TOKEN',
        'csrfCookieName' => 'csrf_cookie_name',
        'csrfExpire'     => 7200,
        'csrfRegenerate' => true,
        'csrfRedirect'   => true,
        'csrfSameSite'   => 'Lax',
    ];

    /**
     * Reverse Proxy IPs
     */
    public array $proxyIPs = [];

    /**
     * Content Security Policy
     */
    public bool $CSPEnabled = false;
}

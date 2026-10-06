<?php

declare(strict_types=1);

/**
 * Projects Data Repository & Helper Functions for ternis.org
 */

function project_categories(): array
{
    return [
        'infra'   => ['en' => 'Infrastructure & DNS', 'de' => 'Infrastruktur & DNS', 'color' => '#ea580c'],
        'tools'   => ['en' => 'Developer Tools',     'de' => 'Entwickler-Tools',     'color' => '#0284c7'],
        'privacy' => ['en' => 'Privacy & Email',     'de' => 'Privatsphäre & Mail',   'color' => '#16a34a'],
        'hosting' => ['en' => 'Hosting & Storage',   'de' => 'Hosting & Storage',     'color' => '#a855f7'],
    ];
}

function projects_all(?string $lang = null): array
{
    $lang = $lang ?? current_lang();
    $isDe = $lang === 'de';

    return [
        'httpclient' => [
            'slug'        => 'httpclient',
            'title'       => 'httpclient.de',
            'category'    => 'tools',
            'tagline'     => $isDe ? 'Kostenloser Online-HTTP-Client & API-Debugger' : 'Fast Online HTTP Client & REST API Debugger',
            'description' => $isDe
                ? 'Moderner, privatsphärefreundlicher Web-Client für HTTP-Header, REST-Anfragen und Payload-Inspektion. Läuft vollständig ohne Tracking oder Datenspeicherung.'
                : 'Privacy-first online REST client to test endpoints, craft headers, inspect payload responses, and debug webhooks with zero telemetry or tracking.',
            'overview'    => $isDe
                ? 'httpclient.de ist ein schnelles, werbefreies Werkzeug für Entwickler und Sysadmins, um HTTP-Endpunkte, REST-APIs und Webhook-Empfänger direkt im Browser zu testen. Es erfordert keine Registrierung, setzt keine Tracking-Cookies und speichert keinerlei Abfragedaten oder Header auf dem Server.'
                : 'httpclient.de is an ad-free, lightweight utility designed for developers and sysadmins to inspect HTTP endpoints, REST APIs, and webhooks directly in their browser. It requires no user registration, stores zero request payload history, and sets no third-party tracking pixels.',
            'features'    => $isDe ? [
                'Vollständige Unterstützung für alle HTTP-Methoden (GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS)',
                'Detaillierte Analyse von TTFB (Time to First Byte), DNS-Auflösung und TLS-Handshake-Laufzeiten',
                'Echtzeit-Validierung von JSON-, XML- und Form-Data-Payloads',
                'Ein-Klick-Export in native cURL-, Fetch- und Python-Requests-Befehle',
                'Zero-Log-Richtlinie: Header und sensible Tokens verbleiben rein clientseitig',
            ] : [
                'Full support for all standard HTTP verbs (GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS)',
                'Granular latency telemetry: TTFB (Time to First Byte), DNS lookup, and TLS handshake timing',
                'Real-time formatting and syntax highlighting for JSON, XML, and multipart payloads',
                'Instant one-click command export to cURL, JavaScript fetch, and Python requests',
                'Zero-retention architecture: API tokens and payloads never touch persistent server disks',
            ],
            'specs'       => [
                'Stack'       => 'PHP 8, Vanilla JavaScript, Clean CSS',
                'Hosting'     => 'European Datacenter (Frankfurt am Main, DE)',
                'Protocols'   => 'HTTP/2, HTTP/3 (QUIC), TLS 1.3',
                'Networking'  => 'Dual-Stack IPv4 & Native IPv6',
                'License'     => 'Open Source / MIT',
            ],
            'snippet_label'=> 'cURL Request Example',
            'snippet'     => "curl -X POST https://httpclient.de/api/inspect \\\n  -H \"Content-Type: application/json\" \\\n  -d '{\"service\": \"ternis.org\", \"test\": true}'",
            'tags'        => ['REST API', 'HTTP Client', 'Zero Telemetry', 'Developer Tool', 'TTFB'],
            'url'         => 'https://httpclient.de',
            'repo_url'    => null,
            'related_wiki'=> ['linux-packages/curl', 'networking/reverse-proxy-basics'],
            'status'      => 'Active • Production',
        ],

        'example-dns' => [
            'slug'        => 'example-dns',
            'title'       => 'example-dns (ternis.net)',
            'category'    => 'infra',
            'tagline'     => $isDe ? 'Autonome Anycast-Nameserver (one & two.ns.ternis.net)' : 'Authoritative Anycast Nameserver Backbone',
            'description' => $isDe
                ? 'Geografisch redundantes autoritatives Anycast-DNS-Netzwerk auf one.ns.ternis.net und two.ns.ternis.net mit DNSSEC ECDSA P-256 Validierung.'
                : 'Geographically dispersed Anycast authoritative nameservers running on one.ns.ternis.net and two.ns.ternis.net with full DNSSEC signing.',
            'overview'    => $isDe
                ? 'Das example-dns Projekt stellt die primäre autoritative DNS-Infrastruktur für das gesamte ternis.org- und ternis.net-Netzwerk bereit. Über zwei geografisch getrennte Knoten (Frankfurt und Nürnberg) werden Zonen mit DNSSEC kryptografisch signiert und weltweit ohne Logging ausgeliefert.'
                : 'The example-dns infrastructure forms the authoritative DNS core for ternis.org, ternis.net, and associated ecosystem domains. Utilizing dual redundant nodes in Frankfurt and Nuremberg, the cluster publishes cryptographically signed DNSSEC zones with 100% zero query logging.',
            'features'    => $isDe ? [
                'Dual-Node-Cluster: one.ns.ternis.net (Frankfurt) und two.ns.ternis.net (Nürnberg)',
                'DNSSEC-Signierung mit ECDSA Curve P-256 (Algorithmus 13) und automatischem Key-Rollover',
                'Redundante DNS-Daemons: BIND 9, Knot DNS und NSD zur Eliminierung von Single-Vendor-Bugs',
                'GitOps-gesteuerte Zonendateien mit CI-Syntaxprüfungen vor jedem Commit',
                'Strikte No-Logs-Richtlinie: DNS-Query-Logs werden direkt nach /dev/null geleitet',
            ] : [
                'Dual-node Anycast resilience: one.ns.ternis.net (Frankfurt) and two.ns.ternis.net (Nuremberg)',
                'Automated DNSSEC zone signing using modern ECDSA Curve P-256 (Algorithm 13)',
                'Multi-daemon redundancy (BIND 9, Knot DNS, and NSD) preventing vendor-specific parser exploits',
                'GitOps zone management: all changes linted and verified in CI pipelines before deployment',
                'Strict zero-telemetry policy: all resolver queries piped directly to /dev/null',
            ],
            'specs'       => [
                'Nodes'       => 'one.ns.ternis.net & two.ns.ternis.net',
                'Locations'   => 'Frankfurt am Main (FRA) & Nuremberg (NUE), DE',
                'Software'    => 'BIND 9, Knot DNS, NSD, nftables',
                'DNSSEC'      => 'Algorithm 13 (ECDSAP256SHA256), NSEC3',
                'Transit'     => 'Dual-homed BGP Anycast Uplinks',
            ],
            'snippet_label'=> 'DNS Verification Query',
            'snippet'     => "dig @one.ns.ternis.net ternis.org +dnssec +noall +answer\nhost -t NS ternis.org one.ns.ternis.net",
            'tags'        => ['one.ns.ternis.net', 'two.ns.ternis.net', 'Anycast DNS', 'DNSSEC Alg 13', 'FOSS'],
            'url'         => 'https://example-dns.com',
            'repo_url'    => 'https://github.com/example-dns/example-dns',
            'codeberg'    => 'https://codeberg.org/example-dns/example-dns',
            'related_wiki'=> ['dns/selfhost-authoritative-dns', 'domains/nameserver-glue-delegation', 'dns/dnssec-basics'],
            'status'      => 'Active • Production',
        ],

        'mtex' => [
            'slug'        => 'mtex',
            'title'       => 'MTEX.dev',
            'category'    => 'tools',
            'tagline'     => $isDe ? 'Developer-Utilities & UI-Komponenten' : 'Developer Utilities & UI Components',
            'description' => $isDe
                ? 'Moderne UI-Toolsets, Webkomponenten und Bibliotheken, die Entwicklerprojekte im gesamten Ökosystem antreiben.'
                : 'Modular developer toolsets, lightweight UI components, and software libraries empowering ecosystem applications.',
            'overview'    => $isDe
                ? 'MTEX.dev entwickelt wiederverwendbare, barrierefreie und CSS-optimierte UI-Komponenten und Entwickler-Bibliotheken. Es dient als technische Wiege für Schnittstellen wie getmy.name und DropHTML.'
                : 'MTEX.dev engineers modular, accessible, and ultra-lightweight UI toolsets and developer utilities, stewarding projects like getmy.name and drophtml.de.',
            'features'    => $isDe ? [
                'Schlanke, vanilla CSS- und Web-Component-Architektur ohne schwere Frameworks',
                'Barrierefreiheit nach WCAG 2.1 AA Standards von Grund auf integriert',
                'Hohe Performance mit minimalen Bundle-Größen und ohne Tracking-Skripte',
                'Zentrale Verwaltung von Design-Tokens für konsistente Farbschemata',
            ] : [
                'Zero-dependency UI components and CSS patterns built for maximum rendering speed',
                'Full WCAG 2.1 AA accessibility baked into component interactions and focus states',
                'Sub-10KB bundle footprints without bulky third-party frontend runtimes',
                'Unified token architecture ensuring seamless dark and light mode adaptation',
            ],
            'specs'       => [
                'Stack'       => 'TypeScript, Modern CSS, Web Components, Vite',
                'Standards'   => 'W3C Web Components, WCAG 2.1 AA',
                'License'     => 'Open Source / MIT',
                'Ecosystem'   => 'Powers getmy.name, drophtml.de, and ternis.org',
            ],
            'snippet_label'=> 'Component Import',
            'snippet'     => "import '@mtex/ui/theme.css';\nimport { createButton } from '@mtex/ui';",
            'tags'        => ['Developer Suite', 'UI Tools', 'Open Source', 'FOSS', 'Design Tokens'],
            'url'         => 'https://mtex.dev',
            'docs_url'    => 'https://getmy.name/api-docs',
            'repo_url'    => null,
            'related_wiki'=> ['javascript/modern-es6-features', 'css/css-grid-flexbox'],
            'status'      => 'Active • Production',
        ],

        'getmyname' => [
            'slug'        => 'getmyname',
            'title'       => 'getmy.name',
            'category'    => 'tools',
            'tagline'     => $isDe ? 'Kostenlose Entwickler-Portfolio-API' : 'Free Developer Portfolio & Profile API',
            'description' => $isDe
                ? 'Schlanke JSON/REST API zur Pflege und Bereitstellung strukturierter Entwicklerprofile, Lebensläufe und Projekte.'
                : 'Lightweight headless REST API to query and render developer profiles, public keys, and project portfolios in clean JSON.',
            'overview'    => $isDe
                ? 'getmy.name ermöglicht es Softwareentwicklern und Designern, ihre Profile, GitHub-Repositories, Social-Links und PGP/SSH-Keys in einer sauberen JSON-Struktur abzuspeichern und über eine globale Edge-API in beliebige Webseiten einzubinden.'
                : 'getmy.name is a headless REST profile service that allows developers to maintain their career bio, project links, and public keys in structured JSON, deployable anywhere via a global edge API.',
            'features'    => $isDe ? [
                'Strukturierte JSON-Endpunkte für Bio, Skills, Repositories und PGP-Schlüssel',
                'Schnelle globale Antwortzeiten dank weltweiter Edge-Verteilung',
                'Perfekt geeignet für statische Portfolio-Generatoren (Astro, Next.js, Hugo, 11ty)',
                'Keine Authentifizierungs-Hürden bei öffentlichen Profilabfragen',
            ] : [
                'Clean JSON endpoints exposing developer biographies, tech stacks, and public keys',
                'Sub-50ms global response latencies served from Cloudflare edge nodes',
                'Ideal for headless static site generators (Astro, Next.js, Hugo, Eleventy)',
                'Simple unauthenticated read-access for public developer profile pages',
            ],
            'specs'       => [
                'Format'      => 'REST API / JSON (RFC 8259)',
                'Edge CDN'    => 'Global Anycast Edge Network',
                'Rate Limit'  => 'Generous unauthenticated tier for open-source dev portfolios',
                'Docs'        => 'https://getmy.name/api-docs',
            ],
            'snippet_label'=> 'Fetch Profile Data',
            'snippet'     => "curl -s https://api.getmy.name/v1/u/fabian \\\n  -H \"Accept: application/json\" | jq .",
            'tags'        => ['JSON API', 'Developer Profiles', 'Portfolio API', 'Headless', 'Edge CDN'],
            'url'         => 'https://getmy.name',
            'docs_url'    => 'https://getmy.name/api-docs',
            'repo_url'    => null,
            'related_wiki'=> ['linux-packages/curl', 'php/php-pdo-best-practices'],
            'status'      => 'Active • Production',
        ],

        'websearch' => [
            'slug'        => 'websearch',
            'title'       => 'web-search.org',
            'category'    => 'privacy',
            'tagline'     => $isDe ? 'Selbst-hostbare, privatsphärefreundliche Suchmaschine' : 'Self-Hostable Privacy Meta-Search Engine',
            'description' => $isDe
                ? 'Schnelle Metasuchmaschine ohne Profiling, ohne Werbetracking und ohne Datenweitergabe an Werbenetzwerke.'
                : 'High-speed, privacy-first meta search engine with zero user profiling, no cookie tracking, and zero advertising pixels.',
            'overview'    => $isDe
                ? 'web-search.org schützt die Privatsphäre bei Suchanfragen. Anfragen werden anonymisiert an verschiedene Suchindizes weitergeleitet, Werbetracker werden herausgefiltert und IP-Adressen werden niemals protokolliert.'
                : 'web-search.org provides clean search results without surveillance capitalism. Queries are stripped of tracking parameters, forwarded anonymously, and answered with strict zero user profiling.',
            'features'    => $isDe ? [
                'Keine Cookies, kein Profiling und kein personalisierter Werbe-Algorithmus',
                'Aggregiert Suchergebnisse aus mehreren Quellen für objektive Antworten',
                'Vollständig selbst-hostbar über ein kompaktes Docker-Compose-Setup',
                'OpenSearch-Unterstützung: Lässt sich direkt als Standard-Suchmaschine im Browser hinterlegen',
            ] : [
                'Strict zero-cookie policy and absolute refusal to log user search histories',
                'Aggregates organic results across multiple independent indexes',
                '100% self-hostable using a compact, production-ready Docker Compose file',
                'Native OpenSearch integration: add directly as your browser default search provider',
            ],
            'specs'       => [
                'Privacy'     => '100% Zero-Profiling, No Persistent Search Logs',
                'Hosting'     => 'European Datacenter (GDPR Compliant)',
                'Deployment'  => 'Docker Container / Standalone Reverse Proxy',
                'License'     => 'Open Source / AGPLv3',
            ],
            'snippet_label'=> 'Docker Compose Run',
            'snippet'     => "docker run -d -p 8080:8080 \\\n  --name websearch \\\n  --restart unless-stopped \\\n  ghcr.io/ternis-org/websearch:latest",
            'tags'        => ['Search Engine', 'Privacy First', 'Self-Hostable', 'No Tracking', 'OpenSearch'],
            'url'         => 'https://web-search.org',
            'repo_url'    => null,
            'related_wiki'=> ['selfhosting/docker-compose-basics', 'networking/reverse-proxy-basics'],
            'status'      => 'Active • Production',
        ],

        'mailfree' => [
            'slug'        => 'mailfree',
            'title'       => 'mail-free.eu & mail-free.uk',
            'category'    => 'privacy',
            'tagline'     => $isDe ? 'Wegwerf-E-Mail-Adressen & Souveräne Relays' : 'Disposable Email Inboxes & European Mail Relays',
            'description' => $isDe
                ? 'Automatisch generierte E-Mail-Aliasse und souveräne europäische Mail-Gateways zum Schutz des persönlichen Postfachs vor Spam.'
                : 'Instantly generated disposable mail aliases and sovereign European mail relays keeping your primary inbox spam-free.',
            'overview'    => $isDe
                ? 'mail-free.eu und mail-free.uk bieten temporäre Postfächer und geschützte E-Mail-Aliasse für Registrierungen und Verifizierungen. Das System filtert bösartige Anhänge und Phishing-Versuche aus, bevor Nachrichten dein Hauptpostfach erreichen.'
                : 'mail-free.eu and mail-free.uk provide on-demand disposable email addresses and sovereign forwarding gateways to safeguard personal and business inboxes from marketing scrapers and credential stuffing.',
            'features'    => $isDe ? [
                'Sofort einsatzbereite Alias-Adressen ohne vorherige Registrierung',
                'Strikte Verschlüsselung auf Transportebene (TLS 1.3, DANE / TLSA und MTA-STS)',
                'Integrierter Rspamd-Schutz zur Abwehr von Viren, Phishing und Malware',
                'E-Mail-Weiterleitung mit kryptografischer DKIM-Neusignierung',
            ] : [
                'Instant disposable address generation without requiring passwords or signups',
                'Strict transport encryption enforced via MTA-STS, TLSA (DANE), and modern TLS 1.3',
                'Automated spam and malicious payload filtering powered by Rspamd',
                'Cryptographic forwarding integrity with automated DKIM re-signing',
            ],
            'specs'       => [
                'Jurisdiction' => 'European Union (GDPR) & United Kingdom',
                'Standards'    => 'SPF, DKIM (2048-bit + Ed25519), DMARC (p=reject), MTA-STS',
                'Infrastructure'=> 'Dual-homed Postfix Cluster with _spf.ternis.net',
            ],
            'snippet_label'=> 'Ecosystem SPF Inclusion',
            'snippet'     => "example.com.  IN  TXT  \"v=spf1 include:_spf.ternis.net ~all\"",
            'tags'        => ['Email Privacy', 'Spam Defense', 'EU Sovereign', 'Free', 'MTA-STS'],
            'url'         => 'https://mail-free.eu',
            'url_alt'     => 'https://mail-free.uk',
            'repo_url'    => null,
            'related_wiki'=> ['dns/dns-records-overview', 'linux/ssh-hardening'],
            'status'      => 'Active • Production',
        ],

        'staticre' => [
            'slug'        => 'staticre',
            'title'       => 'static.re',
            'category'    => 'hosting',
            'tagline'     => $isDe ? 'S3 & Cloudflare R2 Speicherplattform' : 'S3 & Cloudflare R2 Object Storage Platform',
            'description' => $isDe
                ? 'Verwaltete Bereitstellungs- und Speicherplattform für S3-kompatible Backends und Cloudflare R2 Object Storage.'
                : 'Software platform and management delivery service for S3-compatible endpoints and Cloudflare R2 object storage.',
            'overview'    => $isDe
                ? 'static.re vereinfacht die Bereitstellung statischer Assets, Builds und Medien über moderne Cloud-Speicher. Es verbindet S3-kompatible Buckets mit schnellem CDN-Caching und automatischem SSL auf eigenen Domains.'
                : 'static.re accelerates object storage delivery by pairing S3-compatible buckets and Cloudflare R2 with global edge caching and automated custom-domain SSL certificates.',
            'features'    => $isDe ? [
                'Kompatibel mit Standard-S3-Tools (AWS CLI, MinIO Client, rclone, s3cmd)',
                'Nahtlose Anbindung an Cloudflare R2 für Null-Egress-Gebühren',
                'Automatisierte HTTP-Header für langes Browser-Caching (Cache-Control immutable)',
                'Integrierte Webhook-Trigger bei neuen Bucket-Uploads',
            ] : [
                'Full compatibility with standard S3 toolchains (AWS CLI, MinIO client, rclone)',
                'Zero-egress cost workflows when connected to Cloudflare R2 storage',
                'Automated immutable asset caching headers for lightning-fast repeated visits',
                'Webhook event triggers for automated cache purging and CI deployments',
            ],
            'specs'       => [
                'Protocol'    => 'Amazon S3 REST API & S3v4 Signatures',
                'Egress'      => 'Zero-cost egress routing via Cloudflare R2',
                'Caching'     => 'Global CDN with automatic Brotli & Gzip',
            ],
            'snippet_label'=> 'Rclone S3 Sync Command',
            'snippet'     => "rclone sync ./dist staticre:my-bucket/assets \\\n  --header-upload \"Cache-Control: public, max-age=31536000, immutable\"",
            'tags'        => ['S3 Compatible', 'Cloudflare R2', 'Object Storage', 'Asset CDN', 'Zero Egress'],
            'url'         => 'https://static.re',
            'repo_url'    => null,
            'related_wiki'=> ['linux-packages/caddy', 'linux-packages/nginx'],
            'status'      => 'Active • Production',
        ],

        'drophtml' => [
            'slug'        => 'drophtml',
            'title'       => 'drophtml.de',
            'category'    => 'hosting',
            'tagline'     => $isDe ? 'Kostenloses Drag-and-Drop Webhosting' : 'Zero-Config Drag-and-Drop HTML Web Hosting',
            'description' => $isDe
                ? 'Statische HTML-, CSS- und JS-Seiten einfach per Drag-and-Drop im Browser hochladen und sofort weltweit online stellen.'
                : 'Instant static web hosting: drop an HTML file or ZIP archive into your browser to deploy a live, secure website in seconds.',
            'overview'    => $isDe
                ? 'drophtml.de bietet die schnellste Möglichkeit, Webseiten ins Netz zu bringen: Datei oder ZIP-Archiv per Drag-and-Drop im Browser ablegen und innerhalb von zwei Sekunden eine aktive HTTPS-URL erhalten. Ideal für Mockups, Prototypen und statische Dokumentation.'
                : 'drophtml.de offers the fastest path to publishing on the web: drag and drop an HTML file or zipped bundle into the browser window and receive an instant, SSL-secured live web URL in under two seconds.',
            'features'    => $isDe ? [
                'Keine Registrierung, kein Terminal und kein FTP/Git erforderlich',
                'Automatische Bereitstellung mit gültigem TLS-Zertifikat und HTTPS',
                'Unterstützt einzelne HTML-Dateien sowie vollständige ZIP-Webprojekte',
                'Einfaches Teilen von Testversionen und Prototypen mit Kunden und Teams',
            ] : [
                'Zero registration, zero API keys, and zero command-line tools required',
                'Automated TLS issuance guaranteeing immediate HTTPS accessibility',
                'Supports standalone single-file HTML as well as multi-asset ZIP bundles',
                'Instant preview link generation perfect for sharing prototypes with clients',
            ],
            'specs'       => [
                'Deployment'  => 'Instant Client-side Drag & Drop',
                'Security'    => 'Automated TLS Certificates, Sandboxed Origin',
                'Limit'       => 'Generous file quota for HTML, CSS, JS, and image assets',
            ],
            'snippet_label'=> 'Quick Browser Action',
            'snippet'     => "1. Open https://drophtml.de in any browser\n2. Drag & drop your index.html or website.zip\n3. Copy your live instant HTTPS URL!",
            'tags'        => ['HTML Hosting', 'Drag & Drop', 'Static Sites', 'Instant Deploy', 'Prototyping'],
            'url'         => 'https://drophtml.de',
            'repo_url'    => null,
            'related_wiki'=> ['css/css-grid-flexbox', 'linux-packages/caddy'],
            'status'      => 'Active • Production',
        ],

        'ternisdomains' => [
            'slug'        => 'ternisdomains',
            'title'       => 'ternisdomains.de',
            'category'    => 'infra',
            'tagline'     => $isDe ? 'Transparente Domain-Registrierung & DNS-Zonen' : 'Transparent Flat-Rate Domain Registration',
            'description' => $isDe
                ? 'Faire Domain-Registrierungen ohne Lockpreise und ohne Preisfallen bei Verlängerungen, mit nativer Unterstützung für ternis.net Nameserver.'
                : 'Fair flat-rate domain registration and DNS zone management without first-year promo traps or renewal price hikes.',
            'overview'    => $isDe
                ? 'ternisdomains.de ist die Domain-Management-Plattform des ternis.org-Ökosystems. Sie setzt auf dauerhaft transparente Flat-Preise und schützt Kunden vor den gängigen Lockangeboten der Massen-Registrare.'
                : 'ternisdomains.de is the domain registrar platform stewarding ternis.org infrastructure. It advocates transparent lifetime flat pricing, eliminating the predatory renewal price multipliers common among retail domain registrars.',
            'features'    => $isDe ? [
                'Transparente Flat-Preise für Neuregistrierung und jede Folgeverlängerung',
                'Ein-Klick-Delegation an unsere Anycast-Nameserver (one.ns.ternis.net & two.ns.ternis.net)',
                'DNSSEC-Aktivierung und automatisches DS-Key-Publishing im Registry-Root',
                'Umfassende Zone-Editor-Werkzeuge für A, AAAA, CNAME, MX, TXT und CAA',
            ] : [
                'Predictable flat renewal pricing matching first-year registration rates',
                'One-click authoritative delegation to one.ns.ternis.net and two.ns.ternis.net',
                'Native DNSSEC DS record publication into top-level registry zones',
                'Full RFC-compliant DNS zone editor for A, AAAA, CNAME, MX, TXT, and CAA records',
            ],
            'specs'       => [
                'Accreditation' => 'Direct Registry Partnerships (DENIC, PIR, Verisign)',
                'DNS Cluster'  => 'Integrated with one.ns.ternis.net and two.ns.ternis.net',
                'Privacy'      => 'Full WHOIS / RDAP Privacy Redaction Included',
            ],
            'snippet_label'=> 'Recommended Nameserver Delegation',
            'snippet'     => "Nameserver 1: one.ns.ternis.net\nNameserver 2: two.ns.ternis.net",
            'tags'        => ['Domain Registrar', 'DNS Control', 'DNSSEC Ready', 'Flat Pricing', 'Anycast'],
            'url'         => 'https://ternisdomains.de',
            'repo_url'    => null,
            'related_wiki'=> ['domains/register-manage-ternisdomains', 'domains/choosing-tld', 'domains/transfer-move-provider'],
            'status'      => 'Active • Production',
        ],

        'ternisorg' => [
            'slug'        => 'ternisorg',
            'title'       => 'ternis.org & Technical Knowledge Base',
            'category'    => 'infra',
            'tagline'     => $isDe ? 'Open-Source-Hub & 60+ Artikel Tech-Wiki' : 'Official Open Source Hub & 60+ Article Wiki',
            'description' => $isDe
                ? 'Das zentrale Open-Source-Repository und praxisorientierte Technik-Wiki für Linux, DNS, DevOps, MySQL und Homelab-Architektur.'
                : 'The official open-source website and comprehensive technical knowledge base covering Linux, DNS, DevOps, and networking.',
            'overview'    => $isDe
                ? 'ternis.org ist das Herzstück des Open-Source-Ökosystems von Fabian Ternis. Neben der Repräsentation aller Dienste bietet es ein stetig wachsendes, praxisnahes Technik-Wiki mit über 60 Artikeln, 100% SVG-Grafiken, Atom-Syndication und Schema.org-Integration.'
                : 'ternis.org is the open-source flagship repository and public knowledge platform maintained by Fabian Ternis. It pairs ecosystem directories with an in-depth 60+ article technical wiki engineered with pure SVG icons, bilingual hreflang alternates, JSON-LD schemas, and dynamic OpenGraph generation.',
            'features'    => $isDe ? [
                '100% reine SVG-Icons und barrierefreie Benutzeroberfläche ohne Emojis oder Unicode-Symbole',
                'Strukturierte Schema.org JSON-LD-Daten (TechArticle, BreadcrumbList, WebSite)',
                'Echtzeit Atom 1.0 Syndication-Feed (/wiki/feed.xml) für Suchmaschinen und RSS-Reader',
                'Dynamische 1200x630 OpenGraph-Vorschaukarten für jeden einzelnen Artikel',
            ] : [
                '100% pure SVG icons and accessible interface without emojis or unicode symbols',
                'Comprehensive Schema.org structured data (TechArticle, BreadcrumbList, WebSite)',
                'Live Atom 1.0 syndication feed (/wiki/feed.xml) for crawlers and tech aggregators',
                'Automated 1200x630 OpenGraph and Twitter card rendering for every wiki article',
            ],
            'specs'       => [
                'Stack'       => 'Pure PHP 8.2+, Vanilla JavaScript, Modern CSS',
                'Feed'        => 'Atom 1.0 (/wiki/feed.xml)',
                'License'     => 'Open Source / MIT',
                'Repository'  => 'https://github.com/ternis-org/ww1.ternis.org',
            ],
            'snippet_label'=> 'Clone Repository',
            'snippet'     => "git clone https://github.com/ternis-org/ww1.ternis.org.git\ncd ww1.ternis.org\nphp -S localhost:8000 -t public",
            'tags'        => ['Open Source', 'Technical Wiki', 'Atom Feed', '100% SVG', 'Pure PHP'],
            'url'         => 'https://ternis.org/' . $lang,
            'repo_url'    => 'https://github.com/ternis-org/ww1.ternis.org',
            'related_wiki'=> ['git-devops/git-crash-course', 'linux-packages/nginx', 'linux-packages/caddy'],
            'status'      => 'Active • Production',
        ],
    ];
}

function project_find(string $slug, ?string $lang = null): ?array
{
    $all = projects_all($lang);
    return $all[$slug] ?? null;
}

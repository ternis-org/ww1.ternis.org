<?php

declare(strict_types=1);

return [
    'meta' => [
        'title'          => 'ternis.org — Open-Source Entwickler-Infrastruktur & Werkzeuge',
        'description'    => 'ternis.org ist eine Open-Source-Initiative von ternis.dev (ternis-edv.de) zur Betreuung von MTEX.dev-Projekten wie getmy.name (Kostenlose Portfolio-API), mail-free.eu/.uk und static.re.',
        'keywords'       => 'ternis.org, ternis.dev, ternis-edv.de, MTEX.dev, getmy.name, mail-free.eu, mail-free.uk, static.re, Open Source, Portfolio API, Entwickler-Tools, Digitale Souveränität',
        'og_title'       => 'ternis.org — Modernes Open-Source-Ökosystem',
        'og_description' => 'Hochperformante Entwickler-Tools, datenschutzkonforme europäische E-Mail-Infrastruktur und ultraschnelle Webdienste. 100% Free & Open Source.',
        'author'         => 'ternis.dev / Fabian Ternis',
    ],

    'nav' => [
        'brand'         => 'ternis.org',
        'about'         => 'Über uns',
        'projects'      => 'Projekte',
        'playground'    => 'API-Playground',
        'ecosystem'     => 'Ökosystem',
        'roadmap'       => 'Roadmap',
        'opensource'    => 'Open Source',
        'faq'           => 'FAQ',
        'legal'         => 'Rechtliches',
        'imprint'       => 'Impressum',
        'privacy'       => 'Datenschutz',
        'license'       => 'Lizenz',
        'toggle_theme'  => 'Design wechseln',
        'language'      => 'Sprache',
        'github'        => 'GitHub',
    ],

    'hero' => [
        'badge'             => 'Open-Source-Initiative von ternis.dev',
        'title_line1'       => 'Entwickler stärken mit',
        'title_line2'       => 'freien, souveränen & schnellen Tools.',
        'description'       => 'ternis.org betreibt und skaliert moderne Open-Source-Entwicklerwerkzeuge von MTEX.dev, datenschutzfreundliche europäische E-Mail-Infrastruktur und blitzschnelle statische Webdienste. Vollständig quelloffen, ohne Tracking, von Entwicklern für Entwickler.',
        'cta_projects'      => 'Projekte entdecken',
        'cta_playground'    => 'Portfolio-API testen',
        'cta_github'        => 'GitHub Organisation',
        'stat_open_source'     => '100% FOSS',
        'stat_open_source_sub' => 'MIT / Apache 2.0 Lizenziert',
        'stat_privacy'         => '0 Tracker',
        'stat_privacy_sub'     => 'DSGVO & EU-Souveränität',
        'stat_latency'         => '< 50ms',
        'stat_latency_sub'     => 'Globale Edge-Antwortzeit',
        'stat_uptime'          => '99.9%',
        'stat_uptime_sub'      => 'Infrastruktur-Verfügbarkeit',
    ],

    'mission' => [
        'badge'       => 'Unsere Philosophie',
        'title'       => 'Transparenz, Performance & Digitale Freiheit',
        'description' => 'Wir sind überzeugt, dass digitale Werkzeuge transparent, für jeden Entwickler ohne Barrieren zugänglich und auf der Basis europäischer Datenschutzstandards gebaut sein müssen.',
        'card1_title' => 'Quelloffen von Grund auf',
        'card1_desc'  => 'Jeder Dienst, jede Bibliothek und jede API unter ternis.org ist Open Source. Jeder kann den Code auditieren, selbst hosten oder Verbesserungen beisteuern.',
        'card2_title' => 'Europäische Datensouveränität',
        'card2_desc'  => 'Unsere Systeme funktionieren komplett ohne Drittanbieter-Telemetrie, erfüllen strengste DSGVO-Vorgaben und laufen auf energieeffizienter europäischer Serverinfrastruktur.',
        'card3_title' => 'Entwickler-Ergonomie',
        'card3_desc'  => 'Saubere REST-Schnittstellen, vorhersehbare Datenstrukturen, exzellente Dokumentation und blitzschnelle Integration ohne Konfigurationsaufwand.',
    ],

    'projects' => [
        'badge'          => 'Betreutes Ökosystem',
        'title'          => 'Projekte & Infrastruktur',
        'subtitle'       => 'Entdecke die von ternis.org gepflegten, geförderten und entwickelten Open-Source-Projekte.',
        'status_live'    => 'Live & Produktiv',
        'status_dev'     => 'In aktiver Entwicklung',
        'status_planned' => 'In Planung / Inkubation',
        'view_project'   => 'Projekt aufrufen',
        'view_docs'      => 'Dokumentation',
        'view_repo'      => 'Quellcode',

        'getmyname' => [
            'title'       => 'getmy.name',
            'badge'       => 'Live',
            'tagline'     => 'Kostenlose, Headless Entwickler-Portfolio-API',
            'description' => 'Kein manuelles Pflegen statischer JSON-Dateien oder komplexer Backends für deine persönliche Portfolio-Website. getmy.name stellt eine REST-API bereit, die deine Biografie, Fähigkeiten, Projekte und Kontaktdaten in Lichtgeschwindigkeit ausliefert.',
            'tags'        => ['REST API', 'Developer Tools', 'PHP / Laravel', 'Zero Auth Mode', 'JSON'],
            'features'    => [
                'Direktes Abfragen von Profilen über Standard-REST-Endpunkte',
                'Keine unnötigen Cookies, reine JSON-Antworten',
                'Komfortables Web-Dashboard zur Profilverwaltung',
                'Antwortzeiten unter 40ms durch Edge-Server',
            ],
            'url'         => 'https://getmy.name',
            'docs_url'    => 'https://getmy.name/api-docs',
            'repo'        => 'https://github.com/ternis-org/getmy-name',
        ],

        'mtex' => [
            'title'       => 'MTEX.dev',
            'badge'       => 'Live',
            'tagline'     => 'Entwickler-Werkzeuge & Komponenten-Suite',
            'description' => 'Die von Fabian Ternis gegründete Entwickler-Plattform. MTEX.dev bietet leichtgewichtige UI-Komponenten, HTTP-Sandboxes, Hilfsbibliotheken und Produktivitäts-Werkzeuge mit Fokus auf maximale Klarheit.',
            'tags'        => ['Tooling Suite', 'Tailwind CSS', 'API Sandboxes', 'Open Source'],
            'features'    => [
                'Produktionsreife UI-Snippets und Design-Muster',
                'API-Testumgebungen und Debugging-Tools',
                'Minimalistische Helfer für effiziente Workflows',
                'Öffentliche Status-Dashboards unter status.mtex.dev',
            ],
            'url'         => 'https://mtex.dev',
            'repo'        => 'https://github.com/ternis-org/mtex-dev',
        ],

        'mailfree' => [
            'title'       => 'mail-free.eu / .uk',
            'badge'       => 'In Entwicklung',
            'tagline'     => 'Souveräne, datenschutzfreundliche europäische E-Mail',
            'description' => 'Eine saubere, privatsphäreschützende E-Mail-Weiterleitungs- und Kommunikationsplattform. Entwickelt für europäische digitale Selbstbestimmung, frei von Werbetrackern und mit modernstem Spamschutz.',
            'tags'        => ['E-Mail & Privatsphäre', 'DSGVO-Nativ', 'EU/UK Souveränität', 'Anti-Tracking'],
            'features'    => [
                'Vollständige Transportverschlüsselung mit modernem TLS',
                'Kein Datenverkauf, kein Scannen von Postfächern',
                'Einfache Wegwerf-Aliase und Entwickler-Routing-Regeln',
                'Ausschließlich gehostet auf grünen europäischen Servern',
            ],
            'url_eu'      => 'https://mail-free.eu',
            'url_uk'      => 'https://mail-free.uk',
            'repo'        => 'https://github.com/ternis-org/mail-free',
        ],

        'staticre' => [
            'title'       => 'static.re',
            'badge'       => 'In Entwicklung',
            'tagline'     => 'Edge-Auslieferung statischer Inhalte & Kurzlink-Netzwerk',
            'description' => 'Hochperformantes Micro-CDN, Link-Shortener und Asset-Netzwerk für Open-Source-Releases, Dokumentationen und weltweites Caching.',
            'tags'        => ['CDN / Edge', 'Statisches Hosting', 'Schnelle Weiterleitungen', 'Micro-Service'],
            'features'    => [
                'Globales Anycast-Edge-Routing für TTFB unter 20ms',
                'Automatische gzip- und Brotli-Kompression',
                'Entwickler-Kurzlinks und Release-Spiegel',
                'Unveränderliches Asset-Caching mit Versions-Hashes',
            ],
            'url'         => 'https://static.re',
            'repo'        => 'https://github.com/ternis-org/static-re',
        ],
    ],

    'playground' => [
        'badge'          => 'Interaktive Sandbox',
        'title'          => 'Teste getmy.name direkt im Browser',
        'subtitle'       => 'Erlebe, wie einfach es ist, Entwicklerdaten über unsere offene API abzufragen. Wähle deine Programmiersprache oder sende direkt eine echte Anfrage.',
        'endpoint_label' => 'Live-Endpunkt',
        'btn_send'       => 'Anfrage senden',
        'btn_sending'    => 'Wird geladen...',
        'btn_copy'       => 'Code kopieren',
        'btn_copied'     => 'Kopiert!',
        'response_label' => 'API-Antwort (JSON)',
        'latency_label'  => 'Latenz',
        'status_label'   => 'Status: 200 OK',
        'tab_curl'       => 'cURL',
        'tab_js'         => 'JavaScript',
        'tab_py'         => 'Python',
        'tab_php'        => 'PHP',
        'tip'            => 'Du kannst diesen Endpunkt direkt in React, Vue, Next.js, Hugo, Astro oder statische HTML-Seiten einbinden.',
    ],

    'maintainer' => [
        'badge'          => 'Pflege & Betreuung',
        'title'          => 'Betreut von ternis.dev (ternis-edv.de)',
        'subtitle'       => 'ternis.org wird von Fabian Ternis gepflegt und von ternis-edv.de unterstützt — einem inhabergeführten Studio für Webentwicklung und IT-Dienstleistungen aus Deutschland.',
        'desc1'          => 'Über ternis-edv.de und ternis.dev entwickeln wir moderne Webanwendungen, verlässliche Cloud-Infrastrukturen und individuelle Digitallösungen für Kunden und Community.',
        'desc2'          => 'ternis.org fungiert als gemeinnützige Open-Source-Einheit, um langfristige Wartung, Server-Finanzierung und Community-Prozesse für MTEX.dev und Partnerprojekte sicherzustellen.',
        'link_ternis_dev'=> 'ternis.dev (Portfolio)',
        'link_ternis_edv'=> 'ternis-edv.de (Studio)',
        'link_github'    => 'GitHub Profil',
    ],

    'roadmap' => [
        'badge'    => 'Zukunftsausblick',
        'title'    => 'Initiativen & Roadmap',
        'subtitle' => 'Transparente Meilensteine für Infrastruktur-Erweiterungen und neue Dienste.',
        'q1_badge' => 'Phase 1 • Live',
        'q1_title' => 'Konsolidierung des Ökosystems & getmy.name v1',
        'q1_desc'  => 'Zusammenführung unter ternis.org, API-Stabilität und Bereitstellung offener Entwicklerdokumentation.',
        'q2_badge' => 'Phase 2 • Q3-Q4 2026',
        'q2_title' => 'mail-free.eu & .uk Alpha-Rollout',
        'q2_desc'  => 'Inbetriebnahme souveräner Mail-Relays, Webhook-Weiterleitungen und DSGVO-konformes Web-Dashboard.',
        'q3_badge' => 'Phase 3 • In Arbeit',
        'q3_title' => 'static.re Globales Edge-Netzwerk',
        'q3_desc'  => 'Veröffentlichung von statischem Edge-Caching, eigenen Kurzlinks für Open-Source-Repos und weltweiten CDN-Knoten.',
        'q4_badge' => 'Phase 4 • Geplant',
        'q4_title' => 'Föderierte Identität & Community-SDKs',
        'q4_desc'  => 'Veröffentlichung offizieller Client-Bibliotheken für TypeScript, Go, Python und Rust.',
    ],

    'opensource' => [
        'badge'            => 'Community & Mitwirkung',
        'title'            => '100% Frei & Quelloffen',
        'subtitle'         => 'Jede Zeile Code unserer Dienste ist öffentlich einsehbar. Werde Teil unserer Community, melde Fehler oder schlage neue Funktionen vor.',
        'card_code_title'  => 'Quellcode-Repositories',
        'card_code_desc'   => 'Erkunde die Repositories auf GitHub, prüfe den Code, erstelle Forks und sende Pull Requests ein.',
        'card_issues_title'=> 'Issues & Diskussionen',
        'card_issues_desc' => 'Fehler entdeckt oder eine Idee? Eröffne ein Issue auf GitHub, um direkt mit den Maintainern zu sprechen.',
        'card_host_title'  => 'Self-Hosting Anleitungen',
        'card_host_desc'   => 'Betreibe alle Projekte auf eigenen Servern mit Docker Compose und vorkonfigurierten Images.',
        'btn_github_org'   => 'ternis-org auf GitHub besuchen',
        'btn_guidelines'   => 'Richtlinien für Beiträge',
    ],

    'faq' => [
        'badge'    => 'Fragen & Antworten',
        'title'    => 'Häufig gestellte Fragen',
        'subtitle' => 'Alles Wissenswerte über ternis.org, unsere betreuten Projekte und wie du dich einbringen kannst.',
        'items'    => [
            [
                'q' => 'Was ist die Aufgabe von ternis.org?',
                'a' => 'ternis.org ist das Open-Source-Dach von ternis.dev (ternis-edv.de). Es bündelt und pflegt Community-Projekte wie MTEX.dev-Werkzeuge, getmy.name (Portfolio-API), mail-free.eu/.uk und static.re.',
            ],
            [
                'q' => 'Ist getmy.name wirklich dauerhaft kostenlos?',
                'a' => 'Ja, getmy.name ist 100% kostenlos und quelloffen. Entwickler können ihr Profil anlegen und ihre Daten ohne versteckte Kosten und ohne Werbung über die REST-API abrufen.',
            ],
            [
                'q' => 'Wie werden Datenschutz und DSGVO gewährleistet?',
                'a' => 'Wir verzichten konsequent auf Tracking-Skripte, Werbenetzwerke und Profiling-Cookies. Alle Server stehen in zertifizierten europäischen Rechenzentren und unterliegen der DSGVO.',
            ],
            [
                'q' => 'Wie hängen ternis.org, ternis.dev und ternis-edv.de zusammen?',
                'a' => 'ternis-edv.de ist das von Fabian Ternis geführte IT-Studio. ternis.dev bildet die Entwickler-Präsenz, und ternis.org ist die offizielle Organisation für alle quelloffenen Gemeinschaftsprojekte.',
            ],
            [
                'q' => 'Wie kann ich beitragen oder das Projekt unterstützen?',
                'a' => 'Beiträge zu Code und Dokumentation sind über unsere GitHub-Organisation (ternis-org) herzlich willkommen. Zudem kann der Serverbetrieb über GitHub Sponsors unterstützt werden.',
            ],
        ],
    ],

    'cta' => [
        'title'       => 'Bereit für moderne Open-Source-Tools?',
        'subtitle'    => 'Nutze die Dienste von ternis.org für deine persönlichen Projekte und professionellen Workflows.',
        'btn_github'  => 'Auf GitHub mit einem Stern markieren',
        'btn_contact' => 'Kontakt zu ternis.dev aufnehmen',
    ],

    'footer' => [
        'tagline'        => 'Open-Source Entwickler-Infrastruktur & Werkzeuge.',
        'description'    => 'Betreut von ternis.dev (ternis-edv.de) • Entwickelt mit Leidenschaft für freie Software, Entwickler-Ergonomie und digitale Souveränität.',
        'col_projects'   => 'Projekte',
        'col_ecosystem'  => 'Ökosystem',
        'col_community'  => 'Community',
        'col_legal'      => 'Rechtliches',
        'rights'         => 'Alle Rechte vorbehalten. Veröffentlicht unter der MIT Open-Source-Lizenz.',
        'version'        => 'Version',
    ],

    'legal' => [
        'imprint' => [
            'slug'        => 'imprint',
            'title'       => 'Impressum',
            'badge'       => 'Rechtliche Angaben',
            'subtitle'    => 'Angaben gemäß § 5 TMG / DDG (Digitale-Dienste-Gesetz)',
            'operator_heading' => 'Dienstanbieter & Verantwortlicher',
            'operator_name'    => 'Fabian Ternis',
            'operator_org'     => 'ternis-edv.de / ternis.dev',
            'operator_address' => 'Deutschland',
            'contact_heading'  => 'Kontaktmöglichkeiten',
            'contact_email'    => 'E-Mail: contact@ternis.dev / info@ternis-edv.de',
            'contact_web'      => 'Web: https://ternis.dev | https://ternis-edv.de | https://ternis.org',
            'disclaimer_heading'=> 'Haftungsausschluss & Gewährleistung',
            'disclaimer_text'  => 'Die Nutzung aller Open-Source-Tools, Repositories und Schnittstellen erfolgt ohne ausdrückliche oder stillschweigende Gewährleistung jeglicher Art. Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links.',
            'copyright_heading' => 'Urheberrecht & Lizenzierung',
            'copyright_text'   => 'Die auf ternis.org bereitgestellten Open-Source-Projekte stehen unter permissiven Lizenzen (MIT oder Apache 2.0). Alle genannten Marken und Warenzeichen sind Eigentum der jeweiligen Inhaber.',
        ],

        'privacy' => [
            'slug'        => 'privacy',
            'title'       => 'Datenschutzerklärung',
            'badge'       => 'Datenschutz & Privatsphäre',
            'subtitle'    => 'Konsequente DSGVO-Konformität, kein Tracking & höchste Datensicherheit',
            'summary_heading' => 'Datenschutz auf einen Blick',
            'summary_text'    => 'Wir verfolgen den Grundsatz der Datensparsamkeit. Wir setzen keine Analyse-Dienste von Drittanbietern (z. B. Google Analytics) ein, setzen keine Tracking-Cookies und verkaufen oder monetarisieren zu keinem Zeitpunkt Nutzerdaten.',
            'server_heading'  => 'Server-Logfiles & Hosting',
            'server_text'     => 'Beim Aufruf dieser Website oder unserer APIs verarbeiten unsere Server temporäre technische Verbindungsdaten (u. a. anonymisierte IP-Adresse, Zugriffszeitpunkt, angeforderte URL, User-Agent), um die Systemsicherheit zu gewährleisten und Angriffe abzuwehren. Diese Daten werden turnusmäßig gelöscht.',
            'cookies_heading' => 'Cookies & Lokaler Speicher',
            'cookies_text'    => 'Diese Website nutzt den lokalen Browserspeicher (localStorage) ausschließlich zur Speicherung deiner Theme-Einstellung (Dark/Light) und Sprachauswahl. Tracking-Cookies kommen nicht zum Einsatz.',
            'rights_heading'  => 'Deine Rechte nach DSGVO',
            'rights_text'     => 'Du hast gemäß DSGVO jederzeit das Recht auf unentgeltliche Auskunft über deine gespeicherten personenbezogenen Daten sowie ein Recht auf Berichtigung oder Löschung. Wende dich hierzu an privacy@ternis.dev.',
        ],

        'license' => [
            'slug'        => 'license',
            'title'       => 'Open-Source-Lizenz & Bedingungen',
            'badge'       => 'MIT Lizenz',
            'subtitle'    => 'Freie Nutzung, Weiterentwicklung, Verteilung & Self-Hosting',
            'license_heading' => 'Die MIT-Lizenz (MIT)',
            'license_text'    => 'Copyright (c) 2026 ternis.org & Fabian Ternis (ternis.dev / ternis-edv.de)

Hiermit wird jeder Person, die eine Kopie dieser Software und der zugehörigen Dokumentationsdateien (die „Software“) erhält, unentgeltlich die Erlaubnis erteilt, uneingeschränkt mit der Software zu verfahren, einschließlich und ohne Einschränkung der Rechte, sie zu nutzen, zu kopieren, zu modifizieren, zusammenzuführen, zu veröffentlichen, zu verbreiten, zu unterlizenzieren und/oder Kopien der Software zu verkaufen, und Personen, denen die Software zur Verfügung gestellt wird, dies unter den folgenden Bedingungen zu gestatten:

Der obige Urheberrechtshinweis und dieser Genehmigungshinweis müssen in allen Kopien oder wesentlichen Teilen der Software enthalten sein.

DIE SOFTWARE WIRD OHNE JEDE AUSDRÜCKLICHE ODER STILLSCHWEIGENDE GEWÄHRLEISTUNG BEREITGESTELLT, EINSCHLIESSLICH DER GEWÄHRLEISTUNG DER MARKTGÄNGIGKEIT, DER EIGNUNG FÜR EINEN BESTIMMTEN ZWECK UND DER NICHTVERLETZUNG VON RECHTEN DRITTER. IN KEINEM FALL SIND DIE AUTOREN ODER URHEBERRECHTSINHABER FÜR JEGLICHE ANSPRÜCHE, SCHÄDEN ODER SONSTIGE HAFTUNGEN VERANTWORTLICH.',
            'values_heading'  => 'Unser Open-Source-Versprechen',
            'values_text'     => 'ternis.org setzt sich dauerhaft für frei verfügbare Software ein. Alle Kern-Repositories und Schnittstellen bleiben für immer kostenlos und quelloffen.',
        ],
    ],

    'error' => [
        'code_404'     => '404',
        'title_404'    => 'Seite nicht gefunden',
        'not_found'    => 'Die angeforderte Ressource konnte auf ternis.org nicht gefunden werden.',
        'desc'         => 'Die gesuchte Seite wurde möglicherweise verschoben, umbenannt oder ist vorübergehend nicht erreichbar.',
        'back_home'    => 'Zurück zur Startseite',
        'explore_proj' => 'Projekte ansehen',
    ],
];

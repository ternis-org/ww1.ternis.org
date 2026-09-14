<?php

declare(strict_types=1);

return [
    'meta' => [
        'title'          => 'ternis.org — Open-Source Entwickler-Infrastruktur & Werkzeuge',
        'description'    => 'ternis.org ist eine Open-Source-Initiative von ternis.dev (ternis-edv.de) zur Betreuung von MTEX.dev-Projekten wie getmy.name, mail-free.eu und static.re.',
        'keywords'       => 'ternis.org, ternis.dev, ternis-edv.de, MTEX.dev, getmy.name, mail-free.eu, mail-free.uk, static.re, Open Source, Portfolio API, Entwickler-Tools, Digitale Souveränität',
        'og_title'       => 'ternis.org — Modernes Open-Source-Ökosystem',
        'og_description' => 'Souveräne Entwicklertools, autonome Nameserver und schlanke Webdienste.',
        'author'         => 'ternis.dev / Fabian Ternis',
    ],

    'nav' => [
        'brand'         => 'ternis.org',
        'projects'      => 'Projekte',
        'nameservers'   => 'Nameserver',
        'about'         => 'Über uns',
        'legal'         => 'Rechtliches',
        'imprint'       => 'Impressum',
        'privacy'       => 'Datenschutz',
        'license'       => 'Lizenz',
        'toggle_theme'  => 'Design wechseln',
        'language'      => 'Sprache',
        'github'        => 'GitHub',
    ],

    'hero' => [
        'badge'             => 'Ökosystem • ternis.dev / ternis-edv.de',
        'title_line1'       => 'Technologie mit',
        'title_line2'       => 'Souveränität & Speed.',
        'description'       => 'Souveräne Entwicklertools, autonome Nameserver und schlanke Webdienste.',
        'cta_projects'      => 'Projekte erkunden',
        'cta_github'        => 'GitHub',
        'stat_projects'        => '8+',
        'stat_projects_sub'    => 'Aktive Projekte',
        'stat_privacy'         => '0',
        'stat_privacy_sub'     => 'Tracker oder Ads',
        'stat_nameservers'     => '2',
        'stat_nameservers_sub' => 'Nameserver-Knoten',
        'stat_hosting'         => 'EU',
        'stat_hosting_sub'     => 'Hosting & Betrieb',
    ],

    'projects' => [
        'title'          => 'Betreute Projekte',
        'subtitle'       => 'Open-Source-Entwicklertools und souveräne digitale Infrastruktur.',
        'dnbx_note'      => 'DNS verwaltet über dnbx.de mit autoritativen Nameservern one.ns.ternis.net & two.ns.ternis.net.',
        'view_project'   => 'Projekt öffnen',
        'view_docs'      => 'API-Doku',
        'view_repo'      => 'Quellcode',

        'httpclient' => [
            'title'       => 'httpclient.de',
            'tagline'     => 'Kostenloser HTTP-Client für Web & Desktop',
            'description' => 'Schneller, quelloffener HTTP-Client für Web und Desktop zur API-Prüfung.',
            'tags'        => ['HTTP-Client', 'Desktop & Web', 'Entwickler-Tool', 'MIT'],
            'url'         => 'https://httpclient.de',
        ],

        'apisandbox' => [
            'title'       => 'api-sandbox.de',
            'tagline'     => 'Schlanker & freier API-Viewer',
            'description' => 'Minimalistischer REST-API-Viewer und interaktiver JSON-Schema-Inspektor.',
            'tags'        => ['API-Viewer', 'JSON-Inspektor', 'Sandbox', 'Kostenlos'],
            'url'         => 'https://api-sandbox.de',
        ],

        'mtex' => [
            'title'       => 'MTEX.dev',
            'tagline'     => 'Entwicklertools & UI-Komponenten',
            'description' => 'Entwickler-Utilities und UI-Toolsets, einschließlich getmy.name (Kostenlose Portfolio-API).',
            'tags'        => ['Tooling Suite', 'getmy.name', 'UI Tools', 'Open Source'],
            'url'         => 'https://mtex.dev',
            'docs_url'    => 'https://getmy.name/api-docs',
        ],

        'websearch' => [
            'title'       => 'web-search.org',
            'tagline'     => 'Selbsthostbare Suchmaschine',
            'description' => 'Schlanke, datenschutzfreundliche Suchmaschine ohne Tracker oder Nutzerprofile.',
            'tags'        => ['Suchmaschine', 'Selbsthostbar', 'Datenschutz', 'FOSS'],
            'url'         => 'https://web-search.org',
        ],

        'mailfree' => [
            'title'       => 'mail-free.eu + mail-free.uk',
            'tagline'     => 'Automatische Postfächer & Privatsphäre',
            'description' => 'Temporäre E-Mail-Aliase und souveräne europäische Mail-Relays zum Schutz des Postfachs.',
            'tags'        => ['E-Mail-Schutz', 'Auto-Aliase', 'EU / UK Souverän', 'Kostenlos'],
            'url_eu'      => 'https://mail-free.eu',
            'url_uk'      => 'https://mail-free.uk',
        ],

        'staticre' => [
            'title'       => 'static.re',
            'tagline'     => 'S3 & Cloudflare R2 Speicherplattform',
            'description' => 'Open-Source-Software und verwaltete Plattform für S3 & Cloudflare R2 Objektspeicher.',
            'tags'        => ['S3-kompatibel', 'Cloudflare R2', 'Objektspeicher', 'Plattform'],
            'url'         => 'https://static.re',
        ],

        'drophtml' => [
            'title'       => 'drophtml.de',
            'tagline'     => 'Kostenloser Drag-and-Drop Website-Host',
            'description' => 'Statische HTML- und Webseiten sofort per Drag-and-Drop ohne Konfigurationsaufwand hosten.',
            'tags'        => ['HTML-Hosting', 'Drag & Drop', 'Statische Sites', 'Sofort-Deploy'],
            'url'         => 'https://drophtml.de',
        ],

        'exampledns' => [
            'title'       => 'example-dns',
            'tagline'     => 'Autoritative DNS-Infrastruktur',
            'description' => 'Autoritative Nameserver (one.ns.ternis.net & two.ns.ternis.net) für example-dns.com, .net und .org.',
            'tags'        => ['one.ns.ternis.net', 'two.ns.ternis.net', 'Autoritatives DNS', 'FOSS'],
            'url_github'  => 'https://github.com/example-dns/example-dns',
            'url_codeberg'=> 'https://codeberg.org/example-dns/example-dns',
            'url_web'     => 'https://example-dns.com',
        ],
    ],

    'nameservers' => [
        'title'            => 'Autonome Nameserver',
        'subtitle'         => 'Unabhängige DNS-Infrastruktur für digitale Souveränität, Transparenz und Ausfallsicherheit.',
        'alias_label'      => 'Direkter Alias',
        'status_active'    => 'Autoritativ • Online',
        'node1_title'      => 'Primärer Nameserver (NS1)',
        'node1_host'       => 'one.ns.ternis.net',
        'node1_alias'      => 'example-dns.net',
        'node1_desc'       => 'Primärer autoritativer Routing-Knoten. Ohne Telemetrie und mit zuverlässiger weltweiter Auflösung.',
        'node2_title'      => 'Sekundärer Nameserver (NS2)',
        'node2_host'       => 'two.ns.ternis.net',
        'node2_alias'      => 'example-dns.org',
        'node2_desc'       => 'Geografisch redundanter Sekundärknoten für permanente Zonensynchronisation und Ausfallsicherheit.',
        'domains_title'    => 'Eigene Domains & TLD-Netzwerk',
        'domains_desc'     => 'ternis.org besitzt example-dns.com, example-dns.net und example-dns.org. Verwaltet über dnbx.de.',
        'terminal_title'   => 'DNS-Verifikation (dig & host)',
        'btn_visit'        => 'example-dns.com besuchen',
        'btn_github'       => 'GitHub',
        'btn_codeberg'     => 'Codeberg',
        'btn_dnbx'         => 'dnbx.de',
    ],

    'about' => [
        'badge'       => 'Über uns & Leitwerte',
        'title'       => 'Gebaut für Freiheit und Transparenz',
        'subtitle'    => 'Eine unabhängige Open-Source-Initiative für performante Entwicklerwerkzeuge und europäische Datensouveränität.',
        'card1_title' => 'Open Source & freie Tools',
        'card1_desc'  => 'Zentrale Werkzeuge und Bibliotheken werden unter freien Lizenzen (wie MIT oder Apache 2.0) mit öffentlichen Repositories für Community, Beitrag und Prüfung bereitgestellt.',
        'card2_title' => 'Europäische Datensouveränität',
        'card2_desc'  => 'Garantiert ohne Tracking-Skripte, Profiling-Cookies oder Fremd-Telemetrie. Gehostet in europäischen Rechenzentren unter strikter Einhaltung der DSGVO.',
        'card3_title' => 'Studio-Trägerschaft',
        'card3_desc'  => 'Gepflegt von Fabian Ternis und gestützt durch ternis-edv.de — für gesicherte Server-Finanzierung, regelmäßige Pflege und langfristige Stabilität.',
        'link_ternis_dev' => 'ternis.dev (Portfolio)',
        'link_ternis_edv' => 'ternis-edv.de (Studio)',
        'link_github'     => 'GitHub Organisation',
    ],

    'cta' => [
        'title'       => 'Bereit für moderne Open-Source-Tools?',
        'subtitle'    => 'Nutze die Dienste von ternis.org für deine persönlichen Projekte und professionellen Workflows.',
        'btn_github'  => 'Auf GitHub ansehen',
        'btn_contact' => 'Kontakt zu ternis.dev',
    ],

    'footer' => [
        'tagline'        => 'Open-Source Entwickler-Infrastruktur & Werkzeuge.',
        'description'    => 'Betreut von ternis.dev (ternis-edv.de) • Entwickelt mit Leidenschaft für freie Software, Entwickler-Ergonomie und digitale Souveränität.',
        'col_projects'   => 'Projekte',
        'col_ecosystem'  => 'Ökosystem',
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
            'contact_email'    => 'contact@ternis.dev / edv@ternismail.de',
            'contact_web'      => 'https://ternis.dev | https://ternis-edv.de | https://ternis.org',
            'disclaimer_heading'=> 'Haftungsausschluss & Gewährleistung',
            'disclaimer_text'  => 'Die Nutzung aller Open-Source-Tools, Repositories und Schnittstellen erfolgt ohne ausdrückliche oder stillschweigende Gewährleistung jeglicher Art. Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links.',
            'copyright_heading' => 'Urheberrecht & Lizenzierung',
            'copyright_text'   => 'Die auf ternis.org bereitgestellten Open-Source-Projekte und Werkzeuge stehen unter permissiven Lizenzen (wie MIT oder Apache 2.0). Alle genannten Marken und Warenzeichen sind Eigentum der jeweiligen Inhaber.',
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
            'rights_text'     => 'Du hast gemäß DSGVO jederzeit das Recht auf unentgeltliche Auskunft über deine gespeicherten personenbezogenen Daten sowie ein Recht auf Berichtigung oder Löschung. Wende dich hierzu an contact@ternis.dev oder edv@ternismail.de.',
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

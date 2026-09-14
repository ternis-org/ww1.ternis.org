<?php

declare(strict_types=1);

return [
    'meta' => [
        'title'          => 'ternis.org — Open Source Developer Infrastructure & Tooling',
        'description'    => 'ternis.org is an open-source initiative by ternis.dev (ternis-edv.de) maintaining MTEX.dev projects including getmy.name, mail-free.eu, and static.re.',
        'keywords'       => 'ternis.org, ternis.dev, ternis-edv.de, MTEX.dev, getmy.name, mail-free.eu, mail-free.uk, static.re, open source, portfolio api, developer tools, digital sovereignty',
        'og_title'       => 'ternis.org — Modern Open-Source Ecosystem',
        'og_description' => 'Sovereign developer tooling, autonomous nameservers, and lightweight web services. 100% Free & Open Source.',
        'author'         => 'ternis.dev / Fabian Ternis',
    ],

    'nav' => [
        'brand'         => 'ternis.org',
        'projects'      => 'Projects',
        'nameservers'   => 'Nameservers',
        'about'         => 'About',
        'legal'         => 'Legal',
        'imprint'       => 'Imprint',
        'privacy'       => 'Privacy Policy',
        'license'       => 'License',
        'toggle_theme'  => 'Toggle theme',
        'language'      => 'Language',
        'github'        => 'GitHub',
    ],

    'hero' => [
        'badge'             => 'Open Source • ternis.dev / ternis-edv.de',
        'title_line1'       => 'Technology that',
        'title_line2'       => 'breathes freedom.',
        'description'       => 'Sovereign developer tooling, autonomous nameservers, and lightweight web services. 100% Free & Open Source.',
        'cta_projects'      => 'Explore Projects',
        'cta_infrastructure'=> 'Infrastructure',
        'cta_github'        => 'GitHub',
        'stat_open_source'     => '100% FOSS',
        'stat_open_source_sub' => 'MIT Licensed',
        'stat_privacy'         => '0 Trackers',
        'stat_privacy_sub'     => 'GDPR & EU Hosted',
        'stat_latency'         => '< 40ms',
        'stat_latency_sub'     => 'Edge Response',
        'stat_uptime'          => '99.9%',
        'stat_uptime_sub'      => 'Infrastructure SLA',
    ],

    'projects' => [
        'title'          => 'Maintained Projects',
        'subtitle'       => 'Open-source developer tooling and sovereign digital infrastructure.',
        'dnbx_note'      => 'DNS managed via dnbx.de with authoritative nameservers one.ns.ternis.net & two.ns.ternis.net.',
        'view_project'   => 'Visit Project',
        'view_docs'      => 'API Docs',
        'view_repo'      => 'Source Code',

        'httpclient' => [
            'title'       => 'httpclient.de',
            'tagline'     => 'Free HTTP Client for Web & Desktop',
            'description' => 'Fast, open-source HTTP client for web and desktop API testing.',
            'tags'        => ['HTTP Client', 'Desktop & Web', 'Developer Tool', 'MIT'],
            'url'         => 'https://httpclient.de',
        ],

        'apisandbox' => [
            'title'       => 'api-sandbox.de',
            'tagline'     => 'Simple & Free API Viewer',
            'description' => 'Minimalist REST API viewer and live JSON schema inspector.',
            'tags'        => ['API Viewer', 'JSON Inspector', 'Sandbox', 'Free'],
            'url'         => 'https://api-sandbox.de',
        ],

        'mtex' => [
            'title'       => 'MTEX.dev',
            'tagline'     => 'Developer Tools & UI Components',
            'description' => 'Developer utilities and UI toolsets, stewarding getmy.name (Free Portfolio API).',
            'tags'        => ['Tooling Suite', 'getmy.name', 'UI Tools', 'Open Source'],
            'url'         => 'https://mtex.dev',
            'docs_url'    => 'https://getmy.name/api-docs',
        ],

        'websearch' => [
            'title'       => 'web-search.org',
            'tagline'     => 'Self-Hostable Search Engine',
            'description' => 'Lightweight, privacy-first search engine without trackers or profiling.',
            'tags'        => ['Search Engine', 'Self-Hostable', 'Privacy First', 'FOSS'],
            'url'         => 'https://web-search.org',
        ],

        'mailfree' => [
            'title'       => 'mail-free.eu + mail-free.uk',
            'tagline'     => 'Auto-Generated Inboxes & Privacy',
            'description' => 'Disposable email aliases and sovereign European mail relays protecting personal inboxes.',
            'tags'        => ['Email Privacy', 'Auto-Aliases', 'EU / UK Sovereign', 'Free'],
            'url_eu'      => 'https://mail-free.eu',
            'url_uk'      => 'https://mail-free.uk',
        ],

        'staticre' => [
            'title'       => 'static.re',
            'tagline'     => 'S3 & Cloudflare R2 Storage Platform',
            'description' => 'Open-source software and managed delivery platform for S3 & Cloudflare R2 storage.',
            'tags'        => ['S3 Compatible', 'Cloudflare R2', 'Object Storage', 'Platform'],
            'url'         => 'https://static.re',
        ],

        'drophtml' => [
            'title'       => 'drophtml.de',
            'tagline'     => 'Free Drag-and-Drop Website Host',
            'description' => 'Zero-configuration static HTML and website hosting via instant drag-and-drop.',
            'tags'        => ['HTML Hosting', 'Drag & Drop', 'Static Sites', 'Instant Deploy'],
            'url'         => 'https://drophtml.de',
        ],

        'exampledns' => [
            'title'       => 'example-dns',
            'tagline'     => 'Authoritative DNS Infrastructure',
            'description' => 'Authoritative nameservers (one.ns.ternis.net & two.ns.ternis.net) owning example-dns.com, .net, and .org.',
            'tags'        => ['one.ns.ternis.net', 'two.ns.ternis.net', 'Authoritative DNS', 'FOSS'],
            'url_github'  => 'https://github.com/example-dns/example-dns',
            'url_codeberg'=> 'https://codeberg.org/example-dns/example-dns',
            'url_web'     => 'https://example-dns.com',
        ],
    ],

    'nameservers' => [
        'title'            => 'Autonomous Nameservers',
        'subtitle'         => 'Independent DNS infrastructure ensuring digital sovereignty, transparency, and high availability.',
        'alias_label'      => 'Direct Alias',
        'status_active'    => 'Authoritative • Online',
        'node1_title'      => 'Primary Nameserver (NS1)',
        'node1_host'       => 'one.ns.ternis.net',
        'node1_alias'      => 'example-dns.net',
        'node1_desc'       => 'Primary authoritative routing node. Zero telemetry and reliable global resolution.',
        'node2_title'      => 'Secondary Nameserver (NS2)',
        'node2_host'       => 'two.ns.ternis.net',
        'node2_alias'      => 'example-dns.org',
        'node2_desc'       => 'Geographically redundant secondary node for continuous zone sync and resilience.',
        'domains_title'    => 'Owned Domains & TLD Network',
        'domains_desc'     => 'ternis.org owns example-dns.com, example-dns.net, and example-dns.org. Managed via dnbx.de.',
        'terminal_title'   => 'DNS Verification (dig & host)',
        'btn_visit'        => 'Visit example-dns.com',
        'btn_github'       => 'GitHub',
        'btn_codeberg'     => 'Codeberg',
        'btn_dnbx'         => 'dnbx.de',
    ],

    'about' => [
        'badge'       => 'About & Principles',
        'title'       => 'Built for Freedom and Transparency',
        'subtitle'    => 'A dedicated open-source initiative providing reliable developer tools with European digital sovereignty.',
        'card1_title' => '100% Free & Open Source',
        'card1_desc'  => 'Every service and utility is distributed under permissive open licenses (MIT / Apache 2.0). All repositories are public, inspectable, and self-hostable.',
        'card2_title' => 'European Digital Sovereignty',
        'card2_desc'  => 'Strictly zero tracking scripts, no profiling cookies, and no third-party telemetry. Hosted in compliant European datacenters adhering to the GDPR.',
        'card3_title' => 'Studio Stewardship',
        'card3_desc'  => 'Maintained by Fabian Ternis and backed by ternis-edv.de — ensuring long-term server funding, updates, and maintenance for MTEX.dev and community projects.',
        'link_ternis_dev' => 'ternis.dev (Portfolio)',
        'link_ternis_edv' => 'ternis-edv.de (Studio)',
        'link_github'     => 'GitHub Organization',
    ],

    'cta' => [
        'title'       => 'Ready to build with open-source tools?',
        'subtitle'    => 'Use ternis.org services to power your personal projects and production workflows.',
        'btn_github'  => 'Star on GitHub',
        'btn_contact' => 'Get in Touch with ternis.dev',
    ],

    'footer' => [
        'tagline'        => 'Open Source Developer Infrastructure & Tooling.',
        'description'    => 'Maintained by ternis.dev (ternis-edv.de) • Built with passion for open software, developer ergonomics, and digital sovereignty.',
        'col_projects'   => 'Projects',
        'col_ecosystem'  => 'Ecosystem',
        'col_legal'      => 'Legal & Compliance',
        'rights'         => 'All rights reserved. Released under the MIT Open Source License.',
        'version'        => 'Version',
    ],

    'legal' => [
        'imprint' => [
            'slug'        => 'imprint',
            'title'       => 'Legal Notice / Impressum',
            'badge'       => 'Legal Disclosure',
            'subtitle'    => 'Information according to § 5 TMG / DDG (German Telemedia Act)',
            'operator_heading' => 'Provider & Responsible Party',
            'operator_name'    => 'Fabian Ternis',
            'operator_org'     => 'ternis-edv.de / ternis.dev',
            'operator_address' => 'Germany',
            'contact_heading'  => 'Contact Information',
            'contact_email'    => 'contact@ternis.dev / edv@ternismail.de',
            'contact_web'      => 'https://ternis.dev | https://ternis-edv.de | https://ternis.org',
            'disclaimer_heading'=> 'Disclaimer & Liability',
            'disclaimer_text'  => 'All open-source tools, code repositories, and APIs are provided "as is", without warranty of any kind, express or implied. Although we inspect third-party links carefully, we assume no liability for the content of external websites linked on this platform.',
            'copyright_heading' => 'Copyright & Licensing',
            'copyright_text'   => 'The software projects maintained by ternis.org are distributed under permissive open-source licenses (MIT or Apache 2.0). All trademarks and brand names are property of their respective owners.',
        ],

        'privacy' => [
            'slug'        => 'privacy',
            'title'       => 'Privacy Policy / Datenschutz',
            'badge'       => 'Data Protection',
            'subtitle'    => 'Strict GDPR Compliance, Zero Trackers & Maximum Privacy',
            'summary_heading' => 'Privacy at a Glance',
            'summary_text'    => 'We believe in data minimalism. We do not use third-party analytics (e.g. Google Analytics), we do not set tracking cookies, and we never sell or monetize user data.',
            'server_heading'  => 'Server Logs & Hosting',
            'server_text'     => 'When you visit our website or use our APIs, our servers temporarily process technical connection data (such as anonymized IP address, timestamp, requested URL, user-agent) exclusively to ensure system stability, prevent DDoS attacks, and maintain security. These logs are automatically rotated and purged.',
            'cookies_heading' => 'Cookies & Local Storage',
            'cookies_text'    => 'This site uses local browser storage solely to remember your preferred UI theme (dark/light) and language preference. No tracking cookies are used.',
            'rights_heading'  => 'Your Rights under GDPR',
            'rights_text'     => 'Under the European General Data Protection Regulation (GDPR), you have the right to access, rectify, or request deletion of any personal data stored about you. For inquiries, reach out to contact@ternis.dev or edv@ternismail.de.',
        ],

        'license' => [
            'slug'        => 'license',
            'title'       => 'Open Source License & Terms',
            'badge'       => 'MIT License',
            'subtitle'    => 'Free to Use, Modify, Distribute and Self-Host',
            'license_heading' => 'The MIT License (MIT)',
            'license_text'    => 'Copyright (c) 2026 ternis.org & Fabian Ternis (ternis.dev / ternis-edv.de)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.',
            'values_heading'  => 'Our Open Source Commitment',
            'values_text'     => 'ternis.org is dedicated to public-benefit software. All core repositories and tools will remain permanently free and open-source.',
        ],
    ],

    'error' => [
        'code_404'     => '404',
        'title_404'    => 'Page Not Found',
        'not_found'    => 'The requested resource could not be found on ternis.org.',
        'desc'         => 'The page you are looking for might have been removed, renamed, or is temporarily unavailable.',
        'back_home'    => 'Return to Homepage',
        'explore_proj' => 'Explore Projects',
    ],
];

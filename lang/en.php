<?php

declare(strict_types=1);

return [
    'meta' => [
        'title'          => 'ternis.org — Open Source Developer Infrastructure & Tooling',
        'description'    => 'ternis.org is an open-source initiative by ternis.dev (ternis-edv.de) maintaining MTEX.dev projects including getmy.name (Free Portfolio API), mail-free.eu/.uk, and static.re.',
        'keywords'       => 'ternis.org, ternis.dev, ternis-edv.de, MTEX.dev, getmy.name, mail-free.eu, mail-free.uk, static.re, open source, portfolio api, developer tools, digital sovereignty',
        'og_title'       => 'ternis.org — Modern Open-Source Ecosystem',
        'og_description' => 'Maintaining high-performance developer tools, sovereign privacy-first email infrastructure, and lightning-fast web services. 100% Free & Open Source.',
        'author'         => 'ternis.dev / Fabian Ternis',
    ],

    'nav' => [
        'brand'         => 'ternis.org',
        'about'         => 'Philosophy',
        'projects'      => 'Projects',
        'playground'    => 'API Sandbox',
        'ecosystem'     => 'Ecosystem',
        'roadmap'       => 'Roadmap',
        'opensource'    => 'Open Source',
        'faq'           => 'FAQ',
        'cta_explore'   => 'Explore Ecosystem',
        'legal'         => 'Legal',
        'imprint'       => 'Imprint',
        'privacy'       => 'Privacy Policy',
        'license'       => 'License',
        'toggle_theme'  => 'Toggle theme',
        'language'      => 'Language',
        'github'        => 'GitHub',
    ],

    'hero' => [
        'badge'             => 'Open Source Initiative • ternis.dev / ternis-edv.de',
        'title_line1'       => 'Technology that',
        'title_line2'       => 'breathes freedom.',
        'description'       => 'ternis.org maintains and scales open-source developer tooling by MTEX.dev, sovereign European email infrastructure, and lightning-fast edge static services. 100% Free, zero tracking, engineered for developers.',
        'cta_projects'      => 'Discover Projects',
        'cta_playground'    => 'Try Portfolio API',
        'cta_github'        => 'GitHub Org',
        'stat_open_source'     => '100% FOSS',
        'stat_open_source_sub' => 'MIT / Apache 2.0 Licensed',
        'stat_privacy'         => '0 Trackers',
        'stat_privacy_sub'     => 'Strict GDPR & EU Hosted',
        'stat_latency'         => '< 40ms',
        'stat_latency_sub'     => 'Global Edge Response',
        'stat_uptime'          => '99.9%',
        'stat_uptime_sub'      => 'Infrastructure SLA',
    ],

    'mission' => [
        'badge'       => 'Our Core Philosophy',
        'title'       => 'Built on Transparency, Performance & Freedom',
        'description' => 'We believe digital tools should be transparent, accessible to every developer without gatekeeping, and engineered with European privacy standards at their foundation.',
        'card1_title' => 'Open Source by Design',
        'card1_desc'  => 'Every service, library, and API under ternis.org is open-source. Anyone can audit the code, self-host instances, or contribute improvements.',
        'card2_title' => 'European Digital Sovereignty',
        'card2_desc'  => 'Our systems are built with zero third-party telemetry, strict GDPR compliance, and hosted on energy-efficient European infrastructure.',
        'card3_title' => 'Developer Ergonomics',
        'card3_desc'  => 'Clean REST interfaces, predictable schemas, comprehensive docs, and instant zero-config integrations tailored for modern engineering workflows.',
    ],

    'projects' => [
        'title'          => 'Projects ternis.org is Working On',
        'subtitle'       => 'Open-source developer tooling, sovereign infrastructure, and privacy platforms maintained under the ternis.org umbrella.',
        'dnbx_note'      => 'All domains listed are managed through dnbx.de (by ternis.dev).',
        'view_project'   => 'Visit Project',
        'view_docs'      => 'API Docs',
        'view_repo'      => 'Source Code',

        'httpclient' => [
            'title'       => 'httpclient.de',
            'badge'       => 'Work in Progress',
            'tagline'     => 'Free HTTP-Client for Web & Desktop',
            'description' => 'A clean, fast, and open-source HTTP client available both in the browser and as a lightweight native desktop app for API testing, debugging, and request inspection.',
            'tags'        => ['HTTP Client', 'Web & Desktop', 'Developer Tool', 'Open Source', 'Free'],
            'url'         => 'https://httpclient.de',
        ],

        'apisandbox' => [
            'title'       => 'api-sandbox.de',
            'badge'       => 'Partly Functional',
            'tagline'     => 'Simple & Free API Viewer',
            'description' => 'A free and open-source, minimalist API viewer and sandbox designed for quickly inspecting REST endpoints, schemas, and live JSON payloads.',
            'tags'        => ['API Viewer', 'Sandbox', 'JSON Inspector', 'Open Source', 'Free'],
            'url'         => 'https://api-sandbox.de',
        ],

        'mtex' => [
            'title'       => 'MTEX.dev',
            'badge'       => 'Active Ecosystem',
            'tagline'     => 'Developer Tools & UI Components',
            'description' => 'A suite of free and open-source developer utilities and sandboxes, maintaining projects like getmy.name (Free Portfolio-API) and lightweight productivity toolsets.',
            'tags'        => ['Tooling Suite', 'getmy.name', 'UI Components', 'Open Source', 'Free'],
            'url'         => 'https://mtex.dev',
            'docs_url'    => 'https://getmy.name/api-docs',
        ],

        'websearch' => [
            'title'       => 'web-search.org',
            'badge'       => 'Work in Progress',
            'tagline'     => 'Self-Hostable Search Engine Without the Fuss',
            'description' => 'A free, open-source, and simply self-hostable search engine focused on clean, privacy-respecting indexing without algorithmic bloat or user profiling.',
            'tags'        => ['Search Engine', 'Self-Hostable', 'Privacy First', 'Open Source', 'Free'],
            'url'         => 'https://web-search.org',
        ],

        'mailfree' => [
            'title'       => 'mail-free.eu + mail-free.uk',
            'badge'       => 'In Development',
            'tagline'     => 'Auto-Generated Inboxes & Online Privacy',
            'description' => 'Free, open-source email generation and digital privacy relay platform protecting your personal inbox through instant auto-generated aliases and secure European relays.',
            'tags'        => ['Email Privacy', 'Auto-Generated Aliases', 'EU/UK Sovereign', 'Open Source', 'Free'],
            'url_eu'      => 'https://mail-free.eu',
            'url_uk'      => 'https://mail-free.uk',
        ],

        'staticre' => [
            'title'       => 'static.re',
            'badge'       => 'Platform (Paid Tier) & Open-Source Software',
            'tagline'     => 'S3 & Cloudflare R2 Object Storage Platform',
            'description' => 'Open-source software and managed distribution platform (with dedicated commercial tiers) for interacting with S3-compatible object storage like Cloudflare R2.',
            'tags'        => ['S3 Compatible', 'Cloudflare R2', 'Object Storage', 'Open Source Software', 'Platform'],
            'url'         => 'https://static.re',
        ],
    ],

    'playground' => [
        'badge'          => 'Interactive Sandbox',
        'title'          => 'Test getmy.name Live in Your Browser',
        'subtitle'       => 'Experience how simple it is to consume developer profiles from our open API. Select your preferred programming language or execute a real request below.',
        'endpoint_label' => 'Live Endpoint',
        'btn_send'       => 'Send Request',
        'btn_sending'    => 'Sending...',
        'btn_copy'       => 'Copy Code',
        'btn_copied'     => 'Copied!',
        'response_label' => 'API Response (JSON)',
        'latency_label'  => 'Latency',
        'status_label'   => 'Status: 200 OK',
        'tab_curl'       => 'cURL',
        'tab_js'         => 'JavaScript',
        'tab_py'         => 'Python',
        'tab_php'        => 'PHP',
        'tip'            => 'You can integrate this endpoint directly into React, Vue, Next.js, Hugo, Astro, or static HTML pages.',
    ],

    'maintainer' => [
        'badge'          => 'Maintainership & Stewardship',
        'title'          => 'Maintained by ternis.dev (ternis-edv.de)',
        'subtitle'       => 'ternis.org is maintained by Fabian Ternis and backed by ternis-edv.de — a boutique German web development and digital engineering studio.',
        'desc1'          => 'Through ternis-edv.de and ternis.dev, we build modern digital products, reliable cloud architecture, and high-quality web solutions for clients and communities alike.',
        'desc2'          => 'ternis.org serves as our dedicated open-source non-profit wing, ensuring long-term maintenance, server funding, and community governance for MTEX.dev and associated projects.',
        'link_ternis_dev'=> 'ternis.dev (Portfolio)',
        'link_ternis_edv'=> 'ternis-edv.de (Studio)',
        'link_github'    => 'GitHub Profile',
    ],

    'roadmap' => [
        'badge'    => 'Future Outlook',
        'title'    => 'Initiatives & Releases Roadmap',
        'subtitle' => 'Transparent milestones for infrastructure upgrades and new service rollouts.',
        'q1_badge' => 'Phase 1 • Live',
        'q1_title' => 'Ecosystem Consolidation & getmy.name v1',
        'q1_desc'  => 'Unified organization setup under ternis.org, API stability improvements, and open developer documentation.',
        'q2_badge' => 'Phase 2 • Q3-Q4 2026',
        'q2_title' => 'mail-free.eu & .uk Alpha Rollout',
        'q2_desc'  => 'Deployment of sovereign mail relays, developer webhook routing, and GDPR-native web dashboard.',
        'q3_badge' => 'Phase 3 • In Progress',
        'q3_title' => 'static.re Global Edge Network',
        'q3_desc'  => 'Public release of edge static caching, custom vanity URLs for open-source repositories, and CDN points of presence.',
        'q4_badge' => 'Phase 4 • Planned',
        'q4_title' => 'Federated Identity & Community SDKs',
        'q4_desc'  => 'SDK releases for TypeScript, Go, Python, and Rust to integrate all ternis.org APIs seamlessly.',
    ],

    'opensource' => [
        'badge'            => 'Community & Contribution',
        'title'            => '100% Free & Open Source',
        'subtitle'         => 'Every line of code powering our services is publicly accessible. Join our growing community of contributors, report issues, or propose new features.',
        'card_code_title'  => 'Source Repositories',
        'card_code_desc'   => 'Explore the repositories on GitHub, inspect the code, fork, and submit pull requests.',
        'card_issues_title'=> 'Issue Tracking & Discussions',
        'card_issues_desc' => 'Found a bug or have an idea? Open an issue on GitHub to discuss roadmap features with maintainers.',
        'card_host_title'  => 'Self-Hosting Guides',
        'card_host_desc'   => 'Run all projects on your own servers with Docker Compose and our pre-built container images.',
        'btn_github_org'   => 'Visit ternis-org on GitHub',
        'btn_guidelines'   => 'Contribution Guidelines',
    ],

    'faq' => [
        'badge'    => 'Got Questions?',
        'title'    => 'Frequently Asked Questions',
        'subtitle' => 'Everything you need to know about ternis.org, the maintained projects, and how to get involved.',
        'items'    => [
            [
                'q' => 'What is the purpose of ternis.org?',
                'a' => 'ternis.org is an open-source organization umbrella operated by ternis.dev (ternis-edv.de). It maintains and hosts community projects like MTEX.dev tools, getmy.name (Free Portfolio API), mail-free.eu/.uk, and static.re.',
            ],
            [
                'q' => 'Is getmy.name completely free to use?',
                'a' => 'Yes, getmy.name is 100% free and open-source. Developers can register and query their portfolio data via the REST API with zero costs and zero ads.',
            ],
            [
                'q' => 'How are privacy and GDPR handled across your services?',
                'a' => 'We strictly avoid tracking scripts, advertising trackers, and third-party profiling cookies. All servers are located in European datacenters adhering to strict GDPR regulations.',
            ],
            [
                'q' => 'What is the relationship between ternis.org, ternis.dev, and ternis-edv.de?',
                'a' => 'ternis-edv.de is the German digital studio and legal entity operated by Fabian Ternis. ternis.dev is the developer portfolio/engineering hub, and ternis.org is the dedicated open-source organization that maintains community software and public infrastructure.',
            ],
            [
                'q' => 'How can I contribute or sponsor the infrastructure?',
                'a' => 'You can contribute code, documentation, or bug reports via our GitHub organization (ternis-org). If you would like to support server hosting costs, check out our GitHub Sponsors page.',
            ],
        ],
    ],

    'cta' => [
        'title'       => 'Ready to build with open-source tools?',
        'subtitle'    => 'Join hundreds of developers using ternis.org services to power their personal projects and production workflows.',
        'btn_github'  => 'Star on GitHub',
        'btn_contact' => 'Get in Touch with ternis.dev',
    ],

    'footer' => [
        'tagline'        => 'Open Source Developer Infrastructure & Tooling.',
        'description'    => 'Maintained by ternis.dev (ternis-edv.de) • Built with passion for open software, developer ergonomics, and digital sovereignty.',
        'col_projects'   => 'Projects',
        'col_ecosystem'  => 'Ecosystem',
        'col_community'  => 'Community',
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
            'contact_email'    => 'Email: contact@ternis.dev / info@ternis-edv.de',
            'contact_web'      => 'Web: https://ternis.dev | https://ternis-edv.de | https://ternis.org',
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
            'rights_text'     => 'Under the European General Data Protection Regulation (GDPR), you have the right to access, rectify, or request deletion of any personal data stored about you. For inquiries, reach out to privacy@ternis.dev.',
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

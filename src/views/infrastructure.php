<?php

declare(strict_types=1);

/**
 * Infrastructure Index: /{lang}/infrastructure
 * Details the live backbone network of ternis.net powering ternis.org.
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';
?>
<div class="infra-index-page">
    <div class="container" style="padding-top: 2rem; padding-bottom: 5rem;">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="Breadcrumb" class="infra-crumbs" style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--text-muted);margin-bottom:2rem;">
            <a href="/<?= e($lang) ?>" style="display:inline-flex;align-items:center;gap:0.35rem;color:var(--text-muted);text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>ternis.org</span>
            </a>
            <span aria-hidden="true">&rsaquo;</span>
            <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Infrastruktur (ternis.net)' : 'Infrastructure (ternis.net)' ?></span>
        </nav>

        <!-- Hero Header -->
        <header class="section-header scroll-reveal" style="text-align:left;margin-bottom:3.5rem;">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.35rem 0.85rem;border-radius:9999px;background:rgba(234,88,12,0.1);border:1px solid rgba(234,88,12,0.3);color:var(--primary);font-size:0.8125rem;font-weight:600;font-family:var(--font-mono);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:1rem;">
                <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px #22c55e;"></span>
                <span>ternis.net Backbone // All Systems Operational</span>
            </div>
            <h1 style="font-size:clamp(2rem, 4vw, 3.25rem);font-weight:800;letter-spacing:-0.03em;margin-bottom:1rem;line-height:1.15;">
                <?= $isDe ? 'Autonome Infrastruktur & Anycast DNS' : 'Autonomous Infrastructure & Anycast DNS' ?>
            </h1>
            <p style="font-size:1.125rem;color:var(--text-muted);max-width:800px;line-height:1.65;margin:0;">
                <?= $isDe
                    ? 'Die technische Architektur hinter ternis.org: Autonome autoritative Anycast-Nameserver, Stratum-Zeitsynchronisation, souveräne Mail-Gateways und kryptografische Validierung auf ternis.net.'
                    : 'The technical architecture powering ternis.org: Autonomous authoritative Anycast nameservers, Stratum time synchronization, sovereign mail relays, and cryptographic DNSSEC validation on ternis.net.'
                ?>
            </p>

            <!-- Global Architecture Stats -->
            <div class="hero-stats" style="margin-top:2.5rem;display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1rem;">
                <div class="stat-item" style="padding:1.25rem;background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;">
                    <div class="stat-value" style="font-size:1.75rem;font-weight:700;color:var(--primary);">Anycast BGP</div>
                    <div class="stat-label" style="font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'Redundante Rechenzentren DE' : 'Redundant Datacenters DE' ?></div>
                </div>
                <div class="stat-item" style="padding:1.25rem;background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;">
                    <div class="stat-value" style="font-size:1.75rem;font-weight:700;color:var(--primary);">Dual-Stack</div>
                    <div class="stat-label" style="font-size:0.8125rem;color:var(--text-muted);">IPv4 & Native IPv6</div>
                </div>
                <div class="stat-item" style="padding:1.25rem;background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;">
                    <div class="stat-value" style="font-size:1.75rem;font-weight:700;color:var(--primary);">DNSSEC</div>
                    <div class="stat-label" style="font-size:0.8125rem;color:var(--text-muted);">ECDSA Curve P-256 (Alg 13)</div>
                </div>
                <div class="stat-item" style="padding:1.25rem;background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;">
                    <div class="stat-value" style="font-size:1.75rem;font-weight:700;color:#22c55e;">0.0%</div>
                    <div class="stat-label" style="font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'Telemetry & Logging' : 'Telemetry & Zero-Logging' ?></div>
                </div>
            </div>
        </header>

        <!-- Backbone Nodes Grid -->
        <section style="margin-bottom: 4.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                <div>
                    <h2 style="font-size:1.75rem;font-weight:700;letter-spacing:-0.02em;margin:0 0 0.25rem;">
                        <?= $isDe ? 'Primäre Routing-Knoten' : 'Core Backbone Nodes' ?>
                    </h2>
                    <p style="font-size:0.9375rem;color:var(--text-muted);margin:0;">
                        <?= $isDe ? 'Geografisch getrennte autoritative Nameserver und Netzwerkdienste auf ternis.net.' : 'Geographically separated authoritative nameservers and infrastructure daemons on ternis.net.' ?>
                    </p>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:1.5rem;">
                
                <!-- Node 1: one.ns.ternis.net -->
                <div class="infra-node-card" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:1.75rem;position:relative;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;background:rgba(234,88,12,0.15);color:var(--primary);border-radius:6px;font-weight:600;">NS1 • PRIMARY</span>
                            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.8125rem;color:#22c55e;font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                                <?= $isDe ? 'Online' : 'Operational' ?>
                            </span>
                        </div>
                        <h3 style="font-size:1.35rem;font-weight:700;margin:0 0 0.5rem;font-family:var(--font-mono);">one.ns.ternis.net</h3>
                        <p style="font-size:0.875rem;color:var(--text-muted);margin:0 0 1.25rem;line-height:1.5;">
                            <?= $isDe ? 'Primärer autoritativer Anycast-Routing-Knoten. Direkte Zone-Distribution und DDoS-Scrubbing.' : 'Primary authoritative Anycast routing node with instant zone synchronization and high-throughput packet processing.' ?>
                        </p>

                        <div style="background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:8px;padding:0.875rem;margin-bottom:1.25rem;font-family:var(--font-mono);font-size:0.8125rem;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);"><?= $isDe ? 'Standort' : 'Location' ?>:</span>
                                <span>Frankfurt am Main (FRA), DE</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">Engine:</span>
                                <span>BIND 9 + Knot DNS</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">DNSSEC:</span>
                                <span style="color:#22c55e;">ECDSA P-256 (Alg 13)</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;">
                                <span style="color:var(--text-muted);">Direct Alias:</span>
                                <span>example-dns.net</span>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem;">
                        <button type="button" class="btn btn-outline btn-sm copy-chip-btn" data-copy="one.ns.ternis.net" data-toast="Hostname one.ns.ternis.net copied!" style="flex:1;justify-content:center;font-size:0.8125rem;">
                            <span><?= $isDe ? 'Host kopieren' : 'Copy Host' ?></span>
                        </button>
                    </div>
                </div>

                <!-- Node 2: two.ns.ternis.net -->
                <div class="infra-node-card" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:1.75rem;position:relative;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;background:rgba(56,189,248,0.15);color:#0284c7;border-radius:6px;font-weight:600;">NS2 • SECONDARY</span>
                            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.8125rem;color:#22c55e;font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                                <?= $isDe ? 'Online' : 'Operational' ?>
                            </span>
                        </div>
                        <h3 style="font-size:1.35rem;font-weight:700;margin:0 0 0.5rem;font-family:var(--font-mono);">two.ns.ternis.net</h3>
                        <p style="font-size:0.875rem;color:var(--text-muted);margin:0 0 1.25rem;line-height:1.5;">
                            <?= $isDe ? 'Geografisch getrennter sekundärer Replikationsknoten. Unabhängiges Netz und Notfall-Fallback.' : 'Geographically isolated secondary replication node with autonomous upstream transit and emergency failover.' ?>
                        </p>

                        <div style="background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:8px;padding:0.875rem;margin-bottom:1.25rem;font-family:var(--font-mono);font-size:0.8125rem;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);"><?= $isDe ? 'Standort' : 'Location' ?>:</span>
                                <span>Nuremberg (NUE), DE</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">Engine:</span>
                                <span>NSD (Name Server Daemon)</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">DNSSEC:</span>
                                <span style="color:#22c55e;">ECDSA P-256 (Alg 13)</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;">
                                <span style="color:var(--text-muted);">Direct Alias:</span>
                                <span>example-dns.org</span>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem;">
                        <button type="button" class="btn btn-outline btn-sm copy-chip-btn" data-copy="two.ns.ternis.net" data-toast="Hostname two.ns.ternis.net copied!" style="flex:1;justify-content:center;font-size:0.8125rem;">
                            <span><?= $isDe ? 'Host kopieren' : 'Copy Host' ?></span>
                        </button>
                    </div>
                </div>

                <!-- Node 3: time.ternis.net -->
                <div class="infra-node-card" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:1.75rem;position:relative;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;background:rgba(168,85,247,0.15);color:#a855f7;border-radius:6px;font-weight:600;">NTP • STRATUM 1/2</span>
                            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.8125rem;color:#22c55e;font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                                <?= $isDe ? 'Synchron' : 'Synchronized' ?>
                            </span>
                        </div>
                        <h3 style="font-size:1.35rem;font-weight:700;margin:0 0 0.5rem;font-family:var(--font-mono);">time.ternis.net</h3>
                        <p style="font-size:0.875rem;color:var(--text-muted);margin:0 0 1.25rem;line-height:1.5;">
                            <?= $isDe ? 'Hardware-referenzierter Zeitsynchronisationsdienst für RRSIG-Signatur-Gültigkeiten und Cluster-Konsistenz.' : 'Hardware-referenced network time service providing sub-millisecond precision for DNSSEC RRSIG and cluster logs.' ?>
                        </p>

                        <div style="background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:8px;padding:0.875rem;margin-bottom:1.25rem;font-family:var(--font-mono);font-size:0.8125rem;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">Protocols:</span>
                                <span>NTPv4, NTS (RFC 8915)</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">Jitter:</span>
                                <span style="color:#22c55e;">&lt; 0.15 ms</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;">
                                <span style="color:var(--text-muted);"><?= $isDe ? 'Nutzung' : 'Usage' ?>:</span>
                                <span>Core Systems & Clusters</span>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem;">
                        <button type="button" class="btn btn-outline btn-sm copy-chip-btn" data-copy="time.ternis.net" data-toast="time.ternis.net copied!" style="flex:1;justify-content:center;font-size:0.8125rem;">
                            <span><?= $isDe ? 'Host kopieren' : 'Copy Host' ?></span>
                        </button>
                    </div>
                </div>

                <!-- Node 4: mail.ternis.net & _spf.ternis.net -->
                <div class="infra-node-card" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:1.75rem;position:relative;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;background:rgba(34,197,94,0.15);color:#16a34a;border-radius:6px;font-weight:600;">RELAY • GATEWAY</span>
                            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.8125rem;color:#22c55e;font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                                <?= $isDe ? 'Geschützt' : 'Enforced' ?>
                            </span>
                        </div>
                        <h3 style="font-size:1.35rem;font-weight:700;margin:0 0 0.5rem;font-family:var(--font-mono);">_spf.ternis.net</h3>
                        <p style="font-size:0.875rem;color:var(--text-muted);margin:0 0 1.25rem;line-height:1.5;">
                            <?= $isDe ? 'Zentraler SPF-, DKIM- und DMARC-Sicherheitsanker für alle Domains des ternis.org- und mail-free-Netzwerks.' : 'Central cryptographic SPF inclusion, DKIM signing, and DMARC policy anchor for all ecosystem domains.' ?>
                        </p>

                        <div style="background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:8px;padding:0.875rem;margin-bottom:1.25rem;font-family:var(--font-mono);font-size:0.8125rem;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">SPF Policy:</span>
                                <span>include:_spf.ternis.net</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:0.35rem;">
                                <span style="color:var(--text-muted);">DMARC:</span>
                                <span style="color:#22c55e;">p=reject (Strict)</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;">
                                <span style="color:var(--text-muted);">DKIM:</span>
                                <span>2048-bit RSA + Ed25519</span>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem;">
                        <button type="button" class="btn btn-outline btn-sm copy-chip-btn" data-copy="v=spf1 include:_spf.ternis.net ~all" data-toast="SPF record copied!" style="flex:1;justify-content:center;font-size:0.8125rem;">
                            <span><?= $isDe ? 'SPF-Record kopieren' : 'Copy SPF Record' ?></span>
                        </button>
                    </div>
                </div>

            </div>
        </section>

        <!-- Interactive DNS Verification Sandbox -->
        <section style="margin-bottom: 4.5rem;">
            <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:2rem;">
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
                    <div>
                        <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 0.25rem;">
                            <?= $isDe ? 'Live DNS-Inspektor & Befehls-Sandbox' : 'Live DNS Query Sandbox' ?>
                        </h2>
                        <p style="font-size:0.875rem;color:var(--text-muted);margin:0;">
                            <?= $isDe ? 'Wähle eine Abfrage, um die autoritativen Antworten von one.ns.ternis.net direkt einzusehen.' : 'Select a query preset to inspect real authoritative responses from one.ns.ternis.net.' ?>
                        </p>
                    </div>
                    
                    <!-- Query Preset Buttons -->
                    <div class="dns-preset-group" style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                        <button type="button" class="btn btn-outline btn-sm is-active" data-dns-cmd="dig @one.ns.ternis.net ternis.org SOA +noall +answer" data-dns-out="ternis.org.		3600	IN	SOA	one.ns.ternis.net. hostmaster.ternis.org. 2026100601 3600 600 1209600 300">SOA Record</button>
                        <button type="button" class="btn btn-outline btn-sm" data-dns-cmd="dig @one.ns.ternis.net ternis.org NS +noall +answer" data-dns-out="ternis.org.		3600	IN	NS	one.ns.ternis.net.&#10;ternis.org.		3600	IN	NS	two.ns.ternis.net.">NS Delegation</button>
                        <button type="button" class="btn btn-outline btn-sm" data-dns-cmd="dig @two.ns.ternis.net ternis.org DNSKEY +dnssec +noall +answer" data-dns-out="ternis.org.		3600	IN	DNSKEY	257 3 13 4a1F... (KSK ECDSA P-256)&#10;ternis.org.		3600	IN	DNSKEY	256 3 13 9b2C... (ZSK ECDSA P-256)&#10;ternis.org.		3600	IN	RRSIG	DNSKEY 13 2 3600 20261020000000 20261006000000 52814 ternis.org. ...">DNSSEC Keys</button>
                        <button type="button" class="btn btn-outline btn-sm" data-dns-cmd="dig @one.ns.ternis.net ternis.org TXT +noall +answer" data-dns-out="ternis.org.		3600	IN	TXT	&quot;v=spf1 include:_spf.ternis.net ~all&quot;">SPF & TXT</button>
                    </div>
                </div>

                <!-- Terminal Window -->
                <div class="ns-terminal" style="background:#090d13;border:1px solid #1f2937;border-radius:10px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.3);">
                    <div class="ns-terminal-header" style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 1rem;background:#111827;border-bottom:1px solid #1f2937;">
                        <div style="display:flex;gap:0.4rem;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                            <span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
                            <span style="width:10px;height:10px;border-radius:50%;background:#10b981;display:inline-block;"></span>
                        </div>
                        <span id="dns-term-label" style="font-family:var(--font-mono);font-size:0.75rem;color:#9ca3af;">one.ns.ternis.net — Authoritative Query</span>
                        <button type="button" id="copy-terminal-cmd" class="btn btn-ghost btn-sm" style="padding:0.2rem 0.5rem;font-size:0.75rem;color:#9ca3af;">
                            <?= $isDe ? 'Befehl kopieren' : 'Copy command' ?>
                        </button>
                    </div>
                    <div style="padding:1.25rem;font-family:var(--font-mono);font-size:0.875rem;line-height:1.6;color:#e5e7eb;">
                        <div style="color:#f97316;margin-bottom:0.75rem;">
                            <span style="color:#6b7280;">$ </span><span id="dns-term-cmd">dig @one.ns.ternis.net ternis.org SOA +noall +answer</span>
                        </div>
                        <pre id="dns-term-output" style="margin:0;color:#38bdf8;white-space:pre-wrap;font-family:inherit;">ternis.org.		3600	IN	SOA	one.ns.ternis.net. hostmaster.ternis.org. 2026100601 3600 600 1209600 300</pre>
                    </div>
                </div>
            </div>
        </section>

        <!-- Delegated Zone Inventory -->
        <section style="margin-bottom: 4.5rem;">
            <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 0.5rem;">
                <?= $isDe ? 'Delegierte Zonen & Ökosystem' : 'Delegated Zones & Ecosystem' ?>
            </h2>
            <p style="font-size:0.9375rem;color:var(--text-muted);margin:0 0 1.5rem;">
                <?= $isDe ? 'Übersicht aller Domain-Zonen, die von one.ns.ternis.net und two.ns.ternis.net autoritativ betreut werden.' : 'Direct inventory of all forward and reverse DNS zones authoritatively served by the ternis.net cluster.' ?>
            </p>

            <div style="overflow-x:auto;border:1px solid var(--border-subtle);border-radius:12px;background:var(--surface);">
                <table style="width:100%;border-collapse:collapse;text-align:left;font-size:0.875rem;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-subtle);background:rgba(255,255,255,0.02);color:var(--text-muted);">
                            <th style="padding:0.875rem 1.25rem;font-weight:600;">Zone (Domain)</th>
                            <th style="padding:0.875rem 1.25rem;font-weight:600;">Registry</th>
                            <th style="padding:0.875rem 1.25rem;font-weight:600;">Nameservers</th>
                            <th style="padding:0.875rem 1.25rem;font-weight:600;">DNSSEC</th>
                            <th style="padding:0.875rem 1.25rem;font-weight:600;">Status</th>
                        </tr>
                    </thead>
                    <tbody style="font-family:var(--font-mono);">
                        <tr style="border-bottom:1px solid var(--border-subtle);">
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">ternis.org</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">Public Interest Registry (.org)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Signed (Alg 13)</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border-subtle);">
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">Verisign (.net)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Signed (Alg 13)</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border-subtle);">
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">example-dns.com</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">Verisign (.com)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Signed (Alg 13)</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border-subtle);">
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">example-dns.net</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">Verisign (.net)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Signed (Alg 13)</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border-subtle);">
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">example-dns.org</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">PIR (.org)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Signed (Alg 13)</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                        <tr style="border-bottom:1px solid var(--border-subtle);">
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">ternisdomains.de</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">DENIC (.de)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Signed (Alg 13)</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                        <tr>
                            <td style="padding:0.875rem 1.25rem;font-weight:600;color:var(--text-main);">mtex.dev</td>
                            <td style="padding:0.875rem 1.25rem;color:var(--text-muted);">Google Registry (.dev)</td>
                            <td style="padding:0.875rem 1.25rem;">one/two.ns.ternis.net</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">HSTS Preload + Signed</td>
                            <td style="padding:0.875rem 1.25rem;color:#22c55e;">Active</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Technical Deep Dive & Cross Links to Wiki -->
        <section style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:2rem;">
            <div style="margin-bottom:1.5rem;">
                <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 0.25rem;">
                    <?= $isDe ? 'Technische Dokumentation im Wiki' : 'Related Technical Documentation' ?>
                </h2>
                <p style="font-size:0.9375rem;color:var(--text-muted);margin:0;">
                    <?= $isDe ? 'Erfahre im Detail, wie autoritative Nameserver, Glue Records und Anycast-Netzwerke aufgebaut werden.' : 'In-depth engineering guides covering how our authoritative Anycast cluster, glue records, and DNSSEC are deployed.' ?>
                </p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1rem;">
                <a href="/<?= e($lang) ?>/wiki/dns/selfhost-authoritative-dns" style="display:block;padding:1.25rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:10px;text-decoration:none;color:inherit;transition:border-color 0.15s ease;">
                    <div style="font-family:var(--font-mono);font-size:0.75rem;color:var(--primary);margin-bottom:0.35rem;">DNS // GUIDE</div>
                    <strong style="display:block;font-size:1rem;margin-bottom:0.35rem;"><?= $isDe ? 'Autoritativen DNS-Server selbst hosten' : 'Self-Host Authoritative DNS with Knot & BIND' ?></strong>
                    <span style="font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'Architektur, Zonentransfers (AXFR) und Redundanz wie bei ternis.net.' : 'Redundant master/slave architecture, zone signing, and live deployment.' ?></span>
                </a>

                <a href="/<?= e($lang) ?>/wiki/domains/nameserver-glue-delegation" style="display:block;padding:1.25rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:10px;text-decoration:none;color:inherit;transition:border-color 0.15s ease;">
                    <div style="font-family:var(--font-mono);font-size:0.75rem;color:var(--primary);margin-bottom:0.35rem;">DOMAINS // RFC</div>
                    <strong style="display:block;font-size:1rem;margin-bottom:0.35rem;"><?= $isDe ? 'Nameserver Glue Records & Delegation' : 'Nameserver Glue Records & Cross-TLD Delegation' ?></strong>
                    <span style="font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'Warum .net-Nameserver für .org keine Glue Records im Root benötigen.' : 'Why out-of-bailiwick .net nameservers eliminate circular root dependencies.' ?></span>
                </a>

                <a href="/<?= e($lang) ?>/wiki/dns/dnssec-basics" style="display:block;padding:1.25rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:10px;text-decoration:none;color:inherit;transition:border-color 0.15s ease;">
                    <div style="font-family:var(--font-mono);font-size:0.75rem;color:var(--primary);margin-bottom:0.35rem;">SECURITY // CRYPTO</div>
                    <strong style="display:block;font-size:1rem;margin-bottom:0.35rem;"><?= $isDe ? 'DNSSEC Grundlagen & Schlüsselkette' : 'DNSSEC Cryptographic Chain of Trust' ?></strong>
                    <span style="font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'DS-Records, KSK, ZSK und ECDSA P-256 Validierung in der Praxis.' : 'DS records, KSK, ZSK rollover, and cryptographic cache protection.' ?></span>
                </a>

                <a href="/<?= e($lang) ?>/wiki/domains/register-manage-ternisdomains" style="display:block;padding:1.25rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:10px;text-decoration:none;color:inherit;transition:border-color 0.15s ease;">
                    <div style="font-family:var(--font-mono);font-size:0.75rem;color:var(--primary);margin-bottom:0.35rem;">PLATFORM // ECOSYSTEM</div>
                    <strong style="display:block;font-size:1rem;margin-bottom:0.35rem;"><?= $isDe ? 'Domains verwalten mit ternisdomains.de' : 'Register and Manage Domains with ternisdomains.de' ?></strong>
                    <span style="font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'Praxis-Leitfaden für DNS-Einträge, TTLs und Nameserver-Delegation.' : 'Practical configuration workflow for DNS records and delegation.' ?></span>
                </a>
            </div>
        </section>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.dns-preset-group button');
    var cmdEl = document.getElementById('dns-term-cmd');
    var outEl = document.getElementById('dns-term-output');
    var copyBtn = document.getElementById('copy-terminal-cmd');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            buttons.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            var cmd = btn.getAttribute('data-dns-cmd') || '';
            var out = btn.getAttribute('data-dns-out') || '';
            if (cmdEl) cmdEl.textContent = cmd;
            if (outEl) outEl.innerHTML = out.replace(/&quot;/g, '"');
        });
    });

    if (copyBtn && cmdEl) {
        copyBtn.addEventListener('click', function () {
            var text = cmdEl.textContent || '';
            navigator.clipboard.writeText(text).then(function () {
                var prev = copyBtn.textContent;
                copyBtn.textContent = 'Copied!';
                setTimeout(function () { copyBtn.textContent = prev; }, 1500);
            });
        });
    }
});
</script>

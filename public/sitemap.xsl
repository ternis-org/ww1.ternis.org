<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xhtml="http://www.w3.org/1999/xhtml"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html lang="en">
      <head>
        <title>XML Sitemap — ternis.org</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
          :root {
            --bg: #0b0f19;
            --surface: #111827;
            --border: #1f2937;
            --text: #f3f4f6;
            --muted: #9ca3af;
            --accent: #38bdf8;
            --accent-dim: rgba(56, 189, 248, 0.12);
            --code-bg: #1e293b;
          }
          @media (prefers-color-scheme: light) {
            :root {
              --bg: #f8fafc;
              --surface: #ffffff;
              --border: #e2e8f0;
              --text: #0f172a;
              --muted: #64748b;
              --accent: #0284c7;
              --accent-dim: rgba(2, 132, 199, 0.08);
              --code-bg: #f1f5f9;
            }
          }
          * { box-sizing: border-box; margin: 0; padding: 0; }
          body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
            padding: 2rem 1rem;
          }
          .container {
            max-width: 1100px;
            margin: 0 auto;
          }
          header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
          }
          h1 {
            font-size: 1.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
          }
          .badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.2rem 0.5rem;
            background: var(--accent-dim);
            color: var(--accent);
            border-radius: 4px;
            border: 1px solid var(--accent);
          }
          p.desc {
            color: var(--muted);
            font-size: 0.95rem;
          }
          .stats {
            margin-top: 1rem;
            display: inline-flex;
            gap: 1.5rem;
            background: var(--surface);
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.9rem;
          }
          .stats strong {
            color: var(--accent);
          }
          .table-wrap {
            overflow-x: auto;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
          }
          th {
            background: rgba(255, 255, 255, 0.02);
            padding: 0.75rem 1rem;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            white-space: nowrap;
          }
          td {
            padding: 0.65rem 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
          }
          tr:last-child td {
            border-bottom: none;
          }
          tr:hover td {
            background: rgba(56, 189, 248, 0.03);
          }
          a {
            color: var(--accent);
            text-decoration: none;
            word-break: break-all;
          }
          a:hover {
            text-decoration: underline;
          }
          .date, .freq, .prio {
            color: var(--muted);
            white-space: nowrap;
          }
          footer {
            margin-top: 2rem;
            text-align: center;
            color: var(--muted);
            font-size: 0.8rem;
          }
        </style>
      </head>
      <body>
        <div class="container">
          <header>
            <h1>
              XML Sitemap
              <span class="badge">Google / Search Engine Compliant</span>
            </h1>
            <p class="desc">
              This is a standard XML sitemap generated dynamically for search engines like Google, Bing, and DuckDuckGo.
              Web browsers display this styled view for human readers.
            </p>
            <div class="stats">
              <div>Total Indexed URLs: <strong><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></strong></div>
              <div>Root Domain: <strong>ternis.org</strong></div>
            </div>
          </header>

          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th style="width: 50px;">#</th>
                  <th>URL (Location)</th>
                  <th>Last Modified</th>
                  <th>Change Frequency</th>
                  <th>Priority</th>
                </tr>
              </thead>
              <tbody>
                <xsl:for-each select="sitemap:urlset/sitemap:url">
                  <tr>
                    <td class="prio"><xsl:value-of select="position()"/></td>
                    <td>
                      <a href="{sitemap:loc}">
                        <xsl:value-of select="sitemap:loc"/>
                      </a>
                    </td>
                    <td class="date"><xsl:value-of select="sitemap:lastmod"/></td>
                    <td class="freq"><xsl:value-of select="sitemap:changefreq"/></td>
                    <td class="prio"><xsl:value-of select="sitemap:priority"/></td>
                  </tr>
                </xsl:for-each>
              </tbody>
            </table>
          </div>

          <footer>
            ternis.org — Sovereign Infrastructure &amp; Technical Wiki
          </footer>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>

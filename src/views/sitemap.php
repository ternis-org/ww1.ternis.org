<?php

declare(strict_types=1);

/**
 * Dynamic XML Sitemap Generator
 */

$baseUrl = 'https://ternis.org';
$lastmod = date('Y-m-d');

$pages = [
    ''              => ['changefreq' => 'weekly',  'priority' => '1.0'],
    '/legal/imprint'=> ['changefreq' => 'monthly', 'priority' => '0.5'],
    '/legal/privacy'=> ['changefreq' => 'monthly', 'priority' => '0.5'],
    '/legal/license'=> ['changefreq' => 'monthly', 'priority' => '0.5'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($pages as $path => $meta): ?>
    <?php foreach (['en', 'de'] as $lang): ?>
    <url>
        <loc><?= e($baseUrl . '/' . $lang . $path) ?></loc>
        <xhtml:link rel="alternate" hreflang="en" href="<?= e($baseUrl . '/en' . $path) ?>" />
        <xhtml:link rel="alternate" hreflang="de" href="<?= e($baseUrl . '/de' . $path) ?>" />
        <xhtml:link rel="alternate" hreflang="x-default" href="<?= e($baseUrl . '/en' . $path) ?>" />
        <lastmod><?= e($lastmod) ?></lastmod>
        <changefreq><?= e($meta['changefreq']) ?></changefreq>
        <priority><?= e($meta['priority']) ?></priority>
    </url>
    <?php endforeach; ?>
<?php endforeach; ?>
</urlset>

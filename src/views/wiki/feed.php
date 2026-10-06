<?php

declare(strict_types=1);

/**
 * Atom 1.0 XML Feed Generator for Wiki Articles
 */

$baseUrl = rtrim((string) config('app_url', 'https://ternis.org'), '/');
require_once ROOT_PATH . '/src/wiki.php';

$allArticles = [];
$categories = wiki_categories();

foreach (array_keys($categories) as $cat) {
    foreach (wiki_list_articles('en', $cat) as $art) {
        $art['category_label'] = $categories[$cat]['en'] ?? $cat;
        $allArticles[] = $art;
    }
}

// Sort by modification time descending (newest first)
usort($allArticles, static fn($a, $b) => $b['source_mtime'] <=> $a['source_mtime']);
$feedArticles = array_slice($allArticles, 0, 30);
$latestMtime = !empty($feedArticles) ? $feedArticles[0]['source_mtime'] : time();

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title>ternis.org Technical Wiki</title>
  <subtitle>In-depth technical guides for Linux, Networking, DNS, Homelab, and DevOps</subtitle>
  <link href="<?= e($baseUrl) ?>/wiki/feed.xml" rel="self" type="application/atom+xml"/>
  <link href="<?= e($baseUrl) ?>/en/wiki" rel="alternate" type="text/html"/>
  <id><?= e($baseUrl) ?>/wiki/feed.xml</id>
  <updated><?= gmdate('Y-m-d\TH:i:s\Z', $latestMtime) ?></updated>
  <author>
    <name>ternis.org</name>
    <uri><?= e($baseUrl) ?></uri>
  </author>

<?php foreach ($feedArticles as $art): ?>
<?php
    $url = $baseUrl . '/en/wiki/' . $art['category'] . '/' . $art['slug'];
    $updatedIso = gmdate('Y-m-d\TH:i:s\Z', $art['source_mtime']);
?>
  <entry>
    <title><?= e($art['title']) ?></title>
    <link href="<?= e($url) ?>" rel="alternate" type="text/html"/>
    <id><?= e($url) ?></id>
    <updated><?= e($updatedIso) ?></updated>
    <published><?= e($updatedIso) ?></published>
    <category term="<?= e($art['category']) ?>" label="<?= e($art['category_label']) ?>"/>
    <summary type="text"><?= e($art['description']) ?></summary>
  </entry>
<?php endforeach; ?>
</feed>

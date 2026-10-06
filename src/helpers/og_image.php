<?php

declare(strict_types=1);

/**
 * OpenGraph Image Generator for ternis.org & Wiki Articles
 * Renders 1200x630 pixel branded cards.
 */

function generate_og_image(
    string $title,
    string $description = '',
    string $category = '',
    string $date = '',
    string $siteLabel = 'ternis.org // Technical Knowledge Base'
): void {
    $width = 1200;
    $height = 630;

    $im = imagecreatetruecolor($width, $height);
    if ($im === false) {
        http_response_code(500);
        exit('Failed to initialize GD');
    }

    // Enable antialiasing
    if (function_exists('imageantialias')) {
        imageantialias($im, true);
    }

    // Colors
    $bgDark = imagecolorallocate($im, 13, 17, 23); // #0d1117
    $cardBg = imagecolorallocate($im, 17, 24, 39); // #111827
    $borderCol = imagecolorallocate($im, 45, 55, 72); // subtle border
    $brandOrange = imagecolorallocate($im, 234, 88, 12); // #ea580c
    $brandAmber = imagecolorallocate($im, 249, 115, 22); // #f97316
    $badgeBg = imagecolorallocate($im, 31, 41, 55); // #1f2937
    $badgeBorder = imagecolorallocate($im, 75, 85, 99);
    $textWhite = imagecolorallocate($im, 243, 244, 246); // #f3f4f6
    $textMuted = imagecolorallocate($im, 156, 163, 175); // #9ca3af
    $textDim = imagecolorallocate($im, 107, 114, 128); // #6b7280

    // Fill background
    imagefilledrectangle($im, 0, 0, $width, $height, $bgDark);

    // Subtle decorative grid dots
    $dotColor = imagecolorallocatealpha($im, 255, 255, 255, 120);
    for ($x = 40; $x < $width; $x += 40) {
        for ($y = 40; $y < $height; $y += 40) {
            imagesetpixel($im, $x, $y, $dotColor);
        }
    }

    // Decorative gradient accent bar on top
    for ($i = 0; $i < 6; $i++) {
        $alpha = (int) (127 - (127 * (6 - $i) / 6));
        $glow = imagecolorallocatealpha($im, 234, 88, 12, max(0, min(127, $alpha + 60)));
        imageline($im, 0, $i, $width, $i, $glow);
    }
    imagefilledrectangle($im, 0, 0, $width, 3, $brandOrange);

    // Outer card inset border
    imagerectangle($im, 30, 30, $width - 31, $height - 31, $borderCol);

    // Font files
    $fontTitle = ROOT_PATH . '/resources/fonts/Outfit.ttf';
    $fontMono = ROOT_PATH . '/resources/fonts/JetBrainsMono.ttf';

    $hasTtf = file_exists($fontTitle) && function_exists('imagettftext');

    if ($hasTtf) {
        // 1. Top Bar: Logo Icon + Site Label
        // Logo badge box
        imagefilledrectangle($im, 60, 60, 100, 100, $brandOrange);
        imagettftext($im, 24, 0, 71, 93, $textWhite, $fontTitle, 'T');

        // Site Label
        imagettftext($im, 16, 0, 120, 88, $textMuted, $fontMono, strtoupper($siteLabel));

        // 2. Category Badge (if provided)
        $contentStartY = 160;
        if ($category !== '') {
            $catLabel = strtoupper($category);
            $catBox = imagettfbbox(14, 0, $fontMono, $catLabel);
            $catWidth = abs($catBox[4] - $catBox[0]) + 32;
            $catHeight = 34;

            imagefilledrectangle($im, 60, $contentStartY, 60 + $catWidth, $contentStartY + $catHeight, $badgeBg);
            imagerectangle($im, 60, $contentStartY, 60 + $catWidth, $contentStartY + $catHeight, $badgeBorder);
            imagettftext($im, 14, 0, 76, $contentStartY + 23, $brandAmber, $fontMono, $catLabel);

            $contentStartY += 60;
        }

        // 3. Main Title (Word Wrapped)
        $titleFontSize = 38;
        $titleWords = explode(' ', $title);
        $titleLines = [];
        $currentLine = '';

        foreach ($titleWords as $word) {
            $testLine = $currentLine === '' ? $word : $currentLine . ' ' . $word;
            $testBox = imagettfbbox($titleFontSize, 0, $fontTitle, $testLine);
            $testWidth = abs($testBox[4] - $testBox[0]);

            if ($testWidth > 1060 && $currentLine !== '') {
                $titleLines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }
        if ($currentLine !== '') {
            $titleLines[] = $currentLine;
        }

        // Limit to max 3 lines for visual balance
        if (count($titleLines) > 3) {
            $titleLines = array_slice($titleLines, 0, 3);
            $titleLines[2] = rtrim($titleLines[2], '.') . '...';
        }

        $yCursor = $contentStartY + 35;
        foreach ($titleLines as $line) {
            imagettftext($im, $titleFontSize, 0, 60, $yCursor, $textWhite, $fontTitle, $line);
            $yCursor += 52;
        }

        // 4. Description Subtitle (Word Wrapped)
        if ($description !== '') {
            $descFontSize = 18;
            $descWords = explode(' ', $description);
            $descLines = [];
            $currDescLine = '';

            foreach ($descWords as $word) {
                $testLine = $currDescLine === '' ? $word : $currDescLine . ' ' . $word;
                $testBox = imagettfbbox($descFontSize, 0, $fontTitle, $testLine);
                if (abs($testBox[4] - $testBox[0]) > 1060 && $currDescLine !== '') {
                    $descLines[] = $currDescLine;
                    $currDescLine = $word;
                } else {
                    $currDescLine = $testLine;
                }
            }
            if ($currDescLine !== '') {
                $descLines[] = $currDescLine;
            }

            if (count($descLines) > 2) {
                $descLines = array_slice($descLines, 0, 2);
                $descLines[1] = rtrim($descLines[1], '.') . '...';
            }

            $yCursor += 15;
            foreach ($descLines as $dLine) {
                imagettftext($im, $descFontSize, 0, 60, $yCursor, $textMuted, $fontTitle, $dLine);
                $yCursor += 30;
            }
        }

        // 5. Bottom Metadata Bar
        $bottomY = $height - 70;
        imageline($im, 60, $bottomY - 20, $width - 60, $bottomY - 20, $borderCol);

        $footerLeft = 'ternis.org Infrastructure Ecosystem';
        imagettftext($im, 14, 0, 60, $bottomY + 10, $textDim, $fontMono, $footerLeft);

        $footerRight = $date !== '' ? 'Updated ' . $date . '  •  ternis.org' : 'ternis.org/wiki';
        $footBox = imagettfbbox(14, 0, $fontMono, $footerRight);
        $footW = abs($footBox[4] - $footBox[0]);
        imagettftext($im, 14, 0, $width - 60 - $footW, $bottomY + 10, $brandAmber, $fontMono, $footerRight);

    } else {
        // Fallback with built-in GD bitmap fonts if TTF is unavailable
        imagestring($im, 5, 60, 60, $siteLabel, $textWhite);
        if ($category !== '') {
            imagestring($im, 4, 60, 110, '[' . strtoupper($category) . ']', $brandAmber);
        }
        imagestring($im, 5, 60, 160, substr($title, 0, 80), $textWhite);
        if ($description !== '') {
            imagestring($im, 4, 60, 200, substr($description, 0, 120), $textMuted);
        }
        imagestring($im, 4, 60, $height - 80, 'ternis.org // Technical Wiki', $textDim);
    }

    // Output headers & image stream
    header('Content-Type: image/png');
    header('Cache-Control: public, max-age=604800, stale-while-revalidate=86400');
    header('X-Content-Type-Options: nosniff');
    imagepng($im);
    exit;
}

<?php
/**
 * QR Code Diagnostic Script
 * Run this to verify the library is correctly installed and generating SVG.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Services/QrService.php';

use App\Services\QrService;

echo "<div style='font-family: sans-serif; padding: 40px; text-align: center;'>";
echo "<h1 style='color: #4f46e5;'>QR Code Diagnostic</h1>";

try {
    $qr = new QrService();
    $testData = "AU-DIAGNOSTIC-TEST-2026";
    
    // Generate the SVG
    $svg = $qr->generate($testData);
    
    echo "<p style='color: #10b981; font-weight: bold;'>✅ Generator Logic is Healthy!</p>";
    echo "<div style='max-width: 300px; margin: 40px auto; padding: 20px; background: white; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'>";
    echo $svg;
    echo "</div>";
    echo "<p style='color: #64748b;'>Data encoded: <code>$testData</code></p>";
    echo "<p style='margin-top: 20px; font-size: 14px;'>Try scanning the code above with your phone camera!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: #ef4444; font-weight: bold;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Ensure you ran <code>composer require chillerlan/php-qrcode</code></p>";
}

echo "</div>";

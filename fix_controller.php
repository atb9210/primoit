<?php
// Get the contents of the file
$file = __DIR__ . '/app/Http/Controllers/Admin/ITSaleScraperController.php';
$content = file_get_contents($file);

// First, back up the file
file_put_contents($file . '.bak', $content);

// Find the correct ending position (after the first closing brace of the extractFromJsonSpecs method)
$pos = strpos($content, "            }\n        }\n    }\n}");

if ($pos !== false) {
    // Cut off everything after that position and keep just the valid part
    $validContent = substr($content, 0, $pos + 20); // +20 includes the closing braces we want to keep
    
    // Save the fixed content back to the file
    file_put_contents($file, $validContent);
    echo "Controller fixed successfully!\n";
} else {
    echo "Could not find the correct ending position.\n";
} 
<?php
// Test script to verify file upload functionality
echo "Testing file upload functionality...\n";

// Check if uploads directory exists
$uploadDir = __DIR__ . '/uploads/products/';
if (!is_dir($uploadDir)) {
    echo "Creating uploads directory...\n";
    mkdir($uploadDir, 0755, true);
}

// Check if directory is writable
if (!is_writable($uploadDir)) {
    echo "ERROR: Uploads directory is not writable!\n";
    exit(1);
}

echo "Uploads directory is ready and writable.\n";

// Test file creation
$testFile = $uploadDir . 'test.txt';
if (file_put_contents($testFile, 'test content')) {
    echo "File creation test passed.\n";
    unlink($testFile);
} else {
    echo "ERROR: Cannot create files in uploads directory!\n";
    exit(1);
}

echo "All tests passed! File upload should work.\n";
?>
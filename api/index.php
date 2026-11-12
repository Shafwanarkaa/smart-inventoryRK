<?php

// Pastikan folder cache view dan storage tersedia di /tmp (serverless writable directory)
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// Forward request ke public/index.php bawaan Laravel
require __DIR__ . '/../public/index.php';


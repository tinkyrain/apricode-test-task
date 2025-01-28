<?php

require_once __DIR__ . '/../bootstrap.php';

try {
    $app = initApp();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}

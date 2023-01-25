<?php

declare(strict_types=1);

$callback = include dirname(__FILE__) . '/../src/Kernel.php';
/** @var \Micro\Framework\Kernel\KernelInterface $kernel */
$kernel = $callback();
$kernel->run();

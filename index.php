<?php

require_once __DIR__ . '/src/HowLongToBeat.php';

$howlongtobeat = new HowLongToBeat();

// Get game detail
$id = 46445;
$jsonMode = TRUE;
print_r($howlongtobeat->get($id, $jsonMode));

// Search for game details
$title = 'Ni no Kuni';
$jsonMode = TRUE;
$limit = 5;
print_r($howlongtobeat->search($title, $jsonMode, $limit));

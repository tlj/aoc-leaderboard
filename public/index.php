<?php

require __DIR__ . '/../lib/LeaderBoardData.php';

$leaderBoardId = (int)$_REQUEST['id'];
$year = (int)$_REQUEST['year'];

if ($year < 2015 || $year > 2018) die('Invalid year.');
if (!$leaderBoardId) die('Leaderboardid required.');

$leaderBoard = new LeaderBoardData($leaderBoardId, $year);

if (isset($_REQUEST['day']) && is_numeric($_REQUEST['day'])) {
    $reqDay = (int)$_REQUEST['day'];

    $day = $leaderBoard->getDay($reqDay);
    $order = "part2Diff";
    if (isset($_REQUEST['order']) && in_array($_REQUEST['order'], ['part2Diff', 'part1', 'part2'])) {
        $order = $_REQUEST['order'];
    }
    usort($day, function($a, $b) use ($order) {
        $aVal = $a[$order] ?? PHP_INT_MAX;
        $bVal = $b[$order] ?? PHP_INT_MAX;
        return $aVal <=> $bVal;
    });

    include __DIR__ . '/../templates/day.php';
    exit;
}

$totals = $leaderBoard->getTotals();
$sortOrder = $_REQUEST['totOrder'] ?? "part2DiffAvg";
usort($totals, function($a, $b) use ($sortOrder) {
    $aVal = $a[$sortOrder] ?? PHP_INT_MAX;
    $bVal = $b[$sortOrder] ?? PHP_INT_MAX;
    return $aVal <=> $bVal;
});

$tops = $leaderBoard->getTopLists();
$sortOrder = $_REQUEST['topOrder'] ?? "part2Diff";
usort($tops, function($a, $b) use ($sortOrder) {
    $aVal = $a[$sortOrder] ?? PHP_INT_MAX;
    $bVal = $b[$sortOrder] ?? PHP_INT_MAX;
    return $aVal <=> $bVal;
});

$topsToday = $leaderBoard->getTopToday();
$sortOrder = $_REQUEST['topOrder'] ?? "part2Diff";
usort($topsToday, function($a, $b) use ($sortOrder) {
    $aVal = $a[$sortOrder] ?? PHP_INT_MAX;
    $bVal = $b[$sortOrder] ?? PHP_INT_MAX;
    return $aVal <=> $bVal;
});

if (isset($_REQUEST['embed']) && $_REQUEST['embed'] == 1) {
    include __DIR__ . '/../templates/embed.php';
} else {
    include __DIR__ . '/../templates/totals.php';
}

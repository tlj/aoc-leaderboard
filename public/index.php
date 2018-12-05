<?php

require __DIR__ . '/../lib/LeaderBoardData.php';

$leaderBoardId = (int)$_REQUEST['id'];
$year = (int)$_REQUEST['year'];

if ($year < 2015 || $year > 2018) die('Invalid year.');
if (!$leaderBoardId) die('Leaderboardid required.');

$leaderBoard = new LeaderBoardData($leaderBoardId, $year);

$reqDay = 0;
if (isset($_REQUEST['day']) && is_numeric($_REQUEST['day'])) {
    $reqDay = (int)$_REQUEST['day'];

    $day = $leaderBoard->getDay($reqDay);
    $order = "score";
    if (isset($_REQUEST['order']) && in_array($_REQUEST['order'], ['score', 'part2Diff', 'part1', 'part2'])) {
        $order = $_REQUEST['order'];
    }
    if ($order == 'score') {
        usort($day, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

    } else {
        usort($day, function ($a, $b) use ($order) {
            $aVal = $a[$order] ?? PHP_INT_MAX;
            $bVal = $b[$order] ?? PHP_INT_MAX;
            return $aVal <=> $bVal;
        });
    }

    include __DIR__ . '/../templates/day.php';
    exit;
}

$totals = $leaderBoard->getTotals();
$order = $_REQUEST['totOrder'] ?? "score";
if ($order == 'score') {
    usort($totals, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

} else {
    usort($totals, function ($a, $b) use ($order) {
        $aVal = $a[$order] ?? PHP_INT_MAX;
        $bVal = $b[$order] ?? PHP_INT_MAX;
        return $aVal <=> $bVal;
    });
}
$tops = $leaderBoard->getTopLists();
$sortOrder = $_REQUEST['topOrder'] ?? "calculatedDiff";
usort($tops, function($a, $b) use ($sortOrder) {
    $aVal = $a[$sortOrder] ?? PHP_INT_MAX;
    $bVal = $b[$sortOrder] ?? PHP_INT_MAX;
    return $aVal <=> $bVal;
});

include __DIR__ . '/../templates/totals.php';

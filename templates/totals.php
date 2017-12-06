<html>
<?php include __DIR__ . '/_header.php'; ?>
<body>
<h1>Totals (max day <?php echo $leaderBoard->maxDay ?>)</h1>
<?php include __DIR__ . '/_menu.php'; ?>
<table class="pure-table">
    <thead>
    <tr>
        <th>Name</th>
        <th style="text-align:right">Avg. Part 2 Diff</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($totals as $total) { ?>
    <?php if ($total['part2DiffCount'] < $leaderBoard->maxDay) continue; ?>
    <?php /*
    echo ++$i . ".\t" . $total['part2DiffAvg'] . "\t" . $total['name'] . " ({$total['part2DiffCount']}) ({$total['penalty']})\n";
    } */ ?>
        <tr>
            <td><?php echo $total['name'] ?></td>
            <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($total['part2DiffAvg']) ?></td>
        </tr>
    <?php } ?>
    <tbody>
</table>
</body>
</html>

<html>
<?php include __DIR__ . '/_header.php'; ?>
<body>
<!-- <h1>Totals (max day <?php echo $leaderBoard->maxDay ?>)</h1> -->
<!-- <?php include __DIR__ . '/_menu.php'; ?> -->
<div style="width: 96%">

    <div style="float: left;">
        <h2>Fastest today</h2>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Pos</th>
                <th>Name</th>
                <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&topOrder=part1">Part1</a></th>
                <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&topOrder=part2">Part2</a></th>
                <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&topOrder=calculatedDiff">wTime</a></th>
            </tr>
            </thead>
            <tbody>
            <?php $pos = 1; ?>
            <?php foreach ($topsToday as $top): ?>
                <?php if ($pos <= 10) { ?>
                    <tr>
                        <td><?php echo $pos++; ?></td>
                        <td><?php echo $top['name']; ?></td>
                        <td style="text-align: right;"><?php echo LeaderBoardData::readableTimestamp($top['part1']); ?></td>
                        <td style="text-align: right;"><?php echo LeaderBoardData::readableTimestamp($top['part2']); ?></td>
                        <td style="text-align: right;"><?php echo LeaderBoardData::readableTimestamp($top['calculatedDiff']); ?></td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="float:left; margin-right: 20px;">
        <h2>Totals</h2>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Pos</th>
                <th>Name</th>
                <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&totOrder=part1Avg">Part1</a></th>
                <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&totOrder=part2Avg">Part2</a></th>
                <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&totOrder=score">Score</a></th>
            </tr>
            </thead>
            <tbody>

            <?php $pos = 1; ?>
            <?php foreach ($totals as $total) { ?>
            <?php if ($pos <= 10) { ?>
                <?php if ($total['part2DiffCount'] < $leaderBoard->maxDay) continue; ?>
                    <tr>
                        <td><?php echo $pos++; ?></td>
                        <td nowrap><?php echo $total['name'] ?></td>
                        <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($total['part1Avg']) ?></td>
                        <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($total['part2Avg']) ?></td>
                        <td style="text-align:right"><?php echo $total['score'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tbody>
        </table>
    </div>

<div style="float: left;">
<h2>Fastest overall</h2>
<table class="table table-striped table-sm">
    <thead>
    <tr>
        <th>Pos</th>
        <th>Day</th>
        <th>Name</th>
        <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&topOrder=part1">Part1</a></th>
        <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&topOrder=part2">Part2</a></th>
        <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&topOrder=calculatedDiff">wTime</a></th>
    </tr>
    </thead>
    <tbody>
        <?php $pos = 1; ?>
        <?php foreach ($tops as $top): ?>
            <?php if ($pos <= 10) { ?>
            <tr>
                <td><?php echo $pos++; ?></td>
                <td><?php echo $top['day']; ?></td>
                <td nowrap><?php echo $top['name']; ?></td>
                <td style="text-align: right;"><?php echo LeaderBoardData::readableTimestamp($top['part1']); ?></td>
                <td style="text-align: right;"><?php echo LeaderBoardData::readableTimestamp($top['part2']); ?></td>
                <td style="text-align: right;"><?php echo LeaderBoardData::readableTimestamp($top['calculatedDiff']); ?></td>
            </tr>
            <?php } ?>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

</div>

</body>
</html>

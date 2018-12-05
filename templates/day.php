<html>
    <?php include __DIR__ . '/_header.php'; ?>
    <body>
        <h1>Day <?= $reqDay ?></h1>
        <?php include __DIR__ . '/_menu.php'; ?>
        <table class="table-sm">
            <thead>
                <tr>
                    <th>Pos</th>
                    <th>Name</th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=part1">Part1</a></th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=part2">Part2</a></th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=part2Diff">Diff</a></th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=calculatedDiff">wTime</a></th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=score">Score</a></th>
                </tr>
            </thead>
            <tbody>
            <?php $pos = 0; ?>
            <?php foreach ($day as $member) { ?>
                <tr>
                    <td><?php echo ++$pos ?></td>
                    <td><?php echo $member['name'] ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['part1']) ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['part2']) ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['part2Diff']) ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['calculatedDiff']) ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['score']) ?></td>
                </tr>
            <?php } ?>
            <tbody>
        </table>
    </body>
</html>

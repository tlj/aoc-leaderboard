<html>
    <?php include __DIR__ . '/_header.php'; ?>
    <body>
        <h1>Day <?= $reqDay ?></h1>
        <?php include __DIR__ . '/_menu.php'; ?>
        <table class="pure-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=part1">Part1</a></th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=part2">Part2</a></th>
                    <th style="text-align:right"><a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?= $reqDay ?>&order=part2Diff">Diff</a></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($day as $member) { ?>
                <tr>
                    <td><?php echo $member['name'] ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['part1']) ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['part2']) ?></td>
                    <td style="text-align:right"><?php echo LeaderBoardData::readableTimestamp($member['part2Diff']) ?></td>
                </tr>
            <?php } ?>
            <tbody>
        </table>
    </body>
</html>

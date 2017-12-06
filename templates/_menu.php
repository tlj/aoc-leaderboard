<table class="pure-table menu">
    <tr>
        <td class="<?php echo (!isset($reqDay) ? 'selected' : ''); ?>">
            <a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>">Totals</a>
        </td>
        <?php for ($i = 1; $i <= $leaderBoard->maxDay; $i++): ?>
        <td class="<?php echo ($i == $reqDay) ? 'selected' : '' ?>">
            <a href="/?id=<?=$leaderBoardId?>&year=<?=$year?>&day=<?php echo $i; ?>"><?php echo $i; ?></a>
        </td>
        <?php endfor; ?>
    </tr>
</table>
<br />
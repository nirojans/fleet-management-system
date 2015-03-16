<table class="table table-striped" >
    <tr>
        <th>Driver ID</th>
        <th>Working hours</th>
        <th>Details</th>

    </tr>


    <?php foreach ($data as $item):?>
        <tr>
            <td><?= $item['userId'];?></td>
            <td><?= $item['workingHours'];?></td>
            <td><button type="submit" class="btn btn-default" onclick="getDetailedWorkingHoursByDate('<?= $item['userId'];?>')">Details</button></td>
        </tr>

    <?php endforeach;?>
</table>
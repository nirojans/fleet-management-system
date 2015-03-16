<table class="table table-striped" >
    <tr>
        <th>Dispatcher ID</th>
        <th>Name</th>
        <th>User Name</th>
        <th>Pass</th>
        <th>NIC</th>
        <th>tp</th>
        <th>Blocked</th>
    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['userId'];?></td>
            <td><?= $item['name'];?></td>
            <td><?= $item['uName'];?></td>
            <td><?= $item['pass'];?></td>
            <td><?= $item['nic'];?></td>
            <td><?= $item['tp'];?></td>
            <td><?= $item['blocked'];?></td>
            <td><button type="button" class="btn btn-success" onclick="makeCROFormEditable(<?= $item['userId']; ?>,url, '<?php echo $item['user_type']; ?>')">Edit</button></td>
        </tr>

    <?php endforeach;?>
</table>
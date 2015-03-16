<div class="col-lg-6 ">


    <table class="table table-striped">
        <tr>
            <th>CRO ID</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Pass</th>
            <th>NIC</th>
            <th>tp</th>
            <th>User Type</th>
            <th>Blocked</th>
<!--            <th>Action</th>-->
        </tr>
        <?php if(isset($userId)){ ?>

        <tr>
            <td><?= $userId; ?></td>
            <td><?= $name ?></td>
            <td><?= $uName; ?></td>
            <td><?= $pass; ?></td>
            <td><?= $nic; ?></td>
            <td><?= $tp; ?></td>
            <td><?= $user_type; ?></td>
            <td><?= $blocked; ?></td>
            <td><button type="button" class="btn btn-success" onclick="makeCROFormEditable(<?= $userId; ?>,url, '<?php echo $user_type; ?>')">Edit</button></td>
        </tr>
        <?php } ?>
    </table>

    </br>



</div>
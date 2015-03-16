<?php
/**
 * Created by PhpStorm.
 * User: kbsoft
 * Date: 11/28/14
 * Time: 10:26 AM
 */
?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $cab['vType'] ?> <?= $cab['cabId'] ?></h3>
    </div>
    <div class="panel-body">
        <span >Model :</span>
        <span class="text-primary"><?= $cab['model'] ?></span>
        <br/>

        <span >Body Color  :</span>
        <span class="text-info"><?= $cab['color'] ?></span>
        <br/>

        <span >Plate #  :</span>
        <span class="text-info"><?= $cab['plateNo'] ?></span>
        <br/>

        <span >Vehicle Type :</span>
        <span class="text-info"><?= $cab['vType'] ?></span>
        <br/>

        <span >Details :</span>
        <span class="text-info"><?= $cab['info'] ?></span>
        <br/>

        <span >Location :</span>
        <span class="text-info"><?= $cab['zone'] ?></span>
        <br/>

        <span >Driver ID :</span>
        <span class="text-info"><?= $cab['userId'] ?></span>
        <br/>

        <span >Driver Name :</span>
        <span class="text-info"><?= $driver['name'] ?></span>
        <br/>

        <span >Driver TP :</span>
        <span class="text-info"><?= $driver['tp'] ?></span>
        <br/>

    </div>
</div>
<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
    <div class="panel-heading" style="padding: 1px">
        <h5 class="panel-title">Call Center Information</h5>
    </div>
    <div class="panel-body" >

        <div class="col-lg-3">
            <img style='float:left;width:134px;height:128px' src="<?= base_url() ?>assets/img/phone.png" />
        </div>

        <div class="col-lg-4">
            <p style="margin: 0 0 3px;"><span class="label label-default" style="font-size: 83%; ">Total Calls <?= $totalCalls?></span> </p>
            <p style="margin: 0 0 3px;"><span class="label label-info" style="font-size: 83%; ">Total Answered Calls <?= $answeredCalls?></span></p>
            <p style="margin: 0 0 3px;"><span class="label label-success" style="font-size: 83%;">Total Active Calls <?= $activeCalls?></span></p>
            <p style="margin: 0 0 3px;"><span class="label label-success" style="font-size: 83%;">My Active Calls <?= $croActiveCalls?></span></p>
            <p style="margin: 0 0 3px;"><span class="label label-danger" style="font-size: 83%; ">Total Missed Calls <?= $missedCalls?></span></p>
            <p style="margin: 0 0 3px;">My Hires <span class="badge"><?= $croHires?></span></p>

        </div>

        <div class="col-lg-4">
            <h1>Total Hires
                <span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"> <?= $totalHires?></span></h1>
        </div>
    </div>
</div>
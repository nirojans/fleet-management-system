<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">Advanced Bookings</h5>
    </div>

    <div class="panel-body" >
        <?php if(isset($data) && sizeof($data) != 0):?>
            <table class="table table-striped" ><tr>
                    <th>Title</th>
                    <th>Name</th>
                    <th>TP 1</th>
                    <th>TP 2</th>
                    <th>Jobs[T]</th>
                    <th>Cancel[T]</th>
                    <th>Cancel[D]</th>
                    <th>Remark[P]</th>
                    <th>Org</th>
                </tr>
                <?php foreach (array_reverse($data) as $customer):?>
                    <tr>
                        <td><?= $customer['title'];?></td>
                        <td><?= $customer['name'];?></td>
                        <td><?= $customer['tp'];?></td>
                        <td><?= $customer['tp2'];?></td>
                        <td><?= $customer['tot_job'];?></td>
                        <td><?= $customer['tot_cancel'];?></td>
                        <td><?= $customer['dis_cancel'];?></td>
                        <td><?= $customer['pRemark'];?></td>
                        <td><?= $customer['org'];?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        <?php endif?>

        <?php if(!isset($data)):?>
            <div class="col-lg-offset-4 col-lg-5">
                <h4>No Customer is Available with the Name</h4>
            </div>
        <?php endif;?>
    </div>
</div>
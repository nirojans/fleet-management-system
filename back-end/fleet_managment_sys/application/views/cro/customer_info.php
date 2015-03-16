<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
    <div class="panel-heading" style="padding: 1px">
        <h5 class="panel-title">Customer Information</h5>
    </div>
    <div class="panel-body" >
        <div class="col-md-12" style="padding: 1px; ">

            <div class="col-lg-3" style="padding: 1px">
                <img style='float:left;width:134px;height:128px' src="<?= base_url() ?>assets/img/profile_pic.jpg" />


                <div class="col-lg-12" style="margin-top: 5px ; padding: 1px">

                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm" onclick="operations('editCus', '<?= $tp;?>' )">
                                <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" style="padding: 1px">
                <div class="col-lg-12">
                    <span class="col-lg-3">Name</span>
                    <span class="col-lg-9">
                        <?= $title?>
                        <?php if($position !=  '-'){
                            echo '(' . $position . ')';
                        }?>
                        <?= $name?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Telephone 1</span>
                    <span class="col-lg-9"><?= $tp?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Telephone 2</span>
                    <span class="col-lg-9"><?= $tp2?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Remark[P]</span>
                    <span class="col-lg-9"><?= $pRemark?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Organization</span>
                    <span class="col-lg-9"><?= $org?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Profile</span>
                    <span class="col-lg-9"><?= $profileType?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Job Count</span>
                    <span class="col-lg-9"><?= $tot_job?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Cancel [T]</span>
                    <span class="col-lg-9"><?= $tot_cancel?></span>
                </div>

                <div class="col-lg-12">
                    <span class="col-lg-3">Cancel [D]</span>
                    <span class="col-lg-9"><?= $dis_cancel?></span>
                </div>
            </div>

            <div class="col-lg-12" style="padding: 1px">
                <?php if($profileType == 'Cooperate'):?>
                    <div class="col-lg-offset-4 col-lg-8" style="padding: 1px">
                        <div class="input-group">
                            <input type="text" class="form-control" id="cooperateUserTp" placeholder="Land / Mobile">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="operations('addUser');return false;" onsubmit="operations('addUser');return false;">Add User</button>
                                      </span>
                        </div><!-- /input-group -->
                    </div>
                <?php endif;?>

                <?php if(isset($userInfo)):?>
                    <div class="col-lg-12" style="max-height: 150px ; overflow: auto; font-size: 12px ;padding: 1px">
                        <h4>Personal Profiles</h4>
                        <div class="col-lg-12" style="padding: 1px">
                            <table class="table table-striped" >
                                <tr>
                                    <th>Title</th>
                                    <th>Position</th>
                                    <th>Name</th>
                                    <th>tp1</th>
                                    <th>tp2</th>
                                    <th>Remark[P]</th>
                                    <th>Organization</th>
                                </tr>

                                <?php foreach($userInfo as $item):?>
                                    <tr>
                                        <td><?= $item['title'];?></td>
                                        <td><?= $item['position'];?></td>
                                        <td><?= $item['name'];?></td>
                                        <td><?= $item['tp'];?></td>
                                        <td><?= $item['tp2'];?></td>
                                        <td><?= $item['pRemark'];?></td>
                                        <td><?= $item['org'];?></td>
                                    </tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                    </div>
                <?php endif;?>

            </div>
        </div>
    </div>
</div>
</div>
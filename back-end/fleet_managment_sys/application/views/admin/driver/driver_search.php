<div class="col-lg-8">

            <div >
                <table class="table table-striped" >
                    <tr>
                        <th>Driver ID</th>
                        <th>Calling Number</th>
                        <th>Log Sheet Number</th>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>Pass</th>
                        <th>NIC</th>
                        <th>tp</th>
                        <th>Can Logout</th>
                        <th>Cab ID</th>
                        <th>User Type</th>
                        <th>Cab Start Location</th>
                        <th>Blocked</th>                        
                    </tr>
                    <?php if(isset($userId)){ ?>
                      <tr>
                            <td><?= $userId;?></td>
                            <td><?php
                            if(!isset($callingNumber) || $callingNumber == -1 || trim($callingNumber) == ''){echo 'Not Assigned';}
                            else{echo $callingNumber;}
                            ?></td>
                            <td><?php
                            if(!isset($logSheetNumber) || $logSheetNumber == -1 || trim($logSheetNumber) == ''){echo 'Not Assigned';}
                            else{echo $logSheetNumber;}
                            ?></td>
                            <td><?= $name?></td>
                            <td><?= $uName;?></td>
                            <td><?= $pass;?></td>
                            <td><?= $nic;?></td>
                            <td><?= $tp;?></td>
                            <td><?php if($logout==true){echo "true";}else{echo "false";}?></td>
                            <td><?php
                                if(!isset($cabId) || trim($cabId)=='' || $cabId == -1){
                                    echo "empty";
                                }else{
                                    echo $cabId;
                                }
                                ?></td>
                            <td><?= $user_type;?></td>                            
                            <td><?php
                            if(!isset($startLocation) || trim($startLocation) == ''){echo 'Not Assigned';}
                            else{echo $startLocation;}
                            ?></td>
                            <td><?= $blocked; ?></td>
                            <td><button type="button" class="btn btn-success" onclick="makeCROFormEditable(<?= $userId;?>,url, '<?php echo $user_type;?>')">Edit</button></td>
                        </tr>
                    <?php } ?>
                </table>



    </div>
</div>
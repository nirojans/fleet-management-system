<table class="table table-striped" >
    <tr>
        <th>Driver ID</th>
        <th>Login Time</th>
        <th>Logout Time</th>
        <th>Working hours</th>


    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['userId'];?></td>
            <td><?php $timeIn=$item['time'];
                echo date('Y-m-d , h:i:s', $timeIn->sec);
                ?></td>
            <td><?php $timeOut=$item['logout_time'];
                if($timeOut=='-'){
                    // $timeOut = new MongoDate();
                    echo 'not logged out';
                }else{
                    echo date('Y-m-d , h:i:s', $timeOut->sec);
                }
                ?></td>
            <td><?php
                if($timeOut=='-'){
                    echo 'not logged out';
                }else{
                    $preWorkingHours = $timeOut->sec - $timeIn->sec;
                    $workingHour=(int)($preWorkingHours/3600);
                    if($workingHour<24){
                        echo $workingHour."hours";
                    }else{
                        echo (int)($workingHour/24)." day(s) ".($workingHour%24)." hour(s)";
                    }
                }

                ?></td>

        </tr>

    <?php endforeach;?>
</table>
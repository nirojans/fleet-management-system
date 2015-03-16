<table class="table table-striped" >
    <tr>
    <button type="submit" class="btn btn-default" id="CANCEL" onclick="getCancelReportsView('CANCEL')">CANCEL-REPORTS</button>
    <button type="submit" class="btn btn-default" id="DIS_CANCEL" onclick="getCancelReportsView('DIS_CANCEL')">DIS-CANCEL-REPORTS</button>
    <button type="submit" class="btn btn-default" id="ALL" onclick="getCancelReportsView('ALL')">ALL</button>
    <input type="text" placeholder="yyyy-mm-dd" id="date_needed_cr">
    
    </tr>
    <tr>        
        <th>Booking Ref ID</th>
        <th>Type</th>
        <th>Reason</th>
        <th>Time Vehicle REQ</th>
        <th>Time Vehicle Dispatched</th>
        <th>Time of Cancellation</th>
        <th>Time Diff (CALLTIME/CANCEL)</th>
        <th>Time Diff (DISP/CANCEL)</th>
        <th>USR ID (Made Booking)</th>
        <th>USR ID (Made Cancel)</th>
        <th>Driver ID</th>

    </tr>

    <?php foreach ($cancellations as $item):?>

    <tr>
        <td id="bookingRefId"><?= $item['refId']?></td>
        <td id="status"><?= $item['status']?></td>
        <td id="cancelReason"><?php if(isset($item['cancelReason'])){echo $item['cancelReason'];}else{echo "Not Available";}?></td>
        <td id="bookTime"><?= date('jS-M-y  H:i',$item['bookTime']->sec)?></td>
        <td id="dispatchTime"><?php if(isset($item['dispatchTime'])){echo date('jS-M-y  H:i',$item['dispatchTime']->sec);}else{echo "Not Available";}?></td>
        <td id="cancelTime"><?= date('jS-M-y  H:i',$item['cancelTime']->sec);?></td>
        <td id="timeDiff1"><?php if(isset($item['cancelTime'])){
                $seconds_diff = (float)$item['cancelTime']->sec - (float)$item['callTime']->sec;
                $timeDiff1 = $seconds_diff / 60;
                echo round($timeDiff1,0) . ' (mins)';
            }else{
                echo "Not Available";
            }?></td>
        <td id="timeDiff2">
            <?php if(isset($item['dispatchTime'])){
                $seconds_diff = (float)$item['cancelTime']->sec - (float)$item['dispatchTime']->sec;
                $timeDiff2 = $seconds_diff / 60;
                echo round($timeDiff2,0)  . "(mins)";
            }
            else{
                echo "Not Available";}?>
        </td>
        <td id="bookingUserId"><?= $item['croId']?></td>
        <td id="cancelUserId"><?php if(isset($item['cancelUserId'])){echo $item['cancelUserId'];}else{echo "Not Available";}?></td>
        <td id="driverId"><?php if(isset($item['driverId'])){echo $item['driverId'];}else{echo "Not Available";}?></td>
    </tr>

    <?php endforeach;?>
</table>

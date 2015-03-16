<table class="table table-striped" >
    <tr>
    <button type="submit" class="btn btn-default" id="TODAY" onclick="getMissedCallReportView()">Today</button>
    <button type="submit" class="btn btn-default" id="ALL" onclick="getAllMissedCallReportView()">All</button>
    <input type="text" placeholder="yyyy-mm-dd" id="date_needed">
    <button type="submit" class="btn btn-default" id="BY_DATE" onclick="getMissedCallReportViewByDate()">Get by Date</button>
    
    </tr>
    <tr>        
        <th>Phone Number</th>
        <th>Date and Time</th>
    </tr>


    <?php foreach ($missed_call as $item):?>

    <tr>
        <td><?= $item['phone_number']?></td>
        <td><?= date("Y-m-d H:i:s",$item['date']->sec)?></td>        
    </tr>

    <?php endforeach;?>
</table>

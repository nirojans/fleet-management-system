
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <form class="navbar-form navbar-left" role="search" id="getAccount">
            <div class="form-group" id="search_box_for_reports">
                <input class="form-control" placeholder="Enter ID" type="text" id="idForSearch">
            </div>
            
            <button type="submit" class="btn btn-default" onclick="getReportViewFromSearchId();return false;">Submit</button>
            <select id="search_select">
                <option value="driverId">Search by Driver ID</option>
                <option value="refId">Search by Booking Ref ID</option>
                <option value="complaintId">Search by Complaint ID</option>
            </select>
        </form>

<table class="table table-striped" >
    
    
    <tr>
        <th>Complaint Ref ID</th>
        <th>Booking Ref ID</th>
        <th>Complaint</th>
        <th>Driver ID</th>
        <th>CRO ID (Made Booking)</th>
        <th>CRO ID (Took Complaint)</th>
        <th>Time Complaint Made</th>
        

    </tr>


    <?php foreach ($complaints as $item):?>

    <tr>
        <td><?= $item['complaintId']?></td>
        <td><?= $item['refId']?></td>
        <td><?= $item['complaint']?></td>
        <td><?= $item['userId_driver']?></td>
        <td><?= $item['userId_cro_booking']?></td>
        <td><?= $item['userId_cro_complaint']?></td>
        <td><?= date('H:m Y-m-d',$item['timeOfComplaint']->sec)?></td>
    </tr>

    <?php endforeach;?>
</table>

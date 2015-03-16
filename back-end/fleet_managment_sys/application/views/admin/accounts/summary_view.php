Start Date : <input type="text" id="startDate" value="2014-11-09"/>
End Date : <input type="text" id="endDate" value="2014-11-11"/>
DriverId : <select id="driverId" placeholder="0" >
                <option value="0">All</option>
             <?php foreach ($driverIds as $SDriverId):?>
                <option value="<?= $SDriverId;?>"><?= $SDriverId;?></option>
             <?php endforeach;?>
           </select>

<button type="submit" id="dateButton" class="btn btn-default" onclick="getBookingsByDateRange(this.id)">Search</button>
<br><br>
<div id="tableDiv">

</div>
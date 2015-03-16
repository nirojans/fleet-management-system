<script>
    function save_details(id)
    {
        var userId = document.getElementById("userId"+id).innerHTML;//alert(userId);
        var cabId = document.getElementById("cabId"+id).innerHTML;//alert(cabId);
        var callingNumber = document.getElementById("callingNumber"+id).innerHTML.trim();
        var logSheetNumber = document.getElementById("logSheetNumber"+id).innerHTML.trim();//alert(userId+","+cabId+","+callingNumber+","+logSheetNumber);
        if(isNaN(callingNumber)){alert("Invalid Calling Number!"+callingNumber);return;}
        if(isNaN(logSheetNumber)){alert("Invalid Log Sheet Number!"); return;}
        else
        {
            var urlLoc = '<?php echo site_url("user_controller/updateUser")?>';
            var data = {'userId': parseInt(userId) , 'details':{'cabId':cabId, 'callingNumber': callingNumber, 'logSheetNumber': logSheetNumber}};
            ajaxPost_disp(data,urlLoc);
        }
    }
    function ajaxPost_disp(data,urlLoc)    {
        var result=null;
        $.ajax({
            type: 'POST', url: urlLoc,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(data),
            async: false,
            success: function(data, textStatus, jqXHR) {
                result = JSON.parse(jqXHR.responseText);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(jqXHR.status == 400) {
                    var message= JSON.parse(jqXHR.responseText);
                    $('#messages').empty();
                    $.each(messages, function(i, v) {
                        var item = $('<li>').append(v);
                        $('#messages').append(item);
                    });
                } else {
                    alert('Unexpected server error.');
                }
            }
        });
        return result;
    }
</script>
<!--<script>
    var cells = document.getElementsByTagName('tr');
for(var i = 0; i <= cells.length; i++){
    cells[i].addEventListener('click', clickHandler);
}

function clickHandler()
{
    alert(this.textContent);
}</script>-->
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Calling Numbers
    </h4>
</div>
<div class="modal-body">
    <div class="row" style="min-height: 100px">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Cab ID</th>
                <th>Plate No</th>
                <th>Model</th>
                <th>Color</th>
                <th>UserId</th>
                <th>Zone</th>
                <th>Info</th>
                <th>Calling Number</th>
                <th>Log Sheet Number</th>
            </tr>
            </thead>
            <tbody id="searchCabsContainer">
            <?php $i=0; foreach ($assigned_cabs as $cab): ?>
                <tr>
                    <td id="cabId<?= $i?>">
                        <?= $cab['cabId'] ?>
                    </td>
                    <td>
                        <?= $cab['plateNo'] ?>
                    </td>
                    <td>
                        <?= $cab['model'] ?>
                    </td>
                    <td>
                        <?= $cab['color'] ?>
                    </td>
                    <td id="userId<?= $i?>">
                        <?php if(!isset($cab['userId']) || $cab['userId'] == -1){echo "Not Assigned";}else{echo $cab['userId']; }  ?>
                    </td>
                    <td>
                        <?php if(!isset($cab['zone'])){echo "Not Available";} else{echo $cab['zone'];} ?>
                    </td>
                    <td>
                        <?= $cab['info'] ?>
                    </td>
<!--                    need to validate if key exists-->
                    <td contenteditable='true' id="callingNumber<?= $i?>">
                        <?php if(!isset($cab['callingNumber']) || $cab['callingNumber'] == -1){echo "Not Assigned";}else{echo $cab['callingNumber'];} ?>
                    </td>
                    <td contenteditable='true' id="logSheetNumber<?= $i?>">
                        <?php if(!isset($cab['logSheetNumber']) || $cab['logSheetNumber'] == -1){echo "Not Assigned";}else{echo $cab['logSheetNumber'];} ?>
                    </td>
                    <td><button type="button" class="btn btn-success" id="<?= $i?>" onclick="save_details(this.id)">Save</button></td>
                </tr>
            <?php $i++; endforeach ?>


            </tbody>
        </table>
    </div>
    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


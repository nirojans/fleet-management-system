<script>
    //    For reference http://www.bootply.com/92189
    $('.btn-toggle').click(function () {
        console.log("DEBUG: JQuery onclick");
        $(this).find('.btn').toggleClass('active');

        if ($(this).find('.btn-primary').size() > 0) {
            $(this).find('.btn').toggleClass('btn-primary');
        }

        $(this).find('.btn').toggleClass('btn-default');

    });

    $('form').submit(function () {
        alert($(this["options"]).val());
        return false;
    });

    function driverLogOut(button) {
        console.log("DEBUG: JS onClick");
        var driverid = $(button).data('driverid');
        console.log(driverid);
        var data = {"uName": driverid};
        $.ajax({
            type: "POST",
            url: "authenticate/force_logout",
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                console.log(response);
                if(response.isAuthorized){
                    $(button).addClass('disabled');
                    $.UIkit.notify({
                        message: 'Driver status updated!',
                        status: 'success',
                        timeout: 3000,
                        pos: 'bottom-right'
                    });
                }
                else{
                    $.UIkit.notify({
                        message: 'Driver status updated FAILED!',
                        status: 'danger',
                        timeout: 3000,
                        pos: 'bottom-right'
                    });
                }
            }

        });


    }
</script>

<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Cab Details and User Lock
    </h4>
</div>
<div class="modal-body">

    <div class="panel panel-default" style="border: none;min-height: 20%;">
        <div class="panel-body">

            <table class="table table-striped">
                <tr>
                    <th>Calling Number</th>
                    <th>Driver ID</th>
                    <th>Name</th>
                    <th>tp</th>
                    <th>Logout</th>
                    <th>Cab ID</th>
                    <th>Blocked</th>
                </tr>
                <?php foreach ($data as $item): ?>
                    <tr>
                        <td><?php
                            if (!isset($item['callingNumber']) || $item['callingNumber'] == -1 || trim($item['callingNumber']) == '') {
                                echo 'Not Assigned';
                            } else {
                                echo $item['callingNumber'];
                            }
                            ?>
                        </td>
                        <td><?= $item['userId']; ?></td>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['tp']; ?></td>
                        <td>
                            <?php
                            if ($item['isLogout'] == "true") {
                                ?>

                                <button type="button" class="btn btn-primary btn-sm disabled"
                                        data-driverid="<?= $item['userId']; ?>">
                                    Not Logged
                                </button>
                            <?php
                            } else {
                                ?>
                                <button type="button" class="btn btn-danger btn-sm"
                                        data-driverid="<?= $item['userId']; ?>" onclick="driverLogOut(this)">
                                    <span class=" glyphicon glyphicon-off" aria-hidden="true"></span> Logout
                                </button>
                            <?php
                            }
                            ?>

                            <!--<div class="btn-group btn-toggle" data-driverid="<? /*= $item['userId']; */ ?>"
                                 data-currentstatus="<? /*= $item['logout'] */ ?>">
                                <button class="btn btn-xs  <? /*= $yes */ ?>" onclick="driverLogOut(this,true)">Yes</button>
                                <button class="btn btn-xs <? /*= $no */ ?>" onclick="driverLogOut(this,false)">No</button>
                            </div>-->
                        </td>
                        <td><?php
                            if (!array_key_exists("cabId", $item) || $item['cabId'] === "" || $item['cabId'] == -1) {
                                echo 'Not Assigned';
                            } else {
                                echo $item['cabId'];
                            }
                            ?></td>
                        <td><?= getBadge($item['blocked'] === 'true'); ?></td>
                    </tr>

                <?php endforeach; ?>
            </table>

        </div>
    </div>


    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;" type="button" class="btn btn-default"
                        onclick="closeAll()">Close
                </button>
            </div>
        </div>
    </div>
</div>


<?php
function getBadge($status)
{
    $status = (bool)$status;
    if ($status) {
        $returnBadge = '<span class="badge alert-info"><span style="color: #5cb85c" class="glyphicon glyphicon-ok"></span></span>';
    } else {
        $returnBadge = '<span class="badge alert-warning"><span style="color: #d9534f" class="glyphicon glyphicon-remove"></span></span>';
    }
    return $returnBadge;
}

?>


































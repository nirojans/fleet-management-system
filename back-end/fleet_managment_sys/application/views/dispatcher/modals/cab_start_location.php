<script>
</script>

<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Cab Location
    </h4>
</div>
<div class="modal-body">

    <div class="panel panel-default" style="border: none;min-height: 20%;">
        <div class="panel-body">


            <table class="table table-striped" >
                <tr>
                    <th>Driver ID</th>
                    <th>Driver Name</th>
                    <th>tp</th>
                    <th>Cab ID</th>
                    <th>Cab Start Location</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Info</th>
                </tr>

                <?php foreach ($data as $item):?>

                    <tr>
                        <td><?= $item['userId'];?></td>

                        <td><?= $item['name'];?></td>
                        <td><?= $item['tp'];?></td>
                        <td><?php
                            if(!array_key_exists("cabId", $item) || $item['cabId'] === "" || $item['cabId']==-1){
                                echo 'Not Assigned';
                            }else{
                                echo $item['cabId'];
                            }
                            ?>
                        </td>
                        <td><?php
                            if(!isset($item['startLocation']) || trim($item['startLocation']) == ''){echo 'Not Assigned';}
                            else{echo $item['startLocation'];}
                            ?>
                        </td>
                        <td><?php if(isset($item['cab'])) {
                               echo $item['cab']['model'];
                            }
                            else{
                                echo "N/A";
                            }
                            ?>
                        </td>
                        <td><?php if(isset($item['cab'])) {
                                echo $item['cab']['color'];
                            }
                            else{
                                echo "N/A";
                            }
                            ?>
                        </td>
                        <td><?php if(isset($item['cab'])) {
                                echo $item['cab']['info'];
                            }
                            else{
                                echo "N/A";
                            }
                            ?>
                        </td>
                    </tr>

                <?php endforeach;?>
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





































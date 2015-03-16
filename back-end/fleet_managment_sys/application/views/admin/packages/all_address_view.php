<table class="table table-striped" >
    <tr>
        <th>Address Id</th>
        <th>Address Name</th>
        <th>City</th>
        <th>Town</th>
        <th>Road</th>
        <th>Action</th>
    </tr>


    <?php foreach ($data as $item):?>
            <tr>
                <td><p id="<?= $item['addressId'];?>"><?= $item['addressId'];?></p></td>
                <td><p id="<?= $item['addressName'];?>"><?= $item['addressName'];?></p></td>
                <td><?= $item['city'];?></td>
                <td><?= $item['town'];?></td>
                <td><?= $item['road'];?></td>
                <td><button type="submit" class="btn btn-default" onclick="makeAddressFormEditable('<?= $item['addressId'];?>')">Edit</button></td>
            </tr>

    <?php endforeach;?>
</table>

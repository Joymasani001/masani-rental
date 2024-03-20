<?php
include('db_connect.php');
$cat = isset($_GET['cat']) ? $_GET['cat'] : ''; // Get the value of 'cat' parameter

?>

<!-- FORM Panel -->

<!-- Table Panel -->
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <b>Room List</b>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Apartment Id.</th>
                        <th class="text-center">Room no</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Rent Payable</th>
                        <th class="text-center">Tenant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $category = $conn->query("SELECT * FROM rooms");
                    while ($row = $category->fetch_assoc()) :
                        // Check if 'cat' parameter is set and its value indicates filtering
                        if ($cat === 'booked') {
                            // Fetch only rooms that are booked
                            $tenant = getTenant($row['apartment_id'], $row['room_no']);
                            if ($tenant === "N/A") {
                                continue; // Skip this iteration if the room is not booked
                            }
                        } elseif ($cat === 'not_booked') {
                            // Fetch only rooms that are not booked
                            $tenant = getTenant($row['apartment_id'], $row['room_no']);
                            if ($tenant !== "N/A") {
                                continue; // Skip this iteration if the room is booked
                            }
                        }
                    ?>
                        <tr>
                            <td class="text-center">
                                <p><b><?php echo getName($row['apartment_id']) ?></b></p>
                            </td>
                            <td class="">
                                <p><small><b><?php echo $row['room_no'] ?></b></small></p>
                            </td>
                            <td class="">
                                <p><small><b><?php
                                                $tenant = getTenant($row['apartment_id'], $row['room_no']);
                                                if ($tenant == "N/A") {
                                                    echo "available";
                                                } else {
                                                    echo "taken";
                                                }
                                                ?></b></small></p>
                            </td>
                            <td class="">
                                <p><small><b><?php
                                                $rent = getRent($row['apartment_id']);
                                                echo $rent; ?>
                                    </b></small></p>
                            </td>
                            <td class="">
                                <p><small><b><?php
                                                $tenant = getTenant($row['apartment_id'], $row['room_no']);
                                                if ($tenant != null) {
                                                    echo $tenant;
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                    </b></small></p>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Table Panel -->

<?php
function getRent($apartmentId)
{
    global $conn; // Access the global connection object
    $rentSql = "SELECT * FROM apartments WHERE id='$apartmentId'";
    $rentQuery = mysqli_query($conn, $rentSql);
    $res = mysqli_fetch_assoc($rentQuery);
    return $res['price'];
}

function getName($apartmentId)
{
    global $conn; // Access the global connection object
    $rentSql = "SELECT * FROM apartments WHERE id='$apartmentId'";
    $rentQuery = mysqli_query($conn, $rentSql);
    $res = mysqli_fetch_assoc($rentQuery);
    return $res['name'];
}

function getTenant($apartmentId, $roomNo)
{
    global $conn; // Access the global connection object
    $tenantSql = "SELECT * FROM books WHERE apartment_id='$apartmentId' AND room_no='$roomNo' and status=2";
    $tenantQuery = mysqli_query($conn, $tenantSql);
    $count = mysqli_num_rows($tenantQuery);
    if ($count == 0) {
        return "N/A";
    }
    $res = mysqli_fetch_assoc($tenantQuery);
    return $res['name'];
}
?>
</div>
</div>

</div>
<style>
    td {
        vertical-align: middle !important;
    }
</style>
<script>
    $('#manage-category').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=add_room',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                end_load();
                alert_toast("Data successfully added", 'success')
            }
        })
    })
    $('.edit_category').click(function() {
        start_load()
        var cat = $('#manage-category')
        cat.get(0).reset()
        cat.find("[name='id']").val($(this).attr('data-id'))
        cat.find("[name='name']").val($(this).attr('data-name'))
        cat.find("[name='description']").val($(this).attr('data-description'))
        end_load()
    })
    $('.delete_category').click(function() {
        _conf("Are you sure to delete this category?", "delete_category", [$(this).attr('data-id')])
    })

    function delete_category($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_category',
            method: 'POST',
            data: {
                id: $id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
            }
        })
    }
    $('table').dataTable()
</script>

<?php include('db_connect.php');?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                
            </div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Houses</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=manage_car" id="new_car">
                                <i class="fa fa-plus"></i> New Entry
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Floors</th>
                                    <th class="">Building Name</th>
                                    <th>Total Number of Rooms</th>
                                    <th>Available Rooms</th>
                                    <th>Rent</th>
                                    <th class="">Category</th>
                                    <th class="">Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $cat = array();
                                $cat[] = '';
                                $qry = $conn->query("SELECT * FROM categories ");
                                while($row = $qry->fetch_assoc()){
                                    $cat[$row['id']] = $row['name'];
                                }
                                $tt = array();
                                $tt[] = '';
                                $qry = $conn->query("SELECT * FROM transmission_types ");
                                while($row = $qry->fetch_assoc()){
                                    $tt[$row['id']] = $row['name'];
                                }
                                $et = array();
                                $et[] = '';
                                $qry = $conn->query("SELECT * FROM engine_types ");
                                while($row = $qry->fetch_assoc()){
                                    $et[$row['id']] = $row['name'];
                                }
                                $cars = $conn->query("SELECT * FROM apartments order by floors asc,name asc ");
                                while($row = $cars->fetch_assoc()):
                                    $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                                    unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                                    $desc = strtr(html_entity_decode($row['description']),$trans);
                                    $desc = str_replace(array("<li>","</li>"), array("",","), $desc);
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="">
                                    <p> <b><?php echo ucwords($row['floors']) ?></b></p>
                                     
                                    </td>
                                    <td class="">
                                    <p> <b><?php echo ucwords($row['name']) ?></b></p>
                                    </td>
                                    <td class="">
                                    <p> <b><?php
                                    $count=getRoomCount($row['id']);
                                     echo ucwords($count)
                                      ?></b></p>
                                    </td>
                                    <td class="">
                                    <p> <b><?php
                                    $available_count=getRoomCount($row['id'])-getAvailableRoomCount($row['id']);
                                     echo ucwords($available_count)
                                      ?></b></p>
                                    </td>
                                    <td class="">
                                    <p> <b><?php echo ucwords($row['price']) ?></b></p>
                                    </td>
                                    
                                    <td>
                                        <p> <b><?php echo ucwords($cat[$row['category_id']]) ?></b></p>
                                    </td>
                                    <td>
                                        <p><?php echo ucwords($row['description']) ?></p>
                                        
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_car" type="button" data-id="<?php echo $row['id'] ?>" >View</button>
                                        <button class="btn btn-sm btn-outline-primary edit_car" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_car" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php 
                                function getRoomCount($apartmentId)
                                {
                                    $conn= new mysqli('localhost','root','','rentals')or die("Could not connect to mysql".mysqli_error($con));
				$RoomSql="select * from rooms where apartment_id='$apartmentId'";
				$RoomQuery=mysqli_query($conn,$RoomSql);
				$count=mysqli_num_rows($RoomQuery);
				return $count;
			
                                }
                                function getAvailableRoomCount($apartmentId)
                                {
                                        $conn= new mysqli('localhost','root','','rentals')or die("Could not connect to mysql".mysqli_error($con));
                                        $tenantSql="select * from books where apartment_id='$apartmentId'";
                                        $tenantQuery=mysqli_query($conn,$tenantSql);
                                        $count=mysqli_num_rows($tenantQuery);
                                        return $count;
                                    
			
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>    
</div>
<style>
    td{
        vertical-align: middle !important;
    }
    td p{
        margin: unset
    }
    img{
        max-width:100px;
        max-height: 150px;
    }
</style>
<script>
    $(document).ready(function(){
        $('table').dataTable()
    })

    $('.view_car').click(function(){
        uni_modal("Car Details","view_car.php?id="+$(this).attr('data-id'),'mid-large')
    })

    $('.edit_car').click(function(){
        location.href ="index.php?page=manage_car&id="+$(this).attr('data-id')
    })

    $('.delete_car').click(function(){
        _conf("Are you sure to delete this car?","delete_car",[$(this).attr('data-id')])
    })

    function delete_car($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_car',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully deleted",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    }
    <?php 
			function getRent($apartmentId)
			{
				$conn= new mysqli('localhost','root','','rentals')or die("Could not connect to mysql".mysqli_error($con));
				$rentSql="select * from apartments where id='$apartmentId'";
				$rentQuery=mysqli_query($conn,$rentSql);
				$res=mysqli_fetch_assoc($rentQuery);
				return $res['price'];
			}
			function getName($apartmentId)
			{
				$conn= new mysqli('localhost','root','','rentals')or die("Could not connect to mysql".mysqli_error($con));
				$rentSql="select * from apartments where id='$apartmentId'";
				$rentQuery=mysqli_query($conn,$rentSql);
				$res=mysqli_fetch_assoc($rentQuery);
				return $res['name'];
			}
			function getTenant($apartmentId,$roomNo)
			{
				$conn= new mysqli('localhost','root','','rentals')or die("Could not connect to mysql".mysqli_error($con));
				$tenantSql="select * from books where apartment_id='$apartmentId' and room_no='$roomNo'";
				$tenantQuery=mysqli_query($conn,$tenantSql);
				$count=mysqli_num_rows($tenantQuery);
				if($count==0)
				{
					return "N/A";
				}
				$res=mysqli_fetch_assoc($tenantQuery);
				return $res['name'];
			}
			?>
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=add_room',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
                end_load();
					alert_toast("Data successfully added",'success')


			}
		})
	})
	$('.edit_category').click(function(){
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_category').click(function(){
		_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>

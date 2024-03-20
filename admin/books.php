<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Bookings</b>
						
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Tenant</th>
									<th class="">Apartment info</th>
									<th class="">Room number</th>
									<th class="">Rent</th>
									<th class="">Status</th>
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
								$totalPaid=0;
								$totalPending=0;
								while($rows = mysqli_fetch_assoc($qry)){
									$et[$rows['id']] = $rows['name'];
								}
								$books = $conn->query("SELECT b.*,c.floors,c.name as aname,c.id,c.price FROM books b inner join apartments c on c.id = b.apartment_id ");
								while($row=mysqli_fetch_assoc($books)):
									if($row['status']==2)
									{
										$totalPaid=$totalPaid+$row['price'];
									}
									else{
										$totalPending=$totalPending+$row['price'];
									}

								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p> <b><?php echo ucwords($row['name']) ?></b></p>
									</td>
									<td>
										 <p>BUilding Name: <b><?php echo ucwords($row['aname']) ?></b></p>
										 <p>Floors: <b><?php echo ucwords($row['floors']) ?></b></p>
									</td>
									<td>
										 <p>House number: <b><?php echo ucwords($row['room_no']) ?></b></p>
									</td>
									<td>
										 <p>Rent AmountPaid: <b><?php echo ucwords($row['price']) ?></b></p>
									</td>
									<td>
										<?php if($row['status'] == 1): ?>
										<span class="badge badge-secondary">Pending</span>
										<?php elseif($row['status'] == 2): ?>
										<span class="badge badge-primary">Confirmed</span>
										<?php else: ?>
										<span class="badge badge-danger">Pending</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_book" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_book" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
								<tr><td colspan='3'><h4>Total paid:</h4></td><td>Ksh <?php echo $totalPaid; ?></td></tr>
								<tr><td colspan='3'><h4>Total pending:</h4></td><td>Ksh <?php echo $totalPending; ?></td></tr>
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
		max-height:150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('.view_book').click(function(){
		window.open("../index.php?page=view_book&id="+$(this).attr('data-id'))
		
	})
	$('#new_book').click(function(){
		uni_modal("New Book","manage_booking.php","mid-large")
		
	})
	$('.edit_book').click(function(){
		uni_modal("Manage Bookings ","manage_booking.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_book').click(function(){
		_conf("Are you sure to delete this book?","delete_book",[$(this).attr('data-id')])
	})
	
	function delete_book($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_book',
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
</script>
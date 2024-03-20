<?php 
include 'admin/db_connect.php'; 
include 'header.php'; 
$qry = $conn->query("SELECT * FROM apartments where id= ".$_GET['hid']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
$apartment_id=$_GET['hid'];
?>
<body>
<div class="container-fluid">
	<form action="" id="manage-book">
		<input type="hidden" name="id" value="">
		<input type="hidden" name="apartment_id" value="<?php echo isset($_GET['hid']) ? $_GET['hid'] :'' ?>">
		<p>
			<large><b>Book for: <?php echo $name; ?></b></large>
		</p>
		<div class="form-group">
			<label for="" class="control-label">Full Name</label>
			<input type="text" class="form-control" name="name"  value="" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Address</label>
			<textarea cols="30" rows = "2" required="" name="address" class="form-control"><?php echo isset($address) ? $address :'' ?></textarea>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contact #</label>
			<input type="text" class="form-control" name="contact" id="cont" value="<?php echo isset($contact) ? $contact :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Room number</label>
			<?php 
			$sq="select * from rooms where apartment_id='$apartment_id' and status='available'";
			$query=mysqli_query($conn,$sq);
			?>
			<select class="form-control" name="room_no">
				<?php
				while($rows=mysqli_fetch_assoc($query))
				{
					
					echo "<option value='".$rows['room_no']."'>".$rows['room_no']."</option>";
				}
				?>
</select>
			</div>
		<div class="form-group">
			<button class="form-control" class="btn btn-primary" id="manage-book">Save</button>
		</div>
	</form>
</div>
</body>
<script>
	$('#manage-book').submit(function(e){
		e.preventDefault()
		$('#msg').html('')
		$.ajax({
			url:'admin/ajax.php?action=save_book',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				alert(resp);
				if(resp==1){
					alert("Booking Request Sent.");
					$.ajax({
			url:'stkpush.php?contact='+$('#cont').val(),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(respon){
				alert(respon)
				if(resp==1){
					location.replace("confirm.php?contact="+$('#cont').val());
				}
			}
		})
				}
			}
		})
	})
</script>
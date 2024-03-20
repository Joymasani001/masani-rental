<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
</style>

<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="index.php?page=cars">
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class=""></i></span>
                                        <h4><b>
                                            <?php 
                                            $cars =  $conn->query("SELECT sum(qty) as total FROM apartment"); 
                                            echo $conn->query("SELECT * FROM rooms")->num_rows; 
                                            ?>
                                            
                                        </b></h4>
                                        <p><b>Total Rooms</b></p>
                                    </div>
                                </div>
                            </div>
</a>
                        </div>
                        <div class="col-md-4">
                            <a href="index.php?page=rooms&cat=booked">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-book"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM rooms where status = 'taken'")
                                            ->num_rows; ?>
                                        </b></h4>
                                        <p><b>Booked rooms</b></p>
                                    </div>
                                </div>
                            </div>
</a>
                        </div>
                        <div class="col-md-4">
                            <a href="index.php?page=rooms&cat=not_booked">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-book"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM rooms where status = 'available'")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Vacant Rooms</b></p>
                                    </div>
                                </div>
                            </div>
</a>
                        </div>
                       <!-- <div class="col-md-4">
                            <div class="card">
                                <div class="card-body bg-warning">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-history"></i></span>
                                        <h4><b>
                                        <?php echo $conn->query("SELECT * FROM books")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Expected Vacancies Today</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	-->

                    
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>
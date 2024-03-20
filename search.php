<?php 
include 'admin/db_connect.php'; 
?>
<style>
#portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
.cars-list{
cursor: pointer;
border: unset;
flex-direction: inherit;
}
.cars-img,.cars-list .card-body {
    width: calc(50%)
}
.cars-img img{
    border-radius: 5px;
    min-height: 50vh;
    max-width: calc(100%);
}
span.hightlight{
    background: yellow;
}
.carousel,.carousel-inner,.carousel-item{
   min-height: calc(100%)
}
header.masthead,header.masthead:before {
        min-height: 50vh !important;
        height: 50vh !important
    }
.row-items{
    position: relative;
}
.card-left{
    left:0;
}
.card-right{
    right:0;
}
.rtl{
    direction: rtl ;
}
.cars-text{
    justify-content: center;
    align-items: center ;
}
.masthead{
        min-height: 23vh !important;
        height: 23vh !important;
    }
     .masthead:before{
        min-height: 23vh !important;
        height: 23vh !important;
    }
.car-details p {
    margin:unset;
}
</style>
        <header class="masthead">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-4 page-title">
                        <h3 class="text-white"></h3>
                        <hr class="divider my-4" />

                    <div class="col-md-12 mb-2 justify-content-center">
                         <form action="" id="find-car">
                            <div class="row form-group">
                                
                           
                              <div class="col-md-4">
                                <label for="" class="control-label text-white">Category</label>
                                <select class="custom-select select2" name="category_id">
                                  <option value="0">Any</option>
                                  <?php
                                  $qry = $conn->query("SELECT * FROM categories order by name asc");
                                  while($row=$qry->fetch_assoc()):
                                  ?>
                                  <option value="<?php echo $row['id'] ?>" <?php echo $_GET['category_id']== $row['id'] ? "selected" : '' ?>><?php echo $row['name'] ?></option>
                                  <?php endwhile; ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group ">
                              <center>
                                <button class="btn btn-primary">Find Availability</button>
                              </center>
                            </div>
                          </form>
                    </div>                        
                    </div>
                    
                </div>
            </div>
        </header>
            <div class="container-fluid mt-3 pt-2">
               
                <div class="row-items">
                <div class="col-lg-12">
                    <div class="row">
                    <?php
$cat = array();
$cat[] = ''; // Initialize with an empty value
$qry = $conn->query("SELECT * FROM categories");
while($row = $qry->fetch_assoc()){
    $cat[$row['id']] = $row['name'];
}

$tt = array();
$tt[] = ''; // Initialize with an empty value
$qry = $conn->query("SELECT * FROM transmission_types");
while($row = $qry->fetch_assoc()){
    $tt[$row['id']] = $row['name'];
}

$et = array();
$et[] = ''; // Initialize with an empty value
$qry = $conn->query("SELECT * FROM engine_types");
while($row = $qry->fetch_assoc()){
    $et[$row['id']] = $row['name'];
}
echo $_GET['category_id'];
$where = "";
if(isset($_GET['category_id']) && $_GET['category_id'] > 0){
    $where .= "WHERE category_id = {$_GET['category_id']} ";
}

$fpath = 'admin/assets/uploads/cars_img/';

$cars = $conn->query("SELECT * FROM apartments $where");
while($row = $cars->fetch_assoc()):
    $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
    unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
    $desc = strtr(html_entity_decode($row['description']), $trans);
    $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
    
    $in_use = $conn->query("SELECT * FROM books WHERE apartment_id = {$row['id']}")->num_rows;
    
    if($in_use < $row['qty']):
?>
<div class="col-md-6">
    <div class="card cars-list" data-id="<?php echo $row['id'] ?>">
        <div class="cars-img card-img-top">
            <img src="<?php echo $fpath.$row['img_path'] ?>" alt="">
        </div>
        <div class="card-body">
            <div class="row align-items-center justify-content-center h-100">
                <div class="w-100">
                    <p><?php echo $row['name'] ?></p>
                    <p><?php echo $row['floors'] ?></p>
                    <div class="car-details">
                        <p><small><i class="fa fa-circle text-primary"></i> <?php echo $cat[$row['category_id']] ?></small></p> 
                        <p><small><i class="fa fa-tags text-primary"></i> <?php echo number_format($row['price'], 2) ?> /Month</small></p> <br> 
                        <p><small><i class="fa fa-tags text-primary"></i>Remaining Rooms: <?php echo number_format($row['qty'] ) ?> Rooms</small></p>  
                    </div>
                    <div class="w-100">
                        <a class="btn-primary btn btn-sm float-right book-cars" href="booking.php?hid=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">Pay Now</a>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
<?php endif; ?>
<?php endwhile; ?>
</div>
</div>
</div>
</div>


<script>
   
    $('.book-cars').click(function(){
        uni_modal("Submit Booking Request","booking.php?car_id="+$(this).attr('data-id')+'&pickup=<?php echo $_GET['pickup'] ?>&dropoff=<?php echo $_GET['dropoff'] ?>','mid-large')
    })
    $('.cars-img img').click(function(){
        viewer_modal($(this).attr('src'))
    })
     $('#find-car').submit(function(e){
        e.preventDefault()
        location.href = 'index.php?page=search&'+$(this).serialize()
      })

</script>
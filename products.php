<?php
  include_once 'products_crud.php';
 // Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the user is a supervisor or admin
$isAdmin = ($_SESSION['level'] === 'Admin');
$isSupervisor = ($_SESSION['level'] === 'Supervisor');
$isNormalStaff = ($_SESSION['level'] === 'Normal Staff');

?>

<!DOCTYPE html>
<html>
<head>
  <title>My Soccer Shoes Ordering System : Products</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
  <style >
  /* Style for the default state of the pagination button */
  .dataTables_paginate .paginate_button {
    padding: 5px 10px; /* Adjust padding as needed */
    margin: 0 2px; /* Adjust margin as needed */
    display: inline-block;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #fff;
    color: #333;
}

/* Style for the active state of the pagination button */
.dataTables_paginate .paginate_button.current {
    background-color: #007bff; /* Change to your desired active background color */
    color: #fff;
    border: 1px solid #007bff;
}

</style>
</head>
<body>

  <?php include_once 'nav_bar.php'; ?>

<?php if(!$isNormalStaff){?>

  <div class="container-fluid">

  <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Create New Product</h2>
      </div>
    <form action="products.php" method="post" class="form-horizontal">

     <div class="form-group">
          <label for="productid" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-9">
            <input name="pid" type="text"class="form-control" id="productid" placeholder="Product ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_num']; ?>" required> <br>
           </div>
     </div>


      <div class="form-group">
          <label for="productname" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
            <input name="name" type="text" class="form-control" id="productname" placeholder="Product name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>" required> <br>
          </div>
      </div>



     <div class="form-group">
          <label for="productprice" class="col-sm-3 control-label">Price</label>
          <div class="col-sm-9">
             <input name="price" type="text" class="form-control" id="productprice" placeholder="Product price" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_price']; ?>"> <br>

            </div>
      </div>

      <div class="form-group">
         <label for="productbrand" class="col-sm-3 control-label">Brand</label>
          <div class="col-sm-9">
            <select name="brand" class="form-control" id="productbrand" required>
              <option value="Adidas" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Adidas") echo "selected"; ?>>Adidas</option>
              <option value="Nike" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Nike") echo "selected"; ?>>Nike</option>
              <option value="Puma" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Puma") echo "selected"; ?>>Puma</option>
            </select><br>
           </div>
       </div>


      <div class="form-group">
          <label for="playingsurface" class="col-sm-3 control-label">Playing Surface</label>
          <div class="col-sm-9">
             <select name="surface" class="form-control" id="playingsurface" required> 
                <option value="Firm Ground(FG)" <?php if(isset($_GET['edit'])) if($editrow['fld_product_surface']=="Firm Ground(FG)") echo "selected"; ?>>Firm Ground(FG)</option>
                <option value="Soft Ground(SG)" <?php if(isset($_GET['edit'])) if($editrow['fld_product_surface']=="Soft Ground(SG)") echo "selected"; ?>>Soft Ground(SG)</option>
                <option value="Multi-Ground(MG)" <?php if(isset($_GET['edit'])) if($editrow['fld_product_surface']=="Multi-Ground(MG)") echo "selected"; ?>>Multi-Ground(MG)</option>  
              </select><br>
          </div>
      </div>    


      <div class="form-group">
          <label for="productsize" class="col-sm-3 control-label">Size</label>
          <div class="col-sm-9">
          <select name="size"class="form-control" id="productsize" required>
              <option value="UK 7" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 7") echo "selected"; ?>>UK 7</option>
              <option value="UK 7.5" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 7.5") echo "selected"; ?>>UK 7.5</option>
              <option value="UK 8" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 8") echo "selected"; ?>>UK 8</option>
              <option value="UK 8.5" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 8.5") echo "selected"; ?>>UK 8.5</option>
              <option value="UK 9" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 9") echo "selected"; ?>>UK 9</option>
              <option value="UK 9.5" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 9.5") echo "selected"; ?>>UK 9.5</option>
              <option value="UK 10" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 10") echo "selected"; ?>>UK 10</option>
              <option value="UK 10.5" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 10.5") echo "selected"; ?>>UK 10.5</option>
              <option value="UK 11" <?php if(isset($_GET['edit'])) if($editrow['fld_product_size']=="UK 11") echo "selected"; ?>>UK 11</option>
               </select><br>
          </div>
      </div>

      <div class="form-group">
          <label for="productquantity" class="col-sm-3 control-label">Quantity</label>
          <div class="col-sm-9">
            <input name="quantity" type="text" class="form-control" id="productquantity" placeholder="Quantity" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_quantity']; ?>" required> <br>
          </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
           <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldpid" value="<?php echo $editrow['fld_product_num']; ?>">
           <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
          <?php } else { ?>
          <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
          <?php } ?>
          <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
         </div>
      </div>

    </form>
     </div>
  </div>
<?php } ?>

     <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Products List</h2>
      </div>

      <table id="product-table" class="table table-striped table-bordered">
        <thead>
      <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Brand</th>
        <th>Playing Surface</th>
        <th>Size</th>
        <th>Quantity</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Read
      $per_page = 30;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_products_a189647 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>   
      <tr>
        <td><?php echo $readrow['fld_product_num']; ?></td>
        <td><?php echo $readrow['fld_product_name']; ?></td>
        <td><?php echo $readrow['fld_product_price']; ?></td>
        <td><?php echo $readrow['fld_product_brand']; ?></td>
        <td><?php echo $readrow['fld_product_surface']; ?></td>
        <td><?php echo $readrow['fld_product_size']; ?></td>
        <td><?php echo $readrow['fld_product_quantity']; ?></td>

        
        <td>
         <a href="#" class="btn btn-warning btn-xs btn-details" data-product-id="<?php echo $readrow['fld_product_num']; ?>" role="button">Details</a>

          <?php if(!$isNormalStaff){?>
          <a href="products.php?edit=<?php echo $readrow['fld_product_num']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
          <a href="products.php?delete=<?php echo $readrow['fld_product_num']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
          <?php } ?>
        </td>
        
      </tr>
      <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  

 <div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Product Details</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
      $('.export-container .btn-primary').removeClass('btn-secondary').addClass('btn-primary');
          
        $('.btn-details').on('click', function (e) {
            e.preventDefault();
            var pid = $(this).data('product-id');
            var url = 'products_details.php?pid=' + pid;
            
            $('.modal-body').load(url, function () {
                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
        });

       var table = $('#product-table').DataTable({
          "paging": true,
          "pageLength": 5,
          "lengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "All"]], 
          "searching": true, 
          "columnDefs": [{ "searchable": false, "targets": 2 }],  
           "order": [[1, 'asc']], // Default sorting by "Name" column in ascending order
          "dom": 'lBfrtip',
          "buttons": [
            {
              extend: 'excelHtml5',
              text: 'Excel',
              exportOptions: {
                columns: [0, 1, 2, 3]
              },
              className: 'btn btn-primary' 
            }
          ], 

        });

    
        
            // Style the pagination buttons (previous and next) after each draw
            //$('.paginate_button').addClass('btn btn-default');
       

        var exportContainer = $('<div class="export-container"></div>').insertBefore('.dataTables_filter');
        table.buttons().container().appendTo(exportContainer);
        exportContainer.css({
            'float': 'right',
            'margin-bottom': '20px' // Add margin-right for spacing
        });

        
    });
</script>


</body>
</html>

       
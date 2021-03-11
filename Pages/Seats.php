<?php 

    $siteName = "FrontBlow Company";
    define("TITLE", "FrontBlow | Seats");

    require("Header.php");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<link rel="stylesheet" href="../bootstrap/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="../Assets/Event.css">

<body>
    
    <input type="checkbox" id="check">
    <header>
        <label for="check">
            <i class="fas fa-bars" id="sidebar_btn"></i>
        </label>
        <div class="left_area">
            <h3>Seat Preferences</h3>
        </div>
        <div class="right_area">
        <a href="Login.php" class="logout_btn">Logout</a>
        </div>
    </header>

    <div class="sidebar">
        <a href="Dashboard.php"><i class="fas fa-desktop"></i><span>Dashboard</span></a>
        <a href="SoldTickets.php"><i class="fas fa-store"></i><span>Sold Tickets</span></a>
        <a href="Events.php"><i class="fas fa-calendar-week"></i><span>Events</span></a>
        <a href="Seats.php"><i class="fas fa-list-ul"></i><span>Seats</span></a>
        <a href="About.php"><i class="fas fa-info-circle"></i><span>About Us</span></a>
    </div>

    <div class="content">

        <div class="container">

            <div class="upper">

                <div class="sec">

                    <button class="btn-add addJS" > <img src="../Assets/Pictures/addEvents.png"> </button>

                </div>

                <div class="sec">

                    <h4>List of Seats</h3>

                </div>

                <div class="sec">

                    <button onclick="window.print();" class="btn-print">Print</button>

                </div>

            </div>

            <hr>

            <div class="lower">

                <table class="table table-hover table-dark" id="tableData">

                    <thead>

                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Seat Prefix</th>
                            <th scope="col">Seat Details</th>
                            <th scope="col">Seat Size</th>
                            <th scope="col">Price per Seat</th>
                            <th scope="col">Action</th>
                        </tr>

                    </thead>

                    <tbody>
                        <?php

                            $resultCounter = 0;
                            $results = getSeats();
                            while ($result = mysqli_fetch_array($results)) 
                            {
                                $resultCounter++;
                        ?>
                        <tr>
                            <td><?php echo $result['seat_ID']?></td>
                            <td><?php echo strtoupper($result['seat_Pref']);?></td>
                            <td><?php echo ucwords($result['seat_Type']); ?></td>
                            <td> <?php echo $result['seat_Size']; ?> </td>
                            <td> <?php echo $result['seat_Price']; ?> </td>
                            <td>
                                <button class="btn-warning editJS" id="btn-update"> <img src="../Assets/Pictures/edit.png"> 
                                </button>
                                <button class="btn-danger deleteJS" id="btn-delete"> <img src="../Assets/Pictures/del.png">
                                </button>
                            </td>

                        </tr>
                        <?php } ?>
                        
                    </tbody>

                </table>

            </div>

        </div>

        <div class="end">
            <?php include("Footer.php"); ?>
        </div>

    </div>

</body>

<script src="../jquery/jquery-3.4.1.js"></script>
<script src="../bootstrap/bootstrap.min.js"></script>
<script src="../jquery/datatables.min.js"></script>
<script src="../jquery/dataTables.bootstrap4.min.js"></script>

<!-- ------------------------------------------------MODAL SECTION-------------------------------------------------------- -->

<!-- ADD SEATS -->

<?php

    $event = $seat = $size = $price = "";

    if(isset($_POST['addSeats']))
    {
        $seatNn = testInput($_POST['seatPref']);
        $seatings = testInput($_POST['seatType']);
        $size = testInput($_POST['seatSize']);
        $price = testInput($_POST['seatPrice']);

        $seatNn = strtoupper($_POST['seatPref']);
        $seatings = ucwords($_POST['seatType']);

        $_SESSION['seatPref'] =  $seatNn;
        $_SESSION['seatType'] =  $seatings;
        $_SESSION['seatSize'] =  $size;
        $_SESSION['seatPrice'] =  $price;


        $newId = getSeatId();
        global $connection;

        $sqlSeats = "INSERT INTO tbl_seat
                VALUES ('$newId', '$seatNn', '$seatings', '$size', '$price')";

        if(mysqli_query($connection, $sqlSeats))
        {
            $newseatInvId = getSeatInvId();

            $sqlSeatsInv = "INSERT INTO tbl_seatsinventory 
                VALUES ('$newseatInvId', '$size', 0)";

            if(mysqli_query($connection, $sqlSeatsInv))
            {
            ?>
                <div class="popup popup--icon -success js_success-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title">
                            Success! 
                        </h3>
                        Seat Successfully Added!
                        <p>
                            <?php echo "<script>setTimeout(\"location.href = 'Seats.php';\",2000);</script>"; ?>
                        </p>
                    </div>
                </div>
            <?php
            }
            else
            {
                echo "Error: ".$connection->error;
            }
        }
    }
?>

<div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Seats</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">

                <div class="form-group">
                    <label for="seatPre">Area Prefix</label>
                    <input required type="text" id="seatPre" placeholder="Enter Seat Prefix" name="seatPref" class="form-control" autocomplete="off">
                    <small> VIP = Very Important Person, BL = Bleachers, REG = Regular</small>
                </div>

                <div class="form-group">
                    <label for="seatType">Description</label>
                    <input required type="text" id="seatType" placeholder="Enter Seat Description" name="seatType" class="form-control" autocomplete="off">
                </div>


                <div class="form-group">
                    <label for="val-digits">Max Seat Capacity:</label>
                    <input required type="text" id="val-digits" name="seatSize" placeholder="Enter max seat capacity..." class="form-control" autocomplete="off">
                </div>

                <label for="seatPrice">Price per Seat</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">₱</span>
                    </div>
                        <input required type="text" class="form-control" name="seatPrice" id="seatPrice" autocomplete="off" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="addSeats" class="btn btn-primary" id="seatAdded">Add</button>
            </div>

      </form>

    </div>
  </div>
</div>

<!-- EDIT SEATS -->

<?php
    if(isset($_POST['updateSeatDetails']))
    {

        $results = getSeats();
        while($result = mysqli_fetch_array($results))
        {
            
            $id = $_POST['updateId'];
            $UseatPref = $_POST['UseatPref'];
            $UseatDesc = $_POST['UseatType'];
            $UseatSize = $_POST['UseatSize'];
            $UseatPrice = $_POST['UseatPrice'];

            $UseatPref = strtoupper($_POST['UseatPref']);
            $UseatDesc = ucwords($_POST['UseatType']);

            $sql = "UPDATE tbl_seat SET
            seat_Pref = '$UseatPref',
            seat_Type = '$UseatDesc',
            seat_Size = '$UseatSize',
            seat_Price = '$UseatPrice' WHERE seat_ID='$id' ";

            if(mysqli_query($connection, $sql))
            {
            ?>
                <div class="popup popup--icon -success js_success-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title">
                            Success! 
                        </h3>
                            Data Successfully Updated!
                        <p>
                            <?php echo "<script>setTimeout(\"location.href = 'Seats.php';\",2000);</script>"; ?>
                        </p>
                    </div>
                </div>
            <?php
            break;
            }
            else
            {
                echo "Error: ".$connection->error;
            }
        }
    }
?>

<div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Seat Details</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">
            
                <div class="form-group">
                    <input type="hidden" name="updateId" id="updateId">
                </div>

                <div class="form-group">
                    <label for="seatType">Area Prefix</label>
                    <input required type="text" id="seatType" placeholder="Enter Seat Prefix" name="UseatPref" class="form-control USP" autocomplete="off">
                    <small> VIP = Very Important Person, BL = Bleachers, REG = Regular</small>
                </div>

                <div class="form-group">
                    <label for="seatType">Description</label>
                    <input required type="text" id="seatType" placeholder="Enter Seat Description" name="UseatType" class="form-control USD" autocomplete="off">
                </div>


                <div class="form-group">
                    <label for="val-digits">Max Seat Capacity:</label>
                    <input required type="text" id="val-digits" name="UseatSize" placeholder="Enter max seat capacity..." class="form-control USS" autocomplete="off">
                </div>

                <label for="seatPrice">Price per Seat</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">₱</span>
                    </div>
                        <input required type="text" class="form-control USPP" name="UseatPrice" id="seatPrice" autocomplete="off" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updateSeatDetails" class="btn btn-primary">Update</button>
            </div>

      </form>

    </div>
  </div>
</div>

<!-- DELETE SEATS -->

<?php

    if(isset($_POST['delSeatData']))
    {
        $id = $_POST['deleteId'];

        $sql = "DELETE FROM tbl_seat WHERE seat_ID='$id' ";
        
        if(mysqli_query($connection, $sql))
        {
        ?>
           
            <div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                    <h3 class="popup__content__title">
                        Success! 
                    </h3>
                    Data Successfully Deleted!
                    <p>
                        <?php echo "<script>setTimeout(\"location.href = 'Seats.php';\",2000);</script>"; ?>
                    </p>
                </div>
            </div>
            
        <?php
        }
        else
        {
			echo "Error: ".$connection->error;
        }
        
        
    }

?>

<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Delete Seat</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">
            
                <div class="form-group">
                    <input type="hidden" name="deleteId" id="deleteId">
                </div>

                <h4> Do you want to Delete this Seat? </h4>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="delSeatData" class="btn btn-primary">Delete</button>
            </div>

      </form>

    </div>
  </div>
</div>

<!-- ------------------------------------------------SCRIPT SECTION-------------------------------------------------------- -->

<script>

    $(document).ready(function() 
    {
        $('#tableData').DataTable(
        {
            "pagingType": "full_numbers", "lengthMenu":
            [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            responsive: true,
            language:
            {
                search:"_INPUT_",
                searchPlaceholder:"Search records..",
            }
        });
    });


    //--------------------ADD MODAL SCRIPT------------------------------------

    $(document).ready(function()
        {
        $('.addJS').on('click', function()
        {
            $('#addModal').modal('show');

        });
    });

    //--------------------EDIT MODAL SCRIPT------------------------------------

    $(document).ready(function()
    {
        $('.editJS').on('click', function()
        {
            $('#editModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function()
            {
                return $(this).text();
            }).get();

            console.log(data);
            
            $(".USP").val(data[1]);
            $(".USD").val(data[2]);
            $(".USS").val(data[3]);
            $(".USPP").val(data[4]);

        });
    });

    


    //--------------------DELETE MODAL SCRIPT------------------------------------

    $(document).ready(function()
        {
            $('.deleteJS').on('click', function()
            {
                $('#deleteModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function()
                {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#deleteId').val(data[0]);

            });
        });

    

</script>
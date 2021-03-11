<?php 

    $siteName = "FrontBlow Company";
    define("TITLE", "FrontBlow | Events");

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
            <h3>Event Preferences</h3>
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

                    <h4>List of Events</h3>

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
                            <th scope="col">Event Title</th>
                            <th scope="col">Event Date</th>
                            <th scope="col">Event Venue</th>
                            <th scope="col">Action</th>
                        </tr>

                    </thead>

                    <tbody>
                        <?php

                            $resultCounter = 0;
                            $results = getEvents();
                            while ($result = mysqli_fetch_array($results)) 
                            {
                                $resultCounter++;
                        ?>

                        <tr>
                            <td><?php echo $result['event_ID']?></td>
                            <td><?php echo ucwords($result['eventName'])?></td>
                            <td><?php echo date("F j, Y", strtotime($result['eventDate']))?></td>
                            <td><?php echo ucwords($result['eventVenue'])?></td>
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

<!-- ADD EVENTS -->

<?php

    $title = $date = $venue = "";

    if(isset($_POST['addEvents']))
    {

        $title = testInput($_POST['eventTitle']);
        $date = testInput($_POST['eventDate']); 
        $venue = testInput($_POST['eventVenue']);

        $title = ucwords($_POST['eventTitle']);
        $venue = ucwords($_POST['eventVenue']);

        $_SESSION['eventTitle'] =  $title;
        $_SESSION['eventDate'] =  $date;
        $_SESSION['eventVenue'] =  $venue;

      
    
        $newId = getEventId();
        $events = getEvents();
        global $connection;

    
        $sql = "INSERT INTO tbl_events 
                    VALUES ('$newId', '$title', '$date', '$venue')";

            if(mysqli_query($connection, $sql))
            {
            ?>
                <div class="popup popup--icon -success js_success-popup popup--visible">
                        <div class="popup__background"></div>
                        <div class="popup__content">
                            <h3 class="popup__content__title">
                                Success! 
                            </h3>
                                Event Successfully Added!
                            <p>
                                <?php echo "<script>setTimeout(\"location.href = 'Events.php';\",2000);</script>"; ?>
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

<div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Events</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="eventTitle">Event Title</label>
                    <input required type="text" id="eventTitle" placeholder="Enter Event Name.." name="eventTitle" class="form-control" autocomplete="off">
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-digits">Event Date :</label>
                    <div class="col-lg-6">
                        <input required type="date" class="form-control" id="val-digits" name="eventDate" placeholder="Event Date" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="eventVenue">Event Venue</label>
                    <input required type="text" id="eventVenue" placeholder="Enter Event Venue.." name="eventVenue" class="form-control" autocomplete="off">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="addEvents" class="btn btn-primary">Add</button>
            </div>

      </form>

    </div>
  </div>
</div>

<!-- EDIT EVENTS -->

<?php
    if(isset($_POST['updateEventDetails']))
    {

        $results = getEvents();
        while($result = mysqli_fetch_array($results))
        {
            
            $id = $_POST['updateId'];
            $eventTitle = $_POST['eventTitle'];
            $eventDate = $_POST['eventDate'];
            $eventVenue = $_POST['eventVenue'];

            $sql = "UPDATE tbl_events SET
            eventName = '$eventTitle',
            eventDate = '$eventDate',
            eventVenue = '$eventVenue' WHERE event_ID='$id' ";

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
                            <?php echo "<script>setTimeout(\"location.href = 'Events.php';\",2000);</script>"; ?>
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
        <h5 class="modal-title" id="staticBackdropLabel">Edit Event Details</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">
            
                <div class="form-group">
                    <input type="hidden" name="updateId" id="updateId">
                </div>

                <div class="form-group">
                    <label for="eTitle">Event Title</label>
                    <input required type="text" id="eTitle" name="eventTitle" class="form-control" autocomplete="off">
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="eDate">Event Date :</label>
                    <div class="col-lg-6">
                        <input required type="date" class="form-control" id="eDate" name="eventDate" placeholder="Event Date" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="eVenue">Event Venue</label>
                    <input required type="text" id="eVenue" name="eventVenue" class="form-control" autocomplete="off">
                </div>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updateEventDetails" class="btn btn-primary">Update</button>
            </div>

      </form>

    </div>
  </div>
</div>

<!-- DELETE EVENTS -->

<?php

    if(isset($_POST['delEventDetails']))
    {
        $id = $_POST['deleteId'];

        $sql = "DELETE FROM tbl_events WHERE event_ID='$id' ";
        
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
                        <?php echo "<script>setTimeout(\"location.href = 'Events.php';\",2000);</script>"; ?>
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
        <h5 class="modal-title" id="staticBackdropLabel">Delete Event</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">
            
                <div class="form-group">
                    <input type="hidden" name="deleteId" id="deleteId">
                </div>

                <h4> Do you want to Delete this Event? </h4>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="delEventDetails" class="btn btn-primary">Delete</button>
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
            
            $("#updateId").val(data[0]);
            $("#eTitle").val(data[1]);
            $("#eDate").val(data[2]);
            $("#eVenue").val(data[3]);

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
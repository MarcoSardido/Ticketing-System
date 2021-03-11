<?php 

    $siteName = "FrontBlow Company";
    define("TITLE", "FrontBlow | Dashboard");

    require("Header.php");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<link rel="stylesheet" href="../bootstrap/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="../Assets/Dashboard.css">

<input type="checkbox" id="check">
<header>
    <label for="check">
        <i class="fas fa-bars" id="sidebar_btn"></i>
    </label>
    <div class="left_area">
        <h3>Dashboard</h3>
    </div>
    <div class="right_area">
    <a href="Login.php" class="logout_btn">Logout</a>
    </div>
</header>

<div class="sidebar">
    <a href="Dashboard.php" class="Dashi"><i class="fas fa-desktop"></i><span>Dashboard</span></a>
    <a href="SoldTickets.php"><i class="fas fa-store"></i><span>Sold Tickets</span></a>
    <a href="Events.php"><i class="fas fa-calendar-week"></i><span>Events</span></a>
    <a href="Seats.php"><i class="fas fa-list-ul"></i><span>Seats</span></a>
    <a href="About.php"><i class="fas fa-info-circle"></i><span>About Us</span></a>
</div>

<div class="content">

    <div class="cardsContainer">

        <div class="card">

            <img src="../Assets/Pictures/event.png">

            <?php

                $sql = "SELECT count(event_ID) FROM tbl_events ";
                $results = mysqli_query($connection, $sql);
                while ($result = mysqli_fetch_array($results)) 
                { 
                ?>
                
                    <h2 class="cards"> <?php echo $result["count(event_ID)"]; ?> </h2>

                <?php
                }

            ?>

            <h5 class="upperText">Total Events</h5>

        </div>

        <div class="card">

            <img src="../Assets/Pictures/seats.png">

            <?php

                $sql = "SELECT count(seat_ID) FROM tbl_seat ";
                $results = mysqli_query($connection, $sql);
                while ($result = mysqli_fetch_array($results)) 
                { 
                ?>
                
                    <h2 class="cards"> <?php echo $result["count(seat_ID)"]; ?> </h2>

                <?php
                }

            ?>

            <h5 class="upperText">Total Seats</h5>

        </div>

    </div>

    <hr class="styleDash">
    
    <div class="container">

            <div class="upper">

                <div class="sec">

                    <button class="btn-add addJS" > <img class="imgAdd" src="../Assets/Pictures/addTicket.png"> </button>

                </div>

                <div class="sec">

                    <h4>List of Tickets</h3>

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
                            <th scope="col"><center>#</center></th>
                            <th scope="col"><center>Event Details</center></th>
                            <th scope="col"><center>Total Sold</center></th>
                            <th scope="col"><center>Total Remaining</center></th>
                            <th scope="col"><center>Action</center></th>
                        </tr>

                    </thead>

                    <tbody>
                        <?php

                            global $connection;
                            $results = getSell();
                            while ($result = mysqli_fetch_array($results)) 
                            {
                        ?>

                        <tr>
                            <td><?php echo "<center>".$result['sell_ID']."</center>"?></td>
                            
                            <td>
                                <?php

                                    $dispEvent = "SELECT * FROM tbl_events";
                                    $E_results = mysqli_query($connection,$dispEvent);
                                    while($E_result = mysqli_fetch_array($E_results))
                                    {
                                        if($E_result['event_ID'] == $result['event_ID'])
                                        {
                                            $dispSeat = "SELECT * FROM tbl_seat";
                                            $S_results = mysqli_query($connection,$dispSeat);
                                            while($S_result = mysqli_fetch_array($S_results))
                                            {
                                                if($S_result['seat_ID'] == $result['seat_ID'])
                                                {
                                                    echo "<center>". $E_result['eventName']. " ( ". date("F j, Y", strtotime($E_result['eventDate'])). 
                                                    " ) ". "<br>"."<strong>".$S_result['seat_Pref']. " @ ". $result['Price']. "</strong><center>";
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </td>
                            
                            <td>
                                <?php

                                    $dispSeat = "SELECT * FROM tbl_seat";
                                    $S_results = mysqli_query($connection,$dispSeat);
                                    while($S_result = mysqli_fetch_array($S_results))
                                    {
                                        if($S_result['seat_ID'] == $result['seat_ID'])
                                        {
                                            $dispSeatInv = "SELECT * FROM tbl_seatsinventory";
                                            $SInv_results = mysqli_query($connection,$dispSeatInv);
                                            while($SInv_result = mysqli_fetch_array($SInv_results))
                                            {
                                                if($SInv_result['seat_ID'] == $S_result['seat_ID'])
                                                {
                                                    echo "<center>".$SInv_result['seatSold']."</center>";
                                                }
                                            }
                                        }
                                    }

                                ?>
                            </td>
                            <td>
                                <?php

                                    $dispSeat = "SELECT * FROM tbl_seat";
                                    $S_results = mysqli_query($connection,$dispSeat);
                                    while($S_result = mysqli_fetch_array($S_results))
                                    {
                                        if($S_result['seat_ID'] == $result['seat_ID'])
                                        {
                                            $dispSeatInv = "SELECT * FROM tbl_seatsinventory";
                                            $SInv_results = mysqli_query($connection,$dispSeatInv);
                                            while($SInv_result = mysqli_fetch_array($SInv_results))
                                            {
                                                if($SInv_result['seat_ID'] == $S_result['seat_ID'])
                                                {
                                                    echo "<center>".$SInv_result['quantity']."</center>";
                                                }
                                            }
                                        }
                                    }

                                ?>
                            </td>
                            <td>
                                <button class="btn-pay payJS" id="btn-pay"> <img src="../Assets/Pictures/sold.png">
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

    <!-- <div class="end">
            <?php include("Footer.php"); ?>
        </div> -->


</div>


<script src="../jquery/jquery-3.4.1.js"></script>
<script src="../bootstrap/bootstrap.min.js"></script>
<script src="../jquery/datatables.min.js"></script>
<script src="../jquery/dataTables.bootstrap4.min.js"></script>


<!-- ------------------------------------------------MODAL SECTION-------------------------------------------------------- -->

<!-- ADD Tickets -->

<?php

    $event = $seat = $size = $price = "";

    if(isset($_POST['sellTickets']))
    {
        $event = $_POST['eventTitle'];
        $seatings = $_POST['seatType'];

        $_SESSION['eventTitle'] =  $event;
        $_SESSION['seatType'] =  $seatings;


        global $connection;
        $findEvent = "SELECT * FROM tbl_events";
        $Eresult = mysqli_query($connection, $findEvent);
        while($Erow = mysqli_fetch_array($Eresult))
        {
            if($Erow['event_ID'] == $event)
            {
                $foundEvent = $Erow['event_ID'];
                
                $findSeat = "SELECT * FROM tbl_seat";
                $Sresults = mysqli_query($connection,$findSeat);
                while($Sresult = mysqli_fetch_array($Sresults))
                {
                    if($Sresult['seat_ID'] == $seatings)
                    {
                        $foundSeat = $Sresult['seat_ID'];
                        $foundPrice = $Sresult['seat_Price'];
                        
                        global $connection;
                        $checkSell = "SELECT * FROM tbl_sell ";
                        $result = mysqli_query($connection,$checkSell);
                        $count = mysqli_num_rows($result);

                        if($count > 0) //echo $foundEvent. $foundSeat. $foundPrice;
                        {
                            $isAvailable = "SELECT * FROM tbl_sell";
                            $Aresults = mysqli_query($connection,$isAvailable);
                            while($Aresult = mysqli_fetch_array($Aresults))
                            {
                                if($Aresult['event_ID'] != $event)
                                {
                                    $sellID = getSellId();
                                    $sqlSeats = "INSERT INTO tbl_sell 
                                                    VALUES ('$sellID', '$foundEvent', '$foundSeat', '$foundPrice')";
                            
                                    if(mysqli_query($connection, $sqlSeats))
                                    {
                                    ?>
                                        <div class="popup popup--icon -success js_success-popup popup--visible">
                                            <div class="popup__background"></div>
                                            <div class="popup__content">
                                                <h3 class="popup__content__title">
                                                    Success! 
                                                </h3>
                                                Ticket Successfully Added!
                                                <p>
                                                    <?php echo "<script>setTimeout(\"location.href = 'Dashboard.php';\",2000);</script>"; ?>
                                                </p>
                                            </div>
                                        </div> 
                                    <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <div class="popup popup--icon -error js_error-popup popup--visible">
                                            <div class="popup__background"></div>
                                            <div class="popup__content">
                                                <h3 class="popup__content__title">
                                                    Error
                                                </h3>
                                                <p> Strictly 1 Event and Seat Per Ticket </p>
                                                <p>
                                                    <a href="Dashboard.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                                                </p>
                                            </div>
                                        </div>  
                                    <?php 
                                }
                            }
                        }
                        else
                        {
                            $sellID = getSellId();
                            $sqlSeats = "INSERT INTO tbl_sell 
                                            VALUES ('$sellID', '$foundEvent', '$foundSeat', '$foundPrice')";
                            
                            if(mysqli_query($connection, $sqlSeats))
                            {
                            ?>
                                <div class="popup popup--icon -success js_success-popup popup--visible">
                                    <div class="popup__background"></div>
                                    <div class="popup__content">
                                        <h3 class="popup__content__title">
                                            Success! 
                                        </h3>
                                        Ticket Successfully Added!
                                        <p>
                                            <?php echo "<script>setTimeout(\"location.href = 'Dashboard.php';\",2000);</script>"; ?>
                                        </p>
                                    </div>
                                </div> 
                            <?php
                            }
                            else
                            {
                                ?>
                                    <div class="popup popup--icon -error js_error-popup popup--visible">
                                        <div class="popup__background"></div>
                                        <div class="popup__content">
                                            <h3 class="popup__content__title">
                                                Error
                                            </h3>
                                            <p> Strictly 1 Event and Seat Per Ticket</p>
                                            <p>
                                                <a href="Dashboard.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                                            </p>
                                        </div>
                                    </div>  
                                <?php
                            }
                        }
                    }
                }
            }
        }
    }
?>

<div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Tickets</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">

                <div class="alert alert-danger" role="alert">
                    NOTE: Strictly Limiting 1 Ticket Per Event!
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Event:</label>
                    </div>
                        <select class="custom-select" id="inputGroupSelect01" name="eventTitle">
                            <option selected>--Select Event--</option>

                            <?php
                                
                                $results1 = getEvents();
                                while($result1 = mysqli_fetch_array($results1))
                                {
                                    ?>
    
                                        <option value = " <?php echo $result1["event_ID"]; ?>">
                                                <?php echo $result1["eventName"]; ?>
                                        </option>
    
                                    <?php
                                }
                            ?>
                        </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Seat Selection:</label>
                    </div>
                        <select class="custom-select" id="inputGroupSelect01" name="seatType">
                            <option selected>--Select Seat--</option>

                            <?php

                                $results1 = getSeats();
                                while($result1 = mysqli_fetch_array($results1))
                                {
                                    ?>
    
                                        <option value = " <?php echo $result1["seat_ID"]; ?>">
                                            <?php echo $result1["seat_Type"]; ?>
                                        </option>
    
                                    <?php
                                }
                                
                            ?>
                        </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="sellTickets" class="btn btn-primary" id="seatAdded">Add Ticket</button>
            </div>

      </form>

    </div>
  </div>
</div>


<!-- PAYMENT -->

<?php

    $custFN = $custLN = $custNo = "";

    if(isset($_POST['payTickets']))
    {
        $SLid = $_POST['sellID'];
        $uSold = $_POST['sold'];
        $uQuantity = $_POST['quantity'];
        $custFN = testInput($_POST['First']);
        $custLN = testInput($_POST['Last']);
        $custNo = testInput($_POST['Contact']);

        $_SESSION['First'] =  $custFN;
        $_SESSION['Last'] =  $custLN;
        $_SESSION['Contact'] =  $custNo;

        global $connection;
        $checkCust = "SELECT * FROM tbl_customer WHERE customer_Lname = '$custLN' AND customer_Fname = '$custFN' ";
        $result = mysqli_query($connection,$checkCust);
        $count = mysqli_num_rows($result);

        if($count > 0)
        {
            $cust = getCustomerId();
            while($custs = mysqli_fetch_array($cust))
            {
                $existCust = $custs['customer_ID'];

                $getSID = "SELECT * FROM tbl_Sell";
                $SIDresults = mysqli_query($connection, $getSID);
                while($SIDresult = mysqli_fetch_array($SIDresults))
                {
                    if($SIDresult['sell_ID'] == $SLid)
                    {
                        $sID = $SIDresult['sell_ID'];
                        $date = getTheDate();
                        $getOrder = getOrderId();

                        $sqlOrders = "INSERT INTO tbl_ticketorders VALUES ('$getOrder', '$existCust', '$sID', '$date')";

                        if(mysqli_query($connection, $sqlOrders))
                        {
                        ?>
                            <div class="popup popup--icon -success js_success-popup popup--visible">
                                <div class="popup__background"></div>
                                <div class="popup__content">
                                    <h3 class="popup__content__title">
                                        Success! 
                                    </h3>
                                    Ticket Successfully Paid!
                                    <p>
                                        <?php echo "<script>setTimeout(\"location.href = 'Dashboard.php';\",2000);</script>"; ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                                <div class="popup popup--icon -error js_error-popup popup--visible">
                                    <div class="popup__background"></div>
                                    <div class="popup__content">
                                        <h3 class="popup__content__title">
                                            Error
                                        </h3>
                                        <p> Strictly Limiting 1 Ticket Per Person </p>
                                        <p>
                                            <a href="Dashboard.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                                        </p>
                                    </div>
                                </div> 
                            <?php
                        }
                    }
                }
            }
            
        }
        else
        {
            $getSID = "SELECT * FROM tbl_Sell";
            $SIDresults = mysqli_query($connection, $getSID);
            while($SIDresult = mysqli_fetch_array($SIDresults))
            {
                if($SIDresult['sell_ID'] == $SLid)
                {
                    $newId = getCustomerId();
                    global $connection;
                
                    $sqlSeats = "INSERT INTO tbl_customer 
                                    VALUES ('$newId', '$custLN', '$custFN', '$custNo')";
                    if(mysqli_query($connection, $sqlSeats))
                    {
                        $sID = $SIDresult['sell_ID'];
                        $date = getTheDate();
                        $getOrder = getOrderId();

                        $sqlOrders = "INSERT INTO tbl_ticketorders VALUES ('$getOrder', '$newId', '$sID', '$date')";
                        if(mysqli_query($connection, $sqlOrders))
                        {

                            $updateInv = "SELECT * FROM tbl_seatsinventory";
                            $INVresult = mysqli_query($connection, $updateInv);
                            while($INVrow = mysqli_fetch_array($INVresult))
                            {
                                if($INVrow['seat_ID'] == $SIDresult['seat_ID'])
                                {
                                    $Less = $INVrow['quantity'] - 1;
                                    $Add = $INVrow['seatSold'] + 1;
                                    
                                    $uSQL = "UPDATE tbl_seatsinventory 
                                    SET quantity = '$Less', 
                                        seatSold = '$Add'
                                    WHERE seat_ID = '$SLid' ";

                                    if(mysqli_query($connection, $uSQL))
                                    {
                                        ?>
                                            <div class="popup popup--icon -success js_success-popup popup--visible">
                                                <div class="popup__background"></div>
                                                <div class="popup__content">
                                                    <h3 class="popup__content__title">
                                                        Success! 
                                                    </h3>
                                                    Ticket Successfully Paid!
                                                    <p>
                                                        <?php echo "<script>setTimeout(\"location.href = 'Dashboard.php';\",2000);</script>"; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="popup popup--icon -error js_error-popup popup--visible">
                                                <div class="popup__background"></div>
                                                <div class="popup__content">
                                                    <h3 class="popup__content__title">
                                                        Error
                                                    </h3>
                                                    <p> Strictly Limiting 1 Ticket Per Person </p>
                                                    <p>
                                                        <a href="Dashboard.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                                                    </p>
                                                </div>
                                            </div> 
                                        <?php
                                    }
                                }    
                            } 
                        }
                    } 
                }
            }
        }   
    }
?>

<div class="modal fade" id="payModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Enter Client Details</h5>
        </div>

            <form action="" method="post">
                <div class="modal-body">

                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="sold" value="1">

                        <div class="form-group">
                            <label for="disabledTextInput">Sell ID:</label>
                            <input type="text" id="disabledTextInput" name="sellID" autocomplete="off" class="form-control sellID" readonly = "readonly">
                        </div>

                    <div class="form-group">
                            <label for="disabledTextInput">Last Name:</label>
                            <input type="text" id="disabledTextInput" name="Last" autocomplete="off" class="form-control Lname">
                    </div>

                    <div class="form-group">
                        <label for="disabledTextInput">First Name:</label>
                        <input type="text" id="disabledTextInput" name="First" autocomplete="off" class="form-control Fname">
                    </div>

                    <div class="form-group">
                        <label for="disabledTextInput">Contanct No.</label>
                        <input type="text" id="disabledTextInput" name="Contact" autocomplete="off" class="form-control Cont">
                    </div>
                
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="payTickets" class="btn btn-primary">Confirm</button>
                </div>

            </form>

        </div>
  </div>
</div>


<!-- DELETE TICKETS -->

<?php

    if(isset($_POST['']))
    {
        $id = $_POST['deleteId'];

        $sql = "DELETE FROM tbl_sell WHERE sell_ID='$id' ";
        
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
                        <?php echo "<script>setTimeout(\"location.href = 'Dashboard.php';\",2000);</script>"; ?>
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
        <h5 class="modal-title" id="staticBackdropLabel">Delete Ticket</h5>
      </div>

        <form action="" method="post">
            <div class="modal-body">
            
                <div class="form-group">
                    <input type="hidden" name="deleteId" id="deleteId">
                </div>

                <h4> Do you want to Delete this Ticket? </h4>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="delEventDetails" class="btn btn-primary">Delete</button>
            </div>

      </form>

    </div>
  </div>
</div>

<!-- LOGOUT -->

<!-- <div class="modal fade " id="logoutModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Logout</h5>
      </div>

        <form action="">
            <div class="modal-body">

                <h4> Are you sure? </h4>
            
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="document.location='Login.php'">Logout</button>
            </div>

      </form>

    </div>
  </div>
</div> -->


<!-- ------------------------------------------------SCRIPT SECTION-------------------------------------------------------- -->

<script>

    $(document).ready(function() 
    {
        $('#tableData').DataTable(
        {
            "pagingType": "full_numbers", "lengthMenu":
            [
                [2],
                [2]
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

    //--------------------PAY MODAL SCRIPT------------------------------------
    $(document).ready(function()
    {
        $('.payJS').on('click', function()
        {
            $('#payModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function()
            {
                return $(this).text();
            }).get();

            console.log(data);
            
            $(".sellID").val(data[0]);
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

    //--------------------LOGOUT MODAL SCRIPT------------------------------------

    // $(document).ready(function()
    //     {
    //         $('.logoutJS').on('click', function()
    //         {
    //             $('#logoutModal').modal('show');

    //         });
    //     });

</script>



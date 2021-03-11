<?php 

    $siteName = "FrontBlow Company";
    define("TITLE", "FrontBlow | Sold Tickets");

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
            <h3>Sold Tickets</h3>
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

        <div class="container">

                <div class="upper">

                    <div class="sec">

                        <h4>Sold Tickets</h3>

                    </div>

                    <div class="sec">

                        <small>(All Sold Tickets)</small>

                    </div>

                </div>

                <hr>

                <div class="lower">

                    <table class="table table-hover table-dark" id="tableData">

                        <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Event</th>
                                <th scope="col">Seat</th>
                                <th scope="col">Trans Date</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php

                                $resultCounter = 0;
                                $results = getOrders();
                                while ($result = mysqli_fetch_array($results)) 
                                {
                                    $resultCounter++;
                            ?>

                            <tr>
                                <td><?php echo $result['order_ID']?></td>

                                <td>

                                    <?php

                                        $dispCust = "SELECT * FROM tbl_customer";
                                        $C_results = mysqli_query($connection,$dispCust);
                                        while($C_result = mysqli_fetch_array($C_results))
                                        {
                                            if($C_result['customer_ID'] == $result['customer_ID'])
                                            {
                                                echo $C_result['customer_Lname']. ", ". $C_result['customer_Fname'].
                                                    "<br>". $C_result['phonenumber'];
                                            }
                                        }
                                    ?>

                                </td>

                                <td>
                                    <?php

                                        $dispSell = "SELECT * FROM tbl_sell";
                                        $S_results = mysqli_query($connection,$dispSell);
                                        while($S_result = mysqli_fetch_array($S_results))
                                        {
                                            if($S_result['sell_ID'] == $result['sell_ID'])
                                            {
                                                $dispEvent = "SELECT * FROM tbl_events";
                                                $E_results = mysqli_query($connection,$dispEvent);
                                                while($E_result = mysqli_fetch_array($E_results))
                                                {
                                                    if($E_result['event_ID'] == $S_result['event_ID'])
                                                    {
                                                        echo $E_result['eventName']. "<br> <small>". $E_result['eventVenue'].
                                                        " | ( ". date("F j, Y", strtotime($E_result['eventDate'])). " ) </small>";
                                                    }
                                                }
                                            }
                                        }

                                    ?>
                                </td>

                                <td>

                                    <?php 
                                    
                                        $dispSell = "SELECT * FROM tbl_sell";
                                        $S_results = mysqli_query($connection,$dispSell);
                                        while($S_result = mysqli_fetch_array($S_results))
                                        {
                                            if($S_result['sell_ID'] == $result['sell_ID'])
                                            {
                                                $dispSeat = "SELECT * FROM tbl_seat";
                                                $S_results = mysqli_query($connection,$dispSeat);
                                                while($ST_result = mysqli_fetch_array($S_results))
                                                {
                                                    if($ST_result['seat_ID'] == $S_result['seat_ID'])
                                                    {
                                                        echo $ST_result['seat_Pref']. "<br><small>". $ST_result['seat_Type']."</small>";
                                                    }
                                                }
                                            }
                                        }

                                    ?>
                                
                                </td>

                                <td>
                                    
                                    <?php

                                        echo date("F j, Y", strtotime($result['dateBought']));

                                    ?>

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
</script>
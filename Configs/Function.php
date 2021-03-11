<?php

    function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function getTheDate()
{
    date_default_timezone_set("Asia/Manila");

    $dateEncoded = date("Y-m-d");
    return $dateEncoded;
}

    function getAdminRecords()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_admin ORDER BY adminId ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getCustomerId()
    {
        global $connection;
        $newID=0;
        $sql = "SELECT customer_ID FROM tbl_customer ORDER BY customer_ID ASC";
        $results = mysqli_query($connection, $sql);

        while($result = mysqli_fetch_array($results))
        {
            $newID = $result['customer_ID'];
        }
        $newID++;
        return $newID;
    }

    function getCustomerRecords()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_customer ORDER BY customer_ID ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getEventId()
    {
        global $connection;
        $newID=0;
        $sql = "SELECT event_ID FROM tbl_events ORDER BY event_ID ASC";
        $results = mysqli_query($connection, $sql);

        while($result = mysqli_fetch_array($results))
        {
            $newID = $result['event_ID'];
        }
        $newID++;
        return $newID;
    }

    function getEvents()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_events ORDER BY event_ID ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getSeatId()
    {
        global $connection;
        $newID=0;
        $sql = "SELECT seat_ID FROM tbl_seat ORDER BY seat_ID ASC";
        $results = mysqli_query($connection, $sql);

        while($result = mysqli_fetch_array($results))
        {
            $newID = $result['seat_ID'];
        }
        $newID++;
        return $newID;
    }

    function getSeats()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_seat ORDER BY seat_ID ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getSeatInvId()
    {
        global $connection;
        $newID=0;
        $sql = "SELECT seat_ID FROM tbl_seatsinventory ORDER BY seat_ID ASC";
        $results = mysqli_query($connection, $sql);

        while($result = mysqli_fetch_array($results))
        {
            $newID = $result['seat_ID'];
        }
        $newID++;
        return $newID;
    }

    function getSeatInv()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_seatsinventory ORDER BY seat_ID ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getSellId()
    {
        global $connection;
        $newID=0;
        $sql = "SELECT sell_ID FROM tbl_sell ORDER BY sell_ID ASC";
        $results = mysqli_query($connection, $sql);

        while($result = mysqli_fetch_array($results))
        {
            $newID = $result['sell_ID'];
        }
        $newID++;
        return $newID;
    }

    function getSell()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_sell ORDER BY sell_ID ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getOrderId()
    {
        global $connection;
        $newID=0;
        $sql = "SELECT order_ID FROM tbl_ticketorders ORDER BY order_ID ASC";
        $results = mysqli_query($connection, $sql);

        while($result = mysqli_fetch_array($results))
        {
            $newID = $result['order_ID'];
        }
        $newID++;
        return $newID;
    }

    function getOrders()
    {
        global $connection;
        $sql = "SELECT * FROM tbl_ticketorders ORDER BY order_ID ASC";
        $results = mysqli_query($connection, $sql);
        return $results;
    }

    function getSeatForOrders()
    {
        global $connection;
        $sql = "SELECT tbl_seats.seat_ID FROM tbl_seats, tbl_events WHERE tbl_seats.seat_ID = tbl_events.event_ID";
        $results = mysqli_query($connection, $sql);

        while($row = mysqli_fetch_array($results))
        {
            $newID = $result['order_ID'];
            return  $row['seat_ID'];
            
        }
    }

    function getEventForOrders()
    {
        global $connection;
        $sql = "SELECT tbl_events.event_ID FROM tbl_seats, tbl_events WHERE tbl_events.event_ID = tbl_seats.seat_ID";
        $results = mysqli_query($connection, $sql);
        
        while($row = mysqli_fetch_array($results))
        {
            return $row['event_ID'];
            
        }
    }

    function getCustomerForOrders()
    {
        global $connection;
        $sql = "SELECT tbl_customer.customer_ID FROM tbl_seats, tbl_customer WHERE tbl_seats.seat_ID = tbl_customer.customer_ID";
        $results = mysqli_query($connection, $sql);
        
        while($row = mysqli_fetch_array($results))
        {
            return $row['customer_ID'];
            
        }
    }

    // function EventXSell()
    // {
    //     global $connection;
    //     $sql = "SELECT tbl_sell.sell_ID, tbl_events.eventName
    //             FROM tbl_sell, tbl_events WHERE tbl_sell.event_ID = tbl_events.event_ID";
    //     $results = mysqli_query($connection, $sql);
        
    //     while($row = mysqli_fetch_array($results))
    //     {
    //         return $row['sell_ID'], $row['eventName'];
            
    //     }
    // }

    // function SeatXSeatInv()
    // {
    //     global $connection;
    //     $sql = "SELECT tbl_seat.seat_Pref, tbl_seat.seat_Price, tbl_seatsinventory.quantity, tbl_seatsinventory.seatSold  
    //             FROM tbl_seat, tbl_seatsinventory WHERE tbl_seats.seat_ID = tbl_seatsinventory.seat_ID";
    //     $results = mysqli_query($connection, $sql);
        
    //     while($row = mysqli_fetch_array($results))
    //     {
    //         return $row['seat_Pref'], $row['seat_Price', $row['quantity', $row['seatSold'];
            
    //     }
    // }
    



?>





















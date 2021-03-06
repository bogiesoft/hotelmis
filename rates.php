<?php
session_start();
/*****************************************************************************
/*Copyright (C) 2006 Tony Iha Kazungu
/*****************************************************************************
Hotel Management Information System (HotelMIS Version 1.0), is an interactive system that enables small to medium
sized hotels take guests bookings and make hotel reservations.  It could either be uploaded to the internet or used
on the hotel desk computers.  It keep tracks of guest bills and posting of receipts.  Hotel reports can alos be
produce to make work of the accounts department easier.

This program is free software; you can redistribute it and/or modify it under the terms
of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License,
or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program;
if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA or 
check for license.txt at the root folder
/*****************************************************************************
For any details please feel free to contact me at taifa@users.sourceforge.net
Or for snail mail. P. O. Box 938, Kilifi-80108, East Africa-Kenya.
/*****************************************************************************/
error_reporting(E_ALL & ~E_NOTICE);
include_once ("queryfunctions.php");
include_once("login_check.inc.php");
include_once ("functions.php");
access("rates"); //check if user is allowed to access this page

if (isset($_POST['Submit'])){
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Add New Rates':
			$bookingtype=$_POST["bookingtype"];
			$occupancy=$_POST["occupancy"];
			$rate_type=$_POST["rate_type"];
			$bo=$_POST["bo"];
			$bb=$_POST["bb"];
			$hb=$_POST["hb"];
			$fb=$_POST["fb"];
			$currency=$_POST["currency"];
			$date_started=$_POST["date_started"];
			$date_stopped=$_POST["date_stopped"];
			
			$results = db_query( '
				INSERT INTO rates (bookingtype, occupancy, rate_type, bo, bb, hb, fb, currency, date_started, date_stopped)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array( $bookingtype, $occupancy, $rate_type, $bo, $bb, $hb, $fb, $currency, $date_started, $date_stopped ) );
			if ( ! $results || $results->rowCount() == 0 ) {
				//should log mysql errors to a file instead of displaying them to the user
				echo 'Invalid query: ' . db_errno(). "<br>" . ": " . db_error(). "<br>";
				echo "Record NOT ADDED.";  //return;
			}else{
				echo "<div align=\"center\"><h1>Record successfully added.</h1></div>";
			}
			break;
			//"Select bookingtype,occupancy,rate_type,bo,bb,hb,fb,currency,date_started,date_stopped From rates"
		case 'List':
			echo "List";
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			$results = db_query( '
				SELECT rooms.roomid, rooms.roomno, rooms.roomtypeid, roomtype.roomtype, rooms.roomname,
					rooms.noofrooms, rooms.occupancy, rooms.tv, rooms.aircondition, rooms.fun, rooms.safe, rooms.fridge, rooms.reserverd, rooms.photo
				FROM rooms
				INNER JOIN roomtype ON rooms.roomtypeid = roomtype.roomtypeid
				WHERE roomno = ?', array( $search ) );
			$rooms = $results->fetch();
			break;
		case 'Rates':
			echo "Rates";
			break;	
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include('csslinks.php'); ?>
<title>Hotel Management Information System</title>

<script type="text/javascript">
<!--
var request;
var dest;

function loadHTML(URL, destination, button){
    dest = destination;
	var str = '?submit=' + button;
	URL=URL + str
	if (window.XMLHttpRequest){
        request = new XMLHttpRequest();
        request.onreadystatechange = processStateChange;
        request.open("GET", URL, true);
        request.send(null);
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.XMLHTTP");
        if (request) {
            request.onreadystatechange = processStateChange;
            request.open("GET", URL, true);
            request.send();
        }
    }
}

function processStateChange(){
    if (request.readyState == 4){
        contentDiv = document.getElementById(dest);
        if (request.status == 200){
            response = request.responseText;
            contentDiv.innerHTML = response;
        } else {
            contentDiv.innerHTML = "Error: Status "+request.status;
        }
    }
}

function loadHTMLPost(URL, destination, button){
    dest = destination;
	var str = 'button=' + button;
	if (window.XMLHttpRequest){
        request = new XMLHttpRequest();
        request.onreadystatechange = processStateChange;
        request.open("POST", URL, true);
        request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		request.send(str);
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.XMLHTTP");
        if (request) {
            request.onreadystatechange = processStateChange;
            request.open("POST", URL, true);
            request.send();
        }
    }
}
-->	 
</script>
<script language="javascript" src="js/cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" src="js/cal_conf2.js"></script>
<script language="JavaScript" src="js/highlight.js" type="text/javascript"></script>
</head>

<body>
<form action="rates.php" method="post" name="rates" id="rates" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="1" align="center" bgcolor="#66CCCC">
  <tr valign="top">
    <td width="17%" bgcolor="#FFFFFF">
	<table width="100%"  border="0" cellpadding="1">	  
	  <tr>
    <td width="15%" bgcolor="#66CCCC">
		<table cellspacing=0 cellpadding=0 width="100%" align="left" bgcolor="#FFFFFF">
      <tr><td width="110" align="center"><a href="index.php"><img src="images/titanic1.gif" width="70" height="74" border="0"/><br>
          Home</a></td>
      </tr>
      <tr><td>&nbsp; </td>
      </tr>
      <tr>
        <td align="center">
		<?php signon(); ?>		
		</td></tr>
	  </table></td></tr>
	<?php require_once("menu_header.php"); ?>	
    </table>
	</td>
    
    <td bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="1">
      <tr>
        <td width="14%" align="center"></td>
      </tr>
      <tr>
        <td colspan="4">
		<h2>RATES</h2>
		</td>
      </tr>
      <tr>
        <td>From:</td>
        <td width="39%"><input type="text" name="date_started" id="date_started" readonly=""/>
          <a href="javascript:showCal('Calendar5')"> <img src="images/ew_calendar.gif" width="16" height="15" border="0"/></a></td>
        <td width="6%">To:</td>
        <td width="41%"><input type="text" name="date_stopped" id="date_stopped" readonly=""/>
          <a href="javascript:showCal('Calendar6')"> <img src="images/ew_calendar.gif" width="16" height="15" border="0"/></a></td>
      </tr>
	  <tr>
        <td valign="top" colspan="4"><div id="Requests"><div id="Requests">
          <table width="100%"  border="0" cellpadding="1">
<tr>
      <td>Booking Type</td>
      <td colspan="2">
        <label>
<input type="radio" name="bookingtype" value="D" onclick="loadHTMLPost('ajaxfunctions.php','agentoption','Direct')"/>  
Direct booking </label>
        <label>
        <input type="radio" name="bookingtype" value="A" onclick="loadHTMLPost('ajaxfunctions.php','agentoption','Agent')"/>
  Agent booking</label>
      </td>
	  <td colspan="2"><div id="agentoption"></div></td>
    </tr>
<tr>
      <td>Rate type </td>
      <td colspan="4">
        <label>
        <input type="radio" name="rate_type" value="R" />
  Resident</label>
        <label>
        <input type="radio" name="rate_type" value="N" />
  Non-Resident</label>
      </td>
    </tr>   
<tr>
      <td>Room Occupancy</td>
      <td colspan="4">
        <label>
        <input type="radio" name="occupancy" value="S" />
  Single</label>
        <label>
        <input type="radio" name="occupancy" value="D" />
  Double</label>
      </td>
    </tr>   		        
			
            <tr>
              <td width="25%">Currency</td>
              <td width="24%">Bed Only </td>
              <td width="24%">Bed &amp; Breakfast </td>
              <td width="27%">Halfboard</td>
              <td width="27%">Fullboard</td>
            </tr>
            <tr>
              <td><input type="text" name="currency" size="15"/></td>
              <td><input type="text" name="bo" size="15"/></td>
              <td><input type="text" name="bb" size="15"/></td>
              <td><input type="text" name="hb" size="15"/></td>
              <td><input type="text" name="fb" size="15"/></td>
            </tr>
          </table>
                </div><br />
		  <br />
		  </div></td>
		
      </tr>
	  <tr>
        <td align="left" colspan="4"><div id="RequestDetails"></div>
		</td>
      </tr>
    </table></td>
	<td width="16%" bgcolor="#FFFFFF">
	<table width="100%"  border="0" cellpadding="1">	  
	  <tr>
    <td width="15%" bgcolor="#66CCCC">
	<table width="100%"  border="0" cellpadding="1" bgcolor="#FFFFFF">
       <tr>
        <td>Image</td>
      </tr>
	  <tr>
        <td><input type="submit" name="Submit" value="Add New Rates" /></td>
      </tr>
      <tr>
        <td><input type="button" name="Submit" value="View Rates" onclick="loadHTML('ajaxfunctions.php','RequestDetails','Rates')"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
            <label> Search By:<br />
            <input type="radio" name="optFind" value="Name" />
        Agent Name</label>
            <br />
            <label>
            <input type="radio" name="optFind" value="Payrollno" />
        Rate ID. </label>
            <br>
        <input type="text" name="search" width="100" /><br>
        <input type="submit" name="Submit" value="Find"/>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</td></tr></table>
	</td>
  </tr>
   <?php require_once("footer1.php"); ?>
</table>
</form>
</body>
</html>
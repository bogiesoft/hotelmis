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

$GLOBALS[ __FILE__ ] = new PDO( 'mysql:host=localhost;dbname=hotelmis', 'hotelmis', '55doolie', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
) );

function db_query( $query, $params = array() ) {
	$stmt = $GLOBALS[ __FILE__ ]->prepare( $query );
	if ( $stmt ) {
		$stmt->execute( $params );
		return $stmt;
	}
	return false;
}

function db_errno() {
	$errors = $GLOBALS[ __FILE__ ]->errorInfo();
	return $errors[ 1 ];
}

function db_error() {
	$errors = $GLOBALS[ __FILE__ ]->errorInfo();
	return $errors[ 2 ];
}

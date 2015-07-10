<?php
//remove already booked hotels
	// -----(========)----- or [==================] or [========)---------- or ----------(========]
	$rmvdHotels = $bookedDate->where('checked_in', '<=', $searchBag['check_in'])
		->where('checked_out', '>=', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
	// (==--====)----------
	$rmvdHotels = $bookedDate->where('checked_in', '>', $searchBag['check_in'])
		->where('checked_in', '<', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
	// ----------(==--====)
	$rmvdHotels = $bookedDate->where('checked_out', '>', $searchBag['check_in'])
		->where('checked_out', '<', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
	// (===----------=====) or (===----------=====] or [===----------=====)
	$rmvdHotels = $bookedDate->where('checked_in', '>=', $searchBag['check_in'])
		->where('checked_out', '<=', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
?>
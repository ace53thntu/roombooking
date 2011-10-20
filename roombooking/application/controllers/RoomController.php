<?php
class RoomController extends Zend_Controller_Action {
	
	private $hotel;
	private $room;
	private $roomDiscount;
	private $commission;
	private $calendarPriceDiscount;
	private $rate;
	private $customer;
	private $booking;
	
	public function init() {
		$this->hotel = new Hotel();
		$this->room = new Room();
		$this->roomDiscount = new RoomDiscount();
		$this->commission = new Commission();
		$this->calendarPriceDiscount = new CalendarPriceDiscount();
		$this->rate = new Rate();
		$this->customer = new Customer();
		$this->booking = new Booking();
	}
	
	/**
	 * Add room action.
	 */
	public function addAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$hotel = $userProfile->loggedInHotel;
            if (!empty($hotel)) {
            	
            	$pageModel = new ViewPageModel();
            	$pageModel->hotel = $hotel;
            	$pageModel->loggedInUser = $user;
            	
	            $form = new AddHotelRoomForm($hotel);
	            $this->view->form = $form;
	            $this->view->pageModel = $pageModel;
	            
	            if ($this->getRequest ()->isPost ()) {
	                if ($form->isValid ( $_POST )) {
	                	$data = array(
	                	  Room::NAME => trim($form->getValue(Room::NAME)),
	                	  Room::KEY => strtoupper(trim($form->getValue("key"))),
	                	  Room::HOTEL => $form->getValue("hotel_id"),
	                	  Room::TOTAL => $form->getValue("total"),
	                	  Room::MAX_ADULTS => $form->getValue(Room::MAX_ADULTS),
	                	  Room::MAX_CHILDREN => $form->getValue(Room::MAX_CHILDREN),
	                	  Room::AVAILABLE => $form->getValue("available"),
	                	  Room::DESCRIPTION => trim($form->getValue("description"))
	                	);
	                	$db = Zend_Registry::get("db");
	                	$db->beginTransaction();
	                	$this->room->addRoom($data);
	                	$db->commit();
	                	$this->_redirect("/");
	                }
	            }
			} else {
				throw new Zend_Exception("No hotel specified!");
				
			}
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Edit room action.
	 */
	public function editAction() {
	    if ($this->_helper->user->isLoggedIn()) {
            $userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$hotel = $userProfile->loggedInHotel;
            if (!empty($hotel)) {
                
                $roomId = $this->_getParam("rid");
                $room = $this->room->findById($roomId);
                $pageModel = new ViewPageModel();
                $pageModel->hotel = $hotel;
                $pageModel->loggedInUser = $user;
                $pageModel->selectedRoom = $room;
                
                $form = new EditHotelRoomFormSimple($hotel, $room);
                $this->view->form = $form;
                $this->view->pageModel = $pageModel;
                
                if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                        $roomId = $form->getValue("room_id");
                        
                        $db = Zend_Registry::get("db");
                        $db->beginTransaction();
                        $data = array(
                        	Room::ID => $roomId,
                        	Room::AVAILABLE => trim($form->getValue("available"))
                        );
                        $room = $this->room->updateRoom($data);
                        $currentTime = $this->_helper->generator->generateCurrentTime();
                        // add discount if any.
                        $discount = $form->getValue("discount");
                        if ($discount != 0) {
                        	$data = array(
                        		RoomDiscount::ROOM => $form->getValue(RoomDiscount::ROOM),
                        		RoomDiscount::RULE => $form->getValue(RoomDiscount::RULE),
                        		RoomDiscount::DISCOUNT => $form->getValue(RoomDiscount::DISCOUNT),
                        		RoomDiscount::CREATED => $this->_helper->generator->generateCurrentTime(),
                        		RoomDiscount::CREATED => $this->_helper->generator->generateCurrentTime()
                        	);
                        	$this->roomDiscount->addNew($data);
                        } else {
                        	$this->roomDiscount->deleteByRoomAndRule($form->getValue(RoomDiscount::ROOM), $form->getValue(RoomDiscount::RULE));
                        }
                    	// add commission if any.
                        $commission = $form->getValue("commission");
                        if ($commission != 0) {
                        	$this->commission->addOrUpdateCommission($room->id, $commission, $currentTime, $currentTime);
                        } else {
                        	$this->commission->deleteByRoom($form->getValue(RoomDiscount::ROOM));
                        }
                        $db->commit();
                        $this->_redirect("/index/formsucceed");
                    }
                }
            } else {
                throw new Zend_Exception("No hotel specified!");
                
            }
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Room category price action.
	 */
	public function roompriceAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$roomId = $this->_getParam("rid");
			$room = $this->room->findById($roomId);
			if (isset($room)) {
				$pageModel = new RoomViewPageModel();
				$pageModel->loggedInUser = $this->_helper->user->getUserData();
				$pageModel->room = $room;
				$this->view->pageModel = $pageModel;
			} else {
				throw new Zend_Exception("Room not found! ID:" + $roomId);
			}
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * View room price action
	 */
	public function viewroompriceAction() {
		
	}
	
	/**
	 * Add calendar price.
	 */
	public function addcalendarpriceAction() {
	   if ($this->_helper->user->isLoggedIn()) {
            $roomId = $this->_getParam("rid");
            $room = $this->room->findById($roomId);
            if (isset($room)) {
            	$form = new AddCalendarPriceForm($room);
            	$this->view->form = $form;
            	
            	if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                        $roomId = $form->getValue("room_id");
                        
                        $db = Zend_Registry::get("db");
                        $db->beginTransaction();
                        $data = array(
                            CalendarPriceDiscount::CALENDAR => $form->getValue(CalendarPriceDiscount::CALENDAR),
                            CalendarPriceDiscount::ROOM => $form->getValue(CalendarPriceDiscount::ROOM),
                            CalendarPriceDiscount::PRICE => $form->getValue(CalendarPriceDiscount::PRICE),
                            CalendarPriceDiscount::CREATED => $this->_helper->generator->generateCurrentTime(),
                            CalendarPriceDiscount::MODIFIED => $this->_helper->generator->generateCurrentTime(),
                        );
                        $this->calendarPriceDiscount->addCalendarPrice($data);
                        $db->commit();
                        $this->_redirect("/room/roomprice/rid/".$form->getValue(CalendarPriceDiscount::ROOM));
                    }
            	}
            } else {
                throw new Zend_Exception("Room not found! ID:" + $roomId);
            }
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Add room rate action.
	 */
	public function addroomrateAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$user = $this->_helper->user->getUserData();
			$roomId = $this->_getParam("rid");
            $room = $this->room->findById($roomId);
            if (isset($room)) {
            	$form = new AddOrUpdateRoomRateForm($room);
            	$pageModel = new RoomViewPageModel();
            	$pageModel->loggedInUser = $user;
            	$pageModel->room = $room;
            	$this->view->pageModel = $pageModel;
            	$this->view->form = $form;
            	if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                    	$roomId = $form->getValue(Rate::ROOM);
                    	
                    	$db = Zend_Registry::get("db");
                    	$db->beginTransaction();
                    	$calendarPriceDiscountId = null;
//                    	$calendarId = $form->getValue(CalendarPriceDiscount::CALENDAR);
//                    	if (!empty($calendarId)) {
//	                    	$data = array(
//	                    		CalendarPriceDiscount::ROOM => $roomId,
//	                    		CalendarPriceDiscount::CALENDAR => $calendarId,
//	                    		CalendarPriceDiscount::DISCOUNT => $form->getvalue("calendar_price_discount"),
//	                    		CalendarPriceDiscount::CREATED => $this->_helper->generator->generateCurrentTime(),
//                    	   		CalendarPriceDiscount::MODIFIED => $this->_helper->generator->generateCurrentTime()
//	                    	);
//	                    	$calendarPriceDiscountId = $this->calendarPriceDiscount->addCalendarPrice($data);
//                    	}
//                    	
                    	$data = array(
                    	   Rate::ROOM => $roomId,
                    	   Rate::PERSON_NUMBER => $form->getValue(Rate::PERSON_NUMBER),
                    	   Rate::RATE => $form->getValue(Rate::RATE),
                    	   Rate::PRICE => $form->getValue(Rate::PRICE),
//                    	   Rate::DISCOUNT => $form->getValue(Rate::DISCOUNT),
//                    	   Rate::CALENDAR_PRICE_DISCOUNT => $calendarPriceDiscountId,
                    	   Rate::COMMENT => $form->getValue(Rate::COMMENT),
                    	   Rate::CREATED => $this->_helper->generator->generateCurrentTime(),
                    	   Rate::MODIFIED => $this->_helper->generator->generateCurrentTime()
                    	);
                    	$this->rate->addRate($data);
                    	$db->commit();
                    	$this->_redirect("/room/roomprice/rid/".$roomId);
                    }
            	}
            } else {
            	throw new Zend_Exception("Room not found! ID:" + $roomId);
            }
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	
	/**
	 * Edit room rate function
	 */
	public function editroomrateAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$user = $this->_helper->user->getUserData();
			$roomId = $this->_getParam("rid");
			$rateId = $this->_getParam("rateId");
            $room = $this->room->findById($roomId);
            $rate = $this->rate->findById($rateId);
            if (isset($room)) {
            	$form = new AddOrUpdateRoomRateForm($room, $rate);
            	$this->view->form = $form;
            	if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                    	$ratId = $form->getValue(Rate::ID);
                    	$roomId = $form->getValue(Rate::ROOM);
                    	$data = array(
                    		Rate::ID => $rateId,
                    		Rate::ROOM => $roomId,
                    		Rate::PERSON_NUMBER => $form->getValue(Rate::PERSON_NUMBER),
                    		Rate::PRICE => $form->getValue(Rate::PRICE),
//                    		Rate::DISCOUNT => $form->getValue(Rate::DISCOUNT),
//                    		Rate::Calenda => $form->getValue(Rate::CALENDAR),
//                    		Rate::CALENDAR_PRICE_DISCOUNT => $form->getValue(Rate::CALENDAR_PRICE_DISCOUNT),
                    		Rate::COMMENT => $form->getValue(Rate::COMMENT),
                    		Rate::MODIFIED => $this->_helper->generator->generateCurrentTime()
                    	);
                    	$this->rate->updateRate($data);
                    	$this->_redirect("/room/roomprice/rid/".$roomId);
                    }
            	}
            } else {
            	throw new Zend_Exception("Room not found! ID:" + $roomId);
            }
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Delete rate by id.
	 */
	public function deleteroomrateAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$roomId = $this->_getParam("roomId");
			$rateId = $this->_getParam("rateId");
			$this->rate->deleteById($rateId);
			$this->_redirect("/room/roomprice/rid/".$roomId);
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Send booking request.
	 */
	public function searchAction() {
		$config = Zend_Registry::get("config");
		$this->view->headScript ()->appendFile ( $config->baseurl . '/js/search.js' ); 
	    if ($this->_helper->user->isLoggedIn()) {
            $userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$hotel = $userProfile->loggedInHotel;
            if (!empty($hotel)) {
                
                $pageModel = new ViewPageModel();
                $pageModel->hotel = $hotel;
                $pageModel->loggedInUser = $user;
                $roomId = $this->_getParam("rid");
                $room = $this->room->findById($roomId);
                $form = new SearchForm($hotel, $room);
                $this->view->form = $form;
                $this->view->pageModel = $pageModel;
                
                if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                        $cityPart = $form->getValue(Hotel::CITY_PART);
//                        $hotelId = $form->getValue("hotel_id");
//                        $roomId = $form->getValue("room_id");
						$maxAdults = $form->getValue(Room::MAX_ADULTS);
						$maxChildren = $form->getValue(Room::MAX_CHILDREN);
						$maxPrice = $form->getValue(Rate::PRICE);
                        
						$criteria = array(
							Hotel::CITY_PART => $cityPart,
							Rate::PRICE => empty($maxPrice) ? null : $maxPrice,
							Room::MAX_ADULTS => empty($maxAdults) ? null : $maxAdults,
							Room::MAX_CHILDREN => empty($maxChildren) ? null : $maxChildren,
							"excludedHotels" => array($hotel->id)
						);
                        $results = Room::getRoomsBySearchCriteria($criteria);
                        
                        $searchResults = array();
                        $index = 1;
                        foreach ($results as $result) {
                        	$searchResult = new SearchResultDTO();
                        	$room = $this->room->findById($result->roomId);
                        	$searchResult->id = $index;
                        	$searchResult->room = $room;
                        	$searchResult->rate = $this->rate->findById($result->rateId);
                        	$searchResult->roomDiscounts = Room::getRoomDiscounts($room);
                        	$searchResults[$index++] = $searchResult;
                        }
                        $this->view->searchResults = $searchResults;
                    }
                }
            } else {
                throw new Zend_Exception("No hotel specified!");
                
            }
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Send booing request action.
	 */
	public function sendrequestAction() {
		if ($this->_helper->user->isLoggedIn()) {
            $userProfile = $this->_helper->user->getUserProfile();
            $user = $userProfile->loggedInUser;
            $hotel = $userProfile->loggedInHotel;
            $indexes = $this->_getParam("chk");
            if (isset($indexes)) {
            	foreach($indexes as $key => $index) {
            		$roomIds[$key] = $this->_getParam("roomId".$index);
            		$prices[$key] = $this->_getParam("price".$index);
            		$discounts[$key] = $this->_getParam("discount".$index);
            	}
            	$form = new SendRequestForm($user, $hotel, $roomIds, $prices, $discounts);
            	
            	$this->view->form = $form;            	
            } else {
            	throw new Zend_Exception("No room has been chosen!");
            }
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	
	/**
	 * Submit booking request.
	 */
	public function submitbookingrequestAction() {
		if ($this->_helper->user->isLoggedIn()) {
            $user = $this->_helper->user->getUserData();
            $roomIds = $this->_getParam("roomIds");
            foreach ($roomIds as $key => $roomId) {
            	$index = substr($key, 6, strlen($key));
            	$prices = $this->_getParam("prices");
            	$discounts = $this->_getParam("discounts");
            	$db = Zend_Registry::get("db");
                $db->beginTransaction();
                $data = array(
                	Customer::SOCIAL_SECURITY_NUMBER => $this->_getParam(Customer::SOCIAL_SECURITY_NUMBER),
                	Customer::FIRST_NAME => $this->_getParam(Customer::FIRST_NAME),
                	Customer::LAST_NAME => $this->_getParam(Customer::LAST_NAME),
                	Customer::PHONE => $this->_getParam(Customer::PHONE)
                );
				$customerId = $this->customer->addCustomer($data);
						
//                $roomIdsArr = $this->_getParam("roomIds");
//                foreach ($roomIdsArr as $key => $roomId) {
                	$room = $this->room->findById($roomId);
                	$fromHotel = Room::getHotel($room);
                	$data = array(
                		Booking::ROOM_ID => $roomId,
                		Booking::CUSTOMER => $customerId,
                		Booking::FROM_USER => $this->_getParam(Booking::FROM_USER),
                		Booking::FROM_HOTEL => $this->_getParam(Booking::FROM_HOTEL),
                		Booking::TO_HOTEL => $fromHotel->id,
                		Booking::FROM_DATE => $this->_getParam(Booking::FROM_DATE),
                		Booking::TO_DATE => $this->_getParam(Booking::TO_DATE),
                		Booking::NUMBER_OF_PERSON => $this->_getParam(Booking::NUMBER_OF_PERSON),
                		Booking::NUMBER_OF_ROOM => $this->_getParam(Booking::NUMBER_OF_ROOM),
                		Booking::STATUS => BookingStatus::PENDING,
                		Booking::ARRIVAL_TIME => $this->_getParam(Booking::ARRIVAL_TIME),
                		Booking::PRICE => $prices["price".$index],
                		Booking::DISCOUNT => $discounts["discount".$index],
                		Booking::COMMISSION => Room::getCommission($room),
                    	Booking::CREATED => $this->_helper->generator->generateCurrentTime(), 
                    );
//                }
				$this->booking->addEntry($data);
                $db->commit();
            }
            $this->_redirect("/index/formsucceed");
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Edit room discount action.
	 */
	public function editroomdiscountAction() {
		if ($this->_helper->user->isLoggedIn()) {
            $user = $this->_helper->user->getUserData();
            $roomDiscountId = $this->_getParam("rdid");
            $roomDiscount = $this->roomDiscount->find($roomDiscountId)->current();
            $form = new EditRoomDiscount($roomDiscount);
            $this->view->form = $form;
            if ($this->getRequest ()->isPost ()) {
            	if ($form->isValid ( $_POST )) {
            		$data = array(
            			RoomDiscount::ID => $form->getValue(RoomDiscount::ID),
            			RoomDiscount::DISCOUNT => $form->getValue(RoomDiscount::DISCOUNT)
            		);
               		$this->roomDiscount->updateRoomDiscount($data);
               		$this->_redirect("/room/roomprice/rid/".$form->getValue(RoomDiscount::ROOM));
            	}
            }
		} else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Delete room discount action.
	 */
	public function deleteroomdiscountAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$roomDiscountId = $this->_getParam("rdid");
			$this->roomDiscount->deleteById($roomDiscountId);            
		} else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Add new room discount action.
	 */
	public function addroomdiscountAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$roomId = $this->_getParam("rid");
			$room = $this->room->findById($roomId);
			$form = new AddRoomDiscount($room);
			$this->view->form = $form;
			if ($this->getRequest ()->isPost ()) {
            	if ($form->isValid ( $_POST )) {
            		$data = array(
            			RoomDiscount::ROOM => $form->getValue(RoomDiscount::ROOM),
            			RoomDiscount::RULE => $form->getValue(RoomDiscount::RULE),
            			RoomDiscount::DISCOUNT => $form->getValue(RoomDiscount::DISCOUNT),
            			RoomDiscount::CREATED => $this->_helper->generator->generateCurrentTime(),
            			RoomDiscount::MODIFIED => $this->_helper->generator->generateCurrentTime()
            		);
            		$this->roomDiscount->addNew($data);
            		$this->_redirect("/room/roomprice/rid/".$form->getValue(RoomDiscount::ROOM));
            	}
			}
		} else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	public function testAction() {
		$rid = $this->_getParam("rid");
		$room = $this->room->findById($rid);
		$rate = Room::getRoomRate($room);
		echo $rate->id;
		print_r($rate);exit;
	}
}
?>
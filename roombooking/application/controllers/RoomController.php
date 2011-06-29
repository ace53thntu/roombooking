<?php
class RoomController extends Zend_Controller_Action {
	
	private $hotel;
	private $room;
	private $discount;
	private $calendarPrice;
	private $rate;
	
	public function init() {
		$this->hotel = new Hotel();
		$this->room = new Room();
		$this->discount = new Discount();
		$this->calendarPrice = new CalendarPrice();
		$this->rate = new Rate();
	}
	
	/**
	 * Add room action.
	 */
	public function addAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$user = $this->_helper->user->getUserData();
			$hotel = User::getHotel($user);
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
	                	  Room::TOTAL => $form->getValue("available"),
	                	  Room::MAX_ADULTS => $form->getValue(Room::MAX_ADULTS),
	                	  Room::MAX_CHILDREN => $form->getValue(Room::MAX_CHILDREN),
	                	  Room::AVAILABLE => $form->getValue("available"),
	                	  Room::DESCRIPTION => trim($form->getValue("description"))
	                	);
	                	$db = Zend_Registry::get("db");
	                	$db->beginTransaction();
	                	$this->room->addRoom($data);
	                	$db->commit();
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
            $user = $this->_helper->user->getUserData();
            $hotel = User::getHotel($user);
            if (!empty($hotel)) {
                
                $pageModel = new ViewPageModel();
                $pageModel->hotel = $hotel;
                $pageModel->loggedInUser = $user;
                $roomId = $this->_getParam("rid");
                $room = $this->room->findById($roomId);
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
                        // add discount if any.
                        $discount = $form->getValue("discount");
                        if (!empty($discount)) {
                        	$this->discount->addOrUpdateDiscount($room->id, $discount);
                        }
                        $db->commit();
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
                            CalendarPrice::CALENDAR => $form->getValue(CalendarPrice::CALENDAR),
                            CalendarPrice::ROOM => $form->getValue(CalendarPrice::ROOM),
                            CalendarPrice::PRICE => $form->getValue(CalendarPrice::PRICE),
                            CalendarPrice::CREATED => $this->_helper->generator->generateCurrentTime(),
                            CalendarPrice::MODIFIED => $this->_helper->generator->generateCurrentTime(),
                        );
                        $this->calendarPrice->addCalendarPrice($data);
                        $db->commit();
                        $this->_redirect("/room/roomprice/rid/".$form->getValue(CalendarPrice::ROOM));
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
            	$form = new AddRoomRateForm($room);
            	$this->view->room = $room;
            	$this->view->form = $form;
            	if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                    	$roomId = $form->getValue(Rate::ROOM);
                    	
                    	$db = Zend_Registry::get("db");
                    	$db->beginTransaction();
                    	$data = array(
                    	   Rate::ROOM => $roomId,
                    	   Rate::PERSON_NUMBER => $form->getValue(Rate::PERSON_NUMBER),
                    	   Rate::RATE => $form->getValue(Rate::RATE),
                    	   Rate::PRICE => $form->getValue(Rate::PRICE),
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
            	$form = new EditRoomRateForm($room, $rate);
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
            $user = $this->_helper->user->getUserData();
            $hotel = User::getHotel($user);
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
                        $hotelId = $form->getValue("hotel_id");
                        $roomId = $form->getValue("room_id");
                        
                        $rooms = Room::getRoomsBySearchCriteria($cityPart, $hotelId, $roomId);
                        $roomsDTO = array();
                        foreach ($rooms as $room) {
                        	$roomDTO = new RoomDTO();
                        	$roomDTO->id = $room->rid;
                        	$roomDTO->name = $room->name;
                        	$roomDTO->key = $room->key;
                        	$roomDTO->description = $room->description;
                        	$roomsDTO[$room->rid] = $roomDTO;
                        }
                        $this->view->rooms = $roomsDTO;
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
            $user = $this->_helper->user->getUserData();
            
            $roomIds = $this->_getParam("chk");
            
            exit;
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
}
?>
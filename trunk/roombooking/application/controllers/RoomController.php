<?php
class RoomController extends Zend_Controller_Action {
	
	private $hotel;
	private $room;
	private $discount;
	public function init() {
		$this->hotel = new Hotel();
		$this->room = new Room();
		$this->discount = new Discount();
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
                        
                        $db->commit();
                    }
            	}
//                $pageModel = new RoomViewPageModel();
//                $pageModel->loggedInUser = $this->_helper->user->getUserData();
//                $pageModel->room = $room;
//                $this->view->pageModel = $pageModel;
            } else {
                throw new Zend_Exception("Room not found! ID:" + $roomId);
            }
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
	
	/**
	 * Send booking request.
	 */
	public function sendrequestAction() {
	   if ($this->_helper->user->isLoggedIn()) {
            $user = $this->_helper->user->getUserData();
            $hotel = User::getHotel($user);
            if (!empty($hotel)) {
                
                $pageModel = new ViewPageModel();
                $pageModel->hotel = $hotel;
                $pageModel->loggedInUser = $user;
                $roomId = $this->_getParam("rid");
                $room = $this->room->findById($roomId);
                $form = new SendRequestForm($hotel, $room);
                $this->view->form = $form;
                $this->view->pageModel = $pageModel;
                
                if ($this->getRequest ()->isPost ()) {
                    if ($form->isValid ( $_POST )) {
                        
                    }
                }
            } else {
                throw new Zend_Exception("No hotel specified!");
                
            }
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
}
?>
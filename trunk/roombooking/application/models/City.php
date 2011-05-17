<?php
class City extends Zend_Db_Table_Abstract {
    
    protected $_primary = "id";
    protected $_name = "city";
    
    protected $_referenceMap = array(
        'Country' => array(
            'columns' => 'country_id',
            'refTableClass' => 'Country',
            'refColumns' => 'id'    
        )
    );
    
    /**
     * Find city by name.
     * 
     * @param $name cityName
     * @return return city object
     */
    public function findByName($name) {
    	$select = $this->select()->where("upper(name)=upper(?)", $name);
    	return $this->fetchRow($select);
    }
    
    /**
     * Get sub cities of given city.
     * 
     * @param $cityId
     * @return return array which can be added to form select
     */
    public static function getSubCityAsArray($cityId) {
    	$table = new City();
    	$city = $table->find($cityId)->current();
    	$rows = $city->findDependentRowset("City", "ParentCity");
    	$ret = array();
    	foreach ($rows as $row) {
    		$ret[$row->id] = $row->name;
    	}
    	return $ret;
    }
    
    /**
     * Get sub city id array.
     * 
     * @param $cityId
    */ 
    public static function getSubCityIdArray($cityId) {
    	$table = new City();
    	$city = $table->find($cityId)->current();
    	$rows = $city->findDependentRowset("City", "ParentCity");
    	$ret = array();
    	$index = 0;
    	foreach ($rows as $row) {
    		$ret[$index++] = $row->id;
    	}
    	return $ret;
    }
    
    /**
     * Get top city by given city id.
     * 
     * @param $cityId
     * @return return top level city
     */
    public static function getTopCity($cityId) {
    	$table = new City();
        $city = $table->find($cityId)->current();
        if (empty($city->parent_id)) {
        	return $city;
        } else {
            return $city->findParentRow("City", "ParentCity");
        }
    }
	
	/**
	 * Get country of given city.
	 * 
	 * @param $cityId
	 */
	public static function getCountry($cityId) {
		$table = new City ( );
		$city = $table->find ( $cityId )->current ();
		return $city->findParentRow ( "Country", "Country" );
	}
    
}
?>
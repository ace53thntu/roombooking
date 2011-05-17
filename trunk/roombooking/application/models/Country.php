<?php
class Country extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "country";
	
	protected $_dependentTables = array ('City' );
	
	/**
	 * Get all country order by alphabetically.
	 * 
	 * @return return array which can be added to form select
	 */
	public static function getAllCountryAsArray() {
		$table = new Country ( );
		$select = $table->select ()->where("enabled=?", true)->order ( "name ASC" );
		$rows = $table->fetchAll ( $select );
		$ret = array ();
		foreach ( $rows as $row ) {
			$ret [$row->id] = $row->name;
		}
		return $ret;
	}
	
	/**
	 * Get top city by given country id.
	 * 
	 * @param $countryId
	 * @return  return array which can be added to form select
	 */
	public static function getTopCityByCountryAsArray($countryId) {
		$table = new Country ( );
		$city = new City ( );
		$country = $table->find ( $countryId )->current ();
		$rows = $country->findDependentRowset ( "City", "Country", $city->select ()->order ( "name ASC" ) );
		$ret = array();
		foreach ( $rows as $row ) {
			$ret [$row->id] = $row->name;
		}
		return $ret;
	}
}
?>
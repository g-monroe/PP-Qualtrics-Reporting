<?php
/**
 *  Fetches Faculty and Staff data from the database
 *
 * author: Emmanuel Owusu
 * created: 2/13/2008
 */
class StaffModel {
    
   /**
    * $dao an instance of the DataAccess class
    */
    private var $dao;
 
   /**
    * Constucts a new StaffModel object
    * @param $dbobject an instance of the DataAccess class
    */
    function StaffModel (&$dao) {
        $this->dao = &$dao;
    }
	
   /**
    * Tells the $dboject to store this query as a resource
    * @param $start the row to start from
    * @param $rows the number of rows to fetch
    * @return void
    */
    function listStaff() {
        $this->dao->fetch("SELECT * FROM staff WHERE active='1'");
    }
 
   /**
    * Tells the $dboject to store this query as a resource
    * @param $id a primary key for a row
    * @return void
    */
    function listStaffDetail($id) {
        $this->dao->fetch("SELECT * FROM staff WHERE id='".$id."'");
    }
 
   /**
    * Fetches a product as an associative array from the $dbobject
    * @return mixed
    */
    function getStaff() {
        if ( $staff=$this->dao->getRow() )
            return $staff;
        else
            return false;
    }
	
}
?>
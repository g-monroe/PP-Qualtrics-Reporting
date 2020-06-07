<?php
/**
 *  Controls the Staff pages
 */
class StaffController extends StaffView {
 
    /**
    * Constucts a new StaffController object
    * @param $model 	- an instance of the StaffModel class
    * @param $getvars 	- the incoming HTTP GET method variables
    */
    function StaffController (&$model, $getvars=null) {
        StaffView::StaffView($model);
        $this->header();
        switch ( $getvars['view'] ) {
            case "Staff":
                $this->StaffItem($getvars['id']);
                break;
            default:
                if ( empty ($getvars['rownum']) ) {
                    $this->StaffTable();
                } else {
                    $this->StaffTable($getvars['rownum']);
                }
                break;
        }
        $this->footer();
    }
}
?>
<?php


class Insurance implements PatientRecord {
    public $_id;
    public $patient_id;
    public $iname;
    public $from_date;
    public $to_date;

    function __construct($_id){
        $this -> _id = $_id;
		
		$sql_ins = "SELECT * FROM insurance WHERE _id='".$this -> _id."';";
		global $conn;
		$result_ins = mysqli_query($conn, $sql_ins);
		$row_ins = mysqli_fetch_assoc($result_ins);
        
        $this -> from_date = $row_ins["from_date"];
		$this -> to_date = $row_ins["to_date"];
		$this -> patient_id = $row_ins["patient_id"];
		$this -> iname = $row_ins["iname"];
    }

    public function get_RecordId(){
        return $this->_id;

 }
    public function get_PatientNumber(){
        return $this->pn;
 }

    public function get_iname() {
        return $this->iname;
}

//insurance date validation against current date
public function insurance_validate($date){
    $today = date_create_from_format('m-d-y', $date);
    $from_date = date_create_from_format('Y-m-d', $this->from_date);

    if (isset($this->to_date) && !( is_null($this->to_date) ) ) {
        $to_date = date_create_from_format('Y-m-d',$this->to_date);
    } else {
        $to_date = date_create_from_format('Y-m-d','9999-12-31');
    }
    if ($today >= $from_date && $today <= $to_date){
        return true;
    } else {
        return false;
    };

}

}

?>
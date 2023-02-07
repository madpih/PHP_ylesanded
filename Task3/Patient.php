<?php

class Patient implements PatientRecord {

    public $_id;
    public $pn;
    public $first;
    public $last;
	public $dob;
	public $insuranceRecords = array();

  
	function __construct($pn) {
			
		$this -> pn = $pn;

		$sql_pn = "SELECT * FROM patients WHERE pn='".$pn."';";

		global $conn;
		$result_pn = mysqli_query($conn, $sql_pn);
		$row_pn = mysqli_fetch_assoc($result_pn);

        $this -> _id = $row_pn['_id'];
        $this -> first = $row_pn['first'];
        $this -> last =  $row_pn['last'];
		$this-> dob = $row_pn['dob'];
		

		// get insurance records
		$sql_ins = "SELECT _id FROM insurance WHERE patient_id='".$this -> _id."';";
		$result_ins = mysqli_query($conn, $sql_ins);
		
		 while ( $row_ins = mysqli_fetch_assoc($result_ins)){
                $this->insuranceRecords[] = new Insurance($row_ins['_id']);     
		};

    }
   
    public function get_RecordId (){
        return $this -> _id;
    }

    public function get_PatientNumber() {
       return $this -> pn;
    }
	
    //Return full name
	public function get_fullName() {
		return ($this->first." ".$this->last);
	}

	public function get_insuranceRecords(){
        return $this->insuranceRecords;
    }

    //Return insurance records
    public function insurance_records($date){
        foreach($this->insuranceRecords as $insurance) {
            if ($insurance->insurance_validate($date)){
                $insurance_valid = "Yes";
            } else {
                $insurance_valid = "No";
        }
        //output
        echo $this->pn . ", " . $this->get_fullName() . ", " . $insurance->get_iname() . ", " . $insurance_valid ."\n";
         
        }
    }

}


?>
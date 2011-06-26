<?php
//--------------------------------------------------------------------------------------------------------------------------
// data_create.ejs.php
// v0.0.2
// Under GPLv3 License
//
// Integrated by: Ernesto Rodriguez in 2011
//
// Remember, this file is called via the Framework Store, this is the AJAX thing.
//--------------------------------------------------------------------------------------------------------------------------

session_name ( "MitosEHR" );
session_start();
session_cache_limiter('private');

include_once($_SESSION['site']['root']."/classes/dbHelper.class.php");
include_once($_SESSION['site']['root']."/classes/I18n.class.php");
require_once($_SESSION['site']['root']."/classes/dataExchange.class.php");
require_once($_SESSION['site']['root']."/classes/AES.class.php");

//******************************************************************************
// Reset session count 10 secs = 1 Flop
//******************************************************************************
$_SESSION['site']['flops'] = 0;

//-------------------------------------------
// password to AES and validate
//-------------------------------------------
$aes = new AES($_SESSION['site']['AESkey']);

//------------------------------------------
// Database class instance
//------------------------------------------
$mitos_db = new dbHelper();

// *************************************************************************************
// Parse the data generated by EXTJS witch is JSON
// *************************************************************************************
$data = json_decode ( $_POST['row'], true );

// *************************************************************************************
// Validate and pass the POST variables to an array
// This is the moment to validate the entered values from the user
// although Sencha EXTJS make good validation, we could check again 
// just in case 
// *************************************************************************************
$row['username']     = dataEncode($data['username']);
$row['password']     = $aes->encrypt($data['password']);
$row['title']        = dataEncode($data['title']);
$row['fname']        = dataEncode($data['fname']);
$row['mname']        = dataEncode($data['mname']);
$row['lname']        = dataEncode($data['lname']);
$row['authorized']   = (trim($data['authorized']) == 'on' ? 1 : 0);
$row['active']   	 = (trim($data['active']) == 'on' ? 1 : 0);
$row['facility_id']  = dataEncode($data['facility_id']);
$row['see_auth'] 	 = dataEncode($data['see_auth']);
$row['taxonomy'] 	 = dataEncode($data['taxonomy']);
$row['federaltaxid'] = dataEncode($data['federaltaxid']);
$row['federaldrugid']= dataEncode($data['federaldrugid']);
$row['upin']         = dataEncode($data['upin']);
$row['npi']          = dataEncode($data['npi']);
$row['federaltaxid'] = dataEncode($data['federaltaxid']);
$row['specialty']    = dataEncode($data['specialty']);
$row['info']         = dataEncode($data['info']);

// *************************************************************************************
// Finally that validated POST variables is inserted to the database
// This one make the JOB of two, if it has an ID key run the UPDATE statement
// if not run the INSERT statement
// *************************************************************************************
$sql = $mitos_db->sqlBind($row, "users", "U", "id='" . $data['id'] . "'");
$mitos_db->setSQL($sql);
$ret = $mitos_db->execLog();

?>
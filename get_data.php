<?php 
file_get_contents('php://input');
echo json_encode(array('status'=>"success","data"=>array('accuracy'=>'92','job_role'=>'Database Developer')));

?>
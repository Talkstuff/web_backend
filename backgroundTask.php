<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/14/2017
 * Time: 10:20 AM
 */

function SyncOldDb(){
    $dbMaster='talkstuf_kolda';
    $dbSlave='talkstuf_system';
    $passDbMaster='Nkem@1985';
    $passDbSlave='Nkem@1985';
    $userDbMaster='talkstuf_tech';
    $userDbSlave='talkstuf_tech';
    $conMaster = new mysqli("localhost", $userDbMaster, $passDbMaster, $dbMaster);
    $conSlave = new mysqli("localhost", $userDbSlave, $passDbSlave, $dbSlave);
    $tablesAndFieldsToReplicate=array(array(
        'table'=>'users','fields'=>"first_name,gender,email,password,username,registered_date",
        'keyField'=>'email','slaveTable'=>'phpfox_user','slaveFields'=>"full_name,gender,email,password,user_name"
    ));
    $tablesAndFieldsToReplicate2=array(array(
        'table'=>'user_connections','fields'=>"user_id,friend",'keyField'=>array('user_id','friend'),
        'slaveTable'=>'phpfox_friend','slaveFields'=>"user_id,friend_user_id"
    ));

    if ($conMaster->connect_error||$conSlave->connect_error) {
        error_log("Error: " . $conMaster->connect_error . "\n", 0);
        error_log("Error: " . $conSlave->connect_error . "\n", 0);
        // You might want to show them something nice, but we will simply exit
        die;
    }

    $tablesLength=count($tablesAndFieldsToReplicate);
    $table2Length=count($tablesAndFieldsToReplicate2);
    $recordsTransfered=0;$records2Transfered=0;
    for($x=0;$x<$tablesLength;$x++){
        $table=$tablesAndFieldsToReplicate[$x];
        $resultSlave = $conSlave->query("SELECT ".$table['slaveFields']." FROM ".$table['slaveTable']);
        if($resultSlave === false)
        {
            echo "Query failed: ".mysqli_error($conSlave);
            die;
        }
        if ($resultSlave->num_rows > 0) {
            // output data of each row
            while($row = $resultSlave->fetch_assoc()) {
                foreach($row as $key=>$val ){
                    $keyFieldValue=$row[$table['keyField']];
                    $masterResult=$conMaster->query("SELECT ".$table['keyField']." FROM ".$table['table']. " WHERE(".$table['keyField']." = '$keyFieldValue')");
                    if ($masterResult->num_rows > 0) {
                        break;
                    }else{
                        $masterInsert=$conMaster->query("INSERT INTO ".$table['table']
                            ." (".$table['fields'].")"." VALUES ('".$row['full_name'].
                            "','".$row['gender']."','".$row['email']."','".$row['password'].
                            "','".$row['user_name']."',STR_TO_DATE('".date('Y-m-d')."', '%Y-%m-%d'))");
                        if ($masterInsert === TRUE) {
                            $recordsTransfered++;
                        } else {
                            echo "Error: ". $conMaster->error;
                        }

                    }
                }
            }
            echo $recordsTransfered." record Transfered successfully";
        } else {
            echo "0 results";
        }
    }

    for($x=0;$x<$table2Length;$x++){
        $table=$tablesAndFieldsToReplicate2[$x];
        $resultSlave = $conSlave->query("SELECT ".$table['slaveFields']." FROM ".$table['slaveTable']);
        if($resultSlave === false)
        {
            echo "Query failed: ";
            die;
        }
        if ($resultSlave->num_rows > 0) {
            // output data of each row
            while($row = $resultSlave->fetch_assoc()) {
                foreach($row as $key=>$val ){
                    $keyFields=merge_arrays_string($table['keyField']);
                    $queryComplete=CreateWhereClause($table['keyField'],$row);
                    $masterResult=$conMaster->query("SELECT $keyFields FROM ".$table['table']." WHERE($queryComplete)");
                    if ($masterResult->num_rows > 0) {
                        break;
                    }else{
                        $user=(int)$row['user_id'];
                        $friend=(int)$row['friend_user_id'];
                        $masterInsert=$conMaster->query("INSERT INTO ".$table['table']
                            ." (".$table['fields'].")"." VALUES ($user,$friend)");
                        if ($masterInsert === TRUE) {
                            $records2Transfered++;
                        } else {
                            echo "Error: ". $conMaster->error;
                        }

                    }
                }
            }
            echo $records2Transfered." record Transfered successfully";
        } else {
            echo "0 results";
        }
    }

    $conMaster->close();
    $conSlave->close();

}

function merge_arrays_string($arr){
    $len=count($arr);
    $result='';
    for($j=0;$j<$len;$j++){
        if($j==0){$result=$result.$arr[$j];}else{
            $result=$result.",".$arr[$j];
        }
    }
    return $result;
}

function CreateWhereClause($fieldArr,$valueArr){
    $len=count($fieldArr);$queryBuilder='';
    for($i=0;$i<$len;$i++){
        if($i==0){
            $queryBuilder=$queryBuilder.$fieldArr[$i]." = ".$valueArr['user_id'];
        }else{
            $queryBuilder=$queryBuilder." AND ".$fieldArr[$i]." = ".$valueArr['friend_user_id'];
        }
    }
    return $queryBuilder;
}
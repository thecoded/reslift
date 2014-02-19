<?php
function createTable($tableName){

  dbQuery("CREATE TABLE IF NOT EXISTS $tableName (`rId` int(11) NOT NULL AUTO_INCREMENT, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`rId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

  
}

function rollAdd($tableName, $fieldsArr, $checkExists, $print ,$checkAdded, $updateBool, $addNewFields){


   //ensure this doesn't run if tableName and fieldArr is not specified
    if(!isset($tableName)){
      return "noTableName";
    }

    if(!isset($checkExists)){
      return "noFieldsSpecified";
    }



  $tableExists = dbMassData("SHOW TABLES LIKE '$tableName'");
  if($tableExists == null){
   // echo("no table... create one..");
    createTable($tableName);
    sleep(1);
  }

    foreach($fieldsArr as $key => $value){


        $fieldsArr[$key] = str_replace("'", "`", $fieldsArr[$key]);


    }


   
  //determine indicator field nd value to look at for redundancies, updates, etc...
       $pointCheckField;
       $pointCheckValue;
   
      foreach($fieldsArr as $k => $v){
      $pointCheckField= $k;
      $pointCheckValue= $v;
       break;
      }


    if($checkExists == true){
    
     

      $exists= dbMassData("SELECT * FROM $tableName WHERE $pointCheckField = '$pointCheckValue' ");

      if($exists != null){

        // check update Bool, if true, update this record

         if($updateBool == true){
      //echo('updating');
         $baseStr = "UPDATE " . $tableName. " SET ";
         $queryStr="";
         $counter=0;
          foreach($fieldsArr as $k => $v){


            if($addNewFields == true){
                $colExists = dbMassData("SHOW COLUMNS FROM $tableName LIKE '$k'");
                if($colExists == null){

                  //create field in table
                  if(is_float($v)){
                    dbQuery("ALTER TABLE  $tableName  ADD  $k FLOAT NOT NULL");
                  }
                  else if(is_numeric($v)){
                    dbQuery("ALTER TABLE  $tableName  ADD  $k FLOAT NOT NULL");
                  }
                  else if(strlen($v) < 100){
                    dbQuery("ALTER TABLE  $tableName  ADD  $k VARCHAR( 100 ) NOT NULL");
                  }
                  else{
                    dbQuery("ALTER TABLE  $tableName  ADD  $k TEXT NOT NULL");
                  
                  }
                  
                }
              }


              if($counter ==0){
               $queryStr .= $k . " = '". $v. "'";
              }
              else{
                 $queryStr .= ", " . $k . " = '". $v."'";
              }
              $counter= $counter+1;

            

          }
          $baseStr = $baseStr . $queryStr. " WHERE ".  $pointCheckField . " = '" . $pointCheckValue . "';";

            if($print == true){
              echo $baseStr;
            }
            dbQuery($baseStr);
            return "updated";
    }


        return "redundant";
      }
    }


    if( $checkExists == false && $updateBool == true){
      //echo('updating');
         $baseStr = "UPDATE " . $tableName. " SET ";
         $queryStr="";
         $counter=0;
          foreach($fieldsArr as $k => $v){


            if($addNewFields == true){
                $colExists = dbMassData("SHOW COLUMNS FROM $tableName LIKE '$k'");
                if($colExists == null){

                  //create field in table
                  if(is_float($v)){
                    dbQuery("ALTER TABLE  $tableName  ADD  $k FLOAT NOT NULL");
                  }
                  else if(is_numeric($v)){
                    dbQuery("ALTER TABLE  $tableName  ADD  $k FLOAT NOT NULL");
                  }
                  else if(strlen($v) < 100){
                    dbQuery("ALTER TABLE  $tableName  ADD  $k VARCHAR( 100 ) NOT NULL");
                  }
                  else{
                    dbQuery("ALTER TABLE  $tableName  ADD  $k TEXT NOT NULL");
                  
                  }
                  
                }
              }


              if($counter ==0){
               $queryStr .= $k . " = '". $v. "'";
              }
              else{
                 $queryStr .= ", " . $k . " = '". $v."'";
              }
              $counter= $counter+1;

            

          }
          $baseStr = $baseStr . $queryStr. " WHERE ".  $pointCheckField . " = '" . $pointCheckValue . "';";

            if($print == true){
              echo $baseStr;
            }
            dbQuery($baseStr);
            return "updated";
    }

// continues only if the record doens't exist if checkExist is true
  $baseStr = "INSERT INTO " . $tableName. " (";
  $constructString = ") VALUES (";
  $firstSide="";
  $secondSide="";
  $counter=0;
  foreach($fieldsArr as $k => $v){

    //create the field if it doesnt exist in the table

        if($addNewFields == true){ 
           $colExists = dbMassData("SHOW COLUMNS FROM $tableName LIKE '$k'");
                  if($colExists == null){

                    //create field in table
                    if(is_float($v)){
                      dbQuery("ALTER TABLE  $tableName  ADD  $k FLOAT NOT NULL");
                    }
                    else if(is_numeric($v)){
                      dbQuery("ALTER TABLE  $tableName  ADD  $k FLOAT NOT NULL");
                    }
                    else if(strlen($v) < 100){
                      dbQuery("ALTER TABLE  $tableName  ADD  $k VARCHAR( 100 ) NOT NULL");
                    }
                    else{
                      dbQuery("ALTER TABLE  $tableName  ADD  $k TEXT NOT NULL");
                    
                    }
                    
                  }
              }

    if($counter ==0){
      $firstSide .= $k;
     $secondSide .= "'".$v."'";
    }
    else{
       $firstSide .= ", ". $k;
     $secondSide .= ", '" . $v . "'";
    }
    $counter= $counter+1;

    

  }


  $constructString = $baseStr . $firstSide . $constructString . $secondSide;
  $baseString .= $constructString . ");";
  
  dbQuery($baseString);

  if($print==true){
      echo($baseString);
  }

  if($checkAdded == true){

       $pointCheckField="";
       $pointCheckValue="";
   
      foreach($fieldsArr as $k => $v){
      $pointCheckField= $k;
      $pointCheckValue= $v;
       break;
      }

      $exists= dbMassData("SELECT * FROM $tableName WHERE $pointCheckField = '$pointCheckValue' ");

      if($exists != null){
        return "added";
      }
  }








}



?>
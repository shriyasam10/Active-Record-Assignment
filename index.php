<?php
class dbConn
{
protected static $db;

private function __construct()
{

try
{
self::$db= new PDO('mysql:host=sql2.njit.edu;dbname=sss329', 'sss329','Iag2xyAqh');

self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch(PDOException $e)
{
echo "<b>Connection Error:</b>"."<br>".$e->getMessage();
}
}

public static function getconnection()
{
if(!self::$db)
{
new dbconn();
}
return self::$db;
}
}

class collection
{

static public function create()
{
$model = new static::$modelName;
return $model;
}

static public function findAll()
{
$db = dbConn::getconnection();
$tablename = get_called_class();
$sql = 'select * from'.$tableName;
$statement = $db->prepare($sql);
$statement->execute();
$class = static::$modelName;
$statement->setFetchMode(PDO::FETCH_CLASS, $class);
$recordSet = $statement->fetchAll();
return $recordsSet;
}

static public function findOne($id)
{
$db = dbConn::getconnection();
$tableName = get_called_class();
$sql = 'select * from'.$tableName.'where id ='.$id;
$statement = $db->prepare($sql);
$statement->execute();
$class = static::$modelName;
$statement->setFetchMode(PDO::FETCH_CLASS, $class);
$recordsSet = $statement->fetchAll();
return $recordsSet[0];
}
}

class accounts extends collection
{
protected static $modelName = 'account';
}

class todos extends collection
{
protected static $modelName = 'todo';
}

class model
{
protected $tableName;
protected $isUpdate;

public function save()
{

echo "ID is:".$this->id;
echo "Update is:".$this->isUpdate;

if($this->isUpdate=='false')
{
$sql = $this->insert();
}
elseif($this->isUpdate=='delete')
{
$sql = $this->delete();
}

else
{
$sql = $this->update();
}


//if (this->id = '')
//{
//$sql = $this->insert();
//}

//else
//{
//$sql = $this->update();
//}

$db = dbConn::getconnection();
$statement = $db->prepare($sql);
$statement->execute();

$tableName = get_this_class_called();

$array = get_object_vars($this);
$columnString = implode(',',$array);
$valueString = ":".implode(',:', $array);

echo 'I just saved record:'.$this->id;
}

private function insert()
{

echo 'table name in insert';
if($this->tableName==todos)
{

$sql = "Insert into ".$this->tableName."values(".$this->id.",'".$this->owneremail."',".$this->ownerid.",Date('".$this->createddate."'),Date('".$this->duedate."'),'".$this->message."',".$this->isdone.")";
}

else
{
$sql = "Insert into ".$this->tableName."values(".$this->id.",'".$this->email."',".$this->fname.",'".$this->lname.",'".$this->phone.",Date('".$this->createddate."'),'".$this->gender."',".$this->password.")";
}

return $sql;

}

private function update()
{

echo 'table name in update'.$this->id;
$sql = "Update ".$this->tableName." set owneremail='".$this->owneremail."',message = '".$this->message."'where id =".$this->id;
return $sql;
echo 'I just updated record' . $this->id;
}

public function delete()
{

$sql = "Delete from ".$this->tableName." where id = ".$this->id;
return $sql;
echo 'I just deleted record'.$this->id;

}

}

















































































?>































































































































































































































































































































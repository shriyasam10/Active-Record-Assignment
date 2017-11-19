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










































?>































































































































































































































































































































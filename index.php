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
  protected $tableName;
  public static function createdb() 
  {
    $model = new static::$modelName;
    return $model;
  }
  public static function findAll()
  {
    $db = dbConn::getconnection();
    $tableName = get_called_class();
    $sqlquery = 'SELECT * FROM ' . $tableName;
    $statement = $db->prepare($sqlquery);
    $statement->execute();
    $childclass = static::$modelName;
    $statement->setFetchMode(PDO::FETCH_CLASS, $childclass);
    $recordsSet =  $statement->fetchAll();
    return $recordsSet;
  }
  public static function findOne($id) 
  {
    $db = dbConn::getconnection();
    $tableName = get_called_class();
    $sqlquery = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
    $statement = $db->prepare($sqlquery);
    $statement->execute();
    $childclass = static::$modelName;
    $statement->setFetchMode(PDO::FETCH_CLASS, $childclass);
    $recordsSet =  $statement->fetchAll();
    return $recordsSet;
    
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
 
$records = accounts::findAll();
print_r($records);
$records = todos::findAll();
print_r($records);

$records = accounts::findOne(1);
print_r($records);
$records = todos::findOne(1);
print_r($records);













/*class collection
{

static public function create()
{
$model = new static::$modelName;
return $model;
}

static public function findAll()
{
$db = dbConn::getconnection();
$tableName = get_called_class();
$sql = 'select * from'.$tableName;
$statement = $db->prepare($sql);
$statement->execute();
$class = static::$modelName;
$statement->setFetchMode(PDO::FETCH_CLASS, $class);
$recordsSet = $statement->fetchAll();
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

$records = accounts::findOne(1);
print_r($records);
$records = todos::findOne(1);
print_r($records);







/*class model
{
protected $tableName;
protected $isUpdate;

private function save()
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
*/
/*class accounts extends model
{

public $id;
public $email;
public $fname;
public $lname;
public $phone;
public $birthday;
public $gender;
public $password;

public function __construct($isUp)
{

$this->tableName = 'accounts';
$this->isUpdate = $isUp;

}
}

class todo extends model
{

public $id;
public $owneremail;
public $ownerid;
public $createddate;
public $duedate;
public $message;
public $isdone;

private function __construct($isUp)
{

$this->tableName = 'todos';
$this->isUpdate = $isUp;

}
}

$newAccount = new account('false');
$newAccount->id = 12;
$newAccount->owneremail='manoman@gmail.com';
$newAccount->ownerid = 420;
$newAccount->createddate='2017-06-15 09:34:21';
$newTodo->duedate = '2017-06-15 09:34:21';
$newTodo->message = 'new Item';
$newTodo->isdone = 0;
$newTodo->save();

$deleteTodo = new todo('delete');
$deleteTodo->id = 12;
$deleteTodo->save();
*/


?>


































































































































































































































































































































































































































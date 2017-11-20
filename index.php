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
    static public function findAll() {
    $db = dbConn::getconnection();
    $tableName = get_called_class();
    $sql = 'SELECT * FROM ' . $tableName;
    $statement = $db->prepare($sql);
    $statement->execute();
    $class = static::$modelName;
    $statement->setFetchMode(PDO::FETCH_CLASS, $class);
    $recordsSet =  $statement->fetchAll();

    if(static::$modelName=='todo')
    {
    echo "<table border=\"1\"><tr><th>id</th><th>owneremail</th><th>ownerid</th><th>createddate</th><th>duedate</th><th>message</th><th>isdone</th></tr>";
    }
    else
    {
    echo "<table border=\"1\"><tr><th>id</th><th>email</th><th>fname</th><th>lname</th><th>phone</th><th>birthday</th><th>gender</th><th>password</th></tr>";
    }
         
    foreach($recordsSet as $tempRecord)
    {
    if(static::$modelName=='todo')
    {
    echo "<tr><td>".$tempRecord->id."</td><td>".$tempRecord->owneremail."</td><td>".$tempRecord->ownerid."</td><td>".$tempRecord->createddate."</td><td>".      $tempRecord->duedate."</td><td>".$tempRecord->message."</td><td>".$tempRecord->isdone."</td></tr>";
    }
         
    else
    {
    echo "<tr><td>".$tempRecord->id."</td><td>".$tempRecord->email."</td><td>".$tempRecord->fname."</td><td>".$tempRecord->lname."</td><td>".$tempRecord->phone."</td><td>".$tempRecord->birthday."</td><td>".$tempRecord->gender."</td><td>".$tempRecord->password."</td></tr>";
    }
    }
    echo "</table>";
    return $recordsSet;
    }
    static public function findOne($id) 
    {
    $db = dbConn::getconnection();
    $tableName = get_called_class();
    $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
    $statement = $db->prepare($sql);
    $statement->execute();
    $class = static::$modelName;
    $statement->setFetchMode(PDO::FETCH_CLASS, $class);
    $recordsSet =  $statement->fetchAll();
    if(static::$modelName=='todo')
    {
    echo "<table border=\"1\"><tr><th>id</th><th>owneremail</th><th>ownerid</th><th>createdate</th><th>duedate</th><th>message</th><th>isdone</th></tr>";
    }
    else
    {
    echo "<table border=\"1\"><tr><th>id</th><th>email</th><th>fname</th><th>lname</th><th>phone</th><th>birthday</th><th>gender</th><th>password</th></tr>";
    }
    if(static::$modelName=='todo')
    {
    echo "<tr><td>".$recordsSet[0]->id."</td><td>".$recordsSet[0]->owneremail."</td><td>".$recordsSet[0]->ownerid."</td><td>".$recordsSet[0]->createddate."</td><td>".$recordsSet[0]->duedate."</td><td>".$recordsSet[0]->message."</td><td>".$recordsSet[0]->isdone."</td></tr>";
    }
    else
    {
    echo "<tr><td>".$recordsSet[0]->id."</td><td>".$recordsSet[0]->email."</td><td>".$recordsSet[0]->fname."</td><td>".$recordsSet[0]->lname."</td><td>".$recordsSet[0]->phone."</td><td>".$recordsSet[0]->birthday."</td><td>".$recordsSet[0]->gender."</td><td>".$recordsSet[0]->password."</td></tr>";
    }

    echo "</table>";
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
    
    public function save()
    {  
        
    if ($this->action =='insert') 
    {
    $sql = $this->insert();
    } 
    elseif($this->action=='delete')
    {
    $sql = $this->delete();
    }
    else 
    {
    $sql = $this->update();
    }
    $db = dbConn::getconnection();
    $statement = $db->prepare($sql);
    $statement->execute();
    $tableName = get_called_class();
    $array = get_object_vars($this);
    $columnString = implode(',', $array);
    $valueString = ":".implode(',:', $array);
    echo 'I just saved record: ' . $this->id;
    }
    
    private function insert() 
    {
    if($this->tableName=='todos')
    {
		$sql = "Insert into ".$this->tableName." values(".$this->id.",'".$this->owneremail."',".$this->ownerid.",Date('".$this->createddate."'),Date('".$this->duedate."'),'".$this->message."',".$this->isdone.")";
    }
    else
    {
    $sql = "Insert into ".$this->tableName." values(".$this->id.",'".$this->email."','".$this->fname."','".$this->lname."','".$this->phone."',Date('".$this->birthday."'),'".$this->gender."','".$this->password."')";
    }    
    return $sql;        
    }
    
    private function update() 
    {
    if($this->tableName=='todos')
    {
    $sql = "Update ".$this->tableName." set owneremail='".$this->owneremail."',message = '".$this->message."' where id = ".$this->id;
    }
    else
    {
    $sql = "Update ".$this->tableName." set email='".$this->email."',password = '".$this->password."' where id = ".$this->id;    
    }    
    return $sql;
    echo 'I just updated record' . $this->id;
    }
    
    public function delete() 
    {
    $sql = "Delete from ".$this->tableName." where id = ".$this->id;
    return $sql;
    echo 'I just deleted record' . $this->id;
    }
}
    
class account extends model 
{
    
    public $id;
    public $email;
    public $fname;
    public $lname;
    public $phone;
    public $birthday;
    public $gender;
    public $password;
    public $action;
    public function __construct()
    {
        $this->tableName = 'accounts';
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
    public $action;

    public function __construct()
    {
        $this->tableName = 'todos';
         
    }
}

echo " Displaying all records of table Accounts </br>";
accounts::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";

echo " </br>Displaying all records of table Todos </br>";
todos::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>"; 

echo " </br>Displaying record with id 2 of table Todos </br>";
$todoRecord = todos::findOne(2);
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";

echo " </br>Displaying record with id 5 table Accounts </br>";
$accountRecord = accounts::findOne(5);
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";

$newTodo = new todo();
$newAccount = new account();

$newTodo->action = 'insert';
$newTodo->id =18;
$newTodo->owneremail='teddybear@gmail.com';
$newTodo->ownerid = 211;
$newTodo->createddate='2017-06-15 09:34:21';
$newTodo->duedate = '2018-09-15 09:34:21';
$newTodo->message = 'new service';
$newTodo->isdone = 0;
$newTodo->save();
    
echo " </br>Inserted new record with id 18 in table Todos </br>";    
todos::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";

$newAccount->action = 'insert';
$newAccount->id =18;
$newAccount->email='mac@gmail.com';
$newAccount->fname = 'mac';
$newAccount->lname = 'nyx';
$newAccount->phone = '12103748596';
$newAccount->birthday = '1990-02-03 09:34:21';
$newAccount->gender = 'female';
$newAccount->password = 'password';
$newAccount->save();

echo " </br>Inserted new record with id 18 in table Accounts </br>";
accounts::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";


$upDateTodo = new todo();
$upDateTodo->action = 'update';
$upDateTodo->id = 18;
$upDateTodo->owneremail = 'ihateteadybear@gmail.com'; 
$upDateTodo->message = 'Updated Item';
$upDateTodo->save();


echo " </br>Updated record with id 18 in table Todos </br>";
todos::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";


$upDateAccount = new account();
$upDateAccount->action ='update';
$upDateAccount->id = 18;
$upDateAccount->email = 'nyx@gmail.com'; 
$upDateAccount->password = 'Updated password';
$upDateAccount->save();

echo " </br>Updated record with id 18 in table Accounts </br>";
accounts::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";


$deleteTodo = new todo();
$deleteTodo->action ='delete';
$deleteTodo->id = 14;
$deleteTodo->save();

echo " </br>Deleted new record with id 14 in table Todos </br>";
todos::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";


$deleteAccount = new account();
$deleteAccount->action = 'delete';
$deleteAccount->id = 13;
$deleteAccount->save();

echo " </br>Deleted new record with id 13 in table Accounts </br>";
accounts::findAll();
echo " </br> ----------------------------------------------------------------------------------------------------------------------------------------------------------</br>";

?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    































    





































?>

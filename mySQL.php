<?php
function refresh(){
    header("Location: " . $_SERVER['PHP_SELF']);exit();
}
class SQLib{
    public $HOST="localhost";
    public $USER="root";
    public $PASS="";
    public $DB="contoh";
    public $table;
    public $column = array();
    public $values = array();
    public $conn;
    
public function __construct($table)
{
    $this->conn = mysqli_connect("localhost","root","","contoh");
    $this->table=$table;
}


public function execSQL($QUERY){
    mysqli_query($this->conn,$QUERY);
    return $QUERY;
}

public function read($column, $condition = null) {
    if($column=="all"){$column="*";}
    $query = "SELECT {$column} FROM {$this->table}";
    if (!empty($condition)) {
        $query = $query . " WHERE " . $condition;
    }
    // print_r($query);
    $res = mysqli_query($this->conn, $query);
    $rows = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    return $rows;
}

public function insert ($columns=null,$values){
    function val($nilai){return is_numeric($nilai)?$nilai:"'".$nilai."'";}
    $column = array();
    $value = array();
    $column = explode(',',$columns);
    $value = explode(',', $values);
    $value = array_map('val',$value);
    $query="INSERT INTO {$this->table} (".implode(',',$column).") VALUES (".implode(',',$value).")";
    // print_r($query);
    mysqli_query($this->conn,$query);
}

public function delete($kondisi){
    $query="DELETE FROM {$this->table} WHERE {$kondisi}";
    // print_r($query);
    mysqli_query($this->conn,$query);
}

public function update($columns,$values,$kondisi){
    
    function halo($nilai){return is_numeric($nilai)?$nilai:"'".$nilai."'";}
    $column = array();
    $value = array();
    $column = explode(',',$columns);
    $value = explode(',', $values);
    $value = array_map('halo',$value);
    for($i=0;$i< count($column);$i++){
        $updatecol[]="".$column[$i]."=".$value[$i];
    }
    $query="UPDATE {$this->table} SET ".implode(', ',$updatecol)." WHERE {$kondisi}";
    // print_r($query);
    mysqli_query($this->conn,$query);
}
}

?>


<?php
require_once('database.php');
require_once('pdo.php');

//table name:BOOK
//colums id(auto_increment),tile,price

$pdo = new ExtendPDO(DB_HOST,DB_DBNAME,DB_ENCODE,DB_USER,DB_PW);

//select
$query = $pdo->select("SELECT * FROM BOOK WHERE id>:id LIMIT :limit",[
    ':id' => 0,
    ':limit' => 5
]);

foreach($query as $row){
    echo $row['id'].'<br>';
    echo $row['title'].'<br>';

}

//insert
echo $pdo->insert('BOOK',[
    'title'=>'999',
    'rating'=>12,
    'price'=>'7.77'
]);

//update
echo $pdo->update('BOOK',[
    'title'=>'this is update'
],"id = :delete_id",[
    ':delete_id'=>'5'
]);

//delete
echo $pdo->delete('BOOK',"id = :delete_id",[
    ':delete_id'=>'6'
]);

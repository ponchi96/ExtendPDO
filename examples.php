<?php
require_once('config/database.php');
require_once('db/pdo.php');

$pdo = new ExtendPDO(DB_HOST,DB_DBNAME,DB_ENCODE,DB_USER,DB_PW);

$query = $pdo->select("SELECT * FROM BOOK WHERE id>:id LIMIT :limit",[
    ':id' => 0,
    ':limit' => 5
]);
$pdo->error();
foreach($query as $row){
    echo $row['id'].'<br>';
    echo $row['title'].'<br>';

}
/*
$pdo->test = 123;
echo $pdo->test;
$pdo = new ExtendPDO(DB_HOST,DB_DBNAME,DB_ENCODE,DB_USER,DB_PW);
echo $pdo->insert('BOOK',[
    'title'=>'999',
    'rating'=>12,
    'price'=>'7.77'
]);
*/
echo $pdo->delete('BOOK',"id = :delete_id",[
    ':delete_id'=>'6'
]);
$access_token ='v2Vv0XoP8l8iv12VS6Ji0Nftg0nmJGzFJd2as0jLITSQV6dxWD8/ttYkjIm9YRvOVM2OycMgpbjXydEa4ba97kyqSDEpIv1CdOoyWWcuvHJr9FK4jz8CWuYkFe0jMu2LvMQ2gATYRhr64OKA0oHuMQdB04t89/1O/w1cDnyilFU=';
        $json_string = file_get_contents('php://input');
        $json_obj = json_decode($json_string);
        
        
        $ecount = 0;
        $usid = "testt";
        
        for($i=0;$i<$ecount;$i++)
        {
            //初始訊息清空
            $echo = "";
            
            $event = $json_obj->{"events"}[$i];;
            $message = $event->{"message"}->{"text"};;
            $user = $event->{"source"};
            $reply_token = $event->{"replyToken"};
            
            //訊息過濾-START
            $message = str_replace("　"," ",$message);
            $message = trim($message);
            $message = str_replace("'","",$message);
            $message = addslashes($message);
            while(strpos("*".$message, '  '))
            {
                $message = str_replace("  "," ",$message);
            }
            
            $input = explode(" ",$message);		
            
            for($i=0;$i<count($input);$i++)
            {
                if(is_numeric($input[$i]))
                    $input[$i] = floor($input[$i]);
            }
            //訊息過濾-END
            
            if(strpos("*".$usid,$user->{"userId"}) ==false)
            {		    
                    //傳送訊息給使用者
                    $echo = $message;
                    SendPost($echo,$access_token,$reply_token);
                    
                    //避免陣列中單一使用者送出多筆訊息
                    //$usid .= $user->{"userId"};
            }
        }
    

    function SendPost($str,$access_token,$reply_token)
    {
        $post_data =
        [
          "replyToken" => $reply_token,
          "messages" => [
            [
              "type" => "text",
              "text" =>  $str
              
            ]
          ]
        ]; 
                
        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token
            //'Authorization: Bearer '. TOKEN
        ));
        
        $result = curl_exec($ch);
        curl_close($ch);
    }
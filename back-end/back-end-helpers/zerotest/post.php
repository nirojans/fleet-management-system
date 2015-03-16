<?php
    // post.php ???
	
    // This all was here before  ;)

     $entryData = array(
'destination' => $_POST['destination']
, 'message' => 'Fucks'
, 'from' => '0'
, 'time' => time()
);
	
   // $pdo->prepare("INSERT INTO blogs (title, article, category, published) VALUES (?, ?, ?, ?)")
       // ->execute($entryData['title'], $entryData['article'], $entryData['category'], $entryData['when']);

    // This is our new stuff
    $context = new ZMQContext();
    $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
    $socket->connect("tcp://127.0.0.1:5555");

    $socket->send(json_encode($entryData));
    	
?>

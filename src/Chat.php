<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    
    private $clients; 

    private function _construct(){
        $this->clients=array();
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients[]=$conn;
        echo "New connection";

    }

    public function onMessage(ConnectionInterface $from, $msg) {

        foreach($this->clients as $client){

            if($client!=$from){
                $data = json_decode($msg, true);
                $client->send($data['msg']);
            }

        }

    }

    public function onClose(ConnectionInterface $conn) {
    
        echo "Connection closed";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
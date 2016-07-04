<?php



class context {
    private $openid;

    public function __construct($openid){
        $this->openid=$openid;
    }

    public function set($content,$reply){
           pdoInsert('wx_context_tbl',array('openid'=>$this->openid,'content'=>$content,'$reply'=>$reply),'update');
    }

    public function get(){
        $con=pdoQuery('wx_context_tbl',null,array('openid'=>$this->openid),' limit 1');
        $con=$con->fetch();
        if($con)return $con;
        else return array('content'=>false,'reply'=>false);
    }


}
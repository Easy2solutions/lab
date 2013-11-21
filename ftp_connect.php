<?php //script pra retornar os arquivos .txt de determinado diretorio 
require_once('ftp_config.php');

function send_message( $message, $progress) 
{
    $d = array('message' => $message , 'progress' => $progress);
        echo json_encode($d) . PHP_EOL;
    //PUSH THE data out by all FORCE POSSIBLE
    ob_flush();
    flush();
}
$dir = "importar"; 
send_message( 'conectando' , '0');
sleep(1);

if(!ftp_chdir($connect, "$dir/")){
    
    send_message( 'Falha de conexao' , '100');
} else {

 send_message( 'pegando lista' , '10');
}
sleep(1);
  
    $lista_arquivos = ftp_nlist($connect, ".");
    $num = count($lista_arquivos) -2;
    
    $_SESSION['lista_arquivos'] = $lista_arquivos;
    
 send_message( 'lista carregada' , '30'); sleep(1);  
 
 
    if($num == 1){
      
//        $_SESSION['msg_import'] = "Existe 1 arquivo para ser importado";
      send_message( 'Existe 1 arquivo para ser importado' , '30'); sleep(1);  
    } elseif ($num == 0 ) {
//            $_SESSION['msg_import'] = "Nao existem dados para importar";
        send_message( 'Nao existem dados para importar' , '100'); sleep(1);
    }
    else {          
//    $_SESSION['msg_import'] = "Existem $num arquivos para serem importados";
      send_message( 'Existem '.$num .' arquivos para serem importados' , '100'); sleep(1);
}
?>

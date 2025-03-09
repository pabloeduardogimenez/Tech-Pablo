<?php
  require_once("globals.php");
  require_once("db.php");
  require_once("models/Movie.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");
  require_once("dao/MovieDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

//Resgata o  tipo do formulario
$type = filter_input(INPUT_POST, "type");

// Regaste dados do usuário
$userData = $userDao->verifytoken();

if ($type === "create") {

    //Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST,"length");    
 
     

   /* if(isset($_FILES['pic']))
    {
    $ext = strtolower(substr($_FILES['pic']['name'],-4)); //Pegando extensão do arquivo
    
    $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
    $dir = './img/movies/'; //Diretório para uploads   
    move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$new_name);
    
    }*/
   

    if (!empty($title) && !empty($description) && !empty($category) )
    { 
        $movie = new Movie();
        $movie->title = $title;
        $movie->description = $description;
        $movie->trailer = $trailer;
        $movie->category = $category;
        $movie->length = $length;
        $movie->users_id = $userData->id;

        if(isset($_FILES['pic']) && !empty($_FILES['pic']['name'])){
            if(isset($_FILES['pic']))
            {
                
                $ext = strtolower(substr($_FILES['pic']['name'],-4));
                $imagetypes = [".jpeg",".jpg",".png"];
                if (in_array($ext, $imagetypes)) {
                    $new_name = $movie->imageGenerateName(). $ext; //Definindo um novo nome para o arquivo
                    $dir = './img/movies/'; //Diretório para uploads   
                    move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$new_name);                         
                    $movie->image = $new_name; 
               }              
            
      
            } else {
                $message->setMessage(" Tipo inválido de imagem, insera imagem formatado: png ; jpg ou jpeg!" ,"error" , "back");
            }   
        }
     
        $movieDao->create($movie);
    } else {     
        $message->setMessage(" Você precisa adicionar pelo menos: título, descrição e 
        categoria!" ,"error" , "back");

    }
    
} else if($type === "delete") {
    $id = filter_input(INPUT_POST, "id");

    $movie = $movieDao->findById($id);

    if ($movie){
        if($movie->users_id === $userData->id){

            $movieDao->destroy($movie->id);

        } else {
            $message->setMessage("Informações inválidas!.", "error", "index.php");
        }    
    } else {

    $message->setMessage("Informações inválidas!", "error", "index.php");

    } 

} else if($type === "update") {

    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST,"length");
    $id = filter_input(INPUT_POST,"id");

    $movieData = $movieDao->findById($id);

    if ($movieData){
        if($movieData->users_id === $userData->id){
            

            // Edição do filme
            if (!empty($title) && !empty($description) && !empty($category) ) {     
    
                $movieData->title = $title;
                $movieData->description = $description;
                $movieData->trailer = $trailer;
                $movieData->category = $category;
                $movieData->length = $length;
                $movie = new Movie();
               
               
                
                if(isset($_FILES['pic']) && !empty($_FILES['pic']['name'])){
                    if(isset($_FILES['pic']))
                    {
                    $ext = strtolower(substr($_FILES['pic']['name'],-4));
                        $imagetypes = [".jpeg",".jpg",".png"];
                        if (in_array($ext, $imagetypes)) {
                            $new_name = $movie->imageGenerateName(). $ext; //Definindo um novo nome para o arquivo
                            $dir = './img/movies/'; //Diretório para uploads   
                            move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$new_name);                         
                            $movieData->image = $new_name; 
                        }                     
                    }

                    $image = $_FILES['pic'];
                    $imagetypes = ["image/jpeg","image/jpg","image/png"];
                    $jpgArray = ["image/jpeg","image/jpg"];
                
                    if (in_array($image["type"], $imagetypes)){
                          // checar se é jpg
                          if(in_array($image,$jpgArray)) {                             
                                                          
                        
                               
                            } else {
                               
                                                      
                        }
                        
                       
                    } else {
                        $message->setMessage(" Tipo inválido de imagem, insera imagem formatado: png ; jpg ou jpeg!" ,"error" , "back");
                    }
                } 
                
                $movieDao->update($movieData);
            }
            else {
                $message->setMessage(" Você precisa adicionar pelo menos: título, descrição e 
                categoria!" ,"error" , "back");
            }


        } else {
            $message->setMessage("Informações inválidas!.", "error", "index.php");
        }    
    } else {

    $message->setMessage("Informações inválidas!", "error", "index.php");

    } 










} else {

    $message->setMessage(" Informações inválidas!!!" ,"error" , "index.php");
}
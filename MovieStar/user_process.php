<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("models/Message.php");
require_once("models/liberty.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

//Resgata o  tipo do formulario

$type = filter_input(INPUT_POST, "type");

//Atualizar usuário
if ( $type === "update") {

$userData = $userDao->verifytoken();

$name = filter_input(INPUT_POST, "name");
$lastname = filter_input(INPUT_POST, "lastname");
$email = filter_input(INPUT_POST, "email");
$bio = filter_input(INPUT_POST, "bio");

// criar um novo objeto de usuário
$user = new User();

//Preencher os dados do usuário
$userData->name = $name;
$userData->lastname = $lastname;
$userData->email = $email;
$userData->bio = $bio;

//Upload da imagem
  if(isset($_FILES['pic']))
  {
      $ext = strtolower(substr($_FILES['pic']['name'],-4));
      $imagetypes = [".jpeg",".jpg",".png"];
      if (in_array($ext, $imagetypes)) {
          $new_name = $user->imageGenerateName(). $ext; //Definindo um novo nome para o arquivo
          $dir = './img/users/'; //Diretório para uploads   
          move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$new_name);                         
          $userData->image = $new_name; 
      }
      else
      {
        $message->setMessage(" Tipo inválido de imagem, insera imagem formatado: png ; jpg ou jpeg!" ,"error" , "back");
      }                    
  }
  else {
      $message->setMessage(" Tipo inválido de imagem, insera imagem formatado: png ; jpg ou jpeg!" ,"error" , "back");
  }

 


$userDao->update($userData);


//Atualizar senha do usuário 
} else if($type === "changepassword") {
  //Preencher os dados do usuário
  $password = filter_input(INPUT_POST, "password");
  $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

  $userData = $userDao->verifytoken();
  $id = $userData->id;

  if ($password === $confirmpassword) {
    $user = new User();

    $finalpassword = $user->generatePassword($password);

    $user->password = $finalpassword;
    $user->id = $id;

    $userDao->ChangePassword($user);

  } else {
    $message->setMessage(" As senhas não são iguais!" ,"error" , "back");
  }   


} else {
    $message->setMessage(" Informações inválidas" ,"error" , "index.php");
}

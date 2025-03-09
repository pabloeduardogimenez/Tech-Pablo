<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("models/Message.php");
require_once("models/liberty.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

$funcaotexto = new FuncaoTexto;

// resgataa o tipo do formulario
$type = filter_input(INPUT_POST, "type");
//Verifica do tipo de formulario

if($type === "register"){
    $name = filter_input(INPUT_POST, "name");  
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
    /*if ($funcaotexto->LowerCase($password)){
        echo $password . "<br>";
    } else {
        $message->setMessage("As senhas não possuir letras minusculas, digite novamemte.". $password , 
        "error", "back");    
    }*/

     // Verificação de dados mínimos
    if ($name && $lastname && $email && $password) {
        if ($password === $confirmpassword){
                      
            if($userDao->findByEmail($email) === false){         

                $user = new User();

                // criação de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;
                $auth = true;

                $userDao->create($user, $auth);
                

            } else {
                $message->setMessage("Usuário já cadastrado, tente outro e-mail." , "error", "back");     
            }
        } else {
            $message->setMessage("As senhas não iguais, digite novamemte." , "error", "back");    
        }  
        //Senha têm menos de 6 caracteres     

    } else {
        //Enviar uma msg de erro, de dados faltantes
        $message->setMessage("Por favor,preencha todos os campos." , "error", "back");

    }

} else if ($type ==="login"){

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    // Tentar autenticar usuário
    if($userDao->authenticateUser($email, $password)){

         $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");
        
        //Redireciona o usuário , caso não conseguir autenticar
    } else {

        $message->setMessage("Usuário e/ou senha incorretas." , "error", "back");
    }

} else {
    $message->setMessage("Informações inválidas." , "error", "index.php");
}






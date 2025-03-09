<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/liberty.php");

$user = new User();

$userDao = new UserDao($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

?>
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Filme</h1>
            <p class="page-description">Adicione sua crítica e compartilhe com o mundo!</p>
            <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST"
            enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="title"> Título:</label>
                    <input type="text" class="form-control" id="title" name="title" 
                    placeholder="Digite o título do seu filme">
                </div>           
                <div class="form-group">                	
                    <label for="image"> Imagem:</label>
                    <input type="file" class="form-control-file" name="pic" id="image" accept="image/*" >          
                </div>
                <div class="form-group">
                    <label for="length"> Duração:</label>
                    <input type="text" class="form-control" id="length" name="length" 
                    placeholder="Digite o duração do filme">
                </div>  
                <div class="form-group">
                    <label for="category"> Categoria:</label>
                    <select name="category" id="category" class="form-control">
                        <option value=""> Selecione</option>
                        <option value="Acão"> Ação</option>
                        <option value="Drama"> Drama</option>
                        <option value="Comédia"> Comédia</option>
                        <option value="Fantasia"> Fantasia</option>
                        <option value="Ficção"> Ficção</option>
                        <option value="Romance"> Romance</option>
                    </select>
                </div>  
                <div class="form-group">
                    <label for="trailer"> trailer:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" 
                    placeholder="insira o link do trailer">
                </div>  
                <div class="form-group">
                    <label for="description"> descriçao:</label>
                    <textarea name="description" id="description" rows="5" class="form-control" 
                    placeholder="Descreva o seu filme..."></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar filme">                
            </form>       
        </div>
    </div>
<?php
require_once("templates/footer.php");
?>
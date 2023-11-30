<?php
session_start();
require_once "conexao.php";
require '../repositorio/ViagemRepositorio.php';
require '../modelo/Viagem.php';
// ...

//$codigo = rand(0, 100000);
$viagemrepositorio = new ViagemRepositorio($conn);

if (isset($_POST['editar'])){
    $viagem = new Viagem($_POST['id'], 
    $_POST['tipo'], $_POST['nome'], $_POST['preco']);

    //se a imagem foi carregada
    if (isset($_FILES['imagem']['name']) && ($_FILES['imagem']['error'] == 0)){
        $testeImagem = true;
        $viagem->setImagem(uniqid() . $_FILES['imagem']['name']);
        move_uploaded_file($_FILES['imagem']['tmp_name'], $viagem->getImagemDiretorio());
    }elseif ($_FILES['imagem']['error'] == UPLOAD_ERR_NO_FILE){
      $viagem->setImagem('');
    }

  
    $imagem = $_FILES['imagem']['name'];
    $imagemError = $_FILES['imagem']['error'];
    
    $viagemRepositorio->atualizarProduto($viagem);
  //  header("Location: ../visao/admin.php?codedit=$codigo");
    $nomeusuario = $_POST['nomeusuario'];
    $usuario = $_POST['usuario'];
    echo "<form id='redirectForm' action='../visao/admin.php?imagemNome={$imagem}&testeError={$imagemError}&teste={$teste}' method='POST'>";
    echo "<input type='hidden' name='id' value='{$_POST['id']}'>";
    echo "<input type='hidden' name='tipo' value='{$_POST['tipo']}'>";
    echo "<input type='hidden' name='nome' value='{$_POST['nome']}'>";
    echo "<input type='hidden' name='nomeusuario' value='{$nomeusuario}'>";
    echo "<input type='hidden' name='usuario' value='{$usuario}'>";
    echo "<input type='hidden' name='preco' value='{$_POST['preco']}'>";
    echo "</form>";
    echo "<script>document.getElementById('redirectForm').submit();</script>";



}
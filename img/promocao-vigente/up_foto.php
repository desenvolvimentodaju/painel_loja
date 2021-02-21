<?php

    // Conexão com o banco de dados
    include_once('../../conn/conn.php');
    // $conn = @mysql_connect("localhost", "usuario", "senha") or die ("Problemas na conexão.");
    // $db = @mysql_select_db("banco", $conn) or die ("Problemas na conexão");

    // Se o usuário clicou no botão cadastrar efetua as ações
    if (isset($_POST['salvar_foto'])) {

        // Recupera os dados dos campos
        $foto = $_FILES['foto_promocao'];
        var_dump($foto);
        // Se a foto estiver sido selecionada
        if (!empty($foto["name"])) {
        
            // Largura máxima em pixels
            $largura = 200;
            // Altura máxima em pixels
            $altura = 180;
            // Tamanho máximo do arquivo em bytes
            $tamanho = 1000000000;

            $error = array();

            // Verifica se o arquivo é uma imagem
            if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
                $error[1] = "Isso não é uma imagem.";
            }

            // Pega as dimensões da imagem
            $dimensoes = getimagesize($foto["tmp_name"]);
        
            // Verifica se a largura da imagem é maior que a largura permitida
            if($dimensoes[0] > $largura) {
                $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
            }

            // Verifica se a altura da imagem é maior que a altura permitida
            if($dimensoes[1] > $altura) {
                $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
            }
        
            // Verifica se o tamanho da imagem é maior que o tamanho permitido
            if($foto["size"] > $tamanho) {
                $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
            }

            // Se não houver nenhum erro
            if (count($error) == 0) {
            
                // Pega extensão da imagem
                preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

                // Gera um nome único para a imagem
            
                // $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
                $nome_imagem = md5("foto-promocao") . "." . $ext[1];

                // Caminho de onde ficará a imagem
                // $caminho_imagem = "img/promocao-vigente".$nome_imagem;
                $caminho_imagem = $nome_imagem;

                // Cria permissão na pasta
                chmod ("img/promocao-vigente", 0777);
                // Faz o upload da imagem para seu respectivo caminho
                move_uploaded_file($foto["tmp_name"], $caminho_imagem);
        
                // Insere os dados no banco
                $sql = mysql_query("INSERT INTO `foto_promocao`(`id`, `caminho_img`) VALUES (NULL,'".$caminho_imagem."')");
        
                // Se os dados forem inseridos com sucesso
                if ($sql){
                    echo "Imagem salva com sucesso.";
                }
            }
    
            // Se houver mensagens de erro, exibe-as
            if (count($error) != 0) {
                foreach ($error as $erro) {
                    echo "<script> alert('".$erro."') </script>";
                }
            }
        }else{
            echo "<script> alert('Selecione uma foto') </script>";
        }
    }
?>
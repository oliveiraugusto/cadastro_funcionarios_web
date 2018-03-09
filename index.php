<?php
namespace pdo;

include './Funcionario.php';

$conexao = new \PDO("mysql:host=localhost;dbname=cesar_aulas", "cesar", "024860");

$f = new Funcionario($conexao);

?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Funcionários</title>
        
        <!-- JQuery e Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        
        <!-- My Style -->
        <style type="text/css">
            h1, p, input {text-align: center; font-weight: bold;}
            .modal-content {max-width: 850px; padding: 40px; margin: 20px auto;}
            #cadastro {min-height: 500px;}
            #funcionario {max-width: 685px; padding: 40px; margin: 20px auto; min-height: 230px;}
            .dadosFuncioario {float:left; width: 200px;}
            .botoesFuncionario {float:left; margin-top: 20px; margin-left: 200px; }
            th {font-weight: bold; text-align: center;}
            td {text-align: center;}
        </style>
        
        <script type="text/javascript">
            function passarDados(valor)
            {
                var id = document.getElementById('id'+valor).innerHTML;
                var chapa = document.getElementById('chapa'+valor).innerHTML;
                var nome = document.getElementById('nome'+valor).innerHTML;
                var setor = document.getElementById('setor'+valor).innerHTML;
                var cargo = document.getElementById('cargo'+valor).innerHTML;
                var salario = document.getElementById('salario'+valor).innerHTML;
                
                //alert(id+"\n"+chapa+"\n"+nome+"\n"+setor +"\n"+cargo+"\n"+salario);
                
                document.getElementsByName('id')[0].value = id;
                document.getElementsByName('chapa')[0].value = chapa;
                document.getElementsByName('nome')[0].value = nome;
                document.getElementsByName('setor')[0].value = setor;
                document.getElementsByName('cargo')[0].value = cargo;
                document.getElementsByName('salario')[0].value = salario;
                
                $('html, body').animate({scrollTop:0}, 'slow');
            }
        </script>
    </head>
    <body>
        <div id="cadastro" class="modal-content">
            <h1>Cadastro de Funcionarios</h1>
            
            <div id="funcionario" class="modal-content">
                <form method="GET" action=<?php $_SERVER['PHP_SELF']; ?> >
                <div class="dadosFuncioario">
                    <p>ID</p>
                    <input type="text" name="id" readonly="">
                </div>
                
                <div class="dadosFuncioario">
                    <p>CHAPA</p>
                    <input type="text" name="chapa" autofocus="">
                </div>
                
                <div class="dadosFuncioario">
                    <p>NOME</p>
                    <input type="text" name="nome">
                </div>
                
                <div class="dadosFuncioario">
                    <p>SETOR</p>
                    <input type="text" name="setor">
                </div>
                
                <div class="dadosFuncioario">
                    <p>CARGO</p>
                    <input type="text" name="cargo">
                </div>
                
                <div class="dadosFuncioario">
                    <p>SALARIO</p>
                    <input type="text" name="salario">               
                </div>
                
                <div class="botoesFuncionario">
                    <button class="btn btn-danger" name="opcao" value="deletar">Deletar</button>
                    <button class="btn btn-warning" name="opcao"  value="alterar">Atualizar</button>
                    <button class="btn btn-success" name="opcao"  value="inserir">Inserir</button>
                </div>
                </form>
            </div>
            
            <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>CHAPA</th>
                    <th>NOME</th>
                    <th>SETOR</th>
                    <th>CARGO</th>
                    <th>SALARIO</th>
                    <th colspan="2">OPÇÕES</th>
                </thead>
                
                <tbody>
                    <?php
                        $funcionario = $f->listar();
                        $total = count($funcionario);
                    
                        for ($i = 0; $i < $total; $i++)
                        {
                            echo "<tr onclick='passarDados(&quot;Info$i&quot;);'>";
                                echo "<td id='idInfo$i'>".$funcionario[$i]['id']."</td>";
                                echo "<td id='chapaInfo$i'>".$funcionario[$i]['chapa']."</td>";
                                echo "<td id='nomeInfo$i'>".$funcionario[$i]['nome']."</td>";
                                echo "<td id='setorInfo$i'>".$funcionario[$i]['setor']."</td>";
                                echo "<td id='cargoInfo$i'>".$funcionario[$i]['cargo']."</td>";
                                echo "<td id='salarioInfo$i'>".$funcionario[$i]['salario']."</td>";
                                echo "<td><a href='#' class='btn btn-primary'>Selecionar</a></td>";
                            echo "</tr>";
                        }
                        
                    ?>
                </tbody> 
            </table>
        </div>
    </body>
</html>

<?php
switch($_GET['opcao'])
{
    case "inserir" :
    if(isset($_GET['chapa']) && isset($_GET['nome']) && 
             isset($_GET['cargo'])&& isset($_GET['setor']) && 
                 isset($_GET['salario']) && isset($_GET['salario'])
             )
     {   
         if($_GET['chapa'] == "" || $_GET['nome'] == "" || 
          $_GET['cargo'] == "" || $_GET['setor'] == "" || 
          $_GET['salario'] == "")
          {
              echo "<script>alert('Não deixe os campos em branco!'); "
              . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios');</script>";
          }
         else if(
         $f->inserir($_GET['chapa'], $_GET['nome'], 
                 $_GET['cargo'], $_GET['setor'], $_GET['salario']) > 0)
         {
             echo "<script>alert('Dados gravados com sucesso!'); "
             . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios'); "
             . "document.location.reload();</script>";
         }
         else 
         {
             echo "<script>alert('Erro na gravação dos dados!')"
             . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios');</script>";
         }      
     }
     break;
     
    case "deletar" :
        if(isset($_GET['id']) && isset($_GET['opcao']))
     {   
         if($_GET['id'] == "" || $_GET['opcao'] == "")
          {
              echo "<script>alert('Selecione um registro para deletar!'); "
              . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios');</script>";
          }
         else if($f->deletar($_GET['id']) > 0)
         {
             echo "<script>alert('Dados fora removidos com sucesso!'); "
             . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios'); "
             . "document.location.reload();</script>";
         }
         else 
         {
             echo "<script>alert('Erro na gravação dos dados!')"
             . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios');</script>";
         }      
     }
        break;
    
    case "alterar" :
            if(isset($_GET['chapa']) && isset($_GET['nome']) && 
             isset($_GET['cargo'])&& isset($_GET['setor']) && 
                 isset($_GET['salario']) && isset($_GET['salario'])
             )
     {   
         if($_GET['id'] == "" ||$_GET['chapa'] == "" || $_GET['nome'] == "" || 
          $_GET['cargo'] == "" || $_GET['setor'] == "" || 
          $_GET['salario'] == "" || $_GET['opcao'] == "")
          {
              echo "<script>alert('Não deixe os campos em branco!'); "
              . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios');</script>";
          }
         else if($f->atualizar($_GET['id'], $_GET['chapa'], 
                    $_GET['nome'], $_GET['cargo'], 
                        $_GET['setor'], $_GET['salario']) > 0)
         {
             echo "<script>alert('Dados foram modificados com sucesso!'); "
             . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios'); "
             . "document.location.reload();</script>";
         }
         else 
         {
             echo "<script>alert('Erro na modificação dos dados!')"
             . "window.history.pushState('','', '/TI-24/Cesar/aulas/funcionarios');</script>";
         }      
     }
        break;
}
?>


<?php 
    if ($db->connect_errno) { // Verifica se existe algum erro de conexão com o banco de dados
        echo "Erro na conexão com o banco de dados.";
    }
    if (isset($_POST["cpf"]) && isset($_POST["nome"]) && isset($_POST["sexo"]) && isset($_POST["nascimento"])) { // Verifica se todos os parametros foram fornecidos
        $state = isset($_POST["ativo"]) ? 1 : 0; // Converte a informação em "bool"
        $statement = $db->prepare("INSERT INTO tb_passageiro (cpf, nome, data_nasc, sexo) VALUES (?, ?, ?, ?)"); // Prepara a query para inserção
        if ($statement->bind_param("ssss", $_POST["cpf"], $_POST["nome"], $_POST["nascimento"], $_POST["sexo"])) { // Atribui os valores ao statement e verifica a ocorrência de erros
            if (!$statement->execute()) { // Executa a query e verifica a ocorrência de erros
                echo "Erro na inclusão";
            }
        } else {
            echo "Erro na preparação dos parametros.";
        }
    }
?>
<div id="erro-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">CPF Duplicado</h4>
            </div>
            <div class="modal-body">
                <p>O CPF informado já consta no bando de dados.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<form method="POST" class="form-horizontal">
    <fieldset>
        <legend>Cadastrar passageiro</legend>
        <div class="form-group">
            <label for="cpf" class="control-label col-sm-3">CPF</label>
            <div class="col-sm-4">
                <input type="text" name="cpf" class="form-control" placeholder="Somente números" pattern="\d{11}" required>
            </div>
        </div>
        <div class="form-group">
            <label for="nome" class="control-label col-sm-3">Nome</label>
            <div class="col-sm-9">
                <input type="text" name="nome" placeholder="Nome completo" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label for="sexo" class="control-label col-sm-3">Sexo</label>
            <div class="col-sm-4">
                <select name="sexo" class="form-control" required>
                    <option value="M">Masculino</option>
                    <option value="M">Feminino</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="nascimento" class="control-label col-sm-3">Data de nascimento</label>
            <div class="col-sm-4">
                <input type="date" name="nascimento" class="form-control" required>
            </div>
        </div>
        <button class="btn btn-default pull-right" type="reset">Limpar</button>
        <button class="btn btn-primary pull-right" type="submit">Cadastrar</button>
    </fieldset>
</form>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <h5>Passageiros cadastrados no sistema<h5>
    </div>
    <div class="table-responsive">
        <input type="hidden" name="cpf">
        <table class="table table-responsive table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Nascimento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $db->query("SELECT * FROM tb_passageiro ORDER BY nome"); // Executa uma query e armazena o resultado
                    $index = 1;
                    while ($row = $result->fetch_object()) { // Faz um loop por todas as linhas do resultado, associando a variavel a cada uma delas
                        echo "<tr><th scope='row'>" . $index++ . "</th>";
                        echo "<td>" . $row->cpf . "</td>"; // Acessa o campo
                        echo "<td>" . $row->nome . "</td>";
                        echo "<td>" . ($row->sexo == "M" ? "Masculino" : "Feminino") . "</td>";
                        echo "<td>" . date("d/m/Y", strtotime($row->data_nasc)) . "</td>"; // Converte o valor em data e formata para o padrão brasileiro
                    }
                    $result->close(); // Libera o resultado
                ?>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript">
    $("#passageiros").addClass("active"); // Marca a guia como ativa
    $("input[name=cpf]").focusout(function() { // Evento disparado quando o foco sai do campo CPF
        let value = $(this).val();
        $(".loading").css("display", "block"); // Exibe um overlay bloqueando a interação durante o processamento
        $.ajax({ // Chamada para o arquivo check_duplicate.php para verificar se o CPF ja existe no banco
            url: "./php_scripts/check_duplicate.php", 
            data: { tabela: "passageiro", cpf: value }, 
            type: "POST", 
            cache: false, 
            success: function(data) {
                if (data > 0) { // Caso ele já exista, o form é resetado e é exibido um modal informando que o registro já existe
                    $("#erro-modal").modal("show");
                    $("form").get(0).reset();
                }
            },
            complete: function() {
                $(".loading").css("display", "none"); // Oculta o overlay
            }
        });
    });
</script>

<?php 
    if ($db->connect_errno) {
        echo "Erro na conexão com o banco de dados.";
    }
    if (isset($_POST["cpf"]) && isset($_POST["nome"]) && isset($_POST["sexo"]) && isset($_POST["nascimento"])) {
        $state = isset($_POST["ativo"]) ? 1 : 0;
        $statement = $db->prepare("INSERT INTO tb_passageiro (cpf, nome, data_nasc, sexo) VALUES (?, ?, ?, ?)");
        if ($statement->bind_param("ssss", $_POST["cpf"], $_POST["nome"], $_POST["nascimento"], $_POST["sexo"])) {
            if (!$statement->execute()) {
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
        <button class="btn btn-default col-sm-2 pull-right" type="reset">Limpar</button>
        <button class="btn btn-primary col-sm-2 pull-right" type="submit">Submeter</button>
    </fieldset>
</form>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Passageiros cadastrados no sistema<h4>
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
                    $result = $db->query("SELECT * FROM tb_passageiro ORDER BY nome");
                    $index = 1;
                    while ($row = $result->fetch_object()) {
                        echo "<tr><th scope='row'>" . $index++ . "</th>";
                        echo "<td>" . $row->cpf . "</td>";
                        echo "<td>" . $row->nome . "</td>";
                        echo "<td>" . ($row->sexo == "M" ? "Masculino" : "Feminino") . "</td>";
                        echo "<td>" . date("d/m/Y", strtotime($row->data_nasc)) . "</td>";
                    }
                    $result->close();
                ?>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript">
    $("#passageiros").addClass("active");
    $("input[name=cpf]").focusout(function() {
        let value = $(this).val();
        $.ajax({url: "./php_scripts/check_duplicate.php", data: { tabela: "tb_passageiro", cpf: value }, type: "POST", cache: false}).done(function(data) {
            console.log(data);
            if (data == -1) {
                //erro
            } else if (data > 0) {
                $("#erro-modal").modal("show");
                $("form").get(0).reset();
            } 
        })
    });
</script>

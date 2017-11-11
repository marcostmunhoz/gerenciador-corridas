<?php 
    if ($db->connect_errno) {
        echo "Erro na conexão com o banco de dados.";
    }
    if (isset($_POST["cpf"])) {
        $state = isset($_POST["ativo"]) ? 1 : 0;
        if (isset($_POST["nome"]) && isset($_POST["sexo"]) && isset($_POST["nascimento"]) && isset($_POST["veiculo"])) {
            $statement = $db->prepare("INSERT INTO tb_motorista (cpf, nome, data_nasc, modelo_veic, status, sexo) VALUES (?, ?, ?, ?, ?, ?)");
            if ($statement->bind_param("ssssis", $_POST["cpf"], $_POST["nome"], $_POST["nascimento"], $_POST["veiculo"], $state, $_POST["sexo"])) {
                if (!$statement->execute()) {
                    echo "Erro na inclusão";
                }
            } else {
                echo "Erro na preparação dos parametros.";
            }
        } else {
            $statement = $db->prepare("UPDATE tb_motorista SET status = ? WHERE cpf = ?");
            if ($statement->bind_param("is", $state, $_POST["cpf"])) {
                if (!$statement->execute()) {
                    echo "Erro na atualização";
                }
            } else {
                echo "Erro na preparação dos parametros.";
            }
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
<form method="POST" class="form-horizontal" id="cadastrar_form">
    <fieldset>
        <legend>Cadastrar motorista</legend>
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
                    <option value="m">Masculino</option>
                    <option value="f">Feminino</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="nascimento" class="control-label col-sm-3">Data de nascimento</label>
            <div class="col-sm-4">
                <input type="date" name="nascimento" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label for="veiculo" class="control-label col-sm-3">Veiculo</label>
            <div class="col-sm-6">
                <input type="text" name="veiculo" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-10">
                <div class="checkbox">
                    <label for="ativo">
                        <input type="checkbox" name="ativo" checked> Ativo?
                    </label>
                </div>
            </div>
        </div>
        <button class="btn btn-default col-sm-2 pull-right" type="reset">Limpar</button>
        <button class="btn btn-primary col-sm-2 pull-right" type="submit">Submeter</button>
    </fieldset>
</form>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Motoristas cadastrados no sistema<h4>
    </div>
    <form class="table-responsive" method="POST" id="tabela_form">
        <input type="hidden" name="cpf">
        <table class="table table-responsive table-hover">
            <thead>
                <tr>
                    <th class="col-xs-1">#</th>
                    <th class="col-xs-2">CPF</th>
                    <th>Nome</th>
                    <th class="col-xs-1">Sexo</th>
                    <th class="col-xs-2">Nascimento</th>
                    <th>Veiculo</th>
                    <th class="col-xs-1">Ativo?</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $db->query("SELECT * FROM tb_motorista ORDER BY status DESC, nome");
                    $index = 1;
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        echo "<tr><th scope='row'>" . $index++ . "</th>";
                        echo "<td>" . format_string($row["cpf"], "###.###.###-##") . "</td>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . ($row["sexo"] == "M" ? "Masculino" : "Feminino") . "</td>";
                        echo "<td>" . date("d/m/Y", strtotime($row["data_nasc"])) . "</td>";
                        echo "<td>" . $row["modelo_veic"] . "</td>";
                        echo "<td class='text-center'><input type='checkbox' " . ($row["status"] == 1 ? "checked" : "") . " data-cpf='" . $row["cpf"] . "'></td>"; 
                    }
                    $result->close();
                ?>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript">
    $("#motoristas").addClass("active");
    $("input[name=cpf]").focusout(function() {
        let value = $(this).val();
        $.ajax({url: "./php_scripts/check_duplicate.php", data: { tabela: "tb_motorista", cpf: value }, type: "POST", cache: false}).done(function(data) {
            console.log(data);
            if (data == -1) {
                //erro
            } else if (data > 0) {
                $("#erro-modal").modal("show");
                $("form").get(0).reset();
            } 
        })
    });
    $("table input[type=checkbox]").change(function() {
        $("input[type=hidden][name=cpf]").val($(this).attr("data-cpf"));
        $(this).attr("name", "ativo");
        $("#tabela_form").submit();
    });
</script>
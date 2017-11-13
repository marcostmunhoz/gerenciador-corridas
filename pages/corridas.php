<?php 
    if ($db->connect_errno) {
        echo "Erro na conexão com o banco de dados.";
    }
    if (isset($_POST["motorista"]) && isset($_POST["passageiro"]) && isset($_POST["valor"])) { 
        $statement = $db->prepare("INSERT INTO tb_corrida (id_motorista, valor) VALUES (?, ?)");
        if ($statement->bind_param("sd", $_POST["motorista"], $_POST["valor"])) {
            if (!$statement->execute()) {
                echo "Erro na inclusão";
            } else {
                $insert_id = $db->insert_id;
                $statement = $db->prepare("INSERT INTO tb_corrida_passageiro (id_corrida, id_passageiro) VALUES (?, ?)");
                foreach($_POST["passageiro"] as &$passageiro) {
                    if ($passageiro != "-1") {
                        $statement->bind_param("ii", $insert_id, $passageiro);
                        $statement->execute();
                    }
                }
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
                <h4 class="modal-title">Passageiro ausente</h4>
            </div>
            <div class="modal-body">
                <p>É preciso inserir ao menos 1 passageiro na corrida.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<form method="POST" class="form-horizontal">
    <fieldset>
        <legend>Cadastrar corrida</legend>
        <div class="form-group">
            <label for="motorista" class="control-label col-sm-3">Motorista</label>
            <div class="col-sm-6">
                <select name="motorista" class="form-control" required>
                    <?php
                        $motoristas = $db->query("SELECT * FROM tb_motorista WHERE status = 1 ORDER BY nome");
                        while ($motorista = $motoristas->fetch_object()) {
                            echo "<option value='" . $motorista->id . "'>" . $motorista->nome . " - " . $motorista->cpf . "</option>";
                        }
                        $motoristas->free_result();
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group" id="passageiro1">
            <label for="passageiro" class="control-label col-sm-3">Passageiro 1</label>
            <div class="col-sm-6">
                <select name="passageiro[]" class="form-control" required>                    
                    <option value="-1">-----</option>
                    <?php
                        $passageiros = $db->query("SELECT * FROM tb_passageiro ORDER BY nome");
                        while ($passageiro = $passageiros->fetch_object()) {
                            echo "<option value='" . $passageiro->id . "'>" . $passageiro->nome . " - " . $passageiro->cpf . "</option>";
                        }
                        $passageiros->free_result();
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group" id="passageiro2">
            <label for="passageiro" class="control-label col-sm-3">Passageiro 2</label>
            <div class="col-sm-6">
                <select name="passageiro[]" class="form-control" disabled>
                    <option value="-1">-----</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="passageiro3">
            <label for="passageiro" class="control-label col-sm-3">Passageiro 3</label>
            <div class="col-sm-6">
                <select name="passageiro[]" class="form-control" disabled>
                    <option value="-1">-----</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="passageiro4">
            <label for="passageiro" class="control-label col-sm-3">Passageiro 4</label>
            <div class="col-sm-6">
                <select name="passageiro[]" class="form-control" disabled>
                    <option value="-1">-----</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="valor" class="control-label col-sm-3">Valor</label>
            <div class="col-sm-4">
                <div class="input-group">
                    <div class="input-group-addon">R$</div>
                    <input type="number" name="valor" min="1" step="any" class="form-control text-right" required>
                </div>
            </div>
        </div>
        <button class="btn btn-default pull-right" type="reset">Limpar</button>
        <button class="btn btn-primary pull-right" type="submit">Cadastrar</button>
    </fieldset>
</form>
<hr>
<div class="panel panel-default">
    <div class="panel-heading">
        <h5>Corridas cadastradas no sistema<h5>
    </div>
    <div class="table-responsive">
        <input type="hidden" name="cpf">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Motorista</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $corridas = $db->query("SELECT * FROM tb_corrida JOIN tb_motorista ON tb_corrida.id_motorista = tb_motorista.id");
                    while ($corrida = $corridas->fetch_object()) {
                        echo "<tr><th scope='row'>" . $corrida->id_corrida . "</th>";
                        echo "<td>" . $corrida->nome . "</td>";
                        echo "<td>R$ " . number_format($corrida->valor, 2, ",", ".") . "</td>";
                        echo "<tr class='child_row'><td></td><td colspan='2'><table class='table table-bordered'>";
                        echo "<thead><th>CPF</th><th>Nome do passageiro</th></thead><tbody>";
                        $passageiros = $db->query("SELECT * FROM tb_corrida_passageiro AS tb_A JOIN tb_passageiro AS tb_B ON " .
                            "tb_A.id_passageiro = tb_B.id WHERE tb_A.id_corrida = " . $corrida->id_corrida);
                        while ($passageiro = $passageiros->fetch_object()) {
                            echo "<tr><td>" . $passageiro->cpf . "</td><td>" . $passageiro->nome . "</td></td>";
                        }
                        $passageiros->close();
                        echo "</tbody></table></td></tr>";
                    }
                    $corridas->close();
                ?>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript">
    $("#corridas").addClass("active");
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
    $("#passageiro1 select").change(function() {
        $("#passageiro2 select, #passageiro3 select, #passageiro4 select").each(function(index, el) {
            disableSelect(el);
        });
        let selected = $(this).children("option:selected");
        if (selected.val() != "-1") {
            $("#passageiro2 select").empty().attr("disabled", false).append($(this).children(":not(:selected)").clone());
        } 
    });
    $("#passageiro2 select").change(function() {
        $("#passageiro3 select, #passageiro4 select").each(function(index, el) {
            disableSelect(el);
        });
        let selected = $(this).children("option:selected");
        if (selected.val() != "-1") {
            $("#passageiro3 select").empty().attr("disabled", false).append($(this).children(":not(:selected)").clone());
        } 
    });
    $("#passageiro3 select").change(function() {
        $("#passageiro4 select").each(function(index, el) {
            disableSelect(el);
        });
        let selected = $(this).children("option:selected");
        if (selected.val() != "-1") {
            $("#passageiro4 select").empty().attr("disabled", false).append($(this).children(":not(:selected)").clone());
        } 
    });
    $("form").submit(function(event) {
        if ($("#passageiro1 select").val() == "-1") {
            event.preventDefault();
            $("#erro-modal").modal("show");
        }
    }).on("reset", function() {
        $("#passageiro2 select, #passageiro3 select, #passageiro4 select").each(function(index, el) {
            disableSelect(el);
        });
    });
    function disableSelect(select) {
        select.selectedIndex = 0;
        select.disabled = true;
    }
</script>
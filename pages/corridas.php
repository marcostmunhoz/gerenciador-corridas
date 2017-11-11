<?php 
    if ($db->connect_errno) {
        echo "Erro na conexão com o banco de dados.";
    }
    if (isset($_POST["motorista"]) && isset($_POST["passageiro"]) && isset($_POST["valor"])) {        
        $statement = $db->prepare("INSERT INTO tb_corrida (id_motorista, id_passageiro, valor) VALUES (?, ?, ?)");
        if ($statement->bind_param("ssd", $_POST["motorista"], $_POST["passageiro"], $_POST["valor"])) {
            if (!$statement->execute()) {
                echo "Erro na inclusão";
            }
        } else {
            echo "Erro na preparação dos parametros.";
        }
    }
?>
<form method="POST" class="form-horizontal" id="cadastrar_form">
    <fieldset>
        <legend>Cadastrar corrida</legend>
        <div class="form-group">
            <label for="motorista" class="control-label col-sm-3">Motorista</label>
            <div class="col-sm-6">
                <select name="motorista" class="form-control" required>
                    <?php
                        $motoristas = $db->query("SELECT * FROM tb_motorista WHERE status = 1 ORDER BY nome");
                        while ($motorista = $motoristas->fetch_array(MYSQLI_ASSOC)) {
                            echo "<option value='" . $motorista["id"] . "'>" . $motorista["nome"] . " - " . $motorista["cpf"] . "</option>";
                        }
                        $motoristas->free_result();
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="passageiro" class="control-label col-sm-3">Passageiro</label>
            <div class="col-sm-6">
                <select name="passageiro" class="form-control" required>
                    <?php
                        $passageiros = $db->query("SELECT * FROM tb_passageiro ORDER BY nome");
                        while ($passageiro = $passageiros->fetch_array(MYSQLI_ASSOC)) {
                            echo "<option value='" . $passageiro["id"] . "'>" . $passageiro["nome"] . " - " . $passageiro["cpf"] . "</option>";
                        }
                        $passageiros->free_result();
                    ?>
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
                    <th>Motorista</th>
                    <th>Passageiro</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $db->query("SELECT id_corrida, id_motorista, id_passageiro, valor, tb_motorista.nome AS motorista, tb_passageiro.nome AS " . 
                     "passageiro FROM tb_corrida JOIN tb_motorista ON id_motorista = tb_motorista.id JOIN tb_passageiro ON id_passageiro = tb_passageiro.id");
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        echo "<tr><th scope='row'>" . $row["id_corrida"] . "</th>";
                        echo "<td>" . $row["motorista"] . "</td>";
                        echo "<td>" . $row["passageiro"] . "</td>";
                        echo "<td>R$ " . number_format($row["valor"], 2, ",", ".") . "</td>";
                    }
                    $result->close();
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
</script>
<?php
include_once("templates/header.php");
include_once("process/pizza.php");
?>

<div id="main-banner">
    <h1>Faça seu pedido</h1>
</div>
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Monte a pizza como desejar</h2>
                <form action="process/pizza.php" method="POST" id="pizza-form">
                    <div class="form-group">
                        <label for="borda">Borda:</label>
                        <select name="borda" id="borda" class="form-control">
                            <option value="">Selecione a borda da pizza</option>
                            <?php foreach ($bordas as $borda) : ?>
                                <option value="<?php echo $borda["id"] ?> "><?php echo $borda["tipo_borda"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="massa">Massa:</label>
                        <select name="massa" id="massa" class="form-control">
                            <option value="">Selecione a massa da pizza</option>
                            <?php foreach ($massas as $massa) : ?>
                                <option value="<?php echo $massa["id"] ?>"><?php echo $massa["tipo"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sabores">Sabores: (máximo 3)</label>
                        <select multiple name="sabores[]" id="sabores" class="form-control">
                            <option value="">Selecione os sabores da pizza</option>
                            <?php foreach ($sabores as $sabor) : ?>
                                <option value="<?php echo $sabor["id"] ?>"><?php echo $sabor["nome"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Fazer pedido">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>
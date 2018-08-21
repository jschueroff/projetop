
<?php
$estado=$_GET['estado'];
echo $estado;

if ($estado==1){ ?>
<select name="cidade" size=1>
<option value="">selecione sua cidade</option>
<option> Belo Horizonte </option>
<option> Uberlândia </option>
<option> Ipatinga </option>
<option> Juiz de Fora </option>
<option> Pequi </option>
</select>
<?php }
if ($estado==2){ ?>
<select name="cidade" size=1>
<option value="">selecione sua cidade</option>
<option> São Paulo </option>
<option> Santos </option>
<option> Campinas </option>
<option> Guarulhos </option>
<option> Osasco </option>
</select>
<?php
}
if ($estado==3){ ?>
<select name="cidade" size=1>
<option value="">selecione sua cidade</option>
<option> Porto Alegre </option>
<option> Pelotas </option>
<option> Caxias do Sul </option>
<option> Nova Hamburgo </option>
<option> Canoas </option>
</select>
<?php }

if ($estado==4){ ?>
<select name="cidade" size=1>
<option value="">selecione sua cidade</option>
<option> Manaus </option>
<option> Manacapuru </option>
<option> Tefé </option>
<option> Parintins </option>
<option> Itacoatiara </option>
</select>
<?php }

if ($estado==5){ ?>
<select name="cidade" size=1>
<option value="">selecione sua cidade</option>
<option> Recife </option>
<option> Olinda </option>
<option> Caruaru </option>
<option> Paulista </option>
<option> Petrolina </option>
</select>
<?php }
?>
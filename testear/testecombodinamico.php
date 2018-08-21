<html>
<Script Language="JavaScript">
function getStates(what) {
if (what.selectedIndex != '') {
var estado = what.value;
document.location=('teste52.php?estado=' + estado);
}
}
</Script>
<body>




<html>
<body>
<select name="select" size=1 value=2 onChange="getStates(this);">
<option value="">selecione o estado</option>
<option value="1"> Minas Gerais </option>
<option value="2"> São Paulo </option>
<option value="3"> Rio Grande do Sul </option>
<option value="4"> Amazonas </option>
<option value="5"> Pernambuco</option>
</select>
</body>
</html> 
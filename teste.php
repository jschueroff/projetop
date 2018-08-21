<!--<html>
    <body>
        <script>
            function calcular() {
                
                
                var valor1 = parseInt(document.getElementById('txt1').value, 10);
                var valor2 = parseInt(document.getElementById('txt2').value, 10);
                document.getElementById('result').value = valor1 + valor2;
            }
            function myFunction() {
                var valor1 = parseFloat(document.getElementById("txt1").value, 10);
                
                var valor2 = parseFloat(document.getElementById("txt2").value, 10);
               
                document.getElementById('result').value = valor1 + valor2;
                
                
            }
        </script>
        
        $(this).parseInt(document.getElementById('txt1').value, 10).replace('.',',');
        
        <input id="txt1" type="text" value="1" onkeyup="myFunction()"/>
        <input id="txt2" type="text" value="1" onblur="calcular()"/>
        <input id="txt2" type="text" value="1" onkeyup="myFunction()"/>

        <input id="result" type="text"/>
    </body>
</html>-->
<?php
 echo  date('y', strtotime(date("y-m-d\TH:i:sP")));
?>
<html>
<head>
<script type="text/javascript">
function id( el ){
        return document.getElementById( el );
}
function getMoney( el ){
        var money = id( el ).value.replace( ',', '.' );
        return parseFloat( money )*10;
}
function soma()
{
 
        var total = getMoney('campo1')*getMoney('campo2');
        //id('campo4').value = 'R$ '+total/100;
         document.getElementById('result').value = total.value = 'R$ '+total/100;
         
}
</script>
</head>
<body>
        <form action="" method="">
            <input name="campo1" id="campo1" onkeyup="soma()" value="0.00"/>N1<br />
                <input name="campo2" id="campo2" onkeyup="soma()" value="70.00" />N2<br />
               
                
                <input id="result" type="text"/>Soma
                
        </form>
</body>
</html>
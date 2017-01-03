//Sistema de ajax para calcular de uma maneira dimanica as horas
function javascript(arg){
    var result = "working_hours";
    var input1 = document.repair_form.initial_date.value;
    var input2 = document.repair_form.final_date.value;
    var url = "core/functions/class.config.php?code="+arg+"&input1="+input1+"&input2="+input2;
    if (result==""){
        document.getElementById(result).innerHTML="";
        return;
    }
    var xmlhttp;
    if (window.XMLHttpRequest){
        // codigo para IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }else{
        // codigo para IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
				spl = xmlhttp.response.split("<!");
				
            document.getElementById("working_hours").value = spl[0];
            }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

//Verificação de um select. Caso valor seja superior 0 vai proibir escrita em alguns textbox
function verificaOpcao( valor ){
    if( valor > 0 ){
        document.getElementById("client").disabled = true;
        document.getElementById("client1").disabled = true;
        document.getElementById("client2").disabled = true;
    }else if( valor == 0 ){
        document.getElementById("client").disabled = false;
        document.getElementById("client1").disabled = false;
        document.getElementById("client2").disabled = false;
    }
}

//VErificar informação do SQL para selecionar automaticamente
function seleciona(strText){
    objSelect = document.getElementById('produtoID');
    for(i=0; i<objSelect.options.length; i++){
        if (objSelect.options[i].value == strText){
            objSelect.options[i].selected = true;
        }
    }
}



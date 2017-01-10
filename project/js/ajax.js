//Sistema de ajax para calcular de uma maneira dimanica as horas
function javascript(arg) {
    var result = "working_hours";

    var input1 = document.getElementById("initial_date").value;
    var input2 = document.getElementById("final_date").value;
    var url = "core/functions/function.php?code=" + arg + "&input1=" + input1 + "&input2=" + input2;
    if (result == "") {
        document.getElementById(result).innerHTML = "";
        return;
    }
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // codigo para IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // codigo para IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            spl = xmlhttp.response.split("<!");

            document.getElementById("working_hours").value = spl[0];
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

//Verificação de um select. Caso valor seja superior 0 vai proibir escrita em alguns textbox
function verificaOpcao(valor) {
    if (valor > 0) {
        document.getElementById("Name").disabled = true;
        document.getElementById("Address").disabled = true;
        document.getElementById("Email").disabled = true;
        document.getElementById("Phone").disabled = true;
    } else if (valor == 0) {
        document.getElementById("Name").disabled = false;
        document.getElementById("Address").disabled = false;
        document.getElementById("Email").disabled = false;
        document.getElementById("Phone").disabled = false;
    }
}

//VErificar informação do SQL para selecionar automaticamente
function seleciona(strText) {
    objSelect = document.getElementById('produtoID');
    for (i = 0; i < objSelect.options.length; i++) {
        if (objSelect.options[i].value == strText) {
            objSelect.options[i].selected = true;
        }
    }
}

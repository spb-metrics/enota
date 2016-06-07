
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
function cancelarGuiaLivro($codguia){
	var codigo = $codguia;
	var motivo = "";
	if(false){//confirm box com div
		confirmBox.show('mensagem');
		return false;
	}else{
		while (motivo === "")// prompt de pergunta e solicitacao de motivo
		motivo = prompt("Insira o motivo do cancelamento da guia: ", "");
		var url = 'inc/cancelar_declaracao.ajax.php?codigo='+codigo+'&motivo='+motivo;

		if (motivo !== null) {// se confirmar executa ajax
			ajax({
				url: url,
				espera: function(){
					//document.getElementById('tdCancelar'+cont).innerHTML = '<img src="img/botoes/loading.gif">';
				},
				sucesso: function(){
					var resposta = respostaAjax;
					if (resposta){
						alert('Cancelamento conclu�do!');
                        document.getElementById('btnBuscar').click();
                        //document.getElementById("tdTeste").innerHTML = resposta;
					}
				}
			});
			return true;
		} else {
			return false;
		}
	}
}

function mostraDetalhesRPS(url,retorno){
	document.getElementById(retorno).style.display = 'block';
	ajax({
		url:url,
		espera: function(){
			document.getElementById(retorno).innerHTML = 'Verificando...';
		},
		sucesso: function(){
			document.getElementById(retorno).innerHTML = respostaAjax;		
		}
	});
}

function liberaRPS(url,idCampoLimite,hdLimite,retorno){
	var novoLimite = parseInt(document.getElementById(idCampoLimite).value);
	var limiteAntigo = parseInt(document.getElementById(hdLimite).value);
	if(novoLimite > 0){
		if(novoLimite > limiteAntigo){
			ajax({
				url:url+'&novoLimite='+novoLimite,
				espera: function(){
					document.getElementById(retorno).innerHTML = 'Liberando...';
				},
				sucesso: function(){
					document.getElementById(retorno).innerHTML = '';
					alert('Novo limite de RPS liberado!');
					document.getElementById('divDetalhesRPS').style.display = 'none';
					document.getElementById('btBuscar').click();
				}
			});
		}else{
			alert('O novo limite deve ser maior que o Limite anterior!');
			return false;
		}
	}else{
		alert('O campo limite deve estar preenchido com o novo limite de RPS!');
		return false;
	}
}

function recusaRPS(url){
	if(confirm('Deseja recusar esta solicita��o?')){
		ajax({
			url:url,
			sucesso: function(){

				document.getElementById('divDetalhesRPS').style.display = 'none';
				document.getElementById('btBuscar').click();
				
			}
		});
	}
}

function comunicarPartesRPS(url,comunicado){
	if(comunicado == "S"){
		if(confirm('Voc� j� comunicou esta solicita��o, deseja comunicar novamente?')){
			ajax({
				url:url,
				espera: function(){
					conteudoSpanComunicar = document.getElementById('spanComunicar').innerHTML;
					document.getElementById('spanComunicar').innerHTML = 'Comunicando...';
				},
				sucesso: function(){
					document.getElementById('spanComunicar').innerHTML = conteudoSpanComunicar;
					if(respostaAjax == 1){
						alert("Solicitante comunicado");
					}else{
						alert("N�o foi possivel comunicar o solicitante, verifique se o mesmo possui e-mail cadastrado!");
					}
				}
			});
		}
	}else{
		ajax({
			url:url,
			sucesso: function(){
				if(respostaAjax == 1){
					alert("Solicitante comunicado");
					document.getElementById('btBuscar').click();
				}else{
					alert("N�o foi possivel comunicar o solicitante, verifique se o mesmo possui e-mail cadastrado!");
				}
			}
		});
	}
	
}

function mostraDetalhes(codigo,retorno){
	document.getElementById('divDetalhes').style.display = 'block';
	ajax({
		url:'inc/nfe/liberar_detalhes.ajax.php?cod='+codigo+'&a=a',
		espera: function(){
			document.getElementById(retorno).innerHTML = 'Verificando...';
		},
		sucesso: function(){
			id(retorno).innerHTML = respostaAjax;		
		}
	});
}

function ativarCadastro(codigo,retorno){
	ajax({
		url:'inc/nfe/liberar_ativar.ajax.php?codativar='+codigo+'&a=a',
		espera: function(){
			document.getElementById(retorno).innerHTML = 'Verificando...';
		},
		sucesso: function(){
			id(retorno).innerHTML = respostaAjax;
			document.getElementById('divDetalhes').style.display='none';
			alert('Cadastro ativado');
		}
	});
}

function removerCadastro(codigo,retorno){
	ajax({
		url:'inc/nfe/liberar_remover.ajax.php?codremover='+codigo+'&a=a',
		espera: function(){
			document.getElementById(retorno).innerHTML = 'Verificando...';
		},
		sucesso: function(){
			id(retorno).innerHTML = respostaAjax;
			document.getElementById('divDetalhes').style.display='none';
			alert('Cadastro removido');
		}
	});
}


function ValidarDesIssRetido() {
	var total = totalemissores_des;

	if ((!(document.getElementById('cmbAno').value))
			|| (!(document.getElementById('cmbMes').value))) {
		alert('Informe a compet�ncia da declara��o !');
		return false;
	}

	if (!(document.getElementById('txtRazaoNome').value)) {
		alert('Informe sua Raz�oSocial/Nome!');
		return false;
	}
	for (c = 1; total >= c; total--) {

		if ((!(document.getElementById('txtcnpjcpf' + total).value))
				|| (!(document.getElementById('txtNroNota' + total).value))
				|| (!(document.getElementById('txtValIssRetido' + total).value))) {
			alert('Preencha os campos Obrigat�rios para realizar a declara��o!');
			return false;
		}
		if (document.getElementById('hdvalidar' + total).value == 'n') {
			alert('Emissor Digitado n�o consta em nosso sistema, Favor verifique os dados !');
			document.getElementById('txtcnpjcpf' + total).focus();
			return false;
		}
		return true;

	}
}

function SomaIssRetido() {
	var soma = 0;
	var total = totalemissores_des;
	for (c = 1; total >= c; total--) {
		soma += MoedaToDec(document.getElementById('txtValIssRetido' + total).value);
	}
	document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
}

var cont = 0, contservicos = 1, conttbl = 0, totalemissores_des = 0;
function DesTomadores(i) {

	var div = document.getElementById('divEmissores');

	if (i == 'inserir') {
		var contador = conttbl;
		var valorCPF = new Array(conttbl);
		var valorNRONOTA = new Array(conttbl);
		var valorISSRETIDO = new Array(conttbl);
		var valorVALNOTA = new Array(conttbl);

		while (contador > 0) {
			if(document.getElementById('txtcnpjcpf' + contador)){
				if (document.getElementById('txtcnpjcpf' + contador).value) {
					valorCPF[contador] = document
							.getElementById('txtcnpjcpf' + contador).value;
				}
			}
			if(document.getElementById('txtNroNota' + contador)){
				if (document.getElementById('txtNroNota' + contador).value) {
					valorNRONOTA[contador] = document
							.getElementById('txtNroNota' + contador).value;
				}
			}
			if(document.getElementById('txtValNota' + contador)){
				if (document.getElementById('txtValNota' + contador).value) {
					valorVALNOTA[contador] = document
							.getElementById('txtValNota' + contador).value;
				}
			}

			if(document.getElementById('txtValIssRetido' + contador)){
				if (document.getElementById('txtValIssRetido' + contador).value) {
					valorISSRETIDO[contador] = document
							.getElementById('txtValIssRetido' + contador).value;
				}
			}
			contador--;

		}

		conttbl++;
		totalemissores_des++;
		
		if(document.getElementById('divEmissores')){
			var div = document.getElementById('divEmissores');
			div.innerHTML = div.innerHTML
					+ "<table id='tbl"
					+ conttbl+ "' width='100%' border='0'><tr><td width='24%' align=center><font color='#FF0000'>*</font><input onkeydown='return NumbersOnly( event );' onkeyup='CNPJCPFMsk( this );' onblur='ConsultaCnpj(txtcnpjcpf"
					+ conttbl+ ","+ conttbl+ ");' size='18' id='txtcnpjcpf"+ conttbl+ "' name='txtcnpjcpf"
					+ conttbl+ "' class='texto' type='text'></font></td><td width='22%' align=center><font color='#FF0000'>*</font><input name='txtNroNota"
					+ conttbl+ "' id='txtNroNota"
					+ conttbl+ "' size='14' class='texto' type='text'><input type='hidden' id='hdvalidar"
					+ conttbl+ "'></td><td width='29%' align=center><font color='#FF0000'>*</font><input type='text' class='texto' id='txtValNota"
					+ conttbl+ "' name='txtValNota"	+ conttbl+ "' onkeyup='MaskMoeda(this)' size='14'></td><td width='25%' align=center><font color='#FF0000'>*</font><input name='txtValIssRetido"
					+ conttbl+ "' onkeyup='MaskMoeda(this)' onblur='SomaIssRetido();CalculaMultaDes();' id='txtValIssRetido"
					+ conttbl+ "' class='texto' type='text' size='14'></td></tr><tr><td colspan='4'><div id='divtxtcnpjcpf"
					+ conttbl + "' align='center'> </div></td></tr></table>";
		}

		if (contador >= 0) {
			while (contador < conttbl) {
				if (valorCPF[contador]) {
					document.getElementById('txtcnpjcpf' + contador).value = valorCPF[contador];
				}

				if (valorNRONOTA[contador]) {
					document.getElementById('txtNroNota' + contador).value = valorNRONOTA[contador];
				}

				if (valorVALNOTA[contador]) {
					document.getElementById('txtValNota' + contador).value = valorVALNOTA[contador];
				}

				if (valorISSRETIDO[contador]) {
					document.getElementById('txtValIssRetido' + contador).value = valorISSRETIDO[contador];
				}
				contador++;
			}
		}

		if (conttbl > 1) {
			if(document.getElementById('btRemover')){
				document.getElementById('btRemover').disabled = false;
			}
		}

	}

	else if (i == 'deletar') {
		if ((conttbl != 0) && (conttbl != 1)) {
			var tabela = document.getElementById('tbl' + conttbl);
			div.removeChild(tabela);
			conttbl--;
			totalemissores_des--;
		}
		if (conttbl <= 1) {
			document.getElementById('btRemover').disabled = true;
		}
	}

}

function ConsultaCnpj(campo, cont) {
	
	ajax({
		url: 'inc/verificaprestadorcnpj.ajax.php?valor=' + campo.value,
		espera: function(){
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = '<font color="gray">Verificando...</font>';
		},
		sucesso: function() {
			var resposta = respostaAjax;
			if (resposta == 'Emissor n�o cadastrado') {
				document.getElementById('hdvalidar' + cont).value = 'n';
				resposta = '<font color=#ff0000>' + resposta + '</font>';
			} else {
				document.getElementById('hdvalidar' + cont).value = 's';
			}
			// Abaixo colocamos a resposta na div do campo que fez a requisi��o
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = resposta;
		}
	});/*
	// Verificar o Browser
	// Firefox, Google Chrome, Safari e outros
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	}
	// Internet Explorer
	else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = 'inc/verificaprestadorcnpj.ajax.php?valor=' + campo.value;

	req.open("Get", url, true);

	// Quando o objeto recebe o retorno, chamamos a seguinte fun��o;
	req.onreadystatechange = function() {

		// Exibe a mensagem "Verificando" enquanto carrega
		if (req.readyState == 1) {
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = '<font color="gray">Verificando...</font>';
		}

		// Verifica se o Ajax realizou todas as opera��es corretamente
		// (essencial)
		if (req.readyState == 4 && req.status == 200) {
			// Resposta retornada pelo validacao.php
			var resposta = req.responseText;
			if (resposta == 'Emissor n�o cadastrado') {
				document.getElementById('hdvalidar' + cont).value = 'n';
				resposta = '<font color=#ff0000>' + resposta + '</font>';
			} else {
				document.getElementById('hdvalidar' + cont).value = 's';
			}
			// Abaixo colocamos a resposta na div do campo que fez a requisi��o
			document.getElementById('divtxtcnpjcpf' + cont).innerHTML = resposta;
		}

	};
	req.send(null);*/
}

function verificaTomador(campo, cont){
	var cnpj = campo.value;
	if(cnpj!=''){
		ajax({
			url: 'inc/declaracoes/verifica_tomadores.ajax.php?valor='+cnpj,
			espera: function(){
				document.getElementById('tdServ'+cont).innerHTML = 'Verificando...';
			},
			sucesso: function(){
				document.getElementById('tdServ'+cont).innerHTML = respostaAjax;
			}
		});
	}else{
		document.getElementById('tdServ'+cont).innerHTML = '&nbsp;';
	}
}

function GuiaPagamento_TotalISS() {
	if (document.getElementById('ckTodos').checked == true) {
		var aux = document.getElementById('txtTotalIssHidden').value;
		var dados = aux.split("|");
		var soma = 0;

		while (dados[1] >= 0) {
			document.getElementById('ckISS' + dados[1]).checked = true;

			aux = document.getElementById('ckISS' + dados[1]).value;
			valor = aux.split("|");
			document.getElementById('txtCodNota' + dados[1]).value = valor[1];
			soma = parseFloat(soma) + parseFloat(valor[0]);
			dados[1]--;
		}
		document.getElementById('txtTotalIss').value = DecToMoeda(soma);
		CalculaMultaDes();
	} else {
		var aux = document.getElementById('txtTotalIssHidden').value;
		var dados = aux.split("|");
		while (dados[1] >= 0) {
			document.getElementById('ckISS' + dados[1]).checked = false;
			document.getElementById('txtCodNota' + dados[1]).value = '';
			dados[1]--;
		}
		document.getElementById('txtTotalIss').value = DecToMoeda(0);
		CalculaMultaDes();
	}
}

function GuiaPagamento_SomaISS(iss) {
	var valor = iss.value.split("|");
	var numero = iss.id.split("ckISS");
	if (iss.checked == true) {
		var total = MoedaToDec(document.getElementById('txtTotalIss').value);
		total += parseFloat(valor[0]);
		total = total.toFixed(2);
		document.getElementById('txtTotalIss').value = DecToMoeda(total);
		document.getElementById('txtCodNota' + numero[1]).value = valor[1];
		CalculaMultaDes();
	} else {
		var total = MoedaToDec(document.getElementById('txtTotalIss').value);
		var valor = iss.value.split("|");
		total -= parseFloat(valor[0]);
		total = total.toFixed(2);
		document.getElementById('txtTotalIss').value = DecToMoeda(total);
		document.getElementById('txtCodNota' + numero[1]).value = '';
		CalculaMultaDes();
	}

}

function ValidaCkbDec(campo){
	var total = parseInt(document.getElementById(campo).value);
	if(total>0){
		return true;
	}else{
		alert('� necess�rio que escolha ao menos uma declara��o');
		return false;
	}
}//teste se tem pelo penos uma declaracao selecionada para gerar a guia

//declaracao de Recibo de Prestador Autonomo

function ValidarDesTomador() {
	var total = document.getElementById('hdUltima').value;

	if (!(document.getElementById('txtNome').value)) {
		alert('Informe seu Nome!');
		return false;
	}
	for (c = 1; total >= c; total--) {
		if ((!(document.getElementById('txtPrestador' + total).value))
				|| (!(document.getElementById('txtCodigoGuia' + total).value))
				|| (!(document.getElementById('txtValor' + total).value))
				|| (document.getElementById('txtValor' + total).value == '0,00')
				|| (!document.getElementById('txtDataEmissao' + total).value)) {
			alert('Preencha os todos os campos para realizar a declara��o!');
			return false;
		}
		if (document.getElementById('tdNota' + total).innerHTML == '<font color="#ff0000">Emissor n�o cadastrado</font>') {
			alert('Emissor Digitado n�o consta em nosso sistema, Favor verifique os dados!');
			document.getElementById('txtPrestador' + total).focus();
			return false;
		}
		if (document.getElementById('tdNota' + total).innerHTML == '') {
			alert('Verifique Emissor!');
			document.getElementById('txtPrestador' + total).focus();
			return false;
		}
		if (document.getElementById('tdNota' + total).innerHTML == 'Pesquisando...') {
			alert('Pesquisando...');
			document.getElementById('txtPrestador' + total).focus();
			return false;
		}
		if ((document.getElementById('txtDataEmissao' + total).value == '')
				|| ((document.getElementById('txtDataEmissao' + total).value.length != 10))) {
			alert('Preencha a data corretamente (dd/mm/aaa)!');
			document.getElementById('txtDataEmissao' + total).focus();
			return false;
		}
		return true;
	}
}

function CalculaImpostoDes(campoBase, campoAliq, campoImposto, campoIssRetido) {
	var base = MoedaToDec(campoBase.value);
	var aliq;
	if (campoAliq.value == ''){
		aliq = 0;
	}else{
		aliq = parseFloat(campoAliq.value) / 100;
	}
	
	var total = base * aliq;
	
	//testa se tem iss retido na declaracao, se sim recalcula o imposto, se nao continua normal
	if(campoIssRetido !== undefined){
		
		//valor digitado para o iss retido
		var valor_iss_retido = parseFloat(MoedaToDec(campoIssRetido.value));
		
		//nao eh possivel reter mais que o valor do imposto, para nao ficar com o imposto negativo
		if(valor_iss_retido >= total){
			//se for maior que o imposto, o valor retido fica como o total do imposto e o total imposto fica zerado
			campoIssRetido.value = DecToMoeda(total);
			total = 0.00;
		}else{
			//se o iss retido for menor que o total de imposto, subtrai o valor do iss retido do total e conclui a soma
			total = total - valor_iss_retido;
		}
	}
	
	campoImposto.value = DecToMoeda(total);

	SomaImpostosDes();
	CalculaMultaDes();
}//fim CalculaImpostoDes()

function CalculaImpostoRPA(campoBase, campoAliq, campoImposto, campoIssRetido) {
	var base = MoedaToDec(campoBase.value);
	var aliq;
	if (campoAliq.value == ''){
		aliq = 0;
	}else{
		aliq = parseFloat(campoAliq.value);
	}
	var total = aliq;
	
	//testa se tem iss retido na declaracao, se sim recalcula o imposto, se nao continua normal
	if(campoIssRetido !== undefined){
		
		//valor digitado para o iss retido
		var valor_iss_retido = parseFloat(MoedaToDec(campoIssRetido.value));
		
		//nao eh possivel reter mais que o valor do imposto, para nao ficar com o imposto negativo
		if(valor_iss_retido >= total){
			//se for maior que o imposto, o valor retido fica como o total do imposto e o total imposto fica zerado
			campoIssRetido.value = DecToMoeda(total);
			total = 0.00;
		}else{
			//se o iss retido for menor que o total de imposto, subtrai o valor do iss retido do total e conclui a soma
			total = total - valor_iss_retido;
		}
	}
	
	campoImposto.value = DecToMoeda(total);

	SomaImpostosDes();
	CalculaMultaDes();
}//fim CalculaImpostoRPA()

var dop = {
	CalculaImposto : function (campoBase,campoAliq,campoImposto){
		var base = MoedaToDec(campoBase.value);
		var aliq;
		if(campoAliq.value=='')
			aliq = 0;
		else
			aliq = parseFloat(campoAliq.value)/100;
		var total=base*aliq;
		campoImposto.value = DecToMoeda(total);
		
		this.SomaImpostos();
		this.CalculaMulta();
	},
	CalculaMulta : function (){
		var mesComp = window.document.getElementById('cmbMes').value;
		var anoComp = window.document.getElementById('cmbAno').value;
		if (mesComp==''||anoComp=='')
			return false;
			
		var dataServ = window.document.getElementById('hdDataAtual').value.split('/');	
		var diaAtual = dataServ[0];
		var mesAtual = dataServ[1];
		var anoAtual = dataServ[2];
		
		var diaComp = window.document.getElementById('hdDia').value;
		mesComp = parseInt(mesComp) + 1;
		
		var dataAtual = new Date(mesAtual+'/'+diaAtual+'/'+anoAtual);
		var dataComp = new Date(mesComp+'/'+diaComp+'/'+anoComp);
		var diasDec = diasDecorridos(dataComp,dataAtual);
		
		
		var nroMultas = window.document.getElementById('hdNroMultas').value;
		
		if(diasDec>0)
			var multa = 0;
		else
			var multa = -1;
			
		for(var c=0;c < nroMultas; c++){
			var diasMulta = window.document.getElementById('hdMulta_dias'+c).value;
			if(diasDec>diasMulta){
				var multa = c;	
				if(multa<nroMultas-1)
					multa++;
			}//end if
		}//end for
		
		var impostototal = MoedaToDec(window.document.getElementById('txtImpostoTotal').value);
		if(multa>=0){
			var multavalor = 0;
			var multajuros = 0;
			if(window.document.getElementById('hdMulta_valor'+multa)){
				multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
			}
			if(window.document.getElementById('hdMulta_juros'+multa)){
				multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
			}
			var jurosvalor = impostototal*multajuros/100;
			var multatotal = jurosvalor + multavalor;
			var totalpagar = multatotal + impostototal;
			window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
		}
		else{
			window.document.getElementById('txtMultaJuros').value = '0,00';
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
		}
	},
	SomaImpostos : function (){
		var nservs = parseFloat(window.document.getElementById('hdServicos').value);
		var soma   = 0;
		for(cont=1;cont<=nservs;cont++){
			var campo = 'txtImposto'+cont+'';
			soma = soma +MoedaToDec(window.document.getElementById(campo).value);
		}
		window.document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
	},
	InserirServ : function (){
		document.getElementById('hdServicos').value++;
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = '';
		document.getElementById('trServb'+cont).style.display = '';
		document.getElementById('btServRemover').disabled = false;
		if(cont==document.getElementById('hdServMax').value){
			document.getElementById('btServInserir').disabled = true;
		}

	},
	RemoverServ : function (){
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = 'none';
		document.getElementById('trServb'+cont).style.display = 'none';
		document.getElementById('txtCNPJTomador'+cont).value = '';
		document.getElementById('cmbCodServico'+cont).innerHTML = '<option/>';
		document.getElementById('txtBaseCalculo'+cont).value = '';
		document.getElementById('txtImposto'+cont).value = '';
		document.getElementById('txtNroDoc'+cont).value = '';
		document.getElementById('hdServicos').value--;
		document.getElementById('btServInserir').disabled = false;
		if(document.getElementById('hdServicos').value<=1){
			document.getElementById('btServRemover').disabled = true;
		};
		this.SomaImpostos();
		this.CalculaMulta();
	},
	cancelarDeclaracao : function (codigo,nome){
		if(confirm('Deseja cancelar a declaracao N�'+codigo+' de '+nome+'?')){
			document.getElementById('hdCancelaDop').value=codigo;
			acessoAjax('inc/declaracoes/dop/declarar_pesquisa.ajax.php','frmDop','spanDop');
			alert('Declara��o de �rg�o P�blico cancelada!');
		}
	},
	buscaServicos : function (campo ,cont ){
		var cnpj = campo.value;
		if(cnpj!=''){
			ajax({
				url: 'inc/declaracoes/dop/servicos_prestador.ajax.php?cnpj='+campo.value+'&contador='+cont,
				espera: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
				},
				sucesso: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = respostaAjax;
				}
			});
			ajax({
				url: 'inc/declaracoes/verificacnpjcpf.ajax.php?valor='+campo.value,
				espera: function(){
					document.getElementById('tdServ'+cont).innerHTML = 'Verificando...';
				},
				sucesso: function(){
					// Abaixo colocamos a resposta na div do campo que fez a requisi��o
					document.getElementById('tdServ'+cont).innerHTML = respostaAjax;
				}
			});
		}else{
			document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
			document.getElementById('tdServ'+cont).innerHTML = '&nbsp';
		}
	}
};

var decc = {
	CalculaImposto : function (campoBase,campoAliq,campoImposto){
		var base = MoedaToDec(campoBase.value);
		var aliq;
		if(campoAliq.value=='')
			aliq = 0;
		else
			aliq = parseFloat(campoAliq.value)/100;
		var total=base*aliq;
		campoImposto.value = DecToMoeda(total);
		
		this.SomaImpostos();
		this.CalculaMulta();
	},
	CalculaMulta : function (){
		var mesComp = window.document.getElementById('cmbMes').value;
		var anoComp = window.document.getElementById('cmbAno').value;
		if (mesComp==''||anoComp=='')
			return false;
			
		var dataServ = window.document.getElementById('hdDataAtual').value.split('/');	
		var diaAtual = dataServ[0];
		var mesAtual = dataServ[1];
		var anoAtual = dataServ[2];
		
		var diaComp = window.document.getElementById('hdDia').value;
		mesComp = parseInt(mesComp) + 1;
		
		var dataAtual = new Date(mesAtual+'/'+diaAtual+'/'+anoAtual);
		var dataComp = new Date(mesComp+'/'+diaComp+'/'+anoComp);
		var diasDec = diasDecorridos(dataComp,dataAtual);
		
		
		var nroMultas = window.document.getElementById('hdNroMultas').value;
		
		if(diasDec>0)
			var multa = 0;
		else
			var multa = -1;
			
		for(var c=0;c < nroMultas; c++){
			var diasMulta = window.document.getElementById('hdMulta_dias'+c).value;
			if(diasDec>diasMulta){
				var multa = c;	
				if(multa<nroMultas-1)
					multa++;
			}//end if
		}//end for
		
		var impostototal = MoedaToDec(window.document.getElementById('txtImpostoTotal').value);
		if(multa>=0){
			var multavalor = 0;
			var multajuros = 0;
			if(window.document.getElementById('hdMulta_valor'+multa)){
				multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
			}
			if(window.document.getElementById('hdMulta_juros'+multa)){
				multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
			}
			var jurosvalor = impostototal*multajuros/100;
			var multatotal = jurosvalor + multavalor;
			var totalpagar = multatotal + impostototal;
			window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
		}
		else{
			window.document.getElementById('txtMultaJuros').value = '0,00';
			window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
		}
	},
	SomaImpostos : function (){
		var nservs = parseFloat(window.document.getElementById('hdServicos').value);
		var soma   = 0;
		for(cont=1;cont<=nservs;cont++){
			var campo = 'txtImposto'+cont+'';
			soma = soma +MoedaToDec(window.document.getElementById(campo).value);
		}
		window.document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
	},
	InserirServ : function (){
		document.getElementById('hdServicos').value++;
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = '';
		document.getElementById('trServb'+cont).style.display = '';
		document.getElementById('btServRemover').disabled = false;
		if(cont==document.getElementById('hdServMax').value){
			document.getElementById('btServInserir').disabled = true;
		}

	},
	RemoverServ : function (){
		var cont = document.getElementById('hdServicos').value;
		document.getElementById('trServ'+cont).style.display = 'none';
		document.getElementById('trServb'+cont).style.display = 'none';
		document.getElementById('txtCNPJTomador'+cont).value = '';
		document.getElementById('cmbCodServico'+cont).innerHTML = '<option/>';
		document.getElementById('txtBaseCalculo'+cont).value = '';
		document.getElementById('txtImposto'+cont).value = '';
		document.getElementById('txtNroDoc'+cont).value = '';
		document.getElementById('hdServicos').value--;
		document.getElementById('btServInserir').disabled = false;
		if(document.getElementById('hdServicos').value<=1){
			document.getElementById('btServRemover').disabled = true;
		};
		this.SomaImpostos();
		this.CalculaMulta();
	},
	cancelarDeclaracao : function (cont){
		//var codigo = document.getElementById('txtCodigoGuia'+cont).value;
		return CancelarDeclaracaoAjax('decc_des',cont);
	},
	cancelarGuia : function(cont) {
		return CancelarDeclaracaoAjax('guia_pagamento',cont,'','decc_des');
	},
	buscaServicos : function (campo ,cont ){
		var cnpj = campo.value;
		if(cnpj!=''){
			ajax({
				url: 'include/dop/servicos_prestador.ajax.php?cnpj='+campo.value+'&contador='+cont,
				espera: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
				},
				sucesso: function(){
					document.getElementById('tdCmbServ'+cont).innerHTML = respostaAjax;
				}
			});
			ajax({
				url: 'include/verificacnpjcpf.ajax.php?valor='+campo.value,
				espera: function(){
					document.getElementById('tdServ'+cont).innerHTML = 'Verificando...';
				},
				sucesso: function(){
					// Abaixo colocamos a resposta na div do campo que fez a requisi��o
					document.getElementById('tdServ'+cont).innerHTML = respostaAjax;
				}
			});
		}else{
			document.getElementById('tdCmbServ'+cont).innerHTML = '<select style="width:150px;"><option/></select>';
			document.getElementById('tdServ'+cont).innerHTML = '&nbsp';
		}
	}
};



function CalculaMultaDes(){
	var mesComp = window.document.getElementById('cmbMes').value;
	var anoComp = window.document.getElementById('cmbAno').value;
	if (mesComp==''||anoComp=='')
		return false;
		
	var dataServ = window.document.getElementById('hdDataAtual').value.split('/');	
	var diaAtual = dataServ[0];
	var mesAtual = dataServ[1];
	var anoAtual = dataServ[2];
	
	var diaComp = window.document.getElementById('hdDia').value;
	mesComp = parseFloat(mesComp);
	mesComp++;
	
	var dataAtual = new Date(mesAtual+'/'+diaAtual+'/'+anoAtual);
	var dataComp = new Date(mesComp+'/'+diaComp+'/'+anoComp);
	var diasDec = diasDecorridos(dataComp,dataAtual);
	
	
	var nroMultas = window.document.getElementById('hdNroMultas').value;
	
	if(diasDec>0)
		var multa = 0;
	else
		var multa = -1;
		
	for(var c=0;c < nroMultas; c++){
		var diasMulta = window.document.getElementById('hdMulta_dias'+c).value;
		if(diasDec>diasMulta){
			var multa = c;	
			if(multa<nroMultas-1)
				multa++;
		}//end if
	}//end for
	
	if(document.getElementById('txtTotalIss'))
		var impostototal = MoedaToDec(window.document.getElementById('txtTotalIss').value);
	else
		var impostototal = MoedaToDec(window.document.getElementById('txtImpostoTotal').value);
	if(multa>=0){
		var multavalor = 0;
		var multajuros = 0;
		if(window.document.getElementById('hdMulta_valor'+multa)){
			multavalor = MoedaToDec(window.document.getElementById('hdMulta_valor'+multa).value);
		}
		if(window.document.getElementById('hdMulta_juros'+multa)){
			multajuros = parseFloat(window.document.getElementById('hdMulta_juros'+multa).value);
		}
		var jurosvalor = impostototal*multajuros/100;
		var multatotal = jurosvalor + multavalor;
		var totalpagar = multatotal + impostototal;
		window.document.getElementById('txtMultaJuros').value = DecToMoeda(multatotal);
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(totalpagar);
	}
	else{
		window.document.getElementById('txtMultaJuros').value = '0,00';
		window.document.getElementById('txtTotalPagar').value = DecToMoeda(impostototal);
	}
}

function SomaImpostosDes(){
	var nservs = parseFloat(window.document.getElementById('hdServicos').value);
	var soma   = 0;
	for(cont=1;cont<=nservs;cont++){
		var campo = 'txtImposto'+cont+'';
		if(document.getElementById('txtEmo'+cont+'')) {
			var emo = 'txtEmo'+cont+'';
			soma = soma +MoedaToDec(window.document.getElementById(emo).value);
		}
		soma = soma +MoedaToDec(window.document.getElementById(campo).value);
	}
	window.document.getElementById('txtImpostoTotal').value = DecToMoeda(soma);
}


function buscaServicosCartorioTipo(campo, resultado, contador) {
	if(campo.value!=''){
		var req;
		// Verificar o Browser
		// Firefox, Google Chrome, Safari e outros
		if(window.XMLHttpRequest){
		   req = new XMLHttpRequest();
		}
		// Internet Explorer
		else if(window.ActiveXObject) {
		   req = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		var url='inc/declaracoes/dec/listarservicoscartorio.ajax.php?codigo='+campo.value+'&contador='+contador;
		
		req.open("Get", url, true);
			 
		// Quando o objeto recebe o retorno, chamamos a seguinte fun��o;
		req.onreadystatechange = function() {
		 
			// Exibe a mensagem "Verificando" enquanto carrega
			if(req.readyState == 1) {				
				document.getElementById(resultado).innerHTML = '<select style="width:280px;"><option/></select>';
			}
		 
			// Verifica se o Ajax realizou todas as opera��es corretamente (essencial)
			if(req.readyState == 4 && req.status == 200) {
				// Resposta retornada pelo validacao.php
				var resposta = req.responseText;
				//alert(resposta);
				// Abaixo colocamos a resposta na div do campo que fez a requisi��o
				document.getElementById(resultado).innerHTML = resposta;
			}
		 
		};
		req.send(null);
	}else{
		document.getElementById(resultado).innerHTML = '<select style="width:280px;"><option/></select>';
	}
}


function EmissorInserirServ(){
	document.getElementById('hdServicos').value++;
	var cont = document.getElementById('hdServicos').value;
	document.getElementById('trServ'+cont).style.display = '';
	document.getElementById('trServb' + cont).style.display = '';
	document.getElementById('btServRemover').disabled = false;
	if(cont==document.getElementById('hdServMax').value){
		document.getElementById('btServInserir').disabled = true;
	}

}

function EmissorRemoverServ(){
	var cont = document.getElementById('hdServicos').value;
	document.getElementById('trServ'+cont).style.display = 'none';
	document.getElementById('trServb' + cont).style.display = 'none';
	if(document.getElementById('txtTomadorCnpjCpf'+cont)){
		document.getElementById('txtTomadorCnpjCpf'+cont).value = '';
	}
	if(document.getElementById('cmbCodServico'+cont)){
		document.getElementById('cmbCodServico'+cont).value = '';
	}
	document.getElementById('txtBaseCalculo'+cont).value = '';
	document.getElementById('txtImposto'+cont).value = '';
	document.getElementById('txtNroDoc'+cont).value = '';
	document.getElementById('hdServicos').value--;
	document.getElementById('btServInserir').disabled = false;
	if(document.getElementById('hdServicos').value<=1){
		document.getElementById('btServRemover').disabled = true;
	}
	SomaImpostosDes();
	CalculaMultaDes();
}

/* -------------------------------------------------------------------------------------------------------------------------------------------- */

function alternaCampos(campo){
	var valor = document.getElementById(campo).value.split("|");
	if(document.getElementById('hdTemporario').value){
		document.getElementById('btCadastrar').setAttribute('onclick',document.getElementById('hdTemporario').value);
		document.getElementById('hdTemporario').value = "";
	}
	document.getElementById('trBotao').style.visibility = 'visible';
	document.getElementById('trCombos').style.visibility = 'visible';
	if(document.getElementById('bigtable')){
		document.getElementById('bigtable').style.display = 'block';
	}
	switch(valor[1]){
		case "instituicao_financeira":
			document.getElementById('tbl_inst_opr').style.display = 'block';
			document.getElementById('tbl_cart').style.display = 'none';
		  break;
		case "operadora_credito":
			document.getElementById('tbl_inst_opr').style.display = 'block';
			document.getElementById('tbl_cart').style.display = 'none';
		  break;
		case "cartorio":
			document.getElementById('tbl_cart').style.display = 'block';
			document.getElementById('tbl_inst_opr').style.display = 'none';
			document.getElementById('hdTemporario').value = document.getElementById('btCadastrar').getAttribute('onclick');
			document.getElementById('btCadastrar').setAttribute('onclick',document.getElementById('hdPadrao_onclick').value);
			document.getElementById('trBotao').style.visibility = 'hidden';
			document.getElementById('trCombos').style.visibility = 'hidden';
			if(document.getElementById('bigtable')){
				document.getElementById('bigtable').style.display = 'none';
			}
		  break;
		default:
			document.getElementById('tbl_inst_opr').style.display = 'none';
			document.getElementById('tbl_cart').style.display = 'none';
		  break;
	}													
}

/*
function chamaForm(menu,submenu){
	var url= 'inc/'+menu+'/'+submenu;
	document.getElementById('include').value=url;
	document.getElementById('frmMenu').submit();	
}
*/

//Fun��o que envia os dados do form para uma pagina em branco do formulario dos prestadores
function enviaFormPrestadores(btn)
{
	if(btn.name == "rdCompleta")	
		{
			document.frmPrestadoresBtn.target = "_blank";
			document.frmPrestadoresBtn.action = "inc/relatorios_prestadores_lista.php";
		}
	else
		{
			document.frmPrestadoresBtn.target = "_parent";
			document.frmPrestadoresBtn.action = "relatorios.php?btPrestadores=B";
		}
	document.frmPrestadoresBtn.submit();
}

//Fun��o que envia os dados do form para uma pagina em branco do formulario dos servi�os
function enviaFormServicos(btn)
{
	if(btn.name == "rdAtivos")	
		{
			document.frmServicos.target = "_blank";
			document.frmServicos.action = "inc/relatorios_servicos_ativos.php";
		}
	else
		{
			document.frmServicos.target = "_blank";
			document.frmServicos.action = "inc/relatorios_servicos_inativos.php";
		}
	document.frmServicos.submit();
}

//Fun��o para escoinder a div apos o clique
function EscondeDiv(div)
{
 document.getElementById(div).style.display='none';
}



//mostrar aliquota quando selecionar no combo
function MostraAliquota(campoAliq, campoISSRetido, cont)
{ 	 
	var aux = document.getElementById('cmbCodServico'+cont).value;
	aux = aux.split("|");
	var aliquota = aux[0];
    var issretido = aux[2];
	if(issretido >= MoedaToDec(document.getElementById('txtValTotal').value)){
		issretido = MoedaToDec(document.getElementById('txtValTotal').value);
	}
	//document.getElementById(campoISSRetido).value = DecToMoeda(issretido);
	document.getElementById(campoAliq).value = aliquota;
	document.getElementById('hdBaseServico'+cont).value = aux[3]; 
}

function ValorIss(regras_de_credito)
{
    var aux = document.getElementById('cmbCodServico1').value;
	var basecalculorpa = aux.split("|"); 
	basecalculorpa= basecalculorpa[3];
	
	var iss = MoedaToDec(document.getElementById('txtISS').value);
    var credito_final;
	var credito = 0;	 
	var int;
	var float; 
	var tipopessoa = document.getElementById('txtTomadorCNPJ').value.length;
	var valAcrescimo = 0;
	
	var basecalc = MoedaToDec(document.getElementById('txtBaseCalculo').value);

	var valdeduc = MoedaToDec(document.getElementById('txtValorDeducoes').value);
	if(document.getElementById('txtValorAcrescimos')){
		valAcrescimo = MoedaToDec(document.getElementById('txtValorAcrescimos').value);
	}
	
	document.getElementById('txtBaseCalculoAux').value = DecToMoeda(basecalc);
	
	document.getElementById('txtBaseCalculo').value = DecToMoeda(basecalc);
	
	if((basecalculorpa != undefined) && (basecalculorpa>0)){		
		basecalc = basecalculorpa;	
	}
	var base = document.getElementById('txtBaseCalculo').value;
	document.getElementById('hdCalculos').value = base;
	
	
	//--------------------------------------------------------------------------------------
	//Verifica se foi mudado o valor da base de calculo, para que possa corrigir os percentuais dos tributos
	if((MoedaToDec(document.getElementById('hdValorInicial').value) == 0) || (document.getElementById('hdValorInicial').value == "")){
	
		document.getElementById('hdValorInicial').value = base;	
	
	}else if((document.getElementById('hdValorInicial').value != base)&&((basecalculorpa == undefined ) || (basecalculorpa<=0))){
	
		document.getElementById('hdValorInicial').value = base;
		if(document.getElementById('txtIRRFBCpct')){
			document.getElementById('txtIRRFBCpct').onblur();
		}
		if(document.getElementById('txtINSSBCpct')){
			document.getElementById('txtINSSBCpct').onblur();
		}
	
	}
	//---------------------------------------------------------------------------------------
			
	
		if(basecalc != ""){
			
			//calcula o valor total da nota
            var total;
            if((parseFloat(valdeduc) >= parseFloat(basecalc))){
                total = '0.00';
                document.getElementById('txtValorDeducoes'). value = DecToMoeda(basecalc);
                document.getElementById('txtBaseCalculo'). value = DecToMoeda(total);
            }else{
                total = parseFloat(basecalc) - parseFloat(valdeduc);
                if(document.getElementById('hdBkpBaseCalculo').value == "a" && DecToMoeda(valdeduc) != '0,00'){
                    document.getElementById('hdBkpBaseCalculo').value = DecToMoeda(total);
                    document.getElementById('txtBaseCalculo').value = DecToMoeda(total);
                }
            }
			if(valAcrescimo > 0){
				total = parseFloat(total) + parseFloat(valAcrescimo);
			}
			
			var qual_tipopessoa = (tipopessoa == 14) ? "PF" : "PJ";

			
			var issretido = MoedaToDec(document.getElementById('txtIssRetido').value);
			var tem_issretido = (issretido > 0) ? tem_issretido = "S" : tem_issretido = "N";

			var array_regras_credito = regras_de_credito.split("-");
			for(var cont in array_regras_credito){
                var array_campos_nfecredito = array_regras_credito[cont].split("|");
				if((array_campos_nfecredito[0] == qual_tipopessoa)||(array_campos_nfecredito[0] == "PFPJ")){
					if(array_campos_nfecredito[1] == tem_issretido){
						if(iss <= array_campos_nfecredito[2]){
							credito = array_campos_nfecredito[3];
						}
					}
				}
			}				

			//var valor_issretido = MoedaToDec(document.getElementById('txtIssRetido').value);
			//total = total - valor_issretido;
			document.getElementById('txtValTotal').value=DecToMoeda(total);
			
			//calcula o cr?dito final que o tomador receber? ao emitir a nota
			
			credito_final = (iss * parseFloat(credito))/100;
			//credito_final = credito_final.toFixed(2);
			document.getElementById('txtCredito').value=DecToMoeda(credito_final);

			//-------------------------------------------------------------------------------------
			//Soma todos os campos de rentencao e mostra para o usuario
			var campoISSRetido = 0;
			var campoINSS = 0;
			var campoIRRF = 0;
			var TotalRentencao = 0;
			
			campoISSRetido = MoedaToDec(document.getElementById('txtIssRetido').value);
			campoINSS = MoedaToDec(document.getElementById('txtValorINSS').value);
			campoIRRF = MoedaToDec(document.getElementById('txtValorFinalIRRF').value);
			
			TotalRentencao = parseFloat(campoISSRetido) + parseFloat(campoINSS) + parseFloat(campoIRRF);
			document.getElementById('txtValTotalRetencao').value = DecToMoeda(TotalRentencao);
            
			//--------------------------------------------------------------------------------------
			
			
			}//fim if
	
}//fim da funcao

var cont =1, contservicos =1;
//txtNomeSocio txtCpfSocio
function excluirSocio() 
{
  document.getElementById('campossocio'+cont).style.display='none';
  //document.getElementById('linha01socio'+cont).style.display='none';
  //document.getElementById('linha02socio'+cont).style.display='none'; 
  document.getElementById('txtCpfSocio'+cont).value="";
  document.getElementById('txtNomeSocio'+cont).value="";
  cont--;
}

function incluirSocio() 
{ 
   if (cont < 10)
   {
    cont++;     
    document.getElementById('campossocio'+cont).style.display='block';
    //document.getElementById('linha01socio'+cont).style.display='block';
    //document.getElementById('linha02socio'+cont).style.display='block';   
   }
   
}


function ServicosCategorias(categoria)
	{
		var dados;		
			dados=categoria.value;
		if(dados !="")
		{	
			dados = dados.split("|");					
			while(dados[2] > 0)
			{				 
			 if(document.getElementById('div'+dados[2]+dados[1])){
				document.getElementById('div'+dados[2]+dados[1]).style.display='none';
			 }
			 
			 if(document.getElementById('cmbCodigo'+dados[2]+dados[1])){
			 	document.getElementById('cmbCodigo'+dados[2]+dados[1]).value='';
			 }
			 dados[2]--;
			}			
			document.getElementById('div'+dados[0]+dados[1]).style.display='block';			
		}
		
		
	}


function excluirServico(cod) 
{  
	dados=cod.name;
	dados= dados.split("|");
	document.getElementById('camposservico'+dados[2]).style.display='none';
	//document.getElementById('linha01servico'+dados[2]).style.display='none'; 
	//document.getElementById('linha02servico'+contservicos).style.display='none';
	while(dados[1] > 0)	{
		document.getElementById('cmbCategoria'+dados[2]).value='';
		if(document.getElementById('cmbCodigo'+dados[1]+dados[2])){
			document.getElementById('cmbCodigo'+dados[1]+dados[2]).value='';
		}
		if(document.getElementById('div'+dados[1]+dados[2])){
			document.getElementById('div'+dados[1]+dados[2]).style.display='none';
		}
		dados[1]--;
	}
	contservicos--;
}
	


function incluirServico()
{
	var verificaServicos = 1;
	while(verificaServicos <= 5){
		verificaServicos++;
		if(document.getElementById('camposservico'+verificaServicos)){
			if(document.getElementById('camposservico'+verificaServicos).style.display == 'none'){
				document.getElementById('camposservico'+verificaServicos).style.display = 'block';
				break;
			}
		}
	}
}





// FUN��O PARA MARCAR TODOS OS CHECKBOX DE EMISSORES QUE TENEHAM O AIDF LIBERADO
function MarcaCheckboxAIDF(cb,txt,x)
	{
		var cb=cb+x;
		var txt=txt+x;
		document.getElementById(cb).checked=true;
		document.getElementById(txt).disabled=true;
	}
	
// FUN��O PARA TRATAR O FORMUL�RIO DO AIDF	
function AIDF(txt,cb,x)	
	{
		var txt=txt+x;
		var cb=cb+x;
		if(document.getElementById(cb).checked)
			{
				document.getElementById(txt).disabled=true;
				document.getElementById(txt).value=0;
			}
		else
			{
				document.getElementById(txt).disabled=false;
				document.getElementById(txt).value="";
				document.getElementById(txt).focus();
			}
	}

// FUN��O PARA CONFIRMA��O DA ESCRITURA��O DE NOTAS 
function ConfirmaEscriturar(boleto)
	{
		if(confirm("Deseja escrituras as notas contidas no boleto "+boleto+"?"))
			{window.location="inc/escrituracao_inserir.php?boleto="+boleto;}
	}

// FUN��O DE TRATAMENTO DO FORMUL�RIO DE PESQUISA DE BOLETOS
function ValidarBuscaBoleto()
	{
		if(document.frmBuscaBoleto.txtNroBoleto.value=="")
			{
				alert("Informe a chave de controle do boleto");
				return false;
			}
	}
	
//FUN��O PARA TRATAMENDO DO FORMUL�RIO DE DELEGA��O DE NIVEL DE USUARIO	
function MarcaNivel(x)
	{
		var baixo="baixo"+x;
		var medio="medio"+x;
		if(document.getElementById(baixo).checked)
			{
				document.getElementById(medio).checked=true;	
				document.getElementById(medio).disabled=true;	
			}
		else
			{
				document.getElementById(medio).disabled=false;	
			}
	}
	
// FUN��O PARA MARCAR PERMISS�ES DOS USUARIOS DE NIVEL BAIXO
function MarcaCheckboxBaixo(x)
	{
		var baixo = "baixo"+x;
		var medio = "medio"+x;
		document.getElementById(baixo).checked  = true;
		document.getElementById(medio).checked  = true;
		document.getElementById(medio).disabled = true;
	}

// FUN��O PARA MARCAR PERMISS�ES DOS USU�RIOS DE NIVEL M�DIO
function MarcaCheckboxMedio(x)
	{
		var medio = "medio"+x;
		document.getElementById(medio).checked = true;
	}
	
function ConfirmaAcaoProcesso(valor)
	{
		var pergunta;
		if((valor=="processofiscal.php?acao=cancelar")||(valor=="processofiscal.php?acao=estornarcancelamento"))
			{
				if(valor=="processofiscal.php?acao=cancelar")
					{
						pergunta="Deseja cancelar este processo fiscal?";
					}
				else if(valor=="processofiscal.php?acao=estornarcancelamento")
					{
						pergunta="Deseja estornar o cancelamento deste processo fiscal?	";	
					}
				if(confirm(pergunta))
					{
						return true;	
					}
				else
					{
						return false;	
					}
			}
	}
	
function Selecionar(contador)
	{
		for(x=0; x < contador; x++)
		{
			if(document.getElementById('opcao'+x).checked)
			{
			document.getElementById('opcao'+x).checked=false;
			}
			
			else {
				  document.getElementById('opcao'+x).checked=true;
				 }
		}
			
	}
	
	
//Funcao que faz com que o campo no form nao seja afetado pela action do mesmo
function cancelaAction(formid,formaction,formtarget)
{
	document.getElementById(formid).target = formtarget;
	document.getElementById(formid).action = formaction;		
	document.getElementById(formid).submit();
}
	
//Funcao que habilita o uso de uma das funcoes	
function MaskMoeda(campo){
	campo.value = MoedaToDec(campo.value);
	campo.value = DecToMoeda(campo.value);		
}

//Transforma o valor de moeda para decimal
function MoedaToDec(valor)
{
	if (valor=='')
		valor = '0';
	valor=valor.replaceAll(',','');
	valor=valor.replaceAll('.','');
	valor = parseFloat(valor);
	valor/=100;
	return valor;
}

//Transoforma o valor de decimal para moeda
function DecToMoeda(valor){
	if(valor=="")
		valor = 0;
	valor = parseFloat(valor);
	return number_format(valor, 2, ",",".");
}

function calculaISSNfe(hidden, cont){
	var baseservico = document.getElementById('hdBaseServico'+cont).value;
    var iss = null;
	if(baseservico>0){
		iss = (MoedaToDec(document.getElementById('hdBaseServico'+cont).value) * MoedaToDec(document.getElementById('txtAliqServico'+cont).value))/100;
	}else{
		iss = (MoedaToDec(document.getElementById('txtBaseCalcServico'+cont).value) * MoedaToDec(document.getElementById('txtAliqServico'+cont).value))/100;
	}
	

	var aliq      = MoedaToDec(document.getElementById('txtAliqServico'+cont).value);
    var baseCalc  = MoedaToDec(document.getElementById('txtBaseCalcServico'+cont).value);	
	var deducoes  = MoedaToDec(document.getElementById('txtDeducoes'+cont).value);
    var acrescimo = MoedaToDec(document.getElementById('txtAcrescimo'+cont).value);
    var valLiq    = MoedaToDec(document.getElementById('txtValorLiquido'+cont).value);

	if(baseservico>0){
		if(document.getElementById('ckISSRetidoManual'+cont).value=='s'){
			document.getElementById('txtISSRetidoManual'+cont).value = document.getElementById('txtValorIssServico'+cont).value;
		}
		var issRetido = MoedaToDec(document.getElementById('txtISSRetidoManual'+cont).value);
		document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo-issRetido);
	}else{
		document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
		if(document.getElementById('ckISSRetidoManual'+cont).value=='s'){
			document.getElementById('txtISSRetidoManual'+cont).value = document.getElementById('txtValorIssServico'+cont).value;			
		}
		var issRetido = MoedaToDec(document.getElementById('txtISSRetidoManual'+cont).value);
		document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo-issRetido);
	}

	if(issRetido > 0){
		/* exclusivo para prefeitura de curionopulis
          if(issRetido > iss){
			issRetido = iss;
            iss = 0.00;
			document.getElementById('txtISSRetidoManual'+cont).value = DecToMoeda(issRetido);
            document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
		}else{
            iss -= issRetido;
			document.getElementById('txtISSRetidoManual'+cont).value = DecToMoeda(issRetido);
            document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
        }
		document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo);
        document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
        */

       // para demais prefeituras
       if(issRetido > iss){
			issRetido = iss;
			document.getElementById('txtISSRetidoManual'+cont).value = DecToMoeda(issRetido);
		}
		document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo-issRetido);
		document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
	}
	
	/*DBD*/
	
    if(deducoes > 0){
		if(deducoes > baseCalc){
			document.getElementById('txtBaseCalcServico'+cont).value = '0,00';
			document.getElementById('txtValorLiquido'+cont).value = '0,00';
			document.getElementById('txtDeducoes'+cont).value = DecToMoeda(baseCalc);		
		}else{
			document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo-issRetido);
            iss = (MoedaToDec(document.getElementById('txtValorLiquido'+cont).value) * MoedaToDec(document.getElementById('txtAliqServico'+cont).value))/100;
			document.getElementById('txtValorIssServico'+cont).value = DecToMoeda(iss);
			if(document.getElementById('ckISSRetidoManual'+cont).value=='s'){
			 document.getElementById('txtISSRetidoManual'+cont).value = DecToMoeda(iss);			 
			}

		}
    }

    if(acrescimo > 0){
       	document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo-issRetido);
	}
	
	if(MoedaToDec(document.getElementById('txtBaseCalcServico'+cont).value) > 0){
		if(issRetido > baseCalc){
			baseCalc = issRetido;
			document.getElementById('txtBaseCalcServico'+cont).value = DecToMoeda(baseCalc);
			document.getElementById('txtValorLiquido'+cont).value = DecToMoeda(baseCalc-deducoes+acrescimo-issRetido);
		}
	}
    /*DBD*/

	var quantidade = document.getElementById(hidden).value;
	var valorISS = 0;
	issRetido = 0;
	var valorISSRetido = 0;
	baseCalc = 0;
    deducoes = 0;
    acrescimo = 0;
	valLiqTotal = 0;

	for(var contt=1; contt <= quantidade; contt++){

		valorISS = valorISS + MoedaToDec(document.getElementById('txtValorIssServico'+contt).value);
		valorISSRetido = valorISSRetido + MoedaToDec(document.getElementById('txtISSRetidoManual'+contt).value);
		baseCalc = baseCalc + MoedaToDec(document.getElementById('txtBaseCalcServico'+contt).value);
        deducoes = deducoes + MoedaToDec(document.getElementById('txtDeducoes'+contt).value);
        acrescimo = acrescimo + MoedaToDec(document.getElementById('txtAcrescimo'+contt).value);
        valLiqTotal = valLiqTotal + MoedaToDec(document.getElementById('txtValorLiquido'+contt).value);
	}
		
	document.getElementById('txtBaseCalculo').value = DecToMoeda(baseCalc);
	if(document.getElementById('ckISSRetidoManual'+cont).value=='s'){
		document.getElementById('txtISS').value = '0,00';
		document.getElementById('txtIssRetido').value = DecToMoeda(valorISSRetido);
	}else{
		document.getElementById('txtISS').value = DecToMoeda(valorISS);
		document.getElementById('txtIssRetido').value = '0,00';
	}
    document.getElementById('txtValorDeducoes'). value = DecToMoeda(deducoes);
    document.getElementById('txtValorAcrescimos'). value = DecToMoeda(acrescimo);

	//document.getElementById('txtBaseCalculo').onblur();
	document.getElementById('txtValTotal').value = '';
    document.getElementById('txtValTotal').value = DecToMoeda(valLiqTotal);
	
	if(document.getElementById('ckISSRetidoManual'+cont).value=='s'){
			document.getElementById('txtValorIssServico'+cont).value = '0,00';
		}
}

//calcula o ISS   
function CalculaIss(campovaltotal,campoiss) 
{
	var valorparcela = document.getElementById(campovaltotal).value;	
	valorparcela = MoedaToDec(valorparcela);
	iss = valorparcela * 0.02;		
	document.getElementById(campoiss).value=DecToMoeda(iss);	
}

//calcula ISS retido
function CalculaIssRetido(campovaltotal,campoissretido)
{
	var valor = document.getElementById(campovaltotal).value;
	var issretido = document.getElementById(campoissretido).value;
	if(!(issretido > 100))
		{
			valor = MoedaToDec(valor);
			var valor_issretido = (valor * issretido) / 100;
			total = valor - valor_issretido;
			document.getElementById(campovaltotal).value=DecToMoeda(total);
		}
	else
		{
			alert('N�o pode reter mais do que 100% de iss');		
		}
}
	
	
function SomaDeduc(campodeduc,campovaltotal)
{
	var deduc = document.getElementById(campodeduc).value;
	var valor = document.getElementById(campovaltotal).value;
	deduc = MoedaToDec(deduc);
	valor = MoedaToDec(valor);
	var result = deduc + valor;
	document.getElementById(campovaltotal).value=DecToMoeda(result)
}
	
//----- Teste

/***
* Descri��o.: formata um campo do formul�rio de
* acordo com a m�scara informada...
* Par�metros: - objForm (o Objeto Form)
* - strField (string contendo o nome
* do textbox)
* - sMask (mascara que define o
* formato que o dado ser� apresentado,
* usando o algarismo "9" para
* definir n�meros e o s�mbolo "!" para
* qualquer caracter...
* - evtKeyPress (evento)
* Uso.......: <input type="textbox"
* name="xxx".....
* onkeypress="return txtBoxFormat(document.rcfDownload, 'str_cep', '99999-999', event);">
* Observa��o: As m�scaras podem ser representadas como os exemplos abaixo:
* CEP -> 99.999-999
* CPF -> 999.999.999-99
* CNPJ -> 99.999.999/9999-99
* Data -> 99/99/9999
* Tel Resid -> (99) 999-9999
* Tel Cel -> (99) 9999-9999
* Processo -> 99.999999999/999-99
* C/C -> 999999-!
* E por a� vai...
***/

function txtBoxFormat(objForm, strField, sMask, evtKeyPress) {
var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;

if(document.all) { // Internet Explorer
	nTecla = evtKeyPress.keyCode; 
}else if(document.layers) { // Firefox ou Nestcape
	nTecla = evtKeyPress.which;
}

sValue = objForm[strField].value;

// Limpa todos os caracteres de formata��o que
// j� estiverem no campo.
sValue = sValue.toString().replace( "-", "" );
sValue = sValue.toString().replace( "-", "" );
sValue = sValue.toString().replace( ".", "" );
sValue = sValue.toString().replace( ".", "" );
sValue = sValue.toString().replace( "/", "" );
sValue = sValue.toString().replace( "/", "" );
sValue = sValue.toString().replace( "(", "" );
sValue = sValue.toString().replace( "(", "" );
sValue = sValue.toString().replace( ")", "" );
sValue = sValue.toString().replace( ")", "" );
sValue = sValue.toString().replace( " ", "" );
sValue = sValue.toString().replace( " ", "" );
fldLen = sValue.length;
mskLen = sMask.length;

i = 0;
nCount = 0;
sCod = "";
mskLen = fldLen;

while (i <= mskLen) {
	bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
	bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))
	
	if (bolMask) {
		sCod += sMask.charAt(i);
		mskLen++; 
	}else {
		sCod += sValue.charAt(nCount);
		nCount++;
	}
	
	i++;
}

objForm[strField].value = sCod;

if (nTecla != 8) { // backspace
		if (sMask.charAt(i-1) == "9") { // apenas n�meros...
			return ((nTecla > 47) && (nTecla < 58)); 
		} // n�meros de 0 a 9
		else { // qualquer caracter...
			return true;
		} 
	}else {
		return true;
	}
}
//Fim da Fun��o M�scaras Gerais

function verificaDia(){
	var ano = parseInt(document.getElementById('cmbAno').value);
	var mes = parseInt(document.getElementById('cmbMes').value);
	var diaescolhido = document.getElementById('txtDia').value;
	var dia;
	switch(mes)
	{
		case 1 : dia = 31; break;
		case 3 : dia = 31; break;
		case 5 : dia = 31; break;
		case 7 : dia = 31; break;
		case 8 : dia = 31; break;
		case 10: dia = 31; break;
		case 12: dia = 31; break;

		case 4 : dia = 30; break;
		case 6 : dia = 30; break;
		case 9 : dia = 30; break;
		case 11: dia = 30; break;		

		case 2 : 
			if(((ano % 4 == 0)&&( ano % 100 != 0))||(ano % 400 == 0)) 
				dia = 29;
			else
				dia = 28;
			break;
		
 	}
	
	if(diaescolhido>dia){diaescolhido = dia;};
	document.getElementById('txtDia').value = diaescolhido;
	
}

//-----
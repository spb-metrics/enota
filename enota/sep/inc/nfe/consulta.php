<?php
/*
LICEN�A P�BLICA GERAL GNU
Vers�o 3, 29 de junho de 2007
    Copyright (C) <2010>  <PORTAL P�BLICO INFORM�TICA LTDA>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

Este programa � software livre: voc� pode redistribu�-lo e / ou modificar sob os termos da GNU General Public License como publicado pela Free Software Foundation, tanto a vers�o 3 da Licen�a, ou�(por sua op��o) qualquer vers�o posterior.

Este programa � distribu�do na esperan�a que possa ser �til, mas SEM QUALQUER GARANTIA, sem mesmo a garantia impl�cita de COMERCIALIZA��O ou ADEQUA��O A UM DETERMINADO PROP�SITO. Veja a GNU General Public License para mais detalhes.

Voc� deve ter recebido uma c�pia da GNU General Public License��junto com este programa. Se n�o, veja <http://www.gnu.org/licenses/>.


This is an unofficial translation of the GNU General Public License into Portuguese. It was not published by the Free Software Foundation, and does not legally state the distribution terms for software that uses the GNU GPL � only the original English text of the GNU GPL does that. However, we hope that this translation will help Portuguese speakers understand the GNU GPL better.

Esta � uma tradu��o n�o oficial em portugu�s da Licen�a P�blica Geral GNU (da sigla em ingl�s GNU GPL). Ela n�o � publicada pela Free Software Foundation e n�o declara legalmente os termos de distribui��o para softwares que a utilizam � somente o texto original da licen�a, escrita em ingl�s, faz isto. Entretanto, acreditamos que esta tradu��o ajudar� aos falantes do portugu�s a entend�-la melhor.


// Originado do Projeto ISS Digital � Portal P�blico que tiveram colabora��es de Vin�cius Kampff, 
// Rafael Romeu, Lucas dos Santos, Guilherme Flores, Maikon Farias, Jean Farias e Daniel Bohn
// Acesse o site do Projeto www.portalpublico.com.br             |
// Equipe Coordena��o Projeto ISS Digital: <informatica@portalpublico.com.br>   |

*/
?>
<!-- Formulario de insercao de empresa  -->
<style type="text/css">
<!--
#divBusca {
	position:absolute;
	left:30%;
	top:20%;
	width:298px;
	height:276px;
	z-index:1;
 visibility:<?php if(isset($btBuscarCliente)) { echo"visible"; }else{ echo"hidden"; }?>
}
input[type*="text"]{
	text-transform:uppercase;
}
-->
</style>
<div id="divBusca"  >
	<?php include("inc/nfe/busca_prestador.php"); ?>
</div>
<?php 
	if(($_POST['codprestador'])){		   
		$codigo=$_POST['codprestador'];	
		$sql=mysql_query("SELECT IF(cnpj <> '',cnpj,cpf) AS cnpjcpf FROM cadastro WHERE codigo='$codigo'");
		$cpfcnpj = mysql_fetch_object($sql);
	}
?>
<script>
  function CancelaNota(codnota,msg)
  {	
	if(confirm(msg)){
		document.getElementById('hdPrimeiro').value=1; //mantem a paginacao na mesma pagina
		document.getElementById('txtCodigoCancela').value=codnota;
		var motivo = '';
		do{
			motivo = window.prompt("Informe o motivo do cancelamento");
			if(motivo == null){
				motivo = '';
			}else{
				document.getElementById('txtMotivoCancela').value = motivo;
			}
		}while(motivo == '');
		acessoAjax('inc/nfe/pesquisar_resultado.ajax.php','frmNfe','divResultado');
		alert('Nota cancelada!');
	}
  }			
</script>

<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;NFe - Pesquisa </td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<form method="post" name="frmNfe" id="frmNfe" onsubmit="return false">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"]; ?>" />
				<fieldset style="width:800px">
				<legend>Pesquisar Nota</legend>
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td align="left" width="22%">N�mero da Nota</td>
						<td align="left" width="78%">
							<input name="txtNumeroNota" type="text" size="10" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left">C�digo de Verifica��o</td>
						<td align="left">
							<input name="txtCodigoVerificacao" type="text" size="10" class="texto" style="text-transform:uppercase;" />
						</td>
					</tr>
					<tr>
						<td align="left">Prestador - CNPJ/CPF</td>
						<td align="left">
							<input name="txtCNPJPrestador" id="txtCNPJPrestador" maxlength="18" type="text" size="20" class="texto" value="<?php echo $cpfcnpj->cnpjcpf;?>" />
                            <input name="btPesquisar" type="submit" value="Pesquisar" class="botao" onclick="document.getElementById('divBusca').style.visibility='visible'" />
						</td>
					</tr>
                    <tr>
						<td align="left">Prestador - Nome</td>
						<td align="left">
							<input name="txtNomeEmissor" id="txtNomeEmissor" maxlength="30" type="text" size="20" class="texto" />
						</td>
					</tr>
                  <!--  <tr>
						<td align="left">Prestador - CNPJ</td>
						<td align="left">
							<input name="txtCnpjEmissor" id="txtCnpjEmissor" maxlength="30" type="text" size="20" class="texto" />
						</td>
					</tr>
                    -->
					<tr>
						<td align="left">Tomador - CNPJ/CPF</td>
						<td align="left">
							<input name="txtCNPJ" id="txtCNPJ" type="text" size="20" class="texto" maxlength="18" />
						</td>
					</tr>					<tr>
						<td align="left">Data Inicial: </td>
						<td align="left">
							<input name="txtDataInicial" type="text" id="txtDataInicial" size="20" value="<?php echo DataPt($dataInicial);?>" class="texto" />
						</td>
					</tr>					<tr>
						<td align="left">Data Final: </td>
						<td align="left">
							<input name="txtDataFinal" type="text" id="txtDataFinal" size="20" value="<?php echo DataPt($dataFinal);?>" class="texto" />
						</td>
					</tr>
                    <tr>
                    	<td align="left">Tipo: </td>
                        <td align="left">
                        	<label><input type="radio" value="T" name="rdTipo" checked="checked" /> <strong>Todas</strong></label>
                            <label><input type="radio" value="A" name="rdTipo" /> <strong>Avulsas</strong></label>
                            <label><input type="radio" value="N" name="rdTipo" /> <strong>Normais</strong></label>
                        </td>
                    </tr>
					<tr>
						<td align="left" colspan="2">
							<input name="btPesquisar" type="submit" value="Pesquisar" class="botao" onclick="
							acessoAjax('inc/nfe/pesquisar_resultado.ajax.php','frmNfe','divResultado')">
						</td>
					</tr>
				</table>
				</fieldset>
				<div id="divResultado"></div>
			</form>
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>
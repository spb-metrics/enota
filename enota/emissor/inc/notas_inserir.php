<?php
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
?>
<?php 
if($_POST["btInserirNota"] == "Emitir"){
	include("notas_inserir_nova.php");//arquivo que executa o script de insercao no banco de dados
}

$tipopessoa = tipoPessoa($_SESSION['login']);//pega o tipo do prestador, se for cpf usa calculo de RPA

//SELECIONA A ULTIMA NOTA INSERIDA PELA EMPRESA
$sql = mysql_query("SELECT ultimanota, codtipo, codtipodeclaracao FROM cadastro WHERE codigo = '$CODIGO_DA_EMPRESA'");
list($ultimanota,$codtipo,$codtipodec)=mysql_fetch_array($sql);
$ultimanota += 1;

$sql = mysql_query("SELECT notalimite FROM cadastro WHERE codigo = $CODIGO_DA_EMPRESA");
list($notalimite) = mysql_fetch_array($sql);
if($notalimite == 0){
	$notalimite = "Liberado";
}

//GERA O C�DIGO DE VERIFICA��O
$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRXTUVWXYZ';
$max = strlen($CaracteresAceitos)-1;
$password = null;
 for($i=0; $i < 8; $i++) {
 $password .= $CaracteresAceitos{mt_rand(0, $max)}; 
 $carac = strlen($password); 
 if($carac ==4)
 { 
 $password .= "-";
 } 
}

$sql_servicos=mysql_query("
	SELECT 
		cadastro_servicos.codigo,
		servicos.codigo,
		servicos.codservico,
		servicos.descricao,
		servicos.aliquota, 
		servicos.aliquotair, 
		servicos.basecalculo 
	FROM 
		servicos
	INNER JOIN 
		cadastro_servicos ON servicos.codigo = cadastro_servicos.codservico
	WHERE 
		cadastro_servicos.codemissor = '$CODIGO_DA_EMPRESA'
");
 
$sql_lista_regrasdecredito = mysql_query("SELECT credito, tipopessoa, issretido, valor FROM nfe_creditos WHERE estado = 'A' ORDER BY valor DESC");
while(list($nfe_cred,$nfe_tipo_pessoa,$nfe_issretido,$nfe_valor) = mysql_fetch_array($sql_lista_regrasdecredito)){
	$array_regras_credito[] = $nfe_tipo_pessoa."|".$nfe_issretido."|".$nfe_valor."|".$nfe_cred;
}

$regras_credito = implode("-",$array_regras_credito);

//Verifica se o prestador pode ou n�o emitir notas
if(($ultimanota > $notalimite) && ($notalimite != 0)){ 
  echo "<center><font color=\"#000000\"><b>Voc&ecirc; excedeu o limite de AIDFe, por favor solicite um limite maior!</b></font></center>";
?>
<center><a href="aidf.php"><font color="#000099"><b><u>Solicitar mais AIDFe</u></b></font></a></center>
<?php		
}else{ 

	$sql_rps = mysql_query("SELECT ultimorps, limite FROM rps_controle WHERE codcadastro = '$CODIGO_DA_EMPRESA'");
	list($ultimoRPS,$limiteRPS) = mysql_fetch_array($sql_rps);
	
	if($ultimoRPS < 1){
		$ultimoRPS = 0;
	}
	
	if($limiteRPS < 1){
		$limiteRPS = 0;
	}
?>

<form name="frmInserir" method="post" action="notas.php?btPropria=T&btInserir=T" id="frmInserir">
<input name="btInserir" type="hidden" value="Emitir Nota" class="botao" />
<?php
	$sql_municipio = mysql_query("SELECT cidade FROM configuracoes");
	list($UF_MUNICIPIO) = mysql_fetch_array($sql_municipio);
?>
<input type="hidden" id="hdMunicpio" name="hdMunicpio" value="<?php echo $UF_MUNICIPIO;?>" />
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="100" align="center" bgcolor="#FFFFFF" rowspan="3">Emitir Nota</td>
      <td width="470" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">


<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
  <tr>    
      <td  align="left" colspan="3"><font color="#FF0000" size="-2">OBS: N&atilde;o utilizar a tecla Enter para alternar entre os campos.</font>  </td>
  </tr>
  <tr>
    <td colspan="3"><strong><br />
            Informa&ccedil;&atilde;es da Nota</strong>
	</td>
  </tr>
  <tr>
   <td colspan="3">
    
   </td>
  </tr>  
  <tr>
      <td align="center">N&uacute;mero</td>
      <td align="center">Data e Hora de Emiss&atilde;o</td>
      <td align="center">C&oacute;digo de Verifica&ccedil;&atilde;o</td>
  </tr>
  <tr>
    <td align="center"><input name="txtNotaNumero" style="text-align:center;" type="text" size="10" class="texto" readonly="yes" value="<?php print $ultimanota;?> "></td>
    <td align="center">
		<input name="txtNotaDataHoraEmissao" style="text-align:center;" type="text" size="20" class="texto" readonly="yes" 
		value="<?php print date('d/m/Y H:i'); ?>">
	</td>
    <td align="center"><input name="txtNotaCodigoVerificacao" style="text-align:center;" type="text" size="20" class="texto" readonly="yes" value="<?php print $password;?>"></td>
  </tr>  
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
	<tr>
		<td colspan="2">
			<input type="checkbox" name="ckbHabilita" id="ckbHabilita" value="T" 
			onclick="habilitaRPS(this,'txtRpsNum','txtDataRps','hdRPS','hdLimiteRPS','spanRPS')" /> Marque para utilizar RPS
		</td>
	</tr>
	<tr>
            <td width="25%" align="left">N&uacute;mero do RPS</td>
		<td width="75%" align="left">
			<input name="txtRpsNum" id="txtRpsNum" onkeydown="return NumbersOnly( event );" style="text-align:center;" disabled="disabled" 
			type="text" size="6" class="texto" readonly="readonly">
			<input name="hdRPS" id="hdRPS" type="hidden" value="<?php echo $ultimoRPS;?>" />
			<input name="hdLimiteRPS" id="hdLimiteRPS" type="hidden" value="<?php echo $limiteRPS;?>" />
		</td>
	</tr>
	<tr>
		<td align="left">Data do RPS</td>
		<td align="left">
			<input name="txtDataRps" id="txtDataRps" onkeydown="return NumbersOnly( event );"  style="text-align:center;" disabled="disabled" type="text" size="10" 
			maxlength="10" class="texto"> (dd/mm/aaaa) <em>Somente n&uacute;meros</em>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2">
			<span id="spanRPS" style="display:none">
				<font color="#FF0000">
                                <strong>&Eacute; necess&aacute;rio libera&ccedil;&atilde;o de limite de RPS, clique <a href="importar.php">aqui</a> para solicitar.</strong>
				</font>
			</span>
		</td>
	</tr>
</table><br />


<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
  <tr>
      <td colspan="2"><strong>Tomador de Servi&ccedil;os</strong></td>
  </tr>
  <tr>
    <td align="left" width="25%">CPF/CNPJ</td>
    <td align="left"><input name="txtTomadorCNPJ" type="text" size="20" class="texto" onkeydown="stopMsk( event );return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"  maxlength="18" id="txtTomadorCNPJ" onblur="acessoAjax('inc/tomador_nota.ajax.php','frmInserir','divContainer',true);;acessoAjax('inc/valida_cpf.ajax.php','frmInserir','divCPFValidar',true)">
    <div style="float:right;margin-right:40%" id="divCPFValidar"></div></td>
  </tr>
 </table>   
<div id="divContainer">
<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
<tr>
    <td width="25%" align="left">Nome/Raz&atilde;o Social<font color="#FF0000">*</font></td>
    <td width="75%" align="left"><input name="txtTomadorNome" id="txtTomadorNome" type="text" size="55" class="texto">
</td>
  </tr>  
  <tr>
    <td align="left">CEP</td>
    <td align="left">
	 <input name="txtTomadorCEP" id="txtTomadorCEP" onblur="buscacep();" type="text" size="15" class="texto" maxlength="9" onkeydown="return NumbersOnly( event );"  onkeyup="MaskCEP(this);" >
	</td>
  </tr>
  <tr>
      <td align="left">Inscri&ccedil;&atilde;o Municipal</td>
    <td align="left"><input name="txtTomadorIM" id="txtTomadorIM" type="text" size="30" class="texto" onkeydown="return NumbersOnly( event );" ></td>
  </tr>
  <tr>
      <td align="left">Inscri&ccedil;&atilde;o Estadual</td>
    <td align="left"><input name="txtTomadorIE" id="txtTomadorIE" type="text" size="30" class="texto" onkeydown="return NumbersOnly( event );" ></td>
  </tr>
  <tr>
    <td align="left">Logradouro</td>
    <td align="left"><input name="txtTomadorLogradouro" id="txtTomadorLogradouro" type="text" size="30" class="texto">
        &nbsp;&nbsp;N&uacute;mero <input name="txtTomadorNumero" type="text"  onkeydown="return NumbersOnly( event );" size="5" class="texto" maxlength="5"  />
	</td>
  </tr>  
  <tr>
    <td align="left">Complemento</td>
    <td align="left"><input name="txtTomadorComplemento" type="text" size="30" class="texto">
	</td>
  </tr>
  <tr>
    <td align="left">Bairro</td>
    <td align="left"><input name="txtTomadorBairro" id="txtTomadorBairro" type="text" size="30" class="texto"></td>
  </tr>
  <tr>
    <td align="left">UF<font color="#FF0000">*</font></td>
    <td align="left">
    <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
        <select name="txtTomadorUF" id="txtTomadorUF" onchange="buscaCidades(this,'divTomadorMunicipio');">
            <option value=""></option>
            <?php
                $sqlcidades=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                while(list($uf_busca)=mysql_fetch_array($sqlcidades)){
                    echo "<option value=\"$uf_busca\"";if($uf_busca == $UF_MUNICIPIO){ echo "selected=selected"; }echo ">$uf_busca</option>";
                }
            ?>
        </select>
    </td>
  </tr>
  <tr>
    <td align="left">
		Munic&iacute;pio<font color="#FF0000">*</font></td>
    <td align="left">
        <div  id="divTomadorMunicipio">
            <select name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa" class="combo">
                <?php
                    $sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$uf_busca'");
                    while(list($nome_municipio) = mysql_fetch_array($sql_municipio)){
                        echo "<option value=\"$nome_municipio\"";if(strtolower($nome_municipio) == strtolower($NOME_MUNICIPIO)){ echo "selected=selected";} echo ">$nome_municipio</option>";
                    }//fim while 
                ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <td align="left">E-mail</td>
    <td align="left"><input name="txtTomadorEmail" type="text" size="30" class="email"></td>
  </tr>
  <tr>
      <td colspan="8" align="right"></td>
  </tr>
</table>  
</div>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
      <td><strong>Discrimina&ccedil;&atilde;o dos Servi&ccedil;os e/ou Dedu&ccedil;&otilde;es</strong></td>
  </tr>
  <tr>
   <td align="center">
	<textarea name="txtNotaDiscriminacao" cols="0" rows="0" style="width:90%; height:60px;" class="texto" ></textarea>
   </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
  	<td colspan="8">
    <?php
	$codtipodec_teste = coddeclaracao('Simples Nacional');
	//echo $codtipodec."<br>";
	//echo $codtipodec_teste;
	//if($tipopessoa == 'cpf'){
		// include("calculos_nota_inserir_rpa.php");
	if($codtipodec == $codtipodec_teste){
		include("calculos_nota_inserir_simplesnacional.php");	
	}else{
		include("calculos_nota_inserir.php");
	}
	
	?>
	</td>
  </tr>
	  
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
</td></tr></table></form>
<?php } ?>
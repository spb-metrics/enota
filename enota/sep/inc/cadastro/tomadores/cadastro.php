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
//seleciona o estado das configura��es
$sql_info = mysql_query("SELECT estado, cidade FROM configuracoes");
list($UF,$CIDADE) = mysql_fetch_array($sql_info);
	
if($_POST["btSalvar"] == "Salvar"){
	include("atualizar.php");
}
?>

<!-- Formul�rio de insercao de tomadores  --> 
<style type="text/css">
<!--
#divBuscaTomadores {
	position:absolute;
	left:40%;
	top:20%;
	width:298px;
	height:276px;
	z-index:1;
	visibility:<?php if(isset($btBuscarCliente)){ echo"visible";}else{ echo"hidden";} ?>
}
-->
</style>
<div id="divBuscaTomadores" ><?php include("inc/cadastro/tomadores/busca.php"); ?></div>

<?php	
	//verifica se CODTOMADOR tem valor
	if(($_POST['CODTOMADOR'])){		   
		$codigo = $_POST['CODTOMADOR'];	
		$sql_tomador = mysql_query("SELECT codigo,codtipo, nome, IF(cnpj <> '',cnpj,cpf) AS cnpjcpf, inscrmunicipal, inscrestadual, logradouro, complemento, bairro, numero, cep, municipio, uf, email FROM cadastro WHERE codigo = '$codigo'");
		list($codigo,$codtipo,$nome,$cnpjcpf,$inscrmunicipal,$inscrestadual,$logradouro,$complemento,$bairro,$numero,$cep,$municipio,$uf,$email) = mysql_fetch_array($sql_tomador);
	}//fim if
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Tomadores - Cadastro</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="left">
			<form method="post" id="frmCadTomadores">
			<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<?php if($_POST['CODTOMADOR']){?> 
				<input type="hidden" name="CODTOMADOR" id="CODTOMADOR" value="<?php echo $_POST['CODTOMADOR']?>" />
			<?php
					if($_POST["btConsultaCreditos"]){
			?>
						<input type="hidden" name="hdCNPJCPF" value="<?php echo $cnpjcpf;?>" />
						<input name="include" id="include" type="hidden" value="inc/cadastro/tomadores/creditos.php" />
						<script>cancelaAction('frmCadTomadores','principal.php','_parent');</script>
			<?php
					}//fim if
				 }//fim if
			?>
			
				<fieldset><legend>Dados dos Tomadores</legend>
					<table width="100%">
						<tr>
							<td width="16%" align="left">Nome</td>
							<td width="84%" align="left">
							<input name="txtNome" id="txtNome" type="text" class="texto" size="60" maxlength="100" value="<?php if(isset($nome)){echo $nome;} ?>"></td>
						</tr>
						<tr>
							<td align="left">CNPJ/CPF</td>
							<td align="left">
								<input name="txtCNPJCPF" id="txtCNPJCPF" type="text" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"
								class="texto" size="18" maxlength="18" <?php if(isset($cnpjcpf)){ echo "value = '$cnpjcpf' disabled='disabled'";} ?>>
								<input type="hidden" name="hdCNPJCPF" id="hdCNPJCPF" value="<?php if(isset($cnpjcpf)){ echo $cnpjcpf;} ?>" />
							</td>
						</tr>
						<tr>
							<td align="left">Insc. Municipal</td>
							<td align="left"><input name="txtINSCMUNICIPAL" id="txtINSCMUNICIPAL" type="text" class="texto" size="15" maxlength="15" value="<?php if(isset($inscrmunicipal)){echo $inscrmunicipal;} ?>"></td>
						</tr>
                        
                        <tr>
							<td align="left">Insc. Estadual</td>
							<td align="left"><input name="txtINSCESTADUAL" id="txtINSCESTADUAL" type="text" class="texto" size="15" maxlength="15" value="<?php if(isset($inscrestadual)){echo $inscrestadual;} ?>"></td>
						</tr>
                                               
						<tr>
							<td align="left">Logradouro</td>
							<td align="left"><input name="txtLogradouro" id="txtLogradouro" type="text" class="texto" size="60" maxlength="100" value="<?php if(isset($logradouro)){echo $logradouro;} ?>"></td>
						</tr>
                        
                        <tr>
							<td align="left">Complemento</td>
							<td align="left"><input name="txtComplemento" id="txtComplemento" type="text" class="texto" size="60" maxlength="100" value="<?php if(isset($complemento)){echo $complemento;} ?>"></td>
						</tr>
                        
                        <tr>
							<td align="left">Bairro</td>
							<td align="left"><input name="txtBairro" id="txtBairro" type="text" class="texto" size="60" maxlength="100" value="<?php if(isset($bairro)){echo $bairro;} ?>"></td>
						</tr>
                        
						<tr>
                                                    <td align="left">N&uacute;mero</td>
							<td align="left"><input name="txtNumero" id="txtNumero" type="text" class="texto" size="15" maxlength="15" value="<?php if(isset($numero)){echo $numero;} ?>"></td>
						</tr>
						<tr>
							<td align="left">CEP</td>
							<td align="left"><input name="txtCEP" id="txtCEP" type="text" class="texto" size="10" maxlength="9" value="<?php if(isset($cep)){echo $cep;} ?>"></td>
						</tr>
						<tr>
							<td align="left">UF<font color="#FF0000">*</font></td>
							<td align="left">
							<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
								<?php
									if(!$uf){
										$uf_teste = $UF;
									}else{
										$uf_teste = $uf;
									}
									
								?>
                               
								<select name="txtInsUfEmpresa" id="txtInsUfEmpresa" onchange="buscaCidades(this,'txtInsMunicipioEmpresa')">
									<option value=""></option>
									<?php
										$sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
										while(list($uf_busca)=mysql_fetch_array($sql)){
											echo "<option value=\"$uf_busca\"";if($uf_busca == $uf_teste){ 
												echo "selected=selected"; 
											}echo ">$uf_busca</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
                                                    <td align="left">Munic&iacute;pio<font color="#FF0000">*</font></td>
							<td align="left">
								<div  id="txtInsMunicipioEmpresa">
									<select name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa" class="combo">
										<?php
											$sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$uf_teste' ORDER BY nome");
											while(list($nome_municipio) = mysql_fetch_array($sql_municipio)){
												echo "<option value=\"$nome_municipio\"";if(strtolower($nome_municipio) == strtolower($municipio)){ echo "selected=\"selected\"";} echo ">$nome_municipio</option>";
											}//fim while 
										?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td align="left">E-mail</td>
							<td align="left"><input name="txtEmail" id="txtEmail" type="text" class="texto" size="30" maxlength="100" value="<?php if(isset($email)){echo $email;} ?>"><em>Informar somente 01(um)  e-mail</em></td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								<?php
								 $codtipotomador= codtipo('tomador');				 
								 if(($codtipo != $codtipotomador)&&($codtipo)){	?>								 	
									<input type="submit" name="btDetalhesPrestadorVisualizar" value="Detalhes Emissor" class="botao"/>									
								<?php };?>
							</td>
							
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<input type="button" value="Pesquisar" name="btAcao" class="botao" onclick="document.getElementById('divBuscaTomadores').style.visibility='visible'" />
					<?php 
						if($_POST['CODTOMADOR']){
					?>
							<input type="submit" value="Salvar"  name="btSalvar" class="botao">
                            <!--<input name="btConsultaCreditos" type="submit" class="botao" value="Consultar Cr&eacute;ditos"/>-->
					<?php 
						}
					?>
					<input type="submit" name="btLimpar" class="botao" value="Limpar" 
					onclick="LimpaCampos('frmCadTomadores');window.location='cadastro.php';"/>
				</fieldset>
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
<?php
$nome = "";
?>

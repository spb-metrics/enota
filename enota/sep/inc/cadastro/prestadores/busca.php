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
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="150" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;SEPISS - Pesquisar</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" onclick="document.getElementById('divBusca').style.visibility='hidden'" title="Fechar" /></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
<form method="post"  name="frmbusca" id="frmbusca">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<table width="100%">        
        <tr>        	
			<td>
            	CPF/CNPJ</td>
            <td rowspan="4" valign="middle"><input name="btBuscarCliente" type="submit" value="" id="btBuscarCliente" title="Buscar"></td>
        </tr>   
        <tr>        	
			<td>
            	<input name="txtBuscaCPFCNPJ" id="txtBuscaCPFCNPJ" type="text" class="texto" size="59" style="background-color:#255b8f; color:#FFFFFF; text-transform:uppercase" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );">	
			</td>            
	  	</tr>
        <tr>        	
			<td colspan="2"> 
            	Nome
			</td>
        </tr>   
        <tr>        	
			<td colspan="2">
            	<input name="txtBuscaNome" id="txtBuscaNome" type="text" class="texto" size="59" style="background-color:#255b8f; color:#FFFFFF; text-transform:uppercase"  >	
			</td>
            
	  	</tr>
	  <tr>
		<td background="img/busca_fundo.jpg" align="center" colspan="2">	
		<select name="CODEMISSOR" id="CODEMISSOR" size="18" style="width:400px; background-color:#255b8f;color:#FFFFFF;" class="combo" onchange="document.frmbusca.submit();">   		
			<?php 
				$codtipo_orgaop = codtipo('orgao_publico');
			if(isset($_POST['txtBuscaNome']))
				{
					$nome=$_POST['txtBuscaNome'];
					$cpfcnpj = $_POST['txtBuscaCPFCNPJ'];
					$campo = tipoPessoa($cpfcnpj);
					
					if($nome != '' && $cpfcnpj == ''){
						$where=" WHERE nome LIKE'%$nome%' AND estado <> 'NL'";
					}
					else if($nome == '' && $cpfcnpj != ''){
						$where=" WHERE $campo LIKE'%$cpfcnpj%' AND estado <> 'NL'";
					}
					
					//$nome?$cpfcnpj?$where=" WHERE nome LIKE'%$nome%' AND $campo = '$cpfcnpj' AND estado <> 'NL'":$where=" WHERE nome LIKE'%$nome%' AND estado <> 'NL'":NULL;
					//$cpfcnpj?$where=" WHERE $campo = '$cpfcnpj' AND estado <> 'NL'":NULL;
					
					$sql=mysql_query("
					SELECT 
						codigo,
						nome, 
						razaosocial,
						IF(cnpj <> '',cnpj,cpf) AS cnpjcpf,
						inscrmunicipal,
						logradouro,
						numero, 
						municipio, 
						uf, 
						logo,
						email,
						ultimanota, 						
						notalimite,						
						estado, 
						codcontador,
						nfe					
					FROM 
						cadastro 										
					$where
					ORDER BY
						nome
					");
					while(list($codigo,$nome,$razaosocial,$cnpjcpf,$inscrmunicipal,$logradouro,$numero,$municipio,$uf,$logo,$email,$ultima,$notalimite,$estado,$simplesnaconal,$codcontador,$nfe) = mysql_fetch_array($sql)){
						if(!$razaosocial){
							$razaosocial = $nome;
						}
						switch($notalimite){
							case 0:	 $aidf = "Liberado";  break;
							default: $aidf = $notalimite; break;
						}//fim switch
						switch($estado){
							case "A": $estado = "Ativo";  break;
							case "I": $estado = "Inativo";break;
						}//fim switch
						if($razaosocial){
							echo "<option value=\"$codigo\">".$cnpjcpf." - ".$razaosocial."</option>";
						}
					}
				}?>
		</select>
       
		</td>
	</tr>
</table>
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

<map name="Map"><area shape="rect" coords="277,4,294,18" onclick="document.getElementById('divBusca').style.visibility='hidden';" title="Fechar">
</map>
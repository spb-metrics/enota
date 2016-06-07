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
	if($btBuscar!=""){
		$codtipo = codtipo('contador');
		
		switch(strlen($txtCNPJ)){
			case 14: $campo = 'cpf'; break;
			case 18: $campo = 'cnpj'; break;
			default: $campo = null; break;
		}
		$where = '';
		if(!empty($txtNome)){
			$where .= "AND razaosocial LIKE '%$txtNome%'";
		}
		if(!empty($txtCNPJ)){
			if(!is_null($campo)){
				$where .= "AND $campo = '$txtCNPJ'";
			}else{
				$where .= "AND (cpf LIKE '%$txtCNPJ%' OR cnpj LIKE '%$txtCNPJ%')";
			}
		}
		
		$sql = mysql_query("
			SELECT 
				codigo,
				razaosocial
			FROM 
				cadastro
			WHERE
				codtipo = '$codtipo' $where
			ORDER BY
				cadastro.razaosocial
			");
		if(mysql_num_rows($sql)>0){			  
	?>
	<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
			<tr>
				<td width="231">Defina o contador</td>
				<td width="1058">
					<select name="cmbContador">
							<?php
								while(list($codcontador,$razaosocialcontador)=mysql_fetch_array($sql))
									{
										echo "<option value=\"$codcontador\">$razaosocialcontador</option>";
									}				  
							?>	
					  </select>
					  <input type="submit" name="btDefinirContador" class="botao" value="Definir" /></td>
			</tr>
	</table>
	<?php

	}
		else{
			echo "<center>Nenhum contador cadastrado</center>";
		}
;
}

	
?>
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
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	$codigo = $_GET['hdcod'];
	
	$sql_busca = mysql_query("
		SELECT 
			menus_prefeitura_submenus.codigo, 
			submenus_prefeitura.menu, 
			menus_prefeitura_submenus.nivel,
			menus_prefeitura_submenus.ordem
		FROM 
			submenus_prefeitura
		INNER JOIN
			menus_prefeitura_submenus ON menus_prefeitura_submenus.codsubmenu = submenus_prefeitura.codigo
		WHERE 
			menus_prefeitura_submenus.codmenu = '$codigo' AND
			menus_prefeitura_submenus.nfe = 'S'
		ORDER BY
			menus_prefeitura_submenus.ordem
		");
		
?>
<table width="100%">
<?php
	$linhas = mysql_num_rows($sql_busca);
	$x = 0;
	while(list($cod_sub,$menu_sub,$nivel_sub,$ordem) = mysql_fetch_array($sql_busca)){
?>
			<tr>
				<td align="left"><?php echo $menu_sub;?></td>
				<td align="left" width="70%">
					<select name="cmbOrdem<?php echo $x;?>">
					<?php
					for($c=1;$c<=$linhas;$c++){
						if($c==$x+1)
							echo "<option selected=selected>$c</option>";
						else
							echo "<option>$c</option>";
					}
					 ?>
					</select>
					<input type="hidden" name="txtCodigo<?php echo $x;?>" value="<?php echo $cod_sub;?>" />
				</td>
			</tr>
<?php
		$x++;	
	}
?>
</table>
<input type="hidden" name="x" value="<?php echo $x; ?>" />
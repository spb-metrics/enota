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
 $login = $_SESSION['login'];

 if($btAtualizar != "") 
 {
   include("usuarios_editar.php"); 
 }






?>

   <!-- Formul�rio de inser��o de usuarios  -->
   
   <table width="500" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td>
      <fieldset style="width:500px"><legend>Atualiza��o da senha do usu�rio <?php print ("<b><font color=RED>$NOME&nbsp;</font></b>");?></legend>
      <form action="usuarios.php" method="post" name="frmCadUsuarios" >   
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">	       
       <tr>
        <td align="left">Senha</td>
        <td align="left"><input type="password" size="10" maxlength="10" name="txtSenha" class="texto">&nbsp;No m�ximo 10 caracteres        </td>
       </tr>	  
        <td>
	     <input type="submit" value="Atualizar" name="btAtualizar" class="botao"></td>
        <td>		 
		  </td>
        </tr>   
      </table>   
      </form>
      </fieldset>
     </td>
    </tr>  
   </table> 

<!-- Formul�rio de inser��o de usuarios Fim--->

    </td>
  </tr>
  <tr>
    <td> 

<!-- Formul�rio de Edi��o e Ativa��o de servi�os --->


<!-- Formul�rio de Edi��o e Ativa��o de servi�os Fim --->

    </td>
  </tr>  
</table>    
     
   
  
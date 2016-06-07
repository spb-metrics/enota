
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

//JavaScript Document
//arquivo de scripts para o menu principal
var startList = function() {
	if (document.all&&document.getElementById) {
		var navRoot = document.getElementById("nav");
		for (var i=0; i<navRoot.childNodes.length; i++) {
			var node = navRoot.childNodes[i];
			if (node.nodeName=="LI"	) {
				node.onmouseover=function() {
					//alert('"'+this.className+'"');
					this.className+=" over";
				};
				node.onmouseout=function() {
					this.className=this.className.replace(" over", "");
				};
			}
		}
	}
};
var startmenu = function() {
	var navItems = document.getElementById("menu_dropdown").getElementsByTagName("li");
	for (var i=0; i< navItems.length; i++) {
		if(navItems[i].className == "submenua"){
			if(navItems[i].getElementsByTagName('ul')[0] != null){
				navItems[i].onmouseover=function() {
					this.getElementsByTagName('ul')[0].style.display="block";
					this.style.backgroundColor = "#f9f9f9";
				};
				navItems[i].onmouseout=function() {
					this.getElementsByTagName('ul')[0].style.display="none";
					this.style.backgroundColor = "#FFFFFF";
				};
			}
		}
	}
};
//loadEvent(startList);


function chamaForm(menu,submenu){		
	if(menu=='livro'){
		var url='../'+menu+'/'+submenu;	
	}else{
		var url = 'inc/'+menu+'/'+submenu;
	}
	document.getElementById('include').value=url;
	document.getElementById('frmMenu').submit();			    
}

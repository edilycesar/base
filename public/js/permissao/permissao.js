var permissao = {
    
    controller: "controllers/permissao.controller.php",
    
    listarUsuario: function(entidade, elem){        
        var valor = elem.value;
        jQuery.post('usuario/ajaxListar', {            
            entidade: entidade, 
            busca: valor
        }, function(dados){                
            jQuery("#" + entidade + "_ret").html(dados);
            permissao.addEventoUsuario(entidade, 'usuario');
        });
    },
    
    listarUsuarioGrupo: function(entidade, elem){        
        var valor = elem.value;
        jQuery.post('usuarioGrupo/ajaxListar', {            
            entidade: entidade, 
            busca: valor
        }, function(dados){                
            jQuery("#" + entidade + "_ret").html(dados);
            permissao.addEventoUsuario(entidade, 'grupo');
        });
    },
    
    listar: function(){                
        jQuery.post('permissao/ajaxGrupoListar', {
            op: "listar"
        }, function(dados){                
            jQuery("#lista").html(dados);
        });
    },
    
    addEventoUsuario: function(entidade, tipo){
        jQuery(".usuario_lista_item, .usuario_grupo_lista_item").click(function(){
           var id = jQuery(this).attr('title'); 
           var nome = jQuery(this).html();           
           permissao.seleciona(entidade, id, nome, tipo);
        });
    },
    
    seleciona: function(entidade, id, nome, tipo){         
        var tag = "<div class='"+ entidade +"_sel_item sel_item'>";
        tag += "<div class='item_id' data-tipo='" + tipo + "'>" + id + "</div>";
        tag += "<div class='item_nome'>" + nome + "</div>";
        //tag += "<div class='item_apagar' onclick='permissao.apagar(this)'>X</div>";
        tag += "</div>";
        jQuery("#" + entidade + "_sel").append(tag);
        jQuery("#" + entidade + "_input").focus();
        jQuery("#" + entidade + "_ret").html("");
        jQuery(".input").val("");  
        permissao.gravarSelecionados();
    },
    
    apagar: function(elem, permissaoId){    
        if(confirm("Tem certeza?")){
            permissao.apagarDase(permissaoId);
            jQuery(elem).parent(".sel_item").remove();
        }
    },
    
    selecionados: function(entidade){
        var elem = jQuery("#" + entidade + "_sel").children(".sel_item").children(".item_id");
        var c = elem.length;
        var ids = "";        
        var tipos = "";
        for(var i=0; i<c; i++){  
            tipos += jQuery(elem[i]).attr('data-tipo') + ",";            
            ids += jQuery(elem[i]).html() + ",";
        }     
        var dados = new Object();
        dados.ids = ids.substr(0, ids.length-1);
        dados.tipos = tipos.substr(0, tipos.length-1);
        return dados;
    },
    
    buscar: function(){     

    },
    
    gravarSelecionados: function(){
        var recursos = "";
        var usuariosIds = "";
        var tipos = "";
        var elems = jQuery(".recurso_item_content");
        var c = elems.length;
        for(var i=0; i<c; i++){
            var recurso = jQuery(elems[i]).attr("id");
            var dados = permissao.selecionados(recurso);            
            if(dados.ids != ""){
                recursos += recurso + ";";
                usuariosIds += dados.ids + ";";
                tipos += dados.tipos + ";";
            }
        }
        //alert(usuariosIds + "!" + tipos);
        permissao.gravar(recursos, usuariosIds, tipos);
    },
    
    gravar: function(recursos, usuariosIds, tipos){
        jQuery.post('permissao/gravar', {            
            recursos: recursos,
            usuariosIds: usuariosIds,
            tipos: tipos 
        }, function(){               
            permissao.listar();
        });
    },
    
    apagarDase: function(permissaoId){
        jQuery.post('permissao/apagar', {            
            permissaoId: permissaoId
        }, function(){     
            permissao.listar();
        });
    },
    
    selecionarTodos: function(grupo){
        if(confirm("Tem certeza que deseja adicionar todos os usuários neste grupo!?!?!?")){
            jQuery.post(this.controller, {
                op: "selecionar_todos",
                grupo: grupo
            }, function(dados){ 
                //alert(dados);
                permissao.listar();
            });
        }    
    },
    
    efeitoContent: function(elem){
        jQuery(".recurso_item_content").removeAttr("style");
        jQuery(elem).css({backgroundColor: "#eeeeee"});
    }
};

jQuery(document).ready(function(){    
   permissao.listar();   
   
   jQuery(".select_loko").click(function(){
      jQuery(".busca_resultado").html("");
   });   
});
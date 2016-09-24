var Menu = {
  
  mudarVisao: function(itemElem){
        jQuery(".menu1-subitens-ativo").remove();
        var subitemId = jQuery(itemElem).attr("data-id-subitem");
        if(subitemId !== undefined){ 
           var subitemElem = "#" + subitemId;
           this.subitensExibir(itemElem, subitemElem); 
        }    
  },
  
  subitensExibir: function(itemElem, subitemElem){      
      var html = jQuery(subitemElem).html();
      this.subitensAppend(itemElem, html);   
      this.subitensExibirAnima();
  },
  
  subitensExibirAnima: function(){
      //jQuery(".menu1-subitens-ativo").slideDown();
      //jQuery(".menu1-subitens-ativo").fadeIn(300);
  },
  
  subitensAppend: function(itemElem, html){      
      var h = jQuery(itemElem).height();
      var offset = jQuery(itemElem).offset();
      var nav = document.createElement('nav');
      nav.className = "menu1 menu1-subitens-ativo fa-times-af";
      nav.style.position = "absolute";
      nav.style.top = parseInt(offset.top + h - 5) + "px";
      nav.style.left = parseInt(offset.left - 5) + "px";
      var ul = document.createElement('ul');
      ul.innerHTML = html;      
      nav.appendChild(ul);
      document.body.appendChild(nav);
      
      jQuery(".menu1-subitens-ativo").click(function(){
          Menu.subitensRemove();
      });
      
  },
  
  subitensRemove: function(){
    if(jQuery(".menu1-subitens-ativo").length > 0){
        jQuery(".menu1-subitens-ativo").remove(); 
    }
  }
  
};

var mensagens = {
  
  addBt: function(){
      var str = jQuery("#msgError").html();
      if(str != ''){
          jQuery("#msgError").html(str + " <span class='fa-times-circle'></span>");
      }
      
      var str = jQuery("#msgOk").html();
      if(str != ''){
          jQuery("#msgOk").html(str + " <span class='fa-times-circle'></span>");
      }
  },
  
  boxShowCss: function() {
      var box = jQuery(".sysMsgBox");
      var c = box.length;
      for(var i=0; i<c; i++){
        if(jQuery(box[i]).html() != ''){
            jQuery(box[i]).addClass('sysMsgBoxShowing');
        }
      }
  },
  
  anima: function(){
      mensagens.addBt();
      mensagens.boxShowCss();
  }  
};

//var OcorrenciasGL = {    
//    bairrosInvalidos: function(){
//        jQuery.post("ocorrencia/ajaxValidaBairros", {
//            
//        }, function(dados){
//           alert(dados);
//        });
//    }
//};

var Alertas = {
    
    add: function(msg, data, id){
        
        this.addSinal();
        this.addMsgContent();
        
        var p = document.createElement('p');
        p.innerHTML = "&bull; &nbsp;" + msg;
        p.setAttribute('data-alerta-id', id);
        
        var divData = document.createElement('div');
        divData.className = "alerta-data";
        divData.innerHTML = data;
        
        var divBtV = document.createElement('div');
        divBtV.className = "alerta-bt-v  fa-check";
        divBtV.setAttribute('title', 'Marcar visto');
        divBtV.setAttribute('data-alerta-id', id);
        divBtV.addEventListener('click', function(){
           Alertas.marcarVisto(this); 
        });
        
        p.appendChild(divData);
        p.appendChild(divBtV);
        document.getElementById('alertas-msgs').appendChild(p);
    },
    
    addSinal: function(){
        var s = document.getElementsByClassName('alertas-sinal');
        if(s.length === 0){
            var div = document.createElement('div');
            div.innerHTML = "!";
            div.className = "alertas-sinal";
            document.getElementById('alertas').appendChild(div);
        }    
    },
    
    addMsgContent: function(){
        var s = document.getElementById('alertas-msgs');        
        if(s == null){           
            var divMsg = document.createElement('div');        
            divMsg.id = "alertas-msgs";
            document.getElementById('alertas-content').appendChild(divMsg);
        }    
    },
    
    listar: function(){
        jQuery("#alertas-msgs").html("");
        jQuery.post("alerta/ajaxListar", {            
        }, function(dados){
            Alertas.exibir(dados);
            if(jQuery("#alertas-msgs").html() == ""){
                jQuery("#alertas-msgs").hide();
                jQuery(".alertas-sinal").hide();
            }
        }, "json");
    },
    
    exibir: function(dados){
        var c = dados.length;
        for(var i=0; i<c; i++){
            Alertas.add(dados[i].msg, dados[i].data,  dados[i].id);
        }
    },
    
    marcarVisto: function(elem){
        var id = jQuery(elem).attr('data-alerta-id');
        jQuery.post("alerta/marcarVisto", {
            id: id
        }, function(dados){
            if(dados != 1){
                alert("Erro ao marcar visto");
            }
//            jQuery(elem).parent('p').remove();
            
            Alertas.listar();
        });
    }
};

Permissao = {
    
    aplicar: function(){
      this.pegarElementos();  
    },
  
    pegarElementos: function(){
        var itens = jQuery(".controle-acesso");
        var c = itens.length;
        for(var i=0; i<c; i++){
            
            var grupo = this.pegaController(itens[i]);
            //var grupo = jQuery(itens[i]).attr('data-per-grupo');
            
            if(this.permitido(grupo) === false){
                jQuery(itens[i]).css({opacity: 0.3});
                jQuery(itens[i]).removeAttr("onclick");
            }
        }
    },
    
    permitido: function(grupo){
        var controllers = jQuery("#controllers-permitidos").val();
        var contArr = controllers.split(",");
        var c = contArr.length;
        for(var i=0; i<c; i++){
            if(contArr[i].toLowerCase() ==  grupo.toLowerCase()){
                return true;
            }
        }
        return false;
    },
    
    pegaController: function(elem){
        var ctrl = jQuery(elem).attr("onclick");
        ctrl = ctrl.replace(/'/g, "");
        ctrl = ctrl.replace(/"/g, "");
        ctrl = ctrl.replace(/location/g, "");
        ctrl = ctrl.replace(/=/g, "");
        ctrl = ctrl.replace(/ /g, "");
        var ctrlArr = ctrl.split("/");
        var ctrl2 = ctrlArr[0] + "_";
        ctrl2 += ctrlArr[1] === undefined ? "index" : ctrlArr[1];
        return ctrl2;
    }
};

jQuery(document).ready(function(){
    
//    mensagens.anima();
    
    jQuery(".sysMsgBox").click(function(){
       jQuery(this).removeClass('sysMsgBoxShowing');
       jQuery(this).html(''); 
    });
    
    //Alertas
//    Alertas.listar();
//    setInterval(function(){
//        Alertas.listar();
//    }, 60000);
    
    //Efeitos menu principal
    jQuery("#menu1 li").click(function(){
        Menu.mudarVisao(this);
    });
    
    jQuery("body").click(function(){        
       //Menu.subitensRemove();
    });
});
var imagemAdm = {
    
  setTitulo: function(id, elem){
      var texto = prompt("Digite o titulo ");
      jQuery.post("arquivo/setDados", {
          id: id,
          titulo: texto          
      }, function(dados){
        if(dados != 1){
            alert("Erro ao alterar o titulo");
        }else{            
            jQuery(elem).html("&nbsp;" + texto);
        }
      });
  },    
    
  setTexto: function(id, elem){
      var texto = prompt("Digite o texto");
      jQuery.post("arquivo/setDados", {
          id: id,
          texto: texto //coluna: valor         
      }, function(dados){
        if(dados != 1){
            alert("Erro ao alterar o texto");
        }else{            
            jQuery(elem).html("&nbsp;" + texto);
        }
      });
  }  
};
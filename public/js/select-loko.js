var selectLoko = {
  
    elem: null,
  idElemId: null,
  idElemRet: null,
  urlWS: null,
    
  buscar: function(elem, idElemId, idElemRet, urlWS, callBack){
        this.idElemId = idElemId;
        this.idElemRet = idElemRet;
        this.urlWS = urlWS;
        this.elem = elem;
        var busca = this.elem.value;
        jQuery.post(this.urlWS, {
            busca: busca
        }, function(data){                        
            jQuery("#" + selectLoko.idElemRet).html(data);
            selectLoko.addEventoClique(callBack);            
        });
  },
  
  addEventoClique: function(callBack){
      jQuery("#" + selectLoko.idElemRet + " div").click(function(){
         var id = jQuery(this).attr("title"); 
         var nome = jQuery(this).html(); 
         jQuery(selectLoko.elem).val(nome);
         jQuery("#" + selectLoko.idElemId).val(id);
         jQuery("#" + selectLoko.idElemRet).html("");  
         if(callBack != ''){             
            eval(callBack);
         }
      });
  }
};
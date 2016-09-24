var abaMenu = {
  
    elemPai: "",
    maiorHeight: 0,
  
    getElemPai: function(elem){
       this.elemPai = jQuery(elem).parent('.abas-menu').parent('.abas-content');
//       var classe = jQuery(this.elemPai).attr('class');
//       alert(classe);
    }, 
  
    selBt: function(elem){
        
        if(elem === undefined || elem === '' || elem === null){
            var item = jQuery('.abas-menu-item');
            elem = item[0];
        }
        
        var n = jQuery(elem).attr('data-item-n');
        abaMenu.setVisivel(n);
        
        jQuery('.abas-menu-item').removeAttr('style');
        jQuery('.abas-menu-item-barra').remove();
        jQuery(elem).css({
           marginBottom: '-1px',
           opacity: '1'
        });
        jQuery(elem).append('<div class="abas-menu-item-barra"></div>');
        
        var callback = jQuery(elem).attr('data-callback');
        
        if(callback !== undefined && callback !== '' && callback !== null){
            eval(callback);
        }
        
        this.setAlturaContent();
    },
    
    setVisivel: function(n){   
        jQuery(".abas-box").removeClass('box-sel');
        jQuery(".abas-box").removeAttr('style');
        
        jQuery(".abas-box-" + n).addClass('box-sel');
        
        var h = jQuery(".abas-box-" + n).height();
        jQuery(".abas-content").height(h);
        
    },
    
    getMaiorHeight: function(){
        var itens = jQuery(".abas-box");
        var c = itens.length;
        for(var i=0; i<c; i++){
            var h = parseInt(jQuery(itens[i]).height());
            if(h > this.maiorHeight){
                this.maiorHeight = h;
            }
        }
    },
    
    setAlturaContent: function(){
        this.getMaiorHeight();
        jQuery(".abas-content, .abas-box").height(this.maiorHeight + 200);
        jQuery(".abas-box").height(this.maiorHeight);
    }
    
};


jQuery(document).ready(function(){   
    jQuery('.abas-menu-item').click(function(){
        abaMenu.selBt(this);
    });
    abaMenu.selBt();
});




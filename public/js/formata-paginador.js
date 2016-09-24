var fPag = {
    
    classContent: "paginator",    
    classItem: "pgButton",
    idCurrentPg: "currentPg",
    
    elemContent: null,
    
    currentPg: null,
    nShow: 10,
    nStep: 9,
    nPg: 0,
    lastShowing: 0,
    
    init: function(){
        
        if( jQuery("." + fPag.classItem).length < ((fPag.nShow) + 1) ){
            return false;
        }
        
        fPag.elemContent = jQuery("." + fPag.classContent);
        
        if(fPag.currentPg === null){
            fPag.currentPg = parseInt(document.getElementById(fPag.idCurrentPg).value);
        }
        
        var sta = fPag.currentPg === 0 ? fPag.currentPg : fPag.currentPg - 1;
        var end = fPag.currentPg + fPag.nShow;
        var itens = jQuery("." + fPag.classItem);
        fPag.nPg = itens.length;
        
        jQuery("." + fPag.classItem).hide();
        
        for(var i=sta; i<=end; i++){
            if(jQuery(itens[i]).html() !== undefined){
                jQuery(itens[i]).show();
                fPag.lastShowing = parseInt(jQuery(itens[i]).html());
            }
        }        
        
        fPag.addNavButtons();
    },
    
    showBtPro: function(){
        fPag.currentPg = fPag.currentPg + fPag.nStep;
        fPag.init();
    },
    
    showBtAnt: function(){
        fPag.currentPg = fPag.currentPg - fPag.nStep;
        fPag.init();
    },
    
    addNavButtons: function(){
        
        jQuery(".btNavAnt, .btNavPro").unbind();
        jQuery(".btNavAnt, .btNavPro").remove();
        
        if(fPag.currentPg > 0){
            jQuery(fPag.elemContent).prepend("<div class='btNavAnt'> Anterior </div>");
        }   
        
        if(fPag.lastShowing < fPag.nPg){
            jQuery(fPag.elemContent).append("<div class='btNavPro'> Próximo </div>");
        }    
        
        jQuery(".btNavAnt").click(function(){
            fPag.showBtAnt();
        });
        
        jQuery(".btNavPro").click(function(){
            fPag.showBtPro();
        });
    }
};

jQuery(document).ready(function(){
    fPag.init();
});

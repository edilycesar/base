var Carro = {
    
    dateFrom: null,
    dateTo: null,
    currentPg: null,
    divs: null,
    secs: null,
    comb: null,
    buscarCol: null,
    buscar: null,
    finalPlaca: null,
    
    exportarXls: function(queryKey){
        window.open("carro/exportarXls/queryKey/" + queryKey);
    },
    
    submitForm: function(){
        jQuery("#currentPg").val("0");
        this.go();
    },
    
    changePg: function(){
        this.go();
    },
    
    go: function(){
        this.getParams();        
        var url = "carro/index";
            url += (this.currentPg != "" ? "/pg/" + this.currentPg : '');
            url += (this.divs != "" ? "/divs/" + this.divs : '');
            url += (this.secs != "" ? "/secs/" + this.secs : '');
            url += (this.comb != "" ? "/comb/" + this.comb : '');
            url += (this.buscarCol != "" ? "/buscarCol/" + this.buscarCol : '');
            url += (this.buscar != "" ? "/buscar/" + this.buscar : '');
            url += (this.finalPlaca != "" ? "/finalPlaca/" + this.finalPlaca : '');
        location = url;    
    },
    
    getParams: function(){        
       this.currentPg = jQuery("#currentPg").val(); 
       this.divs = checkbox.pegaChecados('divsItem');
       this.secs = checkbox.pegaChecados('secsItem');
       this.comb = jQuery('#combustivel').val();
       this.buscarCol = jQuery('#buscarCol').val();
       this.buscar = jQuery('#buscar').val();
       this.finalPlaca = jQuery('#finalPlaca').val();
    },
    
    checkAllIfNone: function(){
        var divs = checkbox.pegaChecados('divsItem');
        var secs = checkbox.pegaChecados('secsItem');
        
        if(divs == ""){
            jQuery('.divsItem').prop("checked", "on");
        }
        
        if(secs == ""){
            jQuery('.secsItem').prop("checked", "on");
        }        
    },
    
    changeViewFilterForm: function(){
        
    }
};

jQuery(document).ready(function(){
   
    jQuery("#carFormFilter").submit(function(){
        Carro.submitForm();
        return false;
    });
    
    jQuery(".pgButton").click(function(){
        jQuery("#currentPg").val( jQuery(this).attr("data-pg") );
        Carro.changePg();
    });    
    
    jQuery("#btFilter").click(function(){
        View.changeView("filter-content");
    });
    
    Carro.checkAllIfNone();
    
});
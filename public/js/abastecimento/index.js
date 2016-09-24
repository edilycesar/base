var Abastecimento = {
    
    dateFrom: null,
    dateTo: null,
    currentPg: null,    
    secs: null,
    buscarCol: null,
    buscar: null,
    combs: null,
    
//    exportarXls: function(queryKey){
//        window.open("abastecimento/exportarXls/queryKey/" + queryKey);
//    },
    
    submitForm: function(){
        jQuery("#currentPg").val("0");
        this.go();
    },
    
    changePg: function(){
        this.go();
    },
    
    go: function(){
        this.getParams();        
        var url = "abastecimento/index";
            url += (this.currentPg != "" ? "/pg/" + this.currentPg : '');
            url += (this.secs != "" ? "/secs/" + this.secs : '');    
            url += (this.combs != "" ? "/combs/" + this.combs : '');
            url += (this.buscarCol != "" ? "/buscarCol/" + this.buscarCol : '');
            url += (this.buscar != "" ? "/buscar/" + this.buscar : '');
        location = url;    
    },
    
    getParams: function(){        
       this.currentPg = jQuery("#currentPg").val();      
       this.secs = checkbox.pegaChecados('secsItem');
       this.combs = checkbox.pegaChecados('combsItem');
       this.buscarCol = jQuery('#buscarCol').val();
       this.buscar = jQuery('#buscar').val();
    },
    
    checkAllIfNone: function(){
        var combs = checkbox.pegaChecados('combsItem');
        var secs = checkbox.pegaChecados('secsItem');
        
        if(combs == ""){
            jQuery('.combsItem').prop("checked", "on");
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
        Abastecimento.submitForm();
        return false;
    });
    
    jQuery(".pgButton").click(function(){
        jQuery("#currentPg").val( jQuery(this).attr("data-pg") );
        Abastecimento.changePg();
    });        
    
    Abastecimento.checkAllIfNone();
    
});
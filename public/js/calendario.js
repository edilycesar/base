var calendario = {
    
    diaUmTs: '',
    diaSem:'',
    dataOb: '',
    
    formatar: function(){
        this.ajustarPosicao();
        this.setTitulo();
    },
    
    ajustarPosicao: function(){
        this.pegaDiaUm();
        this.pegaDiaSem();
        this.adicionaItens();
    },
    
    pegaDiaUm: function(){        
        var itens = jQuery(".calendario-item");
        this.diaUmTs = jQuery(itens[0]).attr('id');         
        return this.diaUmTs;
    },
    
    pegaDiaSem: function(){
        var ms = this.diaUmTs * 1000;
        this.dataOb = new Date(ms);
        this.diaSem = this.dataOb.getDay();
        return this.diaSem;
    },
    
    adicionaItens: function(){
        for(var i=0; i<this.diaSem; i++){
            var html = "<div class='calendario-item'>&nbsp;</div>";
            jQuery("#calendario-itens").prepend(html);
        }
    },
    
    setTitulo: function(){
        var mes = this.dataOb.getMonth();
        var ano = this.dataOb.getYear() + 1900;
        var mesesNomes = new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", 
        "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
        var html = "<h1 class='calendario-titulo'>" + mesesNomes[mes] + "/" + ano + "</h1>";
        jQuery("#calendario").prepend(html);
    }
};

jQuery(document).ready(function(){
    calendario.formatar();
});
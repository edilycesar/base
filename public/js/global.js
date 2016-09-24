var global = {
    
    confirma: function(url, msg){
        if(msg == '' || msg == undefined){
            msg = 'Tem certeza?';
        }
        if(confirm(msg)){
            location = url;
        }
    },
    
    moveScrollNoElem: function (elem_id){
        var p = jQuery("#" + elem_id).offset();        
        jQuery(document).scrollTop(p.top);
    },
    
    moveScrollNoElem2: function (elem){
        var p = jQuery(elem).offset();        
        jQuery(document).scrollTop(p.top);
    },
    
    avisoOk: function(msg){
        jQuery(".msgOk").html(msg);        
        setTimeout(function(){
            jQuery(".msgOk").html("");
        }, 5000);
    },
    
    avisoError: function(msg){
        jQuery(".msgError").html(msg);
        setTimeout(function(){
            jQuery(".msgError").html("");
        }, 5000);
    },
    
    editarElem: function(classe, evento, executar){   
        
        var tag = document.getElementsByClassName(classe);        
        var c = tag.length;        
        for(var i=0; i<c; i++){
            tag[i].addEventListener(evento, function(){
                //alert(this.innerHTML);
                eval(executar);
            });
        }        
    },
    
    empty: function(v){
        if(v != undefined && v != null && v != '' ){
            return false;
        }
        return true;
    }
};

var checkbox = {
    
    selMestre: function(elem, classe){
        jQuery('.' + classe).prop('checked', elem.checked);
    },
    
    pegaChecados: function(classe){
        var valores = '';
        var itens = jQuery("." + classe);
        var c = itens.length;        
        for(var i=0; i<c; i++){
            if(itens[i].checked){
                valores += itens[i].value + ',';
            }
        }
        if(valores != ''){
            valores = valores.substr(0, valores.length - 1);
        }
        return valores;
    }
};

var exportar = {
    
    imprimir: function(elemId){        
        exportar.omiteNaoImprimiveis();
        var conteudo = jQuery("#" + elemId).html();
        if(exportar.valida(conteudo)){
            var jan = window.open();        
            jan.document.write(conteudo);
            jan.document.close();
            jan.print();        
        }
        exportar.exibeNaoImprimiveis();
    },
    
    xls: function(elemId){        
        exportar.omiteNaoImprimiveis();
        var conteudo = jQuery("#" + elemId).html();        
        if(exportar.valida(conteudo)){
            jQuery.post("exportar/xls", {
                conteudo: conteudo
            }, function(data){
                window.open(data);
            });
        }    
        exportar.exibeNaoImprimiveis();
    },
    
    pdf: function(elemId){        
        exportar.omiteNaoImprimiveis();
        var conteudo = jQuery("#" + elemId).html();        
        if(exportar.valida(conteudo)){
            jQuery.post("exportar/pdf", {
                conteudo: conteudo
            }, function(data){
                window.open(data);
            });
        }   
        exportar.exibeNaoImprimiveis();
    },
    
    enviarEmail: function(elemId, email, callback){        
        exportar.omiteNaoImprimiveis();
        var conteudo = jQuery("#" + elemId).html();        
        if(exportar.valida(conteudo)){
            jQuery.post("exportar/enviarPorEmail", {
                conteudo: conteudo,
                email: email
            }, function(data){
                if(callback != undefined && callback != ''){
                    eval(callback);
                }
            });
        }   
        exportar.exibeNaoImprimiveis();
    },
    
    valida: function(conteudo){
        if(conteudo == ""){
            alert("Não há resultado para exportar, verifique.");
            return false;
        }
        return true;
    },
    
    omiteNaoImprimiveis: function(){
        jQuery('.naoImprimir').hide();
    },
    
    exibeNaoImprimiveis: function(){
        jQuery('.naoImprimir').show();
    }
};

var numero = {
    soNumeros: function(str){
        var num = "";
        var c = str.length;
        for(var i=0; i<c; i++){
            var car = str[i];
            if( isNaN(car) !== true){
                num += car;
            }
        }
        return num.trim();
    },
    
    maskMoney: function(elem){
        var data = jQuery(elem).val();        
        data = numero.soNumeros(data);        
        var dataN = "";
        var c = data.length;
        for(var i=0; i<c; i++){
          dataN += data.substr(i,1);  
          if(i == c-3){
             dataN += ",";
          } 
        }
        jQuery(elem).val(dataN);
        return dataN;
    },
    
    isFloat: function(valor){
        valor = "" + valor;
        if( valor.indexOf(".") === -1 ){
            return false;
        }
        return true;
    },
    
    moneyFormat: function(valor, sepDec){
        valor = "" + valor;
        
        if(sepDec == ''){
            sepDec = ',';
        }
        
        var p = valor.lastIndexOf('.');
        if(p != -1){
            var v3 = valor.substr(p+2, 1);   
            if(v3 == ''){
                valor += "0";
            }
        }
        
        valor = numero.soNumeros(valor);
        var valorN = "";
        var c = valor.length;        
        for(var i=0; i<c; i++){
          valorN += valor.substr(i,1);  
          if(i == c-3){
             valorN += sepDec;
          } 
        }        
        return valorN;
    },
    
    maskCpf: function(elem){
        var data = jQuery(elem).val();        
        data = numero.soNumeros(data);        
        var dataN = "";
        var c = data.length;
        for(var i=0; i<c; i++){
          dataN += data.substr(i,1);  
          if(i == 2 ||i == 5){
             dataN += ".";
          }else if(i == 8){
              dataN += "-";
          } 
        }
        dataN = dataN.substr(0,14);
        jQuery(elem).val(dataN);
        return dataN;
    },
    
    maskTel: function(elem){
        var data = jQuery(elem).val();        
        data = numero.soNumeros(data);        
        var dataN = "";
        var c = data.length;
        for(var i=0; i<c; i++){
          dataN += data.substr(i,1);  
          if(i == 1){
             dataN += ")";
          } 
        }
        dataN = "(" + dataN.substr(0,14);
        jQuery(elem).val(dataN);
        return dataN;
    },
    
    doisDigitos: function(n){
        n = parseInt(n);
        if(n > 9){
            return n;
        }else{
            n = "0" + n;
        }
        return n;
    },
    
    duasCasasDec: function(valor){
        valor = '' + valor;
        var p = valor.lastIndexOf(".");
        if(p == -1){
            return valor + '.00';
        }
        
        //pega 3ª casa
        var v3 = valor.substr(p+3, 1);   
        v3 = parseInt(v3);
        
        valor = parseFloat(valor);
        
        if(v3 >= 5){
            var dif = 10 - v3;
            console.log('*dif:' + dif);
            var add = '0.00' + dif;
            add = parseFloat(add);
            valor = valor + add;            
        }else{
            var rem = '0.00' + v3;
            rem = parseFloat(rem);
            valor = valor - rem;            
        }
        
        //retira depois das 2 casas
        valor = '' + valor;
        valor = valor.substr(0, p+3); 
        valor = numero.moneyFormat(valor, '.');
        return valor;
    }
};

var data = {
    
    maskData: function(elem){
        var data = jQuery(elem).val();        
        data = numero.soNumeros(data);        
        var dataN = "";
        var c = data.length;
        for(var i=0; i<c; i++){
          dataN += data.substr(i,1);  
          if(i == 1 || i == 3){
             dataN += "-";
          } 
          if(i >= 7){
            break;
          }
        }
        jQuery(elem).val(dataN);
        return dataN;
    },
    
    maskDataHora: function(elem){
        var data = jQuery(elem).val();        
        data = numero.soNumeros(data);                
        var dataN = "";
        var c = data.length;
        for(var i=0; i<c; i++){
            dataN += data.substr(i,1);  
            dataN = dataN.trim();
            if(i == 1 || i == 3){
               dataN += "-";
            }else if(i == 7){
                dataN += "_";
            }else if(i == 10 || i == 12){
                dataN += ":";
            }
            
            if(i >= 14){
                break;
            }
        }
        dataN = dataN.replace("_", " ");
        jQuery(elem).val(dataN);
        return dataN;
    },
    
    hoje: function(n){
        var d = new Date();
        if(n != ''){
            n = parseInt(n);            
            d.setDate(d.getDate() + n);
        }
        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var ano = d.getYear() + 1900;
        var hoje = numero.doisDigitos(dia) + "-" + numero.doisDigitos(mes) + "-" + ano;
        return hoje;
    },
    
    timestampToDateHour: function(timestamp){
        
        var hsFaltando = 0;
        var mnFaltando = 0;
        var hsFaltandoInt = 0;
        var scFaltando = 0;
        var mnFaltandoInt = 0;
        var scFaltandoInt = 0;
        var h = 0;
        var m = 0;
        var s = 0;
        
        //Segundos
        scFaltandoInt = parseInt(timestamp % 60);

        //Minutos            
        mnFaltando = timestamp / 60;            
        mnFaltandoInt = parseInt(mnFaltando % 60);

        //Horas            
        hsFaltando = mnFaltando / 60;
        hsFaltandoInt = parseInt(hsFaltando);

        h = numero.doisDigitos(hsFaltandoInt);
        m = numero.doisDigitos(mnFaltandoInt);
        s = numero.doisDigitos(scFaltandoInt);

        return h + ":" + m + ":" + s;
    },
    
    preencheDias: function(n, callback){          
        if(n !== '' && n != undefined){
            if(n >= 0){
                var de = data.hoje(0);
                var ate = data.hoje(n);
            }else{
                var de = data.hoje(n);
                var ate = data.hoje(0);
            }
            
            jQuery("#data-de").val(de);
            jQuery("#data-ate").val(ate);
        }else{
            jQuery("#data-de").val('');
            jQuery("#data-ate").val('');
        }
        
        if(callback != undefined && callback != ''){
            eval(callback);
        }
        
    },
    
    getAno: function(data){
        // 01/03/2016
        return data.substr(6, 4);
    },
    
    getMes: function(data){
        // 01/03/2016
        return data.substr(3, 2);
    },
    
    getDia: function(data){
        // 01/03/2016
        return data.substr(0, 2);
    },
    
    intervaloDias: function(dataDe, dataAte){
        
        var ai = data.getAno(dataDe);
        var mi = data.getMes(dataDe);
        var di = data.getDia(dataDe);
        
        var af = data.getAno(dataAte);
        var mf = data.getMes(dataAte);
        var df = data.getDia(dataAte);
        
        var dateIni = new Date(ai, mi, di, 00, 00, 01, 0); 
        
        var dateFim = new Date(af, mf, df, 00, 00, 01, 0); 
        
        var ms = dateFim.valueOf() - dateIni.valueOf();
        var seg = ms  / 1000;  
        var min = seg / 60;
        var hor = min / 60;
        var dias = Math.round(hor / 24);
        
        return dias + 1;
    }
};


var cepLoko = {    
    
    maskCep: function(elem){
        var data = jQuery(elem).val();        
        data = numero.soNumeros(data);        
        var dataN = "";
        var c = data.length;
        for(var i=0; i<c; i++){
          dataN += data.substr(i,1);  
          if(i == c-4){
             dataN += "-";
          } 
          if(i >= 7){
            break;
          }
        }
        jQuery(elem).val(dataN);
        return dataN;
    }
};


//var cepLoko = {    
//    
//    maskCep: function(elem){
//        var data = jQuery(elem).val();        
//        data = numero.soNumeros(data);        
//        var dataN = "";
//        var c = data.length;
//        for(var i=0; i<c; i++){
//          dataN += data.substr(i,1);  
//          if(i == c-4){
//             dataN += "-";
//          } 
//          if(i >= 7){
//            break;
//          }
//        }
//        jQuery(elem).val(dataN);
//        return dataN;
//    }
//    
//};

var stringLoka = {
    tira_ultimo_caractere: function(string){        
        return string.substr(0,string.length - 1);
    }
};

var config = {
  add: function(nome, valor, callback){      
      var url = "config/add";
      jQuery.post(url, {
          nome: nome,
          valor: valor
      }, function(dados){
          //alert(dados.sucesso);
      }, 'json');
  },
  
  get: function(nome, callback){
      var url = "config/get";
      jQuery.post(url, {
          nome: nome
      }, function(dados){
          //alert(dados.valor);
          if(callback != ''){
                //alert(callback);
                eval(callback);
          }
      }, 'json');
  }
};


var favoritos = {
    
    nome: "",
    anterior: "",
    iconeTitulo: "",
    documentUrl: "",
    
    add: function(temAnt, temTit){
        
        favoritos.documentUrl = document.URL;
        
        if(temAnt !== true){//Pega valor do banco de dados para concatenar com o novo
            var callback = " favoritos.anterior = dados.valor;";
            callback += " favoritos.add(true, false);";
            favoritos.get(callback);            
//        }else if(temTit !== true){//Pega titulo da página
//            var callback = " favoritos.add(true, true);";
//            favoritos.getTitulo(callback);            
        }else{//Salva    
            //alert("VA: " + favoritos.anterior);
            favoritos.iconeTitulo = favoritos.getTitulo();
            var valor = favoritos.anterior + '^' + document.URL + '~' + favoritos.iconeTitulo;
            valor = favoritos.limpar(valor);
            config.add('favoritos', valor);            
            location = 'index/index';
        }    
    },
    
    limpar: function(favoritos){      
        var favoritosNovo = "";
        var favArr = favoritos.split("^");
        var c = favArr.length;
        for(var i=0; i<c; i++){
            var fav = favArr[i];
            var favIArr = fav.split("~");
            if(favIArr[0] !== ''){
                favoritosNovo += fav;
                if(i<c-1){
                    favoritosNovo += "^";
                }
            }
        }
        return favoritosNovo;
    },
    
    makeIcons: function(icones){
        if(icones == ''){
            var callback = 'favoritos.makeIcons(dados.valor);';
            config.get('favoritos', callback);
        }else{
            var html = favoritos.makeIconsHtml(icones);
            jQuery("#favoritos").append(html);
            favoritos.addEventoIcons();
        }
    },
    
    getTitulo0: function(callback){
        var url0 = "favoritos/pegaH1";
        jQuery.post(url0, {
            url: favoritos.documentUrl
        }, function(dados){
            favoritos.iconeTitulo = dados;
            //alert(dados);
            eval(callback);
        });
    },
    
    getTitulo: function(){
        var titulo = jQuery("#favoritos_nome").val();
        while(titulo == '' || titulo == undefined){
           titulo = prompt("Digite o nome desse atalho"); 
        }
        return titulo;
    },
    
    makeIconsHtml: function(valor){
        var html = "";  
        var valores = valor.split("^");
        var c = valores.length;
        for(var i=0; i<c; i++){
            var valArr = valores[i].split('~');
            
            var link = valArr[0];
            
            if(valArr[1] == undefined || valArr[1] == ''){
                var titulo = "Sem titulo";
            }else{
                var titulo = valArr[1];
            }
            
            html += "<div class='favorito_item' ondblclick=\"location='" + link + "'\" title='" + link + "'  > \n\
                     <img src=\"img/icons/gnome-app-install-star.png\" alt=''/>\n\
                     <p>" + titulo + "*</p>\n\
                     </div>";
        }
        return html;
    },
    
    get: function(callback){
        config.get('favoritos', callback);
    },
    
    addEventoIcons: function(){ 
        jQuery('.favorito_item').hover(function(){
            
            var tag = "<div class='fav_item_controle'> \n\
                       <div class='fav_icon_apagar' onclick='favoritos.remove(this)' >\n\
                       <img src='img/icons/list-remove.png' alt='Delete'/>\n\
                       </div> \n\
                       </div>";
                        
            jQuery(this).append(tag); 
            jQuery(this).css({backgroundColor: "#eeeeee"}); 
        }, function(){            
            jQuery('.favorito_item').children(".fav_item_controle").remove();
            jQuery('.favorito_item').removeAttr("style");
        });
    },
    
    remove: function(elem){
        var link = jQuery(elem).parent('.fav_item_controle')
                               .parent('.favorito_item').attr('title');
        var url = "favoritos/remove";
        if(confirm("Deseja remover o atalho para: " + link + " ? ")){
            jQuery.post(url, {
                link: link
            }, function(data){
                //alert(data);
                location = 'index/index';
            });
        }
    } 
};

var View = {
    
    changeView: function(elemId){
        var elem = jQuery("#" + elemId);
        var display = jQuery(elem).css("display");
        
        if(display == "none"){
            jQuery(elem).slideDown();
        }else{
            jQuery(elem).slideUp();
        }
    }
    
};


var buscaRapida = {
    buscar: function(){
        var url = "profissional/index/buscar/" + jQuery("#busca-rapida-buscar").val();
        location = encodeURI(url);
    }
};

jQuery(document).ready(function(){
    jQuery(".clica-limpa").click(function(){
        jQuery(this).val(""); 
    });
    
    jQuery("#msgError, #msgOk").click(function(){
       jQuery(this).html(''); 
    });
});

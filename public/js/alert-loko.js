var alertLoko = {
  
  img: 'img/alert2.jpg',
  
  elemContent: '',
  
  criar: function(txt){
      this.criarContent();
      var elemBox = this.criarBox(txt);      
      this.exibir(elemBox);
  },
  
  criarContent: function(){      
    this.elemContent = document.createElement('div');
    this.elemContent.className = 'alert-loko-content';          
  },
  
  criaImg: function(){
     var img = document.createElement('img');
     img.src = this.img;
     return img;
  },
  
  criaP: function(txt){
      var p = document.createElement('p');
      p.innerHTML = txt; 
      return p;
  },
        
  criarBox: function(txt){            
      var div = document.createElement('div');
      div.className = 'alert-loko-box';      
      
      div.appendChild(this.criaImg());
      div.appendChild(this.criaP(txt));
      div.appendChild(this.criaBt());
      
      return div;
  },
  
  criaBt: function(){
    var div = document.createElement('div');
    div.className = 'botao2';
    div.innerHTML = 'OK';
    div.addEventListener("click", alertLoko.fechar);
    return div;    
  },
  
  exibir: function(elemBox){
      this.elemContent.appendChild(elemBox);
      document.body.appendChild(this.elemContent);      
  },
  
  fechar: function(){
    var contents = document.getElementsByClassName('alert-loko-content');
    var c = contents.length - 1;
    var content = contents[c];
    document.body.removeChild(content);    
  }    
};

jQuery(document).ready(function(){   
//    window.alert = function(txt){
//        alertLoko.criar(txt);
//    };    
});
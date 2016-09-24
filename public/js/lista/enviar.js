var Lista = {
    
    prepararEmails: function(){
        var emails = this.ajustarSeparador(jQuery("#lista-email").val());
        var result = this.validarEmails(emails);        
        emails = result.emails != "" ? result.emails : "Nenhum e-mail válido aqui"; 
        jQuery("#lista-email").val(result.emails);
        jQuery("#quantidade").val(result.quant);
    },
    
    ajustarSeparador: function(emails){
        return emails.replace(/,|;|undefined/g, " ");
    },
    
    validarEmails: function(emails){
        var res = new Object();        
        res.quant = 0;
        res.emails = "";
        
        var emailsArr = emails.split(" ");
        for(var i=0; i<emailsArr.length; i++){
            var email = emailsArr[i].trim();
            if(this.validarEmail(email)){
                res.emails += email + ",";
                res.quant++;
            }
        }
        res.emails;
        return res;
    },
    
    validarEmail: function(x){        
        var atpos = x.indexOf("@");
        var dotpos = x.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {            
            return false;
        }
        return true;
    },
    
    enviar: function(){
        this.prepararEmails();
        jQuery("#form-lista").submit();
    }
};

jQuery(document).ready(function(){
   
    jQuery("#lista-email").bind('change', '', function(){
       Lista.prepararEmails();
    });
    
    jQuery("#form-lista").submit(function(){
        Lista.enviar();
        return false;
    });
    
});

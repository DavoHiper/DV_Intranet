$(function() {
    
    // function chamaDialogConfirmacao()
    // {         
// 
        // $.getJSON("?router=home/js.usuario",{evento:6},function(dados){
// 
        // $.each(dados, function(campo, valor){
// 
            // if(campo == 'Nome')
                // $("#cNome").val(valor);
// 
            // if(campo == 'Matricula')
                // $("#cMatricula").val(valor);
// 
            // if(campo == 'Email')
                // $("#cEmail").val(valor);
// 
            // if(campo == 'CPF')
                // $("#cCPF").val(valor);                        
// 
            // if(campo == 'Depto')
            // {
                // $("#comboDeptos").find("option:contains("+valor+")").each(function(){
                     // if( $(this).val() == valor ) {
                        // $(this).attr("selected","selected");
                     // }
                 // });                   
            // }
// 
            // if(campo == 'Funcao')
            // {
                // $("#comboFuncoes").find("option:contains("+valor+")").each(function(){
                     // if( $(this).val() == valor ) {
                        // $(this).attr("selected","selected");
                     // }
                 // });                   
            // }
// 
            // if(campo == 'Loja')
            // {
                // $("#comboLojas").find("option:contains("+valor+")").each(function(){
                     // if( $(this).val() == valor ) {
                        // $(this).attr("selected","selected");
                     // }
                 // });                   
            // }
// 
        // });
// 
        // $.get("?router=home/js.usuario",{evento:4},function(html){  
            // $("#linhaPrincipal").append(html);
        // });                
// 
    // //        $('#dialog-confirm-dados').css('overflow-y', 'hidden');
        // $('#dialog-confirm-dados').css('overflow-x', 'hidden');                
// 
        // $("#dialog-confirm-dados").dialog
        // ({    
            // resizable: false,
            // height:400,
            // draggable: false,
            // width:420,
            // modal: true,
            // title:"Caixa de Confirmação de Dados",
            // buttons:
            // {
                    // Atualizar: function() 
                    // {
                        // var login   =   $("#name").val();
                        // var nome        = $("#cNome").val();
                        // var matricula   = $("#cMatricula").val();
                        // var cpf         = $("#cCPF").val();
                        // var loja        = $("#comboLojas").val();
                        // var funcao      = $("#comboFuncoes").val();
                        // var depto       = $("#cDepto").val();
                        // var email       = $("#cEmail").val();
                        // var linha       = $(".linha");
// 
                        // var arrTpFone   = new Array();
                        // var arrNumero   = new Array();
                        // var arrDdd      = new Array();
                        // var arrRamal    = new Array();
// 
                        // $.each(linha, function(){
                            // arrTpFone.push($(this).find(".cTpFone").val());
                            // arrDdd.push($(this).find(".cDDD").val());
                            // arrNumero.push($(this).find(".cNumero").val());
                            // arrRamal.push($(this).find(".cRamal").val());
                        // });
// 
                        // $.get("?router=home/js.usuario",{  login:login
                                                         // , nome:nome
                                                         // , matricula:matricula
                                                         // , funcao:funcao
                                                         // , departamento:depto
                                                         // , cpf:cpf
                                                         // , loja:loja
                                                         // , email:email
                                                         // , tpfone:arrTpFone
                                                         // , numero:arrNumero
                                                         // , ddd:arrDdd
                                                         // , ramal:arrRamal                                                                 
                                                         // , evento:3
// 
                                                     // },function(){ 
// 
                            // $("#dialog-confirm-dados").dialog("close");
                            // location.reload();                                                                 
// 
                        // });  
// 
                    // }
            // }
    // });  
    // });
//             
    // }

    function login()
    {
        var login   =   $("#name").val();
        var senha   =   $("#password").val();
        var action  = 'login';
        
        // $.get("?router=home/js.usuario",{login:login, evento:4},function(html){  
            // $("#linhaPrincipal").append(html);
        // }); 
        
        // $('#dialog-confirm-dados').css('overflow-x', 'hidden');        

        $.getJSON("?router=home/js.usuario",{login:login,senha:senha, action:action,evento:1},function(dados){

/*
            $.get("?router=home/js.usuario",{evento:7},function(retorno){

              if(retorno==1)
              {  
                    $.each(dados, function(campo, valor){

                        if(campo == 'Nome')
                            $("#cNome").val(valor);

                        if(campo == 'Matricula')
                            $("#cMatricula").val(valor);

                        if(campo == 'Email')
                            $("#cEmail").val(valor);

                        if(campo == 'CPF')
                            $("#cCPF").val(valor);                        

                        if(campo == 'Depto')
                            $("#cDepto").val(valor);

                        if(campo == 'Funcao')
                        {
                            $("#comboFuncoes").find("option:contains("+valor+")").each(function(){
                                 if( $(this).val() == valor ) {
                                    $(this).attr("selected","selected");
                                 }
                             });                   
                        }

                        if(campo == 'Loja')
                        {
                            $("#comboLojas").find("option:contains("+valor+")").each(function(){
                                 if( $(this).val() == valor ) {
                                    $(this).attr("selected","selected");
                                 }
                             });                   
                        }

                        $("#dialog-confirm-dados").dialog
                        ({    
                            resizable: false,
                            height:400,
                            draggable: false,
                            width:420,
                            modal: true,
                            closeOnEscape: false,
                            title:"Caixa de Confirmação de Dados",
                            buttons:
                            {
                                    Atualizar: function() 
                                    {

                                        var login   =   $("#name").val();
                                        var nome        = $("#cNome").val();
                                        var matricula   = $("#cMatricula").val();
                                        var cpf         = $("#cCPF").val();
                                        var loja        = $(".comboLojas").val();
                                        var funcao      = $(".comboFuncoes").val();
                                        var depto       = $(".comboDeptos").val();
                                        var email       = $("#cEmail").val();
                                        var linha       = $(".linha");

                                        var arrTpFone   = new Array();
                                        var arrNumero   = new Array();
                                        var arrDdd      = new Array();
                                        var arrRamal    = new Array();

                                        $.each(linha, function(){
                                            arrTpFone.push($(this).find(".cTpFone").val());
                                            arrDdd.push($(this).find(".cDDD").val());
                                            arrNumero.push($(this).find(".cNumero").val());
                                            arrRamal.push($(this).find(".cRamal").val());
                                        });

                                        $.get("?router=home/js.usuario",{  login:login
                                                                         , nome:nome
                                                                         , matricula:matricula
                                                                         , funcao:funcao
                                                                         , departamento:depto
                                                                         , cpf:cpf
                                                                         , loja:loja
                                                                         , email:email
                                                                         , tpfone:arrTpFone
                                                                         , numero:arrNumero
                                                                         , ddd:arrDdd
                                                                         , ramal:arrRamal                                                                 
                                                                         , evento:3

                                                                     },function(){ 

                                            $("#dialog-confirm-dados").dialog("close");
                                            location.reload();                                                                 

                                        });  

                                    }
                            }
                        });                     

                    });
              }
              else location.reload();
              
            });
*/
            location.reload();    
        });          
    } 
    
    function limpaDialogConfirmacao()
    {
        $("cNome").val("");
        $("cMatricula").val("");
        $("cCPF").val("");
        $("cFuncao").val("");
        $("cDepto").val("");
        $("cTpFone").val("");
        $("cDDD").val("");
        $("cNumero").val("");
        $("cEmail").val("");
        
        var linha   =   $(".linha");
        
        $.each(linha, function(){
            if($(this).css('display') != 'none')
            {
                $(this).remove();
            }
        });
        
            
    }

    $("#cAdd").click(function(){
        
        $("#linhaCabec").css("display","block");
        
        var linha   =   $(".linha:first").clone(true);
        
        $("#linhaPrincipal").append(linha);
        
        $(".linha:last").removeAttr("style");
        
    });
        
    $(".cRemove").live("click",function(){
        var $this   =   $(this);
        var id      =   $(this).parents(".linha").find(".cId").val();
                
        $.post("?router=home/js.usuario", {evento:5, id:id}, function(retorno){
            if(retorno==1)
                $this.parents(".linha").remove();
        });
        
        
    });
    
    $("#logout").live("click",function(e){
        e.preventDefault();
        var action  =   "logout";
        var evento  =   1;  

        $.get("?router=home/js.usuario", {action:action, evento:evento}, function(){
            location.reload();
        }); 

    }); 

    //Ao pressionar Enter
    $("#dialog-login").keydown(function(event) {
        if (event.keyCode == '13')
            {                
                login();                        
                $( this ).dialog( "close" );                        
            }                                    
    });

    $('#login').click(function(e){
        e.preventDefault();
        
        //limpaDialogConfirmacao();
        
        $('#dialog-login').css('overflow-y', 'hidden');
        $('#dialog-login').css('overflow-x', 'hidden');

        $("#dialog-login").dialog
        ({    
            resizable: false,
            height:230,
            draggable: false,
            width:205,
            modal: true,
            title:"Caixa de Login",
            buttons:
            {
                    Login: function() 
                    {
                       login(); 
                       $("#dialog-login").dialog("close");
                    }
                    ,
                    Cancelar: function()
                    {
                        $(this).dialog("close");
                    }
            }
        });        
        
    });
    
    // $('#meus_dados').click(function(e){
        // e.preventDefault();        
//         
        // chamaDialogConfirmacao();
//         
    // });
                
});

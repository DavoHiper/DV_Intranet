// Data de Criação: 25/09/2013
// Descrição:      Funções do programa T0133 - Sinistro GE
// Desenvolvedor:  Roberta Schimidt/* 

$(function(){
    
    $(".botaoDadosTroca").live("click",(function(){
        var $this   =    $(this);
        var codigoAutorizacao    =    $this.parents("tr.linha").find(".codigoAutorizacao").text();
        var cpf                  =    $this.parents("tr.linha").find(".cpf").text();
    
       $.post("?router=T0133/js.dadosTroca",{codigoAutorizacao: codigoAutorizacao, cpf:cpf}, function(dados){
           $(".dialogDadosTroca").html(dados);
       });
      
    $(".dialogDadosTroca").dialog
    ({
        resizable: false,
                height:450,
                draggable: false,
                width:620,
                modal: true,
                buttons:
                        {
                            Fechar:function(){
                                $(this).dialog("close");
                            }        
                        }
        
    });
}));


    $(".botaoEditarDadosTroca").live("click",(function(){
        var $this   =    $(this);
        var codigoAutorizacao    =    $this.parents("tr.linha").find(".codigoAutorizacao").text();
        var cpf                  =    $this.parents("tr.linha").find(".cpf").text();
    
       $.post("?router=T0133/js.editarDadosTroca",{codigoAutorizacao: codigoAutorizacao, cpf:cpf}, function(dados){
           $(".dialogEditarDadosTroca").html(dados);
       });
      
    $(".dialogEditarDadosTroca").dialog
    ({
        resizable: false,
                height:450,
                draggable: false,
                width:660,
                modal: true,
                buttons:
                        {
                            Fechar:function(){
                                $(this).dialog("close");
                            }        
                        }
        
    });
}));


 $(".botaoMaisProduto").live("click",function(){
     var $this  =   $(this);
     var cont   =   $this.parents(".linha").find(".numerador").val();
     
     cont++;
     
     var input  =   '<div class="linhaDados">';
         input +=   '<div class="grid_2">';
         input +=   '<input type="text" class="pdv" name="T127_pdv[]"/>';
         input +=   '</div>';
         input +=   '<div class="grid_2">';
         input +=   '<input type="text" class="cupom" name="T127_cupom[]"/>';
         input +=   '</div>';
         input +=   '<div class="grid_2">';
         input +=   '          <input type="text" class="codProduto" name="T127_cod_produto[]"/>';
         input +=   '</div> ';
         input +=   '       <div class="grid_2">';
         input +=   '           <input type="text" class="valor" name="T127_valor[]"/>';
         input +=   '       </div>';
         input +=   '       <div class="grid_1">';
         input +=   '           <input type="hidden" class="numerador"   value='+(cont)+' name="numerador[]"/>';
         input +=   '       </div>';
         input +=   '       <div class="grid_1">';
         input +=   '           <ul class="lista-de-acoes"><li><a href="#" Title="Adicionar Produto" class="botaoMaisProduto"><span class="ui-icon ui-icon-circle-plus"></span></a></li></ul>    ';
         input +=   '       </div>';
         input +=   '       </div>';
         $(".form-inpu-tab").append(input);
         
     
 });
 $(".botaoMaisProdutoEdit").live("click",function(){
     var $this  =   $(this);
     var cont   =   $this.parents(".linhaDadosEdit").find(".numerador").val();
     
     cont++;
     
     var input  =   '<tr class="linhaDadosEdit">';
         input +=   '<td><input type="text" class="pdv" name="T127_pdv[]"/></td>';
         input +=   '<td><input type="text" class="cupom" name="T127_cupom[]"/></td>';
         input +=   '<td><input type="text" class="codProduto" name="T127_cod_produto[]"/></td>';
         input +=   '<td><input type="text" class="valor" name="T127_valor[]"/></td>';
         input +=   '<input type="hidden" class="numerador"   value='+(cont)+' name="numerador[]"/>';
         input +=   '<td><ul class="lista-de-acoes"><li><a href="#" Title="Adicionar Produto" class="botaoMaisProdutoEdit"><span class="ui-icon ui-icon-circle-plus"></span></a></li></ul></td>';
         input +=   '<td><ul class="lista-de-acoes"><li><a href="#" Title="Remover Produto" class="botaoRemoverProd"><span class="ui-icon ui-icon-circle-minus"></span></a></li></ul></td>';
         input +=   '       </tr>';
         $(".tablesorterEdit").append(input);
         
     
 });
 
 $(".botaoRemoverProd").live("click", function(){
    var $this = $(this);
    var id = $this.parents("tr.linhaDadosEdit").find(".ID").val();
    
    $.post("?router=T0133/js.excluirDadosTroca", {id: id}, function(dados){
        
    });
    
    
   $this.closest('tr').remove();
     
 });
 
 
 
 
 $(".botaoDetalhesTroca").live("click", function(){
    var $this   =    $(this);
    var codigoAutorizacao = $this.parents("tr.linha").find(".codigoAutorizacao").text();
    var cpf                  =    $this.parents("tr.linha").find(".cpf").text();
    
    
       $.post("?router=T0133/js.detalhesTroca",{codigoAutorizacao: codigoAutorizacao, cpf:cpf}, function(dados){
           $(".dialogDetalhesTroca").html(dados);
       });
      
    $(".dialogDetalhesTroca").dialog
    ({
        resizable: false,
                height:450,
                draggable: false,
                width:620,
                modal: true,
                buttons:
                        {
                            Fechar:function(){
                                $(this).dialog("close");
                            }        
                        }
        
    });
    
 });
 
 $(".botaoAnexar").live("click", function(){
     
    var $this   =    $(this);
    var codAutorizacao = $this.parents("tr.linha").find(".codigoAutorizacao").text();
    var cpf            = $this.parents("tr.linha").find(".cpf").text();
    
     $("#dialog-upload").dialog
    ({
        resizable: false,
        height:250,
        width:330,
        modal: true,
        draggable: false,
        buttons:
        {
                "Upload": function()
                {
                    $("#form-upload").append("<input type='text' name='T125_cod_autorizacao' value='"+codAutorizacao+"'</input>");
                    $("#form-upload").submit();
                } 
                ,
                Cancelar: function()
                {
                    $(this).dialog("close");
                }
        }
    });
    
});

$(".efetuarTroca").live("click", function(){
    var $this   =    $(this);
    var codigoAutorizacao = $this.parents("tr.linha").find(".codigoAutorizacao").text();
    
    $.post("?router=T0133/js.aprovar",{codigoAutorizacao: codigoAutorizacao, acao: 1});
    
    location.reload("?router=T0133/home");
    
});


$(".confirmaPag").live("click", function(){
    var $this   =    $(this);
    var codigoAutorizacao = $this.parents("tr.linha").find(".codigoAutorizacao").text();
    
    $.post("?router=T0133/js.aprovar",{codigoAutorizacao: codigoAutorizacao, acao: 2});
    
    location.reload("?router=T0133/home");
    
});


$(".botaoCancelar").live("click", function(){
    var $this   =    $(this);
    var codigoAutorizacao = $this.parents("tr.linha").find(".codigoAutorizacao").text();
    
    $.post("?router=T0133/js.cancelar",{codigoAutorizacao: codigoAutorizacao});
    
    location.reload(".conteudo_16");
    
});


});






function toggleDeleteAllButton(e){!0===e?$("#grid_button_delete_all").prop("disabled",!1).removeClass("button_inactive").addClass("btn-danger").addClass("button_delete"):$("#grid_button_delete_all").prop("disabled",!0).removeClass("button_delete").removeClass("btn-danger").addClass("button_inactive")}$(document).ready(function(){$(".grid_view tbody tr").click(function(e){"checkbox"!==e.target.type&&(checkbox=$(this).children("th").children(".grid_checkbox_delete"),$(":checkbox",this).trigger("click"))}),$("#grid_select_all").change(function(e){!0===$(this).prop("checked")?($(".grid_checkbox_delete").prop("checked",!0),toggleDeleteAllButton(!0)):($(".grid_checkbox_delete").prop("checked",!1),toggleDeleteAllButton(!1))}),$(".grid_checkbox_delete").change(function(e){0<$(".grid_checkbox_delete:checked").length?toggleDeleteAllButton(!0):toggleDeleteAllButton(!1),$(".grid_checkbox_delete:checked").length===$(".grid_checkbox_delete").length?$("#grid_select_all").prop("checked",!0):$("#grid_select_all").prop("checked",!1)}),$("#grid_button_delete_all").click(function(e){return 0<$(".grid_checkbox_delete:checked").length?confirm("Você tem certeza que deseja excluir os itens selecionados?"):(alert("Por favor, selecione pelo menos um registro."),!1)}),$(".grid_button_delete").click(function(e){return confirm("Você tem certeza que deseja excluir os itens selecionados?")}),$(".grid-ajax-action").on("click",function(){var l=$(this);return $.post(l.prop("href"),{},function(e,t,c){!0===e.success&&l.prop("href",e.url).html(e.text)},"json"),!1})});
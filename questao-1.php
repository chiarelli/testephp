<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Questão 1</title>
        <style>
            .loader {
                border: 16px solid #f3f3f3; /* Light grey */
                border-top: 16px solid #3498db; /* Blue */
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
              }

              @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
              }
        </style>
    </head>
    <body>
        <main>
            <form onsubmit="return false;">
                <label id="label" style="display: none;">
                    Renderizar menu
                    <select id="imobiliarias" required>
                        <option value="" selected disabled>-- Selecione uma imobiliária</option>
                    </select>
                    <button id="action_get_all_imobiliarias">Renderizar</button>
                </label>
            </form>
            <div class="loader"></div>
            
            <section id="menu-container"></section>
        </main>
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                
                var $btn_renderizar_menu = $('#action_get_all_imobiliarias')
                  , $menu_container      = $('#menu-container')
                  , $select_imobiliarias      = $('#imobiliarias')
                  , $loading      = $('.loader')
                ;
                
                $btn_renderizar_menu.click(function(e) {
                    
                    $menu_container.html('');
                    $loading.show();
                    
                    server({
                        action: 'get_menu',
                        imobiliaria_id: $select_imobiliarias.val()
                    }).done(function(items) {
                        
                        html = cake_html_menu(items);
                        
                        console.log(html);
                        
                        $menu_container.html(html);
                    }).always(function() {
                        $loading.hide();
                    });
                    
                });
                
                function cake_html_menu(items) {
                    html = '<ul>';
                        
                    items.forEach(function(item) {
                        
                        console.log( 'LENGHT', item.children.length);
                        
                        html += `<li><a href="#">${item.Titulo}</a>`;
                        
                        if( Array.isArray(item.children) && item.children.length ) {
                            html += cake_html_menu(item.children);
                        }
                        
                        html += `</li>`;
                        
                    });

                    html += '</ul>';
                    
                    return html;
                }
                
                function hidrate_select_imobiliarias() {
                    var select = $('#imobiliarias');
                    
                    server({
                        action: 'get_all_imobiliarias',                        
                    }).done(function(itens) {
                        
                        itens.forEach(function(item) {
                            select.append(`<option value="${item.id}">${item.Nome}</option>`)
                        });
                        
                    }).always(function() {
                        $loading.hide();
                        $('#label').show();
                    });
                }
                
                function server(data) {

                    return $.ajax({
                        method: 'POST',
                        data: data,
                        url : 'server.php', 
                        dataType : 'json', 
                    }).done(function(resp) {
                        console.log('resposta', resp);
                    });
                    
                };
                
                hidrate_select_imobiliarias();                
            });
        </script>
    </body>
</html>

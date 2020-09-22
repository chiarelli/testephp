<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Questão 1</title>
    </head>
    <body>
        <main>
            <form onsubmit="return false;">
                <label>
                    Renderizar menu
                    <select id="imobiliarias" required>
                        <option value="" selected disabled>-- Selecione uma imobiliária</option>
                    </select>
                    <button id="action_get_all_imobiliarias">Renderizar</button>
                </label>
            </form>
            
            <section id="menu-container"></section>
        </main>
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                
                var $btn_renderizar_menu = $('#action_get_all_imobiliarias')
                  , $menu_container      = $('#menu-container')
                  , $select_imobiliarias      = $('#imobiliarias')
                ;
                
                $btn_renderizar_menu.click(function(e) {
                    
                    server({
                        action: 'get_menu',
                        imobiliaria_id: $select_imobiliarias.val()
                    }).done(function(items) {
                        
                        html = cake_html_menu(items);
                        
                        console.log(html);
                        
                        $menu_container.html(html);
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

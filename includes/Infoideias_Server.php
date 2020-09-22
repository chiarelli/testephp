<?php

/**
 * Description of Infoideias_Server
 *
 * @author raphael
 */
class Infoideias_Server {
    
    /**
     *
     * @var mysqli
     */
    private $mysqli;
    
    
    public function __construct($servidor, $usuario, $senha, $banco) {
        $this->mysqli = new mysqli($servidor, $usuario, $senha, $banco);
        if (mysqli_connect_errno()) {
            trigger_error(mysqli_connect_error());            
        }
        
        register_shutdown_function([ $this, 'mysqli_close' ]);
    }

    function registerRouter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            switch (@$_POST['action']) {
                case 'get_menu':
                    $this->act_get_menu($_POST);

                    break;
                
                case 'get_all_imobiliarias':
                    $this->act_get_all_imobiliarias($_POST);

                    break;

                default:
                    break;
            }
            
        }
    }
    
    function act_get_all_imobiliarias($args) {
        $sql = "SELECT * FROM imobiliaria";
        
        $result = $this->mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        exit(json_encode($rows));
    }
    
    function act_get_menu($args) {
        extract($args);
        
        if(!$imobiliaria_id) {
            // lançar erro php 404
        }
        
        $sql = "SELECT * FROM conteudo WHERE imobiliariaID = {$imobiliaria_id}";
        
        $result = $this->mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        $items = [];
        foreach ($rows as $row) {
            if($row['ConteudoID'] == 0) {
                $children = $this->get_menu_children($rows, $row['ID']);
                $row['children'] = $children;
                $items[] = $row;
            }
        }
        
        
        exit(json_encode($items));
    }
    
    protected function get_menu_children($rows, $father_id) {
        $childrens = [];
        
        foreach ($rows as $item) {
            if($item['ConteudoID'] == $father_id) {
                
                $item['children'] = $this->get_menu_children($rows, $item['ID']) ;
                
                $childrens[] = $item;
            }
        }
        
        return $childrens;
    }
    
    function getConn() {
        return $this->mysqli;
    }
    
    function mysqli_close() {
        $this->mysqli->close();
    }
    
}

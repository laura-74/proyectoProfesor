<?php
class MenuNode {
    public $id;
    public $label;
    public $children;

    public function __construct($id, $label) {
        $this->id = $id;
        $this->label = $label;
        $this->children = [];
    }

    public function addChild(MenuNode $child) {
        $this->children[] = $child;
    }
}

// Conexión a la base de datos
include("admin/bd.php");

    // Crear el árbol de menú
    $menu = new MenuNode(0, "Menú");

    // Obtener los menús
    $stmtMenus = $conn->query("SELECT id, nombre FROM menu");
    while ($menuRow = $stmtMenus->fetch(PDO::FETCH_ASSOC)) {
        $menuNode = new MenuNode($menuRow['id'], $menuRow['nombre']);

        // Obtener los platos de cada menú
        $stmtPlatos = $conn->prepare("SELECT id, nombre, precio, foto FROM plato WHERE menu_id = ?");
        $stmtPlatos->execute([$menuRow['id']]);
        while ($platoRow = $stmtPlatos->fetch(PDO::FETCH_ASSOC)) {
            $platoNode = new MenuNode($platoRow['id'], $platoRow['nombre']);

            // Obtener los ingredientes de cada plato
            $stmtIngredientes = $conn->prepare("
                SELECT i.id, i.nombre 
                FROM ingrediente i
                INNER JOIN plato_ingrediente pi ON i.id = pi.ingrediente_id
                WHERE pi.plato_id = ?
            ");
            $stmtIngredientes->execute([$platoRow['id']]);
            while ($ingredienteRow = $stmtIngredientes->fetch(PDO::FETCH_ASSOC)) {
                $ingredienteNode = new MenuNode($ingredienteRow['id'], $ingredienteRow['nombre']);
                $platoNode->addChild($ingredienteNode);
            }

            $menuNode->addChild($platoNode);
        }

        $menu->addChild($menuNode);
    }

    // Función para generar el menú desplegable en HTML
    function renderMenu($node) {
        $html = "<ul>";
        $html .= "<li>" . htmlspecialchars($node->label);
        if (!empty($node->children)) {
            foreach ($node->children as $child) {
                $html .= renderMenu($child);
            }
        }
        $html .= "</li>";
        $html .= "</ul>";
        return $html;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Desplegable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<header class="header">
    <div class="div_a">
    <a class="header_a text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded" href="/index.php">Volver a la pagina principal</a>
    </div>
  </header>
    <div class="container mx-auto p-6">
        
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Menú Desplegable</h1>
        <div class="bg-white shadow-md rounded-lg p-4">
            <?php echo renderMenu($menu); ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = document.querySelectorAll("li");
            items.forEach(item => {
                item.addEventListener("click", function(e) {
                    e.stopPropagation();
                    this.classList.toggle("open");
                });
            });
        });
    </script>
    <style>
        ul {
            list-style-type: none;
            padding-left: 1rem;
        }
        li {
            cursor: pointer;
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            transition: background-color 0.2s;
        }
        li:hover {
            background-color: #f3f4f6;
        }
        ul ul {
            display: none;
            margin-left: 1rem;
        }
        li.open > ul {
            display: block;
        }
    </style>
</body>
</html>

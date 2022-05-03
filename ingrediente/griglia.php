<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
include_once('ingredienti_class.php');
$ingrediente_collection = new ingredienti_class(); //recupero dati principali
$ingredienteFound = $ingrediente_collection->getAll();
?>

<table id="ingredienti" class="w-100">
    <thead class="bg-white">
        <tr>
            <th class="text-c-silver-ligth">Nome</th>
            <th class="text-c-silver-ligth">Allergene</th>
            <th class="text-c-silver-ligth">Modifica</th>
            <th class="text-c-silver-ligth">Elimina</th>

        </tr>
    </thead>
    <tbody class="bg-white border-0">
        <?php foreach ($ingredienteFound as $ingrediente) {

            echo "
            <tr>
            <td class=\"p-2\">
                    " . $ingrediente['ingrediente'] . "
                </td>
            <td class=\"p-2\">
                    " . $ingrediente['allergene'] . "
                </td>                                          
            <td class=\"p-2\">                         
                    <button 
                        class=\"btn btn-outline-secondary modificaIngrediente\" 
                        type=\"button\" data-bs-toggle=\"modal\"  
                        data-bs-target=\"#ModalPut\"
                        aria-controls=\"ModalPut\" 
                        aria-expanded=\"false\"
                        aria-label=\"pp\"
                        id=\"button-modIngredient\"
                        value=" . $ingrediente['id'] . "
                    >
                        Modifica
                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pencil\" viewBox=\"0 0 16 16\"><path d=\"M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z\"/></svg>
                    </button>
                </td>
            <td class=\"p-2\">
                    <button
                        class=\"btn btn-outline-danger eliminaIngrediente\"
                        type=\"button\"
                        aria-expanded=\"false\"
                        aria-label=\"del pippo\"
                        id=\"button-delIngredient\"
                        value=" . $ingrediente['id'] . "
                    >
                        Elimina
                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-trash\" viewBox=\"0 0 16 16\">
                        <path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"/>
                        <path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"/></svg>
                    </button>
                </td>
            </tr>";
        }
        ?>

    </tbody>
    <!--   <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Allergene</th>
                            <th>Modifica</th>
                            <th>Elimina</th>
                        </tr>
                    </tfoot>-->
</table>
<script>
    $(document).ready(function() {


        $('#ingredienti').DataTable();

    });
</script>
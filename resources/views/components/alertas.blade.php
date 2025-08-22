<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php

foreach ($message as $key => $mensajes) :
    $status = $key;
    echo
    "<script>
        Swal.fire({
      icon: '$key', ";
    foreach ($mensajes as $mensaje) :
?>
<?php echo " 
  title: 'Alerta',
  text: '$mensaje',
 "; ?>

<?php
    endforeach;

    echo "})
    </script>";
endforeach;

?>

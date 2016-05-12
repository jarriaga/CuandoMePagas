<p style="font-size:14px;">Hola <span style="font-weight: bold"> <?php echo $firstname;?></span></p>
<p style="text-align: justify">
    Recientemente recibimos una peticion para <span style="font-weight: bold">recuperar tu password</span>,
    si tu no hiciste esta peticion por favor ignora este mensaje, si tu hiciste la peticion puedes dar click en el enlace
    siguiente para crear un nuevo password.
</p>
<p style="text-align: center"><a href="<?php echo $hostname; ?>/reset-password/<?php echo $code; ?>">Recuperar mi password ahora</a></p>
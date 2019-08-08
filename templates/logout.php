    <?php
    //suppression de la session
    session_start ();
    session_unset ();
    session_destroy ();
    //suppression des cookies
    /*unset($_COOKIE['id']);
    unset($_COOKIE['nom']);
    unset($_COOKIE['prenom']);*/
    setcookie('id');
    unset($_COOKIE['id']);
    header ('location:../index.php');
    ?>
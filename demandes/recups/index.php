<center><?php
$dir = './'.$_GET['id'].'/';
$image_largeur = 1000;
$valide_extensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');

$Ressource = opendir($dir);
while($fichier = readdir($Ressource))
{
    $berk = array('.', '..');

    $test_Fichier = $dir.$fichier;

    if(!in_array($fichier, $berk) && !is_dir($test_Fichier))
    {
        $ext = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));

        if(in_array($ext, $valide_extensions))
        {
            echo '<a href="'.$test_Fichier.'"><img src="'.$test_Fichier.'" style="width:'.$image_largeur.'px" /></a>';
        }
    }
}
?>
</center>

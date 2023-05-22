<?php
declare(strict_types=1);

try{

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
}

exit;
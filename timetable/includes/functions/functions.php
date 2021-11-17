<?php 

    function getTitle() {

        // define this variable as global 
        
        global $pageTitle;

        // Check If This Variable Exist In Page 

        if( isset($pageTitle) ):
            echo $pageTitle;
        else: 
            echo "Default";
        endif;
    }



    // RedirectHome
    function redirectHome($theMsg, $url = null){

        if( $url === null):
            $url = "index.php"; 
        else:
            if( isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ){
                $url = $_SERVER['HTTP_REFERER'];
            }else {
                $url = "index.php";
            }    
        endif;      

        echo $theMsg;
        header("refresh: 3; url= $url");    
    
        exit();

    }


    function seance($h,$jour,$class){
        
        $seance = getSeance($h,$jour,$class);
        if(empty($seance)):
            echo "<td></td>";
        else:
            echo "<td class='cours'>";
                echo "<span>".$seance['subject'] . "</span>";
                echo "<span> Prof : <strong>".$seance['nameProf'] . "</strong></span>";
                echo '<button type="button" class="btn btn-danger btn-supp" data-idseance="'.$seance['idEmploi'].'" data-toggle="modal" data-target="#delModal">
                        <i class="fa fa-close "></i> supprimer
                    </button>';
            echo "</td>";
        endif;
    }


?>


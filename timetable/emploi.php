<?php
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        include "init.php";

        $do = isset($_GET['do']) ? $_GET['do'] : "Manage";

        if($do == "Manage"){
        ?>
        <div class="container emploi">

            <h1 class="text-center">Gestion Des Emplois</h1>

            <!-- Add Button modal -->
            <button type="button" class="btn btn-primary btn-new" data-toggle="modal" data-target="#addModal">
            Ajouter Une Seance
            </button>

            <form action="?do=Display" method="POST">
                <div class="form-group row">   
                    <?php
                        $classes = getAllClass();
                        if(empty($classes)):
                            echo "<p class='alert alert-info'>Y'a pas des classes Veuillez les <a href='classes.php'><strong>Ajouter</strong></a></p>";
                        else:
                            echo '<label for="classe" class="col-sm-2 choose-class">Choisir Une Classe</label>';
                            echo "<div class='col-sm-8'>";
                            echo '<select name="classe" class="form-control">';
                                echo "<option value=''>Choisir Une Classe</option>";
                                foreach($classes as $class):
                                    echo "<option value='".$class['idClass']."'>".$class['nameClass']."</option>";
                                endforeach;
                            echo "</select>";
                            echo "</div>";    
                            echo '<button type="submit" name="displayClass" class="btn btn-primary col-sm-2 btn-afficher">';
                                echo 'Afficher';
                            echo '</button>';
                        endif;    
                    ?>
                </div>
            </form>

            
            <!-- Add Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Ajouter une seance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="?do=Insert" method="POST">
                        <div class="form-group">
                            <label for="heure">Heure</label>
                            <select name="heure" class=form-control>
                                <?php 
                                    $timeArray = array(
                                        ""          => "Choisir l'heure",
                                        "8:30"      => "8:30 - 10:00",
                                        "10:00"     => "10:15-11:45",
                                        "12:15"     => "12:15-13:45",
                                        "14:00"     => "14:00-15:30",
                                        "15:45"     => "15:45-17:15",
                                        "17:30"     => "17:30-19:00"
                                    );
                                    foreach($timeArray as $timeIndex => $timeValue ){
                                        echo "<option value=".$timeIndex.">".$timeValue."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jour">Jour</label>
                            <select name="jour" class=form-control>
                                <?php 
                                    $jourArray = array(
                                        ""          => "Choisir le Jour",
                                        "samedi"    => "Samedi",
                                        "dimanche"  => "Dimanche",
                                        "lundi"     => "Lundi",
                                        "mardi"     => "Mardi",
                                        "mercredi"  => "Mercredi"
                                    );
                                    foreach($jourArray as $jourIndex => $jourValue){
                                        echo "<option value=".$jourIndex.">".$jourValue."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prof">Professeur</label>
                            <?php
                                $profs = getAllProf();
                                if(empty($profs)):
                                    echo "<input type='text' name='profid'>";
                                    echo "<p>Y a des matieres pour ce professeur</p>";
                                else:
                                    ?>
                                    <select name="profid" id="profid" class="form-control">
                                    <?php
                                        echo '<option value=""> Choisir un Professeur</option>';
                                        foreach($profs as $prof):
                                            if($prof > 0 ) {
                                                echo "<option value='".$prof['idProf']."'>".$prof['nameProf']."</option>";
                                            }
                                        endforeach;
                                    echo '</select>';
                                endif;
                            ?>                                
                        </div>
                        <div class="form-group">
                            <label for="matiere">Matiere</label>
                            <?php 
                                
                                $mats = getAllMat();
                                if(empty($mats)):
                                    echo "<input type='hidden' name='matid'>";
                                    echo "<p>Y a des matieres pour ce professeur</p>";
                                else:
                                    echo '<select name="matid" id="matid" class="form-control">';
                                    echo '<option value="">Choisissez une matiere</option>';
                                    foreach($mats as $mat):
                                        if($mat > 0 ) {
                                            echo "<option value='".$mat['idMatiere']."'>".$mat['subject']."</option>";
                                        }
                                    endforeach;
                                    echo '</select>';
                                endif;
                            ?>       
                            
                        </div>
                        <div class="form-group">
                            <label for="classe">Classe</label>
                            <select name="classe" class="form-control">
                                <?php 
                                    $classes = getAllClass();
                                    echo "<option value=''>Choisir Une Classe</option>";
                                    foreach($classes as $classe):
                                        if($classe > 0 ) {
                                            echo "<option value='".$classe['idClass']."'>".$classe['nameClass']."</option>";
                                        }
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="addEmploi" class="btn btn-primary">Save changes</button>
                        </div>

                    </form>
                </div>
                </div>
            </div>
            </div>



        </div>  <!-- End COntainer   -->
        <?php    
        }  // End Section Manage
        else if($do == "Display"){

        ?>    

            <!-- Start Delete Modal -->
            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Supprimer la seance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure ??</p>
                        <form action="?do=Delete" method="POST">
                            <input type="hidden" name="deleteid" id="deleteidseance">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="deleteSeance" class="btn btn-danger">Supprimer</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Delete Modal -->

        <?php
            if(isset($_POST['displayClass'])) {
                $class = $_POST['classe'];
                if(!empty($class)){
            
                $returnClass = getClassWhere($class);
            echo "<div class='container emploi'>";
                echo "<h1 class='text-center'>Emploi de " . $returnClass['nameClass'] . "</h1>"; 
        ?>

        <!-- Start Table  -->
        <div class="table-responsive">
        <table class="table main-table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <span>Jour / </span>
                            <span>Heure</span>
                        </th>
                        <th>Samedi</th>
                        <th>Dimanche</th>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 8H  -->
                    <tr>
                        <td scope="row">8:30 - 10:00</td>
                        <!-- Samedi -->
                        <?php 
                            seance('8:30','samedi',$class)
                        ?>
                        <!-- dimanche -->
                        <?php 
                            seance('8:30','dimanche',$class)
                       ?>
                        <!-- Lundi -->
                        <?php 
                            seance('8:30','lundi',$class)
                       ?>
                        <!-- Mardi -->
                        <?php 
                            seance('8:30','mardi',$class)
                       ?>
                        
                        <!-- Mercredi -->
                        <?php 
                            seance('8:30','mercredi',$class)
                       ?>

                    </tr>

                    <!-- 10H  -->
                    <tr>
                        <td scope="row">10:15 - 11:45</td>
                        <!-- samedi -->
                        <?php 
                            seance('10:15','samedi',$class )
                        ?>
                        <!-- dimanche -->
                        <?php 
                            seance('10:15','dimanche',$class )
                       ?>
                        <!-- Lundi -->
                        <?php 
                            seance('10:15','lundi',$class )
                       ?>
                        <!-- Mardi -->
                        <?php 
                            seance('10:15','mardi',$class )
                       ?>
                        
                        <!-- Mercredi -->
                        <?php 
                            seance('10:15','mercredi',$class )
                       ?>
                    </tr>

                    <!-- 12H  -->
                    <tr>
                        <td scope="row">12:15 - 13:45</td>
                        <!-- samedi -->
                        <?php 
                            seance('12:15','samedi',$class )
                        ?>
                        <!-- dimanche -->
                        <?php 
                            seance('12:15','dimanche',$class )
                        ?>
                        <!-- Lundi -->
                        <?php 
                            seance('12:15','lundi',$class )
                        ?>
                        <!-- Mardi -->
                        <?php 
                            seance('12:15','mardi',$class )
                        ?>
                        <!-- Mercredi -->
                        <?php 
                            seance('12:15','mercredi',$class )
                        ?>

                    </tr>

                    <!-- 14H  -->
                    <tr>
                        <td scope="row">14:00 - 15:30</td>
                        <!-- samedi -->
                        <?php 
                            seance('14:00','samedi',$class )
                        ?>
                        <!-- dimanche -->
                        <?php 
                            seance('14:00','dimanche',$class )
                        ?>
                        <!-- Lundi -->
                        <?php 
                            seance('14:00','lundi',$class )
                        ?>
                        <!-- Mardi -->
                        <?php 
                            seance('14:00','mardi',$class )
                        ?>
                        <!-- Mercredi -->
                        <?php 
                            seance('14:00','mercredi',$class )
                        ?>
                    </tr>

                    <!-- 15H45  -->
                    <tr>
                        <td scope="row">15:45 - 17:15</td>
                        <!-- samedi -->
                        <?php 
                            seance('15:45','samedi',$class )
                        ?>
                        <!-- dimanche -->
                        <?php 
                            seance('15:45','dimanche',$class )
                        ?>
                        <!-- Lundi -->
                        <?php 
                            seance('15:45','lundi',$class )
                        ?>
                        <!-- Mardi -->
                        <?php 
                            seance('15:45','mardi',$class )
                        ?>
                        <!-- Mercredi -->
                        <?php 
                            seance('15:45','mercredi',$class )
                        ?>
                    </tr>

                    <!-- 17H15  -->
                    <?php 
                        //if( !empty(seance('17:30','samedi',$class )) && !empty(seance('17:30','dimanche',$class )) && !empty(seance('17:30','lundi',$class )) && !empty(seance('17:30','mardi',$class )) && !empty(seance('17:30','mercredi',$class )) ) :    
                    ?>
                    <tr>
                        <td scope="row">17:30 - 19:00</td>
                        <!-- samedi -->
                        <?php 
                            seance('17:30','samedi',$class )
                        ?>
                        <!-- dimanche -->
                        <?php 
                            seance('17:30','dimanche',$class )
                        ?>
                        <!-- Lundi -->
                        <?php 
                            seance('17:30','lundi',$class )
                        ?>
                        <!-- Mardi -->
                        <?php 
                            seance('17:30','mardi',$class )
                        ?>
                        <!-- Mercredi -->
                        <?php 
                            seance('17:30','mercredi',$class )
                        ?>
                    </tr>
                    <?php //endif; ?>        
                    
                </tbody>
            </table>
            </div>                            
            <!-- End Table  -->
                

    <?php
        echo "</div>"; // end container
            } else {
                $error = "<div class='container'><div class='alert alert-info'>Obliger de choisir Une Classe</div></div>";
                redirectHome($error,"Back");
            }// end if empty class 
    } // end if isset Post : display name                        

    } // end display 
        
        else if($do == "Insert"){
            echo "<div class='container'>";
            echo "<h1 class='text-center'> Ajouter Une Seance</h1>";
            if(isset($_POST['addEmploi'])){
                $heure = $_POST['heure'];
                $jour = $_POST['jour'];
                $prof = $_POST['profid'];
                $matiere = $_POST['matid'];
                $classe = $_POST['classe'];
                // echo "prof : " .$prof. " Matier : " . $matiere . " Class : " . $classe;
                $formErrors = array();
                
                if(empty($heure)){
                    $formErrors[] = "<div class='alert alert-danger'>Obliger de <strong>choisir l'heure</strong></div>";
                }
                
                if(empty($jour)){
                    $formErrors[] = "<div class='alert alert-danger'>Obliger de <strong>choisir le jour</strong></div>";
                }

                if(!is_numeric($prof)){
                    $formErrors[] = "<div class='alert alert-danger'>Vous etes Oblige de <strong>choisir Un professeur</strong></div>";
                }
                
                if(!is_numeric($matiere)){
                    $formErrors[] = "<div class='alert alert-danger'>Vous etes Oblige de <strong>choisir Une Matiere</strong></div>";
                }
                
                if(!is_numeric($classe)){
                    $formErrors[] = "<div class='alert alert-danger'>Vous etes Oblige de <strong>choisir Une Classe</strong></div>";
                }

                foreach($formErrors as $error){
                    echo $error;
                    $url = $_SERVER['HTTP_REFERER'];
                    header("refresh:3; url=$url");
                    // $theMsg = $error;
                    // redirectHome($theMsg,"Back");
                }

                if(empty($formErrors)){

                    $checkEmploiClass = checkEmploiClass($heure,$jour,$classe);
                    if($checkEmploiClass > 0){ // verifier si la classe est occupe ou non a cette heure
                        $theMsg = "<div class='alert alert-danger'> Impossible de faire une seance a cette heure</div>";
                        redirectHome($theMsg,"Back");
                    } else {

                        $checkHourProf = checkHourProf($heure,$jour,$prof);
                        // Apres avoir reccuperer les donnes 
                        // nous allons verifier est ce que la matiere que le professeur enseigne a cette heure
                        // est la matiere que la matiere qu'on veut inserer 
                        if($checkHourProf > 0){    
                            if($checkHourProf['idMatiere'] == $matiere): // verifier si la matiere selectionner est la meme
                                $insert = insertEmploi($heure,$jour,$prof,$matiere,$classe);
                                if($insert>0):
                                    $successInsert = "<div class='alert alert-success'> Seance Ajouter Avec Succes</div>";
                                    redirectHome($successInsert,"Back");
                                endif; 
                            else:
                                $theMsg = "<div class='alert alert-danger'> Impossible d'enseigner cette matiere il a deja une autre a cette heure </div>";
                                redirectHome($theMsg,"Back");
                            endif;  // verifier si la matiere selectionner est la meme
                        }else {
                            $insert = insertEmploi($heure,$jour,$prof,$matiere,$classe);
                            if($insert>0):
                                $successInsert = "<div class='alert alert-success'> Seance Ajouter Avec Succes</div>";
                                redirectHome($successInsert,"Back");
                            else:
                                $failInsert = "<div class='alert alert-danger'> Seance N'a pas Ajouter</div>";
                                redirectHome($failInsert,"Back");
                            endif;        
    
                        }
                    }    // end if check emploi

                    
                } // end if empty error

            }

            echo "</div>";
        } // ENd Insert Section

        else if($do == "Delete"){

            if(isset($_POST['deleteSeance'])){
                echo "<div class='container'>";
                echo "<h1 class='text-center'>Suppression De la Seance</h1>";
                $id = $_POST['deleteid'];
                $delete = deleteSeance($id);
                if($delete > 0):
                    $successDelete = "<div class='alert alert-success'>Suppression Avec Success</div>";
                    redirectHome($successDelete,"Back");
                else:
                    $failDelete = "<div class='alert alert-danger'>Suppression N'a pas ete faite</div>";
                    redirectHome($failDelete,"Back");
                endif;

                echo "</div>";
            }


        } // End Section Delete

        include $tpl . "footer.php";   
    }else {
        header("Location: index.php");
    }
    ob_end_flush();
?>    

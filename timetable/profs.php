<?php

    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        include "init.php";
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        if($do == "Manage"){
            // Manage
        ?>

        <div class="container profs"> 
            <h1 class="text-center">Gestion des Professeurs</h1>
            <div class="row">
                <div class="col-sm-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#AddModal">
                        <i class='fa fa-plus'></i> Ajouter Un Professeur
                    </button>
                </div>
                <div class="col-sm-4 search">
                    <div class="form-group">
                        <input class="form-control" id="searchProf" type="search" placeholder="Search" aria-label="Search">
                    </div>
                </div>
                <div class="col-sm-2 search">
                    <div class="form-group">
                        <form action="" method="POST" class="limit">
                            <select name="limit" id="limit-record" class="form-control">
                                <option>--Limit Records--</option>
                                <?php 
                                    $limitArr = array("5","10","20","50","100");
                                    foreach($limitArr as $lim):
                                        echo "<option value='".$lim."'>".$lim."</option>";
                                    endforeach;
                                ?>
                                <option value="<?php echo countRowProf(); ?>">All Data</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php 
                        $limit = isset($_POST['limit']) ? $_POST['limit'] : 5;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;                        
                        $start = ($page - 1) * $limit;                            
                        
                        $professeurs = getAllProfLimit($start,$limit); 
                        
                        $total     = countRowProf();    
                        // echo $total;
                        $pages     = ceil($total/$limit); 
                        // echo $pages;
                        $previous  = ($page - 1) > 0 ? $page - 1 : $page;
                        $next      = ($page < $pages ) ? $page +1 : $page;
                        
                        $curr = isset($_GET['page']) ? $_GET['page'] : 1;    
                    
                    ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="?do=Manage&page=<?php echo $previous?>">Previous</a></li>
                            <li class="page-item"><a class="page-link"><strong>Page:</strong> <?php echo $curr?></a></li>
                            <li class="page-item"><a class="page-link" href="?do=Manage&page=<?php echo $next?>">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <?php
                // $professeurs = getAllProf($page,$previous,$next); 
                if(!empty($professeurs)):
            ?>

        <div class="table-responsive">
            <table class="table main-table table-bordered" id="profTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Telephone</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($professeurs as $prof){                
                    ?>
                    <tr>
                        <td><?php echo $prof['idProf']; ?></td>
                        <td><?php echo $prof['nameProf']; ?></td>
                        <td><?php echo $prof['lnameProf']; ?></td>
                        <td><?php echo $prof['cellphone']; ?></td>
                        <td>
                            <button type="button" class="btn btn-success btn-edit" data-toggle="modal" data-target="#edModal">
                            <i class='fa fa-edit'></i> Modifier
                            </button>                          
                            <button type="button" class="btn btn-danger btn-delete" data-idprof="<?php echo $prof['idProf']; ?>" data-toggle="modal" data-target="#delModal">
                              <i class='fa fa-close'></i> Supprimer
                            </button>
                        </td>
                    </tr>
                    <?php } // End foreach loop =>prof
                        else:
                            echo "<div class='alert alert-info'>There is No Information To Show</div>";
                        endif;  // end if table professor is empty 
                    ?> 
                </tbody>
            </table>
        </div>

        <!-- Start Add Modal -->
            <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddModal">Ajouter un Professeur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="?do=Insert" method="POST">
                            <div class="form-group">
                                <label for="fname">Nom</label>
                                <input type="text" class="form-control" name="fname" placeholder="Entere le Nom">
                            </div>
                            <div class="form-group">
                                <label for="lname">Prenom</label>
                                <input type="text" class="form-control" name="lname" placeholder="Entrer le Prenom">
                            </div>
                            <div class="form-group">
                                <label for="cellphone">Telephone</label>
                                <input type="text" class="form-control" name="cellphone" placeholder="Entrer le Numero de telephone">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" name="Add">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- ENd Add Modal -->

            <!-- Start Edit Modal -->
            
            <div class="modal fade" id="edModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">Modifer Un Professeur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <form action="?do=Update" method="POST">    
                            <div class="form-group">
                                <input type="hidden" name="idprof" id="idProf">
                            </div>
                            <div class="form-group">
                                <label for="fname">Nom</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="Entrer Le Nom">
                            </div>
                            <div class="form-group">
                                <label for="lname">Prenom</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Entre Le Prenom">
                            </div>
                            <div class="form-group">
                                <label for="cellphone">Telephone</label>
                                <input type="text" class="form-control" id="phone" name="cellphone" placeholder="Entre le numero de telephone">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" name="edit">Modifier l'enregistrement</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <!-- End Edit Modal -->

            <!-- Start Delete Modal -->
            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal">Delete Record</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Do You Want Delete this record ??                           
                            <form action="?do=Delete" method="POST">
                                <input type="hidden" id="prof-delete" name="idprof">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="delete">Delete Record</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- ENd Delete Modal -->

        </div>

<?php   } elseif($do == "Insert") {
    
        echo "<div class='container'>";
        echo '<h1 class="text-center">Insert Professor</h1>';

        if( ($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['Add']) ){
                $fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
                $lname = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
                $phone = filter_var($_POST['cellphone'],FILTER_SANITIZE_NUMBER_INT);

                $formErrors =  array();

                if(empty($fname)):
                    $formErrors[] = "Le champ Nom de professeur <strong>ne peut pas etre vide </strong>";
                endif;
                if(empty($lname)):
                    $formErrors[] = "Le champ prenom de professeur <strong>ne peut pas etre vide </strong>";
                endif;      
                
                if(!is_numeric($phone)){
                    $formErrors[] = "Le numero de telephone doit Contenir <strong> Uniquement de nombre</strong>";
                }

                    foreach($formErrors as $error):
                        $theMsg = "<div class='alert alert-danger'>" . $error . "</div>";
                        redirectHome($theMsg,"back");
                    endforeach;   

                if(empty($formErrors)){
                    $insert = insertProf($fname,$lname,$phone);
                    if($insert == 1 ):
                        $theMsg = "<div class='alert alert-success'> record Inserted</div>";
                        redirectHome($theMsg,"back");
                    endif;    
                }
            } 
            echo "</div>";
        } // end insert prof
        
        else if($do == "Update"){ // End Update

            echo "<div class='container'>";
            echo "<h1 class='text-center'>Update Professor</h1>";
            if(isset($_POST['edit'])){
                
                $id = $_POST['idprof'];
                $fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
                $lname = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
                $phone = filter_var($_POST['cellphone'],FILTER_SANITIZE_NUMBER_INT);
                
                $formErrors = array();

                if(empty($fname)):
                    $formErrors[] = "Le champ Nom de professeur <strong>ne peut pas etre vide </strong>";
                endif;
                if(empty($lname)):
                    $formErrors[] = "Le champ prenom de professeur <strong>ne peut pas etre vide </strong>";
                endif;      
                if(!is_numeric($phone)):
                    $formErrors[] = "Le numero de telephone doit Contenir <strong> Uniquement de nombre</strong>";
                endif;   

                foreach($formErrors as $error):
                    $theMsg = "<div class='alert alert-danger'>" . $error . "</div>";
                    redirectHome($theMsg,"Back");
                endforeach;   

                if(empty($formErrors)):
                    $editprof = updateProf($fname,$lname,$phone,$id);
                    if($editprof>0):
                        $theMsg = "<div class='alert alert-success'> Modification Terminer </div>";
                        redirectHome($theMsg,"Back");
                    else:
                        $theMsg = "<div class='alert alert-info'> Rien N'a èté Modifier </div>";
                        redirectHome($theMsg,"Back");
                    endif;    
                endif;

            }

            echo "</div>";

        }  // End Update
        
        else if($do == "Delete"){ // Start Delete 

            echo "<div class='container'>";
                echo "<h1 class='text-center'>Supprimer Un Professeur</h1>";

                if( ($_SERVER['REQUEST_METHOD'] == "POST") &&  isset($_POST['delete']) ){
                    $id  = $_POST['idprof'];
                    
                    $del = deleteProf($id);
                    if($del == 1){
                        $theMsg = "<div class='alert alert-success'>Suppression Avec Succes</div>";
                        redirectHome($theMsg,"back");
                    }else {
                        $theMsg = "<div class='alert alert-danger'>Rien N'a èté supprimer </div>";
                        redirectHome($theMsg,"back");
                    }
    
                }else {
                    $theMsg = "<div class='alert alert-danger'>Acces direct Non Autoriser</div>";
                    redirectHome($theMsg);
                }

            echo "</div>";

        } // End Delete Prof


        include $tpl . "footer.php";

    }else {
        header("Location: index.php");
    }

    ob_end_flush();

?>
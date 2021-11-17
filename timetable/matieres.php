<?php 
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        include "init.php";

        $do = isset($_GET['do']) ? $_GET['do'] : "Manage";

        if($do == "Manage"){
        ?>    
        
        <div class='container matieres'>
            <h1 class='text-center'>Gestion des matieres</h1>
    
            <!-- Button ADD modal -->
            <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#adModal">
                <i class='fa fa-plus'></i> Ajouter nouvelle matiere
            </button>
            
            <?php 
                $matieres = getAllMat(); 
                if(!empty($matieres)):
            ?>
            <div class="table-responsive">
            <table class="table main-table table-bordered">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Matiere</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($matieres as $mat):
                    ?>
                    <tr>
                        <td><?php echo $mat['idMatiere']; ?></td>
                        <td><?php echo $mat['subject']; ?></td>
                        <td>   
                        <!-- Button Edit modal -->
                        <button type="button" class="btn btn-success btn-edit" data-toggle="modal" data-target="#edModal">
                            <i class='fa fa-edit'></i> Modifier
                        </button>   
                         <!-- Button Delete modal -->
                         <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#delModal">
                            <i class='fa fa-close'></i> Supprimer
                        </button>   
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php 
                else:
                    echo "<div class='alert alert-info'> Il n'existe pas de matiere a afficher</div>";
                endif;
            ?>

            <!-- ADD Modal -->
            <div class="modal fade" id="adModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="?do=Insert" method="POST">
                            <div class="form-group">
                                <label for="matiere">Matiere</label>
                                <input type="text" name="matiere" class="form-control" placeholder="Enter Name Of Subject">
                            </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="addSubject" class="btn btn-primary">Save Record</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End ADD MODAL -->


            <!-- Start Edit Modal -->
           <div class="modal fade" id="edModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="?do=Update" method="POST">
                            <input type="hidden" name="updateid" id="updateid">
                            <div class="form-group">
                                <label for="matiere">Matiere</label>
                                <input type="text" name="matiere" id="updateMatiere" class="form-control" placeholder="Enter Name Of Subject">
                            </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="editSubject" class="btn btn-success">Save changes</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Edit Modal -->


            <!-- Start Delete Modal -->
            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure ??</p>
                        <form action="?do=Delete" method="POST">
                            <input type="hidden" name="deleteid" id="deleteid">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="deleteSubject" class="btn btn-danger">Save changes</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Delete Modal -->


        </div> <!-- ENd COntainer-->
        
        <?php
        } // End Manage 
        
        else if($do == "Insert"){
        ?>    
        
            <div class='container'>
                <h1 class='text-center'>Insert Subject</h1>
                <?php
                    if(isset($_POST['addSubject'])) {
                        $matiere = filter_var($_POST['matiere'],FILTER_SANITIZE_STRING);
                        
                        $formErrors = array();

                        if(empty($matiere)):
                            $formErrors[] = "Le champ Matiere <strong>Ne peut pas etre vide</strong>";
                        endif;

                        foreach($formErrors as $error){
                            echo "<div class='alert alert-danger'>".$error."</div>";
                        }


                        if(empty($formErrors)){
                            
                            if(getMat($matiere)):
                                $theMsg = "<div class='alert alert-danger'> La matiere existe deja</div>";                                
                                redirectHome($theMsg,"Back");
                            else:                             
                                $insert = insertMat($matiere);
                                if($insert == 1):
                                    $successMsg = "<div class='alert alert-success'> Matiere Inserted</div>";                                
                                    redirectHome($successMsg,"Back");
                                else:
                                    $failedMsg = "<div class='alert alert-danger'> Matiere No Inserted</div>";                                
                                    redirectHome($failedMsg,"Back");
                                endif;
                            endif;    
                        }

                    }
                ?>
            </div>
        
        <?php
        } // End Insert
        
        else if($do == "Update"){
            
            echo "<div class='container'>";
                echo "<h1 class='text-center'>Update Subject</h1>";
                if(isset($_POST['editSubject'])){
                    $id  = $_POST['updateid'];
                    $mat = filter_var($_POST['matiere'],FILTER_SANITIZE_STRING);

                    if(empty($mat)):
                        $error = "Subject <strong>Can't Be Empty</strong>";
                    endif;

                    if(empty($error)):
                        $update = updateMat($mat,$id);
                        if($update == 1):
                            $successMsg = "<div class='alert alert-success'> Record Updated</div>";
                            redirectHome($successMsg,"Back"); 
                        else:
                            $failMsg = "<div class='alert alert-danger'> Record No Updated</div>";
                            redirectHome($failMsg,"Back");
                        endif;

                    else:
                        $err =  "<div class='alert alert-danger'>".$error."</div>";
                        redirectHome($err,"Back");
                    endif;


                }
                
            
            echo "</div>";
        
        } // End Delete 
        
        else if($do == "Delete"){
           
        echo "<div class='container'>";
            echo "<h1 class='text-center'>Delete Subject</h1>";
        
            if( isset($_POST['deleteSubject']) ) {
                $id = $_POST['deleteid'];
                $delete = deleteMat($id);
                if($delete == 1):
                    $successDelete = "<div class='alert alert-success'> Reecord Deleted</div>";
                    redirectHome($successDelete,"Back");
                else:
                    $failedDelete = "<div class='alert alert-danger'> Reecord No Deleted</div>";
                    redirectHome($failedDelete,"Back");
                endif; 
            }
            
        echo "</div>";
       
        }


        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

    ob_end_flush();
?>
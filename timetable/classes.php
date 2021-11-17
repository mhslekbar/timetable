<?php 
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        include "init.php";

        $do = isset($_GET['do']) ? $_GET['do'] : "Manage";


        if($do == "Manage") {
        ?>    

    <div class='container classes'>
            <h1 class='text-center'>Manage Classes</h1>
            
        <!-- Button ADD modal -->
        <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#adModal">
            <i class='fa fa-plus'></i> Add New Classe
        </button>
        
        <div class="table-responsive">

        <?php 
            $classes = getAllClass();
            if(!empty($classes)):
        ?>   

            <table class="table main-table table-bordered">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Class Name</th>
                        <th>Contol</th> 
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($classes as $class):
                ?>
                    <tr>
                        <td><?php echo $class['idClass']; ?></td>
                        <td><?php echo $class['nameClass']; ?></td>
                        <td>
                        <!-- Button Edit modal -->
                        <button type="button" class="btn btn-success btn-edit" data-toggle="modal" data-target="#edModal">
                            <i class='fa fa-edit'></i> Edit
                        </button>
                        <!-- Button Edit modal -->
                        <button type="button" class="btn btn-danger btn-delete" data-idClasse="<?php echo $class['idClass']; ?>" data-toggle="modal" data-target="#delModal">
                            <i class='fa fa-close'></i> Delete
                        </button>
                        </td>
                    </tr>
                <?php 
                    endforeach; 
                ?>    
                </tbody>
            </table>    
        <?php 
            else:
                echo "<div class='alert alert-info'> There is no information to show </div>";
            endif;
        ?>
        </div> <!-- End Table Responsive -->


        <!-- ADD Modal -->
        <div class="modal fade" id="adModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="?do=Insert" method="POST">
                        <div class="form-group">
                            <label for="nameClass">Class Name</label>
                            <input type="text" name="nameClass" class="form-control"> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="btn-add"class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>    


        <!-- Edit Modal -->
        <div class="modal fade" id="edModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="?do=Update" method="POST">
                    <input type="hidden" name="idClass" id="updateIdClass">
                    <div class="form-group">
                        <label for="nameClass">Class Name</label>
                        <input type="text" name="nameClass" class="form-control text-left" id="updateClass"> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="btn-edit"class="btn btn-success">Update changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>


        <!-- Delete Modal -->
        <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModal">Delete Classe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are Your Sure ??</h5>
                    <form action="?do=Delete" method="POST">
                        <input type="hidden" name="idclass" id="delete-Class">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="btn-delete"class="btn btn-danger">Delete Record</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>


    </div> <!-- End COntainer -->

        <?php    

        } // End Manage
        else if($do == "Insert"){

            echo "<div class='container'>";
                echo "<h1 class='text-center'>Insert classe</h1>";

                if(isset($_POST['btn-add'])){
                    $nameClasse = filter_var($_POST['nameClass'],FILTER_SANITIZE_STRING);
                    $error="";
                    if(empty($nameClasse)){
                        $error = "Class Name Can't Be Empty";
                    }

                    if(!empty($error)){
                        $theMsg = "<div class='alert alert-danger'>" . $error . "</div>";
                        redirectHome($theMsg,"Back");
                    }else {
                        $check = checkClassExist($nameClasse);
                        if($check>0):
                            $theMsg = "<div class='alert alert-danger'> La Classe existe Deja</div>";
                            redirectHome($theMsg,"Back");
                        else:
                            $insrt = insertClasse($nameClasse);
                            if($insrt == 1):
                                $theMsg = "<div class='alert alert-success'> La classe est enregistrer avec succes</div>";
                                redirectHome($theMsg,"Back"); 
                            endif;    
                        endif;    
                    }

                }

            echo "</div>";

        } // End Insert 
        else if($do == "Update"){
            echo "<div class='container'>";
            echo "<h1 class='text-center'>Update Classes</h1>";
            
            if(isset($_POST['btn-edit'])){
                
                $id = $_POST['idClass'];
                $name = filter_var($_POST['nameClass'],FILTER_SANITIZE_STRING);
                if(empty($name)):
                    $error = "Class Name Can't Be Empty";
                endif;
        
                if(empty($error)):
                    $class = updateClasse($name,$id);
                    if($class == 1):
                        $theMsg = "<div class='alert alert-success'> Record Updated</div>";
                        redirectHome($theMsg,"Back");
                    endif;   
                else:
                    $theMsg = "<div class='alert alert-danger'>".$error."</div>";
                    redirectHome($theMsg,"Back");
                endif;
        
            }
            
            echo "</div>";
        } // End Edit 
        else if($do == "Delete"){
            echo "<div class='container'>";
            echo "<h1 class='text-center'>Delete Record</h1>";
            
            if(isset($_POST['btn-delete'])){
                $id = $_POST['idclass'];
                $delClass = deleteClasse($id);
                if($delClass == 1):
                    $theMsg = "<div class='alert alert-success'>Class Deleted</div>";  
                    redirectHome($theMsg,"back");                  
                else:
                    $theMsg = "<div class='alert alert-danger'> Class No Deleted</div>";  
                    redirectHome($theMsg,"back");                  
                endif;
            }
            
            echo "</div>";
            
        } // End Delete 

        include $tpl . "footer.php";

    }else {
        header("Location: index.php");
    }

    ob_end_flush();
    
?>
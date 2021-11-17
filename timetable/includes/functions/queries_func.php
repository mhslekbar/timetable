<?php 
    
    /* Start Professors Tricks*/

    // getAllProf 
    function getAllProf(){
        global $con;
        $stmt = $con->prepare("SELECT * FROM profs ORDER BY idProf DESC");
        $stmt->execute();
        $profs = $stmt->fetchAll();
        return $profs;
    }

    
    function getAllProfLimit($start,$limit){
        global $con;
        $stmt = $con->prepare("Select * from profs ORDER BY idProf DESC LIMIT $start, $limit");
        $stmt->execute();
        $profs = $stmt->fetchAll();
        return $profs;
    }


    // InsertProf
    function insertProf($fname,$lname,$phone){
        global $con;
        $stmt = $con->prepare("INSERT INTO profs (nameProf,lnameProf,cellphone) values (?,?,?)");
        $stmt->execute(array($fname,$lname,$phone));
        $count = $stmt->rowCount();
        return $count;
    } 

    // Update Prof 

    function updateProf($fname,$lname,$phone,$id){
        global $con;
        $stmt2 = $con->prepare("UPDATE profs SET nameProf = ? , lnameProf = ? , cellphone = ? WHERE idProf = ?");
        $stmt2->execute(array($fname,$lname,$phone,$id));
        $count = $stmt2->rowCount();
        return $count;
    }

    // Delete Professeur

    function deleteProf($id){
        global $con;
        $stmt = $con->prepare("DELETE FROM profs where idProf = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        return $count;
    }

    // count rows 
    function countRowProf(){
        global $con;
        $stmt = $con->prepare("SELECT * from profs");
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }


    /* End Professors Tricks */
    
 
    /**************** */
 
    /* Start Classes Tricks */
    
    // Display All Classes

    function getAllClass() {
        global $con;
        $stmt = $con->prepare("SELECT * FROM classes ORDER BY idClass DESC");
        $stmt->execute();
        $classe = $stmt->fetchAll();
        return $classe;
    }   
    
    // Check if Class existe 

    function checkClassExist($classe){
        global $con;
        $stmt = $con->prepare("SELECT * FROM classes WHERE nameClass = ? ");
        $stmt->execute(array($classe));
        $count = $stmt->rowCount();
        return $count;
    }
    

    // Insert Class

    function insertClasse($name){
        global $con;
        $stmt = $con->prepare("INSERT INTO classes (nameClass) values (?)");
        $stmt->execute(array($name));
        $count = $stmt->rowCount();
        return $count;
    }

    function updateClasse($name,$id){
        global $con;
        $stmt = $con->prepare("UPDATE classes SET nameClass = ? WHERE idClass = ?");
        $stmt->execute(array($name,$id));
        $count = $stmt->rowCount();
        return $count;
    }


    function deleteClasse($id){
        global $con;
        $stmt = $con->prepare("DELETE FROM classes WHERE idClass = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        return $count;
    }



    /* End Classes Tricks */


    /* Start Matieres Tricks */

    function getAllMat(){
        global $con;
        $stmt = $con->prepare("SELECT * FROM matieres ORDER BY idMatiere DESC");
        $stmt->execute();
        $matiere = $stmt->fetchAll();
        return $matiere; 
    }

    function getMat($mat){
        global $con;
        $stmt = $con->prepare("SELECT * FROM matieres where subject = ? ");
        $stmt->execute(array($mat));
        $matiere = $stmt->fetch();
        return $matiere; 
    }

    // Insert 

    function insertMat($mat){
        global $con;
        $stmt = $con->prepare("INSERT INTO matieres (subject) values (?) ");
        $stmt->execute(array($mat));
        $count = $stmt->rowCount();
        return $count;
    }

    // Update

    function updateMat($mat,$id){
        global $con;
        $stmt = $con->prepare("UPDATE matieres SET subject = ? WHERE idMatiere = ?");
        $stmt->execute(array($mat,$id));
        $count = $stmt->rowCount();
        return $count;
    }


    // Delete 

    function deleteMat($id){
        global $con;
        $stmt = $con->prepare("DELETE FROM matieres WHERE idMatiere = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        return $count;
    }   

    /* End Matieres Tricks */



    /* Start Emploi Tricks */
    
    // Insert 
    function insertEmploi($h,$j,$prof,$matiere,$classe){
        global $con;
        $stmt = $con->prepare("INSERT INTO emploi (heure,jour,idProf,idMatiere,idClass) values (?,?,?,?,?) ");
        $stmt->execute(array($h,$j,$prof,$matiere,$classe));
        $count = $stmt->rowCount();
        return $count;
    }
    
    // verifier si cette heure est libre pour une classe precis

    function checkEmploiClass($h,$j,$class){
        global $con;
        $stmt = $con->prepare("SELECT * from emploi WHERE heure = ? AND jour = ?  AND idClass = ? ");
        $stmt->execute(array($h,$j,$class));
        $count = $stmt->rowCount();
        return $count;
    }
    
    // afficher le professeur qui ont une matiere a cette heure
    
    function checkHourProf($h,$j,$prof){
        global $con;
        $stmt = $con->prepare("SELECT * from emploi WHERE heure = ? AND jour = ? AND idProf = ? ");
        $stmt->execute(array($h,$j,$prof));
        $count = $stmt->fetch();
        return $count;
    }

    // reccupere les seances pour les afficher dans un tableau

    function getSeance($heure,$jour,$class){
        global $con;
        $stmt = $con->prepare("SELECT idEmploi, subject, profs.nameProf as nameProf FROM emploi JOIN matieres ON emploi.idMatiere = matieres.idMatiere JOIN profs ON profs.idProf = emploi.idProf WHERE heure = ? AND jour = ? AND idClass = ?");
        $stmt->execute(array($heure,$jour,$class));
        $cours = $stmt->fetch();
        return $cours;
    }

    function getClassWhere($class){
        global $con;
        $stmt = $con->prepare("SELECT * FROM classes where idClass = ?");
        $stmt->execute(array($class));
        $classe = $stmt->fetch();
        return $classe;      
    }


    // Delete Seance

    function deleteSeance($id){
        global $con; 
        $stmt = $con->prepare("DELETE FROM emploi WHERE idEmploi = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        return $count;
    }

    /* End Emploi Tricks */
    














?>
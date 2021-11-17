$(document).ready(function(){
    
    'use strict';

    // Start Login

    $(".alert-login").fadeTo(1000,100).slideDown(300,function(){
            $(this).slideUp();
    });

    // ENd Login 

    $(".profs .btn-delete").on("click",function(){
        var idprof = $(this).data('idprof');
        $("#prof-delete").val(idprof);
    });

    $(".profs .btn-edit").on("click",function(){
        var idprf = $(this).data("idprof");
        $("#prof-edit").text(idprf);
    });


    // Edit Prof

    $(".profs .btn-edit").on("click",function(){
        $('#edmodal').modal('show');
        
        var data = $(this).closest('tr').children("td").map(function(){
            return $(this).text();
        }).get();

        $("#idProf").val(data[0]);
        $("#fname").val(data[1]);
        $("#lname").val(data[2]);
        $("#phone").val(data[3]);
    });

    // Limit Record

    $("#limit-record").change(function(){
        $('form.limit').submit();
    });

    
    // Search prof

    $("#searchProf").on("keyup",function(){
        var value = $(this).val().toLowerCase();
        $("#profTable tbody tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) >= 0);
        });
    });

    // Edit Classe

    $(".classes .btn-edit").on("click",function(){
        
        var data = $(this).closest("tr").children("td").map(function(){
            return $(this).text();
        }).get();
        
        $("#updateIdClass").val(data[0]); 
        $("#updateClass").val(data[1]);

    });

    // Drop Class 

    $(".classes .btn-delete").on("click",function(){
        
        var id = $(this).closest("tr").children("td").map(function(){
            return $(this).text();
        }).get();
        
        $("#delete-Class").val(id[0]);
    });



    // Edit Matiere 
    
    $(".btn-edit").on("click",function(){
        var data = $(this).closest("tr").children("td").map(function(){
            return $(this);
        }).get();
        $("#updateid").val(data[0].text());
        $("#updateMatiere").val(data[1].text());
        // $("#updateMatProf").val(data[0].text()).attr("selected",true);

        // console.log($("#updateMatProf").val(data[0].data("id").val()) );
        
    });


    // Delete Matiere 

    $(".btn-delete").on("click",function(){
        var data = $(this).closest("tr").children("td").map(function(){
            return $(this).text();
        }).get();
        $("#deleteid").val(data[0]);

    });




    /* Emploi Tricks  */

    // function getProf(val){
    //     $.ajax({
    //         type: "POST",
    //         url: "",
    //         data: "profid=" + val,
    //         success: function(data){
    //             $("#matid").html(data);
    //         }
    //     }); 
    // }

    // $("#profid").on("change", function() {
    //     var profid = document.getElementById("profid").value;
    //     $.post('emploi.php', { id: profid }, function(result) {
    //         $('#matid').val(result);
    //         $('#matid').change();
    //        }
    //    );
        
    // });

    $(".btn-supp").on("click",function(){
        var idseance = $(this).data("idseance");
                
        $("#deleteidseance").val(idseance);

    });


    /* Emploi Tricks  */







});


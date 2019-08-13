$(document).ready(function() {
    $("#addToClip").click(function() {
        $.ajax( {
            type: "POST",
            url: "clipboard/add-to-clipboard.php",
            data: "userId=" + u_id + "&prodId=" + p_id,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                alert('Wystąpił błąd! Sprawdź konsolę aby uzyskać więcej informacji!');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        })
        .done(function (response){
            let result;
            if(response.status == "success"){
                result = "Sukces!";
                let amount = parseInt($("#clipAmount").text(), 10);
                amount = amount + 1;
                $("#clipAmount").text(amount);
                $(".alert-icon-success").css("display","flex");
                $(".alert-icon-danger").css("display","none");
            }
            else{
                result = "Uwaga!";
                $(".alert-icon-success").css("display","none");
                $(".alert-icon-danger").css("display","flex");
            }
            $("#alertModal").modal("show");
            $("#alertModalTitle").text(result);
            $("#alertModalText").text(response.text);
        });
    });
});
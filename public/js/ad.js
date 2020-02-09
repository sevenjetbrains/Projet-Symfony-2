$('#add-image').click(function () { // je récupére le numéro des futurs champs que je vais créer
    const index = + $('#widgets-counter').val();
    // je récupére le protoype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/_name_/g, index);
    
    
    // j'injecte ce code au sein de la div
    $('#ad_images').append(tmpl);
    // je gére le boutton supprimer
    
    $('#widgets-counter').val(index + 1);
    handleDeleteButtons();
    
    });
    
    function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
    const target = this.dataset.target;
    console.log(target);
    $(target).remove();
    });
    
    }
    function updateCounter(){
        const count= +$('#ad_images div.form-group').length;
    
        $('#widgets-counter').val(count); 
    }
     updateCounter();
    handleDeleteButtons();
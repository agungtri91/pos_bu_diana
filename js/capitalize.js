$(document).ready(function() {
    $("input, textarea").not('input[type="email"]').keyup(function() {
        var val = $(this).val()
        $(this).val(val.toUpperCase());
    });

    $('input[type="text"]').not('input[type="email"]').not('.btn').on('keydown', function() { 
        var $this = $(this), value = $this.val(); 
        if (value.length === 1) { 
            $this.val( value.charAt(0).toUpperCase() );
        }  
    });
});
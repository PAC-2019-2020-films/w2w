if (typeof jQuery != "undefined") {

    (function($) {
    
        $(document).ready(function() {
            
            /**
             * Extrait le nom du fichier du chemin complet
             */
            function basename(str) {
                return str.split(':').pop().split('\\').pop().split('/').pop();
            }
            
            /**
             * Renvoie le nom du fichier sans l'extension
             */
            function stripExtension(str) {
                var pos = str.lastIndexOf(".");
                if (pos > 0) {
                    return str.substring(0, pos);
                }
            }
            
            /**
             * deprecated
             */
            /*$("#poster-file").change(function() {
                let filePath = $(this).val();
                let fileName = basename(filePath);
                let posterValue = stripExtension(fileName);
                $("#poster").val(posterValue);
            });*/
            
            
            if ($.fn.multi) {
                /*$("select#tags").multi({
                    non_selected_header: "Tags",
                    selected_header: "Selected Tags"
                });*/
                $("select.multi").multi({
                    non_selected_header: "Disponibles",
                    selected_header: "Sélectionnés"
                });
            }
            
        });    
    
    })(jQuery);

}

$('document').ready(function () {
    const BASE_URL = 'http://w2w.localhost';

    const actionsDiv = $("#actions");
    let showCatUpdate = false;

    /* ****************** GESTIONS CATEGORIES ****************** */

    const categoryActions = $("#categoryActions");
    categoryActions.on("click", viewCategories);

    function viewCategories() {
        closeModal();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/admin/category/category-list.php?context=ajax",
            dataType: "text",
            async: false
        }).done(function (html) {

            actionsDiv.html(html);

            $('#modal-delete-category').on("show.bs.modal", function (event) {
                let button = $(event.relatedTarget);
                let catId = button.data('catid');
                $(this).find(".modalCatId").val(catId);
            });

            const addCategoryBtn = $("#btnAddCat");
            addCategoryBtn.on("click", addCategory);

            const btnDelCat = $("#submitDelete");
            btnDelCat.on("click", deleteCategory);

            $(".fa-edit").on("click", updateCategory);


        }).fail(function () {
            console.log("view cat failed");
        })
    }

    function addCategory(e) {
        e.preventDefault();

        let formCat = new FormData($("#addCatForm")[0]);

        $.ajax({
            type: "POST",
            url: BASE_URL + '/admin/category/category-add.php?context=ajax',
            data: formCat,
            processData: false,
            contentType: false,
            async: false
        }).done(function (result) {
            console.log(result);
            viewCategories();
        }).fail(function () {
            console.log("merde");
        });
    }

    function updateCategory() {
        if (showCatUpdate) {
            hideCatUpdate();
        }

        let row = $(this).closest("tr");
        let catName = row.find(".cat_name>p").html();
        let catDesc = row.find(".cat_description>p").html();
        let catId = row.find(".cat_id>p").html();
        row.find('.fa-edit').css('color', 'grey');

        showCatUpdate = true;

        row.after(
            "<tr class='showUpdateForm'><td colspan='5'>" +
            "<form action='#' method='post' id='updateCategoryForm' class='d-flex justify-content-between form-inline'>" +

            "<input type='text' value='" + catId + "' disabled class='form-control' style='width: 50px'>" +
            "<input name='categoryName' value=\"" + catName + "\" class='form-control'/>" +

            "<input name='categoryDescription' value=\"" + catDesc + "\" class='form-control'/>" +
            "<input type='hidden' value='" + catId + "' name='catId' class='form-control'>" +

            "<input type='submit' value='Mettre à jour' id='submitCatUpdate' class='btn btn-primary'/>" +

            "<input type='button' value='Annuler' class='form-control cancelUpdate'>" +

            "</form>" +
            "</td></tr>"
        );

        $(".cancelUpdate").on("click", hideCatUpdate);
        $("#submitCatUpdate").on("click", handleCatUpdate);

    }

    function hideCatUpdate() {
        $(".fa-edit").removeAttr("style");
        $(".showUpdateForm").remove();
    }

    function handleCatUpdate(e) {
        e.preventDefault();

        let form = new FormData($("#updateCategoryForm")[0]);

        $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/category/category-edit.php?context=ajax",
            data: form,
            processData: false,
            contentType: false,
            async: false
        }).done(function (result) {
            console.log(result);
            viewCategories();
        }).fail(function (result) {
            console.log(failed);

        })
    }

    function deleteCategory(e) {
        e.preventDefault();

        let form = new FormData($("#deleteCategoryForm")[0]);
        $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/category/category-delete.php?context=ajax",
            dataType: 'text',
            data: form,
            processData: false,
            contentType: false,
            async: false
        }).done(function (result) {
            console.log(result);
            $(".modal-backdrop").remove();
            if ($.isNumeric(result)) {
                let warningModal =
                    "<div class=\"modal fade\" id=\"modal-delete-cat-dependency\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal-delete-cat-dependency\"\n" +
                    "     aria-hidden=\"true\">\n" +
                    "    <div class=\"modal-dialog\" role=\"document\">\n" +
                    "        <div class=\"modal-content\">\n" +
                    "            <div class=\"modal-header\">\n" +
                    "                <h5 class=\"modal-title\" id=\"modal-delete-cat-dependency-title\">Attention</h5>\n" +
                    "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" +
                    "                    <span aria-hidden=\"true\">&times;</span>\n" +
                    "                </button>\n" +
                    "            </div>\n" +
                    "            <div class=\"modal-body\" id=\"\">\n" +
                    "                <form action=\"category/category-delete.php?context=ajax\" method=\"post\" id=\"deleteCatDependencyForm\" enctype=\"multipart/form-data\">\n" +
                    "                    <div>\n" +
                    "                        <input type=\"hidden\" class=\"modalCatId\" name=\"id\" id=\"categoryId\" value=" + result + "/>\n" +
                    "                        <input type=\"hidden\" id=\"confirm\" name=\"confirm\" value=\"confirm\"/>\n" +
                    "                        <label for=\"submitDeleteAllMov\">Des films sont liés à cette catégorie, voulez-vous les supprimer, les classer comme hors catégorie ou annuler?</label>\n" +
                    "                        <input id=\"submitDeleteAllMov\" name=\"submitDeleteAllMov\" type=\"submit\" class=\"btn btn-primary\" value=\"Supprimer\"/>\n" +
                    "                        <input id=\"submitHorsCat\" name=\"submitHorsCat\" type=\"submit\" class=\"btn btn-primary\" value=\"Hors Catégorie\"/>\n" +
                    "                        <button class=\"btn btn-primary\" data-dismiss=\"modal\" aria-label=\"Close\"> Annuler</button>\n" +
                    "                    </div>\n" +
                    "                </form>\n" +
                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>\n" +
                    "</div>";

                $("#warning-modal").html(warningModal);
                $("#modal-delete-cat-dependency").modal('show');
                $("#submitDeleteAllMov").on("click", deleteCategoryDependency);
                $("#submitHorsCat").on("click", deleteCategoryDependency);
            } else {
                viewCategories();
            }

        }).fail(function (res) {
            console.log(res);
            console.log("delete failed");
        })
    }

    function deleteCategoryDependency(e) {
        console.log($(e.target).attr('id'));
        e.preventDefault();

        let formCat = new FormData($("#deleteCatDependencyForm")[0]);

        if ($(e.target).attr('id') === 'submitHorsCat') {
            formCat.append('submitHorsCat', 'submitHorsCat')
        }

        if ($(e.target).attr('id') === 'submitDeleteAllMov') {
            formCat.append('submitDeleteAllMov', 'submitDeleteAllMov')
        }


        $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/category/category-delete.php?context=ajax",
            dataType: 'text',
            data: formCat,
            processData: false,
            contentType: false,
            async: false
        }).done(function (result) {
            console.log(result);
            viewCategories();
        }).fail(function () {
            console.log("delete failed");
        })
    }

    /* ****************** END GESTIONS CATEGORIES ****************** */

    /* ****************** GESTION DES TAGS ****************** */


    const tagActions = $("#tagActions");
    tagActions.on("click", viewTags);


    function viewTags() {
        closeModal();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/admin/tag/tag-list.php?context=ajax",
            dataType: "text",
            async: false
        }).done(function (html) {
            actionsDiv.html(html);
            $('#modal-delete-tag').on("show.bs.modal", function (event) {
                let button = $(event.relatedTarget);
                let tagId = button.data('tagid');
                $(this).find(".modalTagId").val(tagId);
            });

        }).fail(function () {
            console.log("view cat failed");
        })
    }


    /* ****************** END GESTION DES TAGS ****************** */

    /* ****************** GESTION FILMS ****************** */

    const movieActions = $("#movieActions");
    movieActions.on("click", viewMovies);


    function viewMovies() {
        closeModal();
        $.ajax({
            type: "GET",
            url: "/admin/movie-list.php?context=ajax",
            dataType: "text",
            async: false
        }).done(function (html) {

            actionsDiv.html(html);

            $('#modal-delete-movie').on("show.bs.modal", function (event) {
                let button = $(event.relatedTarget);
                let movieId = button.data('movieid');
                $(this).find(".modalMovieId").val(movieId);
            });

            const btnDelMovie = $("#submitDeleteMovie");
            btnDelMovie.on("click", deleteMovie);

        }).fail(function () {
            console.log("view cat failed");
        })
    }

    function deleteMovie(e) {
        e.preventDefault();

        let formMovieDel = new FormData($("#deleteMovieForm")[0]);
        $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/movie-delete.php?context=ajax",
            data: formMovieDel,
            processData: false,
            contentType: false,
            async: false
        }).done(function (result) {
            viewMovies();
        }).fail(function () {
            console.log("delete failed");
        })
    }

    /* ****************** END GESTION FILMS ****************** */

    /* ****************** MODAL ****************** */
    function closeModal() {
        $(".modal-open").removeClass("modal-open");
        $(".modal-backdrop").remove();
    }

    /* ****************** END MODAL ****************** */


});

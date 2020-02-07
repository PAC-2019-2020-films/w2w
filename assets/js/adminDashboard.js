$('document').ready(function () {
    $.noConflict();
    const BASE_URL = 'http://w2w.localhost';

    const actionsDiv = $("#actions");


    /* ****************** GESTIONS CATEGORIES ****************** */

    const categoryActions = $("#categoryActions");
    categoryActions.on("click", viewCategories);


    function viewCategories() {
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

            const btnDelCat = $("#submitDelete");
            btnDelCat.on("click", deleteCategory);

        }).fail(function () {
            console.log("view cat failed");
        })
    }

    function deleteCategory(e) {
        e.preventDefault();
        console.log("delete");

        let form = new FormData($("#deleteCategoryForm")[0]);
        $.ajax({
            type: "POST",
            url: BASE_URL + "/admin/category/category-delete.php?context=ajax",
            data: form,
            processData: false,
            contentType: false,
            async: false
        }).done(function (result) {
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


});

const BASE_URL = "http://localhost/cadastro-produto/";

$('#btn-close').click(function() {
    $('.alert').hide("slow");
});

$('#search-form').on('submit', search);

function search(e) {
    e.preventDefault();

    var cod = $(this).find('input[name=input-search]').val();

    if (cod !== "") {
        $.ajax({
            url: BASE_URL + 'home/search',
            type: 'GET',
            data: {cod: cod},
            dataType: 'json',
            success: function(resp) {

                if ((resp.length !== 0) && (resp !== null)) {
                    searchForm(resp);
                } else {
                    alert("error");
                }
            }
        });
    }
}

function edit(obj) {
    var form_data = $(obj).closest('tr');

    var cod = form_data.find('th[data-cod]').data('cod');
    var name = form_data.find('td[data-name]').data('name');
    var price = form_data.find('td[data-price]').data('price');
    var units = form_data.find('td[data-units]').data('units');
    var id = form_data.find('td[data-id]').data('id');

    $('#edit-modal').find('.modal-body').find('input[name=input-name]').val(name);
    $('#edit-modal').find('.modal-body').find('input[name=input-cod]').val(cod);
    $('#edit-modal').find('.modal-body').find('input[name=input-price]').val(price);
    $('#edit-modal').find('.modal-body').find('input[name=input-units]').val(units);
    $('#edit-modal').find('.modal-body').find('input[name=id]').val(id);

    $('#edit-modal').find('.modal-body').find('form').on('submit', save);

    $('#edit-modal').modal('show');
}

function save(e) {
    e.preventDefault();

    var cod = $(this).find('input[name=input-cod]').val();
    var name = $(this).find('input[name=input-name]').val();
    var price = $(this).find('input[name=input-price]').val();
    var units = $(this).find('input[name=input-units]').val();
    var id = $(this).find('input[name=id]').val();

    $.ajax({
        url: BASE_URL + 'home/edit',
        type: 'POST',
        data: {cod: cod, name: name, price: price, units: units, id: id},
        success: function(resp) {

            var alert_class = 'success';
            var msg = "";

            if (resp === 'success') {
                msg = 'Produto atualizado com sucesso';
            } else {
                alert_class = 'info';
                msg = "Erro ao atualizar produto";
            }

            var rm_msg = "<div class='modal-body alert alert-" + alert_class + "'>" +
                    "<div class='container-fluid'>" +
                    "<div class='row'>" +
                    "<div class='col-12'>" +
                    "<h5>" + msg + "</5>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";

            $('#edit-modal').find('#edit-modal-content').html(rm_msg);
            $('#edit-modal').modal('show');
            $('#edit-modal').on('hide.bs.modal', function(event) {
                window.location.href = window.location.href;
            });

        }
    });
}

function remove(id) {
    var btn_yes = "<button class='btn btn-danger btn-lg btn-block' id = 'btn-rm-yes' onclick='remove_yes(" + id + ")'>Sim</button>";
    $('#remove-modal').find('#col-rm-yes').html(btn_yes);
    $('#remove-modal').modal('show');
}

function remove_yes(id) {
    $.ajax({
        url: BASE_URL + 'home/remove',
        type: 'POST',
        data: {id: id},
        success: function(resp) {
            var alert_class = 'success';
            var msg = "";

            if (resp === 'success') {
                msg = 'Produto removido com sucesso';
            } else {
                alert_class = 'info';
                msg = "Erro ao remover produto";
            }

            var rm_msg = "<div class='modal-body alert alert-" + alert_class + "'>" +
                    "<div class='container-fluid'>" +
                    "<div class='row'>" +
                    "<div class='col-12'>" +
                    "<h5>" + msg + "</5>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";

            $('#remove-modal').find('#remove-modal-content').html(rm_msg);
            $('#remove-modal').modal('show');
            $('#remove-modal').on('hide.bs.modal', function(event) {
                window.location.href = window.location.href;
            });
        }
    });
}

function searchForm(resp) {
    var importado = (parseInt(resp.importado) === 0) ? "Não" : "Sim";

    var form = "<div class='container pt-5' id='search-data'>" +
            "<div class='row'>" +
            "<div class='table-responsive justify-content-center'>" +
            "<table class='table table-striped'>" +
            "<thead class='thead-dark'>" +
            "<tr>" +
            "<th scope='col'>Código</th>" +
            "<th scope='col'>Nome</th>" +
            "<th scope='col'>Preço</th>" +
            "<th scope='col'>Unidades</th>" +
            "<th scope='col'>Importado</th>" +
            "<th scope='col'></th>" +
            "<th scope='col'></th>" +
            "</tr>" +
            "</thead>" +
            "<tbody>" +
            "<tr>" +
            "<th scope='row' data-cod='" + resp.codigo + "' >" + resp.codigo + "</th>" +
            "<td data-name='" + resp.nome + "' >" + resp.nome + "</td>" +
            "<td data-price='" + resp.preco + "' >" + resp.preco + "</td>" +
            "<td data-units='" + resp.unidades + "' >" + resp.unidades + "</td>" +
            "<td data-id='" + resp.id + "'>" + importado + "</td>" +
            "<td><a class='btn btn-outline-warning btn-block edit' href='javascript:' onclick='edit(this);' >Editar</a></td>" +
            "<td><a class='btn btn-outline-danger btn-block remove' href='javascript:' onclick='remove(" + resp.id + ");' >Remover</a></td>" +
            "</tr>" +
            "</tbody>" +
            "</table>" +
            "</div>" +
            "</div>" +
            "</div>";

    $('#search-modal').find('#search-modal-content').html(form);
    $('#search-modal').modal('show');

    $('#edit-modal').on('show.bs.modal', function(event) {
        $('#search-modal').modal('hide');
    });

}
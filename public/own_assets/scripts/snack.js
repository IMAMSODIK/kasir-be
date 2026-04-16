let modal = "", userDetail = "";

function closeModal(element) {
    element.modal("hide");
}

$("#filter").on("click", function () {
    let section = $("#filter-section");

    if (section.hasClass("d-none")) {
        section.removeClass("d-none").hide().slideDown(200);
    } else {
        section.slideUp(200, function () {
            section.addClass("d-none");
        });
    }
});


$("#cancel-edit").on("click", function () {
    closeModal($("#edit-data-modal"));
});

$("#cancel-add").on("click", function () {
    closeModal($("#tambah-data-modal"));
});

$(document).on("click", ".error-response", function () {
    closeModal($(`#${modal}`));
})

$("#tambah-data").on("click", function () {
    modal = "tambah-data-modal";
    $(`#${modal}`).modal("show");
});

$(document).on("click", ".detail-unit", function () {

    $('body').css('cursor', 'wait');
    let id = $(this).data('id');
    modal = "edit-data-modal";

    $.ajax({
        url: "/units/detail",
        method: "GET",
        data: { id: id },

        success: function (response) {

            $('body').css('cursor', 'default');

            if (response.status) {
                $("#id").val(response.data.id);
                $("#edit_name").val(response.data.name);
                $("#edit_type").val(response.data.type);
                $("#edit_price").val(response.data.price_per_hour);
                $(`#${modal}`).modal("show");

            } else {
                alert(response.message || "Terjadi kesalahan");
            }
        },

        error: function () {
            $('body').css('cursor', 'default');
            alert("Terjadi kesalahan server");
        }
    });
});

$(document).on("click", ".error-response", function () {
    $(`#${modal}`).modal("show");
});

function alertModal(status, message = null) {
    if (status) {
        $("#alert-image").attr(
            "src",
            "../../dashboard_assets/assets/images/gif/dashboard-8/successful.gif"
        );
        $("#alert-message").text("Success");
        $("#alert-message").text(message);
    } else {
        $("#alert-image").attr(
            "src",
            "../../dashboard_assets/assets/images/gif/danger.gif"
        );
        $("#alert-message").text("Gagal");
        $("#alert-message").html(message);
    }

    $("#alert").modal("show");
}

$("#store").on("click", function () {

    let button = $(this);
    $('body').css('cursor', 'wait');
    button.prop('disabled', true);

    $.ajax({
        url: "/snack/store",
        method: "POST",
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            name: $("#name").val(),
            price: $("#price").val(),
            stock: $("#stock").val(),
        },
        success: function (response) {

            $('body').css('cursor', 'default');
            button.prop('disabled', false);
            $("#tambah-data-modal").modal("hide");

            if (response.status) {
                alertModal(true, response.message);
                setTimeout(function(){
                    location.reload()
                }, 1500)
            } else {
                alertModal(false, message);
            }
        },
        error: function () {
            $('body').css('cursor', 'default');
            button.prop('disabled', false);
            alertModal(false, "Something went wrong");
        }
    });
});

$("#update").on("click", function () {
    let button = $(this);
    console.log("Modal", modal)

    $('body').css('cursor', 'wait');
    $(button).prop('disabled', true);

    $.ajax({
        url: "/units/update",
        method: "POST",
        data: {
            "_token": $("meta[name='csrf-token']").attr("content"),
            "id": $("#id").val(),
            "nama": $("#edit_name").val(),
            "type": $("#edit_type").val(),
            "price": $("#edit_price").val(),
        },
        success: function (response) {
            $(`#${modal}`).modal("hide");

            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            if (response.status) {
                alertModal(true, response.message);
                
                setTimeout(function(){
                    location.reload()
                }, 1500);

                $("#is-error").removeClass('error-response');
            } else {
                let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${response.message || "An error occurred."}</div>`;

                if (response.errors) {
                    const detailMessages = Object.values(response.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }

                $("#is-error").addClass('error-response');
                alertModal(false, message);
            }

        },
        error: function (xhr) {
            $(`#${modal}`).modal("hide");
            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">An error occurred.</div>`;

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${xhr.responseJSON.message}</div>`;
                }
                if (xhr.responseJSON.errors) {
                    const detailMessages = Object.values(xhr.responseJSON.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }
            }

            $("#is-error").addClass('error-response');
            alertModal(false, message);
        }
    });
})

$("#reset").on("click", function () {
    let formData = new FormData();
    let button = $(this);

    $('body').css('cursor', 'wait');
    $(button).prop('disabled', true);

    let file = $("#edit_foto")[0].files[0];
    if (file) {
        formData.append("foto", file);
    }
    formData.append("_token", $("meta[name='csrf-token']").attr("content"));
    formData.append("id", $("#id").val());

    $.ajax({
        url: "/students/reset-password",
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            $(`#${modal}`).modal("hide");

            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            if (response.status) {
                alertModal(true, response.message);

                $("#is-error").removeClass('error-response');
            } else {
                let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${response.message || "An error occurred."}</div>`;

                if (response.errors) {
                    const detailMessages = Object.values(response.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }

                $("#is-error").addClass('error-response');
                alertModal(false, message);
            }

        },
        error: function (xhr) {
            $(`#${modal}`).modal("hide");
            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">An error occurred.</div>`;

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${xhr.responseJSON.message}</div>`;
                }
                if (xhr.responseJSON.errors) {
                    const detailMessages = Object.values(xhr.responseJSON.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }
            }

            $("#is-error").addClass('error-response');
            alertModal(false, message);
        }
    });
})

$("#delete").on("click", function () {
    let formData = new FormData();
    let button = $(this);

    $('body').css('cursor', 'wait');
    $(button).prop('disabled', true);

    formData.append("_token", $("meta[name='csrf-token']").attr("content"));
    formData.append("id", $("#id").val());

    $.ajax({
        url: "/students/delete",
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            $(`#${modal}`).modal("hide");

            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            if (response.status) {
                alertModal(true, response.message);
                userDetail.attr("data-status", response.data.status);
                if (response.data.status == 1) {
                    userDetail.find(".ribbon")
                        .removeClass("ribbon-danger")
                        .addClass("ribbon-success")
                        .text("Active");
                } else {
                    userDetail.find(".ribbon")
                        .removeClass("ribbon-success")
                        .addClass("ribbon-danger")
                        .text("Nonactive");
                }

                $("#is-error").removeClass('error-response');
            } else {
                let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${response.message || "An error occurred."}</div>`;

                if (response.errors) {
                    const detailMessages = Object.values(response.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }

                $("#is-error").addClass('error-response');
                alertModal(false, message);
            }

        },
        error: function (xhr) {
            $(`#${modal}`).modal("hide");
            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">An error occurred.</div>`;

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${xhr.responseJSON.message}</div>`;
                }
                if (xhr.responseJSON.errors) {
                    const detailMessages = Object.values(xhr.responseJSON.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }
            }

            $("#is-error").addClass('error-response');
            alertModal(false, message);
        }
    });
})

$("#activate").on("click", function () {
    let formData = new FormData();
    let button = $(this);

    $('body').css('cursor', 'wait');
    $(button).prop('disabled', true);

    formData.append("_token", $("meta[name='csrf-token']").attr("content"));
    formData.append("id", $("#id").val());

    $.ajax({
        url: "/students/activate",
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            $(`#${modal}`).modal("hide");

            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            if (response.status) {
                alertModal(true, response.message);
                userDetail.attr("data-status", response.data.status);
                if (response.data.status == 1) {
                    userDetail.find(".ribbon")
                        .removeClass("ribbon-danger")
                        .addClass("ribbon-success")
                        .text("Active");
                } else {
                    userDetail.find(".ribbon")
                        .removeClass("ribbon-success")
                        .addClass("ribbon-danger")
                        .text("Nonactive");
                }

                $("#is-error").removeClass('error-response');
            } else {
                let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${response.message || "An error occurred."}</div>`;

                if (response.errors) {
                    const detailMessages = Object.values(response.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }

                $("#is-error").addClass('error-response');
                alertModal(false, message);
            }

        },
        error: function (xhr) {
            $(`#${modal}`).modal("hide");
            $('body').css('cursor', 'default');
            $(button).prop('disabled', false);

            let message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">An error occurred.</div>`;

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    message = `<div style="text-align: center; font-weight: bold; margin-bottom: 10px;">${xhr.responseJSON.message}</div>`;
                }
                if (xhr.responseJSON.errors) {
                    const detailMessages = Object.values(xhr.responseJSON.errors)
                        .map(msgs => msgs[0])
                        .join("<br>");
                    message += `<div style="text-align: center;">${detailMessages}</div>`;
                }
            }

            $("#is-error").addClass('error-response');
            alertModal(false, message);
        }
    });
})

$("#search").on('input', function () {
    let text = $(this).val();

    $.ajax({
        url: "/students/search",
        method: "GET",
        data: { q: text },
        success: function (response) {
            $(".data-ctr").empty();

            if (response.status) {
                response.data.forEach(function (user) {
                    let foto = (user.foto) ? `/storage/${user.foto}` : '/own_assets/images/avatar.png';
                    let statusRibbon = (user.status == 1) 
                        ? `<div class="ribbon ribbon-success">Active</div>`
                        : `<div class="ribbon ribbon-danger">Nonactive</div>`;

                    let row = `
                        <div class="col-6 col-xl-3 col-md-3 detail-user" style="cursor: pointer" data-id="${user.id}">
                            <div class="card">
                                <div class="product-box">
                                    <div class="product-img">
                                        <img class="img-fluid" src="${foto}" alt="Profile Picture">
                                        ${statusRibbon}
                                    </div>
                                    <div class="product-details">
                                        <span class="badge rounded-pill badge-primary text-white mb-2">Student</span>
                                        <h5>${user.name}</h5>
                                        <p>${user.email}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $(".data-ctr").append(row);
                });
            } else {
                $(".data-ctr").html(`
                    <div class="col-12 text-center">
                        <p style="font-weight:bold; color:#999;">${response.message}</p>
                    </div>
                `);
            }
        },
        error: function () {
            $(".data-ctr").html(`
                <div class="col-12 text-center">
                    <p style="font-weight:bold; color:red;">An error occurred while searching.</p>
                </div>
            `);
        }
    });
});

$("#apply-filter").on("click", function () {
    let status = $("#filter-status").val().trim();

    $(".detail-user").each(function () {
        let userStatus = $(this).attr("data-status");

        if (status === "" || userStatus == status) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

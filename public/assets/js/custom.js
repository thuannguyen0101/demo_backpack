const Helper = {
    /* Get record info */
    add: function (id,type) {
        const addButton = event.currentTarget;
        const row = addButton.parentElement.parentElement.children;
        $("#addId").val(id);
        $("#addName").val(row[1].textContent.trim());
        $("#addPriority").val(row[2].textContent.trim().toLowerCase());
        $("#addIos").val(row[3].textContent.trim());
        $("#addAndroid").val(row[4].textContent.trim());
        $("#addWeb").val(row[5].textContent.trim());
        $("#addMemo").val(row[9].textContent.trim());
        $("#type").val(type);
    },
    /* Add record into project */
    addSave: function (type) {
        var url = "";
        let button = event.target;
        if (type === "systems") {
            url = '/admin/api/project/systems/';
        }
        if (type === "requirements") {
            url = '/admin/api/project/systems/requirements/';
        }
        if (type === "subFunctions") {
            url = '/admin/api/project/systems/requirements/subfunctions/';
        }
        button.disabled = true;
        $.ajax({
            data: {
                "parent_id": $('#addParent').val(),
                "name": $('#addName').val(),
                "priority": $('#addPriority').val(),
                "ios_cost": $('#addIos').val(),
                "android_cost": $('#addAndroid').val(),
                "web_cost": $('#addWeb').val(),
                "memo": $('#addMemo').val(),
                "type": $('#type').val(),
                "_token": csrf,
            },
            url: url + $("#addId").val(),
            type: 'POST',
            success: function (result) {
                location.reload();
            },
            error: function (xhr, status, error) {
                let errors = eval("(" + xhr.responseText + ")").errors;
                $.map(errors, function (value, index) {
                    messageAlert(value, 'error');
                    setTimeout(function () {
                        button.disabled = false;
                    }, 3000);
                });
            }
        });
    },
    /* Delete record from project */
    delete: function (type, id) {
        var url = "";
        if (type === "systems") {
            url = '/admin/systems/'
        }
        if (type === "requirements") {
            url = '/admin/requirements/'
        }
        if (type === "subFunctions") {
            url = '/admin/subfunctions/'
        }
        swal({
            title: "Warning",
            text: "Are you sure you want to delete this item?",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "bg-secondary",
                    closeModal: true,
                },
                delete: {
                    text: "Delete",
                    value: true,
                    visible: true,
                    className: "bg-danger",
                }
            },
        }).then((value) => {
            if (value) {
                $.ajax({
                    data: {
                        "_token": csrf,
                    },
                    url: url + id,
                    type: 'DELETE',
                    success: function () {
                        location.reload();
                    }
                });
            }
        })
    }
}

/* Get system info  into modal */
function editSystems(id) {
    data.map(function (value, index) {
        if (value.id == id) {
            $("#editId").val(value.id);
            $("#editName").val(value.name);
            $("#editPriority").val(value.priority);
            $("#editIos").val(value.ios_cost);
            $("#editAndroid").val(value.android_cost);
            $("#editWeb").val(value.web_cost);
            $("#editMemo").val(value.memo);
            if ($("#editType").val(value.project_id) != null) {
                type = "systems";
            }
        }
    });
}

/* Get requirement info  into modal */
function editRequirement(id) {
    data.forEach(function (element) {
        var requirementData = element.requirements
        requirementData.map(function (value, index) {
            if (value.id == id) {
                $("#editId").val(value.id);
                $("#editName").val(value.name);
                $("#editPriority").val(value.priority);
                $("#editIos").val(value.ios_cost);
                $("#editAndroid").val(value.android_cost);
                $("#editWeb").val(value.web_cost);
                $("#editMemo").val(value.memo);
                if ($("#editType").val(value.system_id) != null) {
                    type = "requirements";
                }
            }
        });
    })
}

/* Get subFunction info  into modal */
function editSubFunction(id) {
    data.forEach(function (element) {
        var requirement = element.requirements
        requirement.forEach(function (item) {
            var subFunctionData = item.sub_functions
            subFunctionData.map(function (value, index) {
                if (value.id == id) {
                    $("#editId").val(value.id);
                    $("#editName").val(value.name);
                    $("#editPriority").val(value.priority);
                    $("#editIos").val(value.ios_cost);
                    $("#editAndroid").val(value.android_cost);
                    $("#editWeb").val(value.web_cost);
                    $("#editMemo").val(value.memo);
                    if ($("#editType").val(value.requirement_id) != null) {
                        type = "subFunctions";
                    }
                }
            });
        })
    })
}

/* Saving edit */
$("#editSave").click(function () {
    var url = "";
    let button = event.target;
    if (type === "systems") {
        url = '/admin/api/project/system/';
    }
    if (type === "requirements") {
        url = '/admin/api/project/requirement/';
    }
    if (type === "subFunctions") {
        url = '/admin/api/project/subFunction/';
    }
    button.disabled = true;
    $.ajax({
        data: {
            "name": $('#editName').val(),
            "priority": $('#editPriority').val(),
            "ios_cost": $('#editIos').val(),
            "android_cost": $('#editAndroid').val(),
            "web_cost": $('#editWeb').val(),
            "memo": $('#editMemo').val(),
            "_token": csrf,
        },
        url: url + $("#editId").val(),
        type: 'PUT',
        success: function () {
            location.reload();
        },
        error: function (xhr, status, error) {
            let errors = eval("(" + xhr.responseText + ")").errors;
            $.map(errors, function (value, index) {
                messageAlert(value, 'error');
                setTimeout(function () {
                    button.disabled = false;
                }, 3000);
            });
        }
    });
});

/* get requirement according to system */
var options = $('#addParent').find('option');
$('#addSystem').on('change', function () {
    $('#addParent').html(options.filter('[name="' + this.value + '"]'));
}).trigger('change')

/* Notification alert */
function messageAlert(message, type, layout = 'topRight') {
    new Noty({
        type: type,
        layout: layout,
        text: message
    }).show();
}
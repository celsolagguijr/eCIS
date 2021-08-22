function SendRequest(datas) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: datas.url,
      type: datas.method,
      dataType: datas.dataType,
      data: datas.data,
      cache: true,
      beforeSend: function () {
        $("#additional-forms").append(loadingModal);
        $("#Loading").modal("show");
      },
      complete: function () {
        setTimeout(function () {
          $("#Loading").modal("toggle");
        }, 500);
      },
      success: function (data) {
        setTimeout(function () {
          resolve(data);
        }, 1000);
      },
      error: function (data) {
        reject(data);
      },
    });
  });
}

function loadingModal(message) {
  message = message == "" || null ? "Please wait" : message;

  return (
    '<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="Loading">' +
    '<div class="modal-dialog modal-dialog-centered modal-sm">' +
    '<div class="modal-content">' +
    '<div class="m-2 text-center">' +
    '<img src="/eCIS/imgs/ajax-loader.gif" style="width:50px;height:50px">' +
    "</div>" +
    '<div class="m-2 text-center">' +
    "<h5>" +
    message +
    "</h5>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>"
  );
}

function formMessage(result, message) {
  return result === "success"
    ? "<div class='alert alert-success alert-dismissible'>" +
        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" +
        message +
        "</div>"
    : "<div class='alert alert-danger alert-dismissible'>" +
        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" +
        message +
        "</div>";
}

function toast(result, msg) {
  switch (result) {
    case "success":
      toastr.success(msg);
      break;

    case "info":
      toastr.info(msg);
      break;

    case "error":
      toastr.error(msg);
      break;
  }
}

function onPageLoad() {
  var apiData = {
    url: "/eCIS/controllers/PageController.php",
    method: "GET",
    data: {
      pageName: "default",
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#nabar_contents").html(generateNavigation(data.navigations.result));
      $("#content").html(data.content);
      $("#username_").text(data.user);
      $("#listOfRecords").DataTable({
        bDestroy: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
}

function generateNavigation(navs) {
  var nav = "";
  navs.forEach(function (datas) {
    nav +=
      "<li class='nav-item active'>" +
      "<a class='nav-link btnURL' href='#' class='btn btn-success'  pageName='" +
      datas.name +
      "' type='" +
      datas.type +
      "'><span class='" +
      datas.icon +
      "'></span> " +
      datas.pageName +
      "</a>" +
      "</li>";
  });
  return nav;
}

$(document).on("click", ".btnURL", function (e) {
  e.preventDefault();
  var apiData;
  switch ($(this).attr("type")) {
    case "Page":
      apiData = {
        url: "/eCIS/controllers/PageController.php",
        method: "GET",
        data: {
          pageName: $(this).attr("pageName"),
        },
        dataType: "json",
      };

      SendRequest(apiData)
        .then(function (data) {
          $("#nabar_contents").html(
            generateNavigation(data.navigations.result),
          );
          $("#content").html(data.content);
          $("#username_").text(data.user);
          $("#listOfRecords").DataTable({ bDestroy: true });
          getUsers();
        })
        .catch(function (error) {
          console.log(error);
        });
      break;

    case "Form":
      apiData = {
        url: "/eCIS/controllers/FormController.php",
        method: "GET",
        data: {
          form: $(this).attr("pageName"),
        },
        dataType: "json",
      };

      SendRequest(apiData)
        .then(function (data) {
          $("#additional-forms").append(data.result.form);
          $("#" + data.result.id).modal({
            show: true,
          });
        })
        .catch(function (error) {
          console.log(error);
        });

      break;

    case "Logout":
      apiData = {
        url: "/eCIS/controllers/PageController.php",
        method: "GET",
        data: {
          pageName: $(this).attr("pageName"),
        },
        dataType: "json",
      };

      SendRequest(apiData)
        .then(function (data) {
          toast("success", "Successfully Logout");
          onPageLoad();
        })
        .catch(function (error) {
          console.log(error);
        });

      break;
  }
});

$(document).on("submit", "#loginFormSubmit", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        $("#LoginForm").modal("toggle");
        toast(data.status, data.result);
        onPageLoad();
      } else {
        $(".formMessage").append(formMessage("data.status", data.result));
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#confirmationLogin", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        $("#additional-forms").append(data.form);
        $("#" + data.id).modal({
          show: true,
        });
        $("#confirmLogin").modal("toggle");
      } else {
        toast("error", data.result);
        $("#confirmLogin").modal("toggle");
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

var modals =
  "#backupForm,#LoginForm,#viewInformation,#Loading,#addRecord,#confirmLogin,#editRecordForm,#deleteForm,#addUserForm,#editUserForm,#resetPasswordForm,#changeStatus,#UserPrivileges,#addAppointmentForm,#editAppointmentForm,#deleteAppointmentForm,#addRequestForm";

$(document).on("hidden.bs.modal", modals, function () {
  $(this).remove();
});

$(document).on("click", ".btnView ", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("id"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.result.form);
      $("#firstname").val(data.result.data[0].FIRSTNAME);
      $("#lastname").val(data.result.data[0].LASTNAME);
      $("#middlename").val(data.result.data[0].MIDDLENAME);
      $("#contactNo").val(data.result.data[0].CONTACT_NO);
      $("#agency").val(data.result.data[0].AGENCY);
      $("#gsisIDNo").val(data.result.data[0].gsisid);
      $("#bpNo").val(data.result.data[0].bpNo);
      $("#bank").val(data.result.data[0].BANK);
      $("#cardType").val(data.result.data[0].ECARD_TYPE);
      $("#memberType").val(data.result.data[0].MEMBERTYPE);
      $("#cardStatus").val(data.result.data[0].ECARD_STATUS);
      $("#dateReceived").val(data.result.data[0].DATE_RECIEVED);
      $("#releasedTo").val(data.result.data[0].RELEASED_TO);
      $("#designation").val(data.result.data[0].DESIGNATION);
      $("#dateReleased").val(data.result.data[0].DATE_RELEASED);
      $("#releasedBy").val(data.result.data[0].RELEASED_BY);
      $("#remarks").val(data.result.data[0].CARD_REMARKS);
      $("#" + data.result.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#searcRecordForm", function (e) {
  e.preventDefault();

  var data = "";

  if (this.searchBy.value === "Name") {
    data = {
      userAction: "getRecords",
      searchBy: this.searchBy.value,
      lastName: this.lastName.value,
      firstName: this.firstName.value,
    };
  } else if (this.searchBy.value === "BpNo") {
    data = {
      userAction: "getRecords",
      searchBy: this.searchBy.value,
      BpNo: this.BpNo.value,
    };
  } else if (this.searchBy.value == "agency") {
    if (this.agency.value.length < 3) return;

    data = {
      userAction: "getRecords",
      searchBy: this.searchBy.value,
      agency: this.agency.value,
    };
  } else {
    data = {
      userAction: "getRecords",
      searchBy: this.searchBy.value,
      gsisIdNo: this.gsisIdNo.value,
    };
  }

  var searchDatas = {
    url: this.action,
    method: this.method,
    data: data,
    dataType: "json",
  };

  loadTable(searchDatas);
});

$(document).on("submit", "#searchECardsForReleaseForm", function (e) {
  e.preventDefault();
  $.ajax({
    url: this.action,
    method: this.method,
    dataType: "json",
    data: $(this).serialize(),
    beforeSend: function () {
      $(".searchDatas").html(
        '<div class="m-2 text-center">' +
          '<img src="/eCIS/imgs/ajax-loader.gif" style="width:50px;height:50px">' +
          "</div>" +
          '<div class="m-2 text-center">' +
          "<h5>Please wait</h5>" +
          "</div>",
      );
    },
    success: function (data) {
      setTimeout(function () {
        if (data.total_Page <= 0) {
          $(".searchDatas").html("<h5>No Record Found</h5>");
          $(".pagination_Content").html("");
        } else {
          var content = "";
          data.page.forEach(function (rec) {
            content += listOfRecords(rec);
          });
          $(".searchDatas").html(content);
          $(".pagination_Content").html(pagination(data.total_Page));
        }
      }, 500);
    },
    error: function (data) {
      console.log(data);
    },
  });
});

$(document).on("click", ".btnSelect", function () {
  var searchDatas = {
    url: "/eCIS/controllers/TransactionsController.php",
    method: "POST",
    data: {
      userAction: "selectRecord",
      id: $(this).attr("recID"),
    },
    dataType: "json",
  };

  var datas = document.forms[1].elements["recordID[]"];

  if (datas == undefined) {
    SendRequest(searchDatas)
      .then(function (data) {
        $(".selectedDatas").append(addList(data[0]));
      })
      .catch(function (error) {
        console.log(error);
      });
  } else {
    SendRequest(searchDatas)
      .then(function (dataSearch) {
        var isExist = false;

        $(".recordsid").each(function (data) {
          var idrec = $(this).val();
          if (idrec == dataSearch[0].id) {
            isExist = true;
            return false;
          }
        });

        if (isExist == true) {
          toast("failed", "The record is already on the list.");
        } else {
          $(".selectedDatas").append(addList(dataSearch[0]));
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }
});

$(document).on("click", ".paginateBtn", function () {
  $.ajax({
    url: "/eCIS/controllers/TransactionsController.php",
    method: "POST",
    dataType: "json",
    data: {
      userAction: "paginatePage",
      pageNo: $(this).attr("pageNo"),
      searchBy: $("#searchBy").val(),
      searchText: $("#searchText").val(),
    },
    beforeSend: function () {
      $(".searchDatas").html(
        '<div class="m-2 text-center">' +
          '<img src="/eCIS/imgs/ajax-loader.gif" style="width:50px;height:50px">' +
          "</div>" +
          '<div class="m-2 text-center">' +
          "<h5>Please wait</h5>" +
          "</div>",
      );
    },
    success: function (data) {
      setTimeout(function () {
        var content = "";
        data.forEach(function (rec) {
          content += listOfRecords(rec);
        });
        $(".searchDatas").html(content);
      }, 500);
    },
    error: function (data) {
      console.log(data);
    },
  });
});

$(document).on("submit", "#ecardReleaseForm", function (e) {
  e.preventDefault();
  var datas = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(datas)
    .then(function (data) {
      if (data.status === "success") {
        toast("success", "eCards successfully released");
        $("#searchBy").val("lastname");
        $("#searchText").val("");
        $(".searchDatas").html("<h5>** Search **</h5>");
        $(".pagination_Content").html("");
        $("#dateReleased").val("");
        $("#remarks").val("");
        $("#designation").val("");
        $(".selectedDatas").html("<h5>** **</h5>");
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".btnSearchClear", function () {
  $("#searchBy").val("");
  $("#searchText").val("");
  $(".searchDatas").html("<h5>** Search **</h5>");
  $(".pagination_Content").html("");
});

$(document).on("click", ".btnClearListofEcard", function () {
  $("#dateReleased").val("");
  $("#remarks").val("");
  $("#designation").val("");
  $(".selectedDatas").html("<h5>** **</h5>");
});

$(document).on("click", ".btnRemove", function () {
  $(".list" + $(this).attr("recID")).remove();
});

function listOfRecords(data) {
  return (
    '<li class="list-group-item">' +
    '<div class="row justify-content-between">' +
    "<div>" +
    '<p class="m-0 p-0 text-primary" style="font-size:1rem;font-weight:bolder;">' +
    data.fullname +
    "</p>" +
    '<p class="m-0 p-0" style="font-size:0.8rem;">' +
    data.gsisIDNO +
    " | " +
    data.MEMBERTYPE +
    " | " +
    data.ECARDTYPE +
    "</p>" +
    '<p class="m-0 p-0" style="font-size:0.8rem;">' +
    data.agency +
    "</p>" +
    "</div>" +
    "<div>" +
    '<button class="btn btn-warning btn-sm float-right btnSelect" recID="' +
    data.id +
    '">Select <span class="fa fa-check"></span></button>' +
    "</div>" +
    "</div>" +
    "</li>"
  );
}

function addList(data) {
  return (
    '<li class="list-group-item list' +
    data.id +
    '">' +
    '<input type="hidden" name="recordID[]" value="' +
    data.id +
    '" class="recordsid">' +
    '<div class="row justify-content-between">' +
    "<div>" +
    '<p class="m-0 p-0 text-primary" style="font-size:1rem;font-weight:bolder;">' +
    data.fullname +
    "</p>" +
    '<p class="m-0 p-0" style="font-size:0.8rem;">' +
    data.gsisIDNO +
    " | " +
    data.MEMBERTYPE +
    " | " +
    data.ECARDTYPE +
    "</p>" +
    '<p class="m-0 p-0" style="font-size:0.8rem;">' +
    data.agency +
    "</p>" +
    "</div>" +
    '<div">' +
    '<button class="btn btn-light text-danger btn-sm float-right btnRemove" recID="' +
    data.id +
    '"><span class="fa fa-times"></span></button>' +
    "</div>" +
    "</div>" +
    "</li>"
  );
}

function pagination(noOFPage) {
  var paginationContent =
    '<li class="page-item disabled"><a class="page-link"><< </a> </li> ';
  for (var i = 1; i <= noOFPage; i++) {
    paginationContent +=
      '<li class="page-item"><a class="page-link paginateBtn" href="#" pageNo="' +
      i +
      '">' +
      i +
      "</a></li>";
  }
  paginationContent +=
    ' <li class="page-item disabled"><a class="page-link"> >></a></li>';
  return paginationContent;
}

$(document).on("click", ".btnClear", function () {
  var table = $("#listOfRecords").DataTable();
  table.clear().draw();
});

$(document).on("click", ".btnEdit", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("id"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.result.form);
      $("#" + data.result.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".btnDelete", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("id"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      //if null the user is not login into the system
      if (data.status === "success" || data.status == null) {
        $("#additional-forms").append(data.form);
        $("#" + data.id).modal({
          show: true,
        });
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("change", "#releaseToggle", function () {
  if (this.checked) {
    $.ajax({
      url: "/eCIS/controllers/FormController.php",
      method: "GET",
      data: {
        form: "getReleasedForm",
      },
      dataType: "json",
      beforeSend: function () {
        $(".releaseInput").html(
          '<div class="m-2 text-center">' +
            '<img src="/eCIS/imgs/ajax-loader.gif" style="width:50px;height:50px">' +
            "</div>" +
            '<div class="m-2 text-center">' +
            "<h5>Please wait</h5>" +
            "</div>",
        );
      },
      success: function (data) {
        setTimeout(function () {
          $(".releaseInput").html(data.form);
        }, 500);
      },
      error: function (error) {
        console.log(error);
      },
    });
  } else {
    $(".releaseInput").html("");
  }
});

$(document).on("submit", "#saveEditRecord", function (e) {
  e.preventDefault();
  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        $("#editRecordForm").modal("toggle");

        //load table
        var form = document.getElementById("searcRecordForm");

        var data = "";
        if (this.searchBy.value === "Name") {
          data = {
            userAction: "getRecords",
            searchBy: form.searchBy.value,
            lastName: form.lastName.value,
            firstName: form.firstName.value,
          };
        } else if (this.searchBy.value === "BpNo") {
          data = {
            userAction: "getRecords",
            searchBy: form.searchBy.value,
            BpNo: form.BpNo.value,
          };
        } else {
          data = {
            userAction: "getRecords",
            searchBy: form.searchBy.value,
            gsisIdNo: form.gsisIdNo.value,
          };
        }

        var searchDatas = {
          url: form.action,
          method: form.method,
          data: data,
          dataType: "json",
        };

        loadTable(searchDatas);
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#deleteFormSubmit", function (e) {
  e.preventDefault();
  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        $("#deleteForm").modal("toggle");

        var form = document.getElementById("searcRecordForm");

        var data = "";
        if (this.searchBy.value === "Name") {
          data = {
            userAction: "getRecords",
            searchBy: form.searchBy.value,
            lastName: form.lastName.value,
            firstName: form.firstName.value,
          };
        } else if (this.searchBy.value === "BpNo") {
          data = {
            userAction: "getRecords",
            searchBy: form.searchBy.value,
            BpNo: form.BpNo.value,
          };
        } else {
          data = {
            userAction: "getRecords",
            searchBy: form.searchBy.value,
            gsisIdNo: form.gsisIdNo.value,
          };
        }

        var searchDatas = {
          url: form.action,
          method: form.method,
          data: data,
          dataType: "json",
        };

        loadTable(searchDatas);
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#csvRecordsForm", function (e) {
  e.preventDefault();

  var recordStatus = this.recordStatus.value;
  $.ajax({
    url: this.action,
    method: this.method,
    dataType: "json",
    data: new FormData(this),
    beforeSend: function () {
      $("#additional-forms").append(loadingModal("Processing..."));
      $("#Loading").modal("show");
    },
    complete: function () {
      setTimeout(function () {
        $("#Loading").modal("toggle");
      }, 500);
    },
    success: function (data) {
      setTimeout(function () {
        if (data.status === "success") {
          $("#csvRecordsForm")[0].reset();
          toast("success", "Done.");
          $(".noSuccess").text(data.result.success.length);
          $(".noError").text(data.result.error.length);

          var successBody,
            errorBody = "";

          for (var i = 0; i < data.result.success.length; i++) {
            if (recordStatus === "newRecord") {
              successBody += newRecordFormat(data.result.success[i]);
            } else {
              successBody += oldRecordFormat(data.result.success[i]);
            }
          }

          $("#successBody").html(successBody);

          for (var i = 0; i < data.result.error.length; i++) {
            if (recordStatus === "newRecord") {
              errorBody += newRecordFormat(data.result.error[i]);
            } else {
              errorBody += oldRecordFormat(data.result.error[i]);
            }
          }

          $("#errorBody").html(errorBody);
        } else {
          toast("error", data.result);
        }
      }, 1000);
    },
    error: function (data) {
      console.log(data);
    },
    cache: false,
    contentType: false,
    processData: false,
  });
});

function newRecordFormat(data) {
  return (
    "<tr>" +
    "<td>" +
    data[0] +
    "</td>" +
    "<td>" +
    data[1] +
    "</td>" +
    "<td>" +
    data[2] +
    "</td>" +
    "<td>" +
    data[3] +
    "</td>" +
    "<td>" +
    data[4] +
    "</td>" +
    "<td>" +
    data[5] +
    "</td>" +
    "<td>" +
    data[6] +
    "</td>" +
    "<td>" +
    data[7] +
    "</td>" +
    "<td>" +
    data[8] +
    "</td>" +
    "<td></td>" +
    "<td></td>" +
    "<td></td>" +
    "<td></td>" +
    "<td></td>" +
    "<td></td>" +
    "<td></td>" +
    "<td></td>" +
    "</tr>"
  );
}

function oldRecordFormat(data) {
  return (
    "<tr>" +
    "<td>" +
    data[0] +
    "</td>" +
    "<td>" +
    data[1] +
    "</td>" +
    "<td>" +
    data[2] +
    "</td>" +
    "<td>" +
    data[3] +
    "</td>" +
    "<td>" +
    data[4] +
    "</td>" +
    "<td>" +
    data[5] +
    "</td>" +
    "<td>" +
    data[6] +
    "</td>" +
    "<td>" +
    data[7] +
    "</td>" +
    "<td>" +
    data[8] +
    "</td>" +
    "<td>" +
    data[9] +
    "</td>" +
    "<td>" +
    data[10] +
    "</td>" +
    "<td>" +
    data[11] +
    "</td>" +
    "<td>" +
    data[12] +
    "</td>" +
    "<td>" +
    data[13] +
    "</td>" +
    "<td>" +
    data[14] +
    "</td>" +
    "<td>" +
    data[15] +
    "</td>" +
    "<td>" +
    data[16] +
    "</td>" +
    "</tr>"
  );
}

$(document).on("submit", "#saveNewRecord", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        $("#saveNewRecord")[0].reset();
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".addUserForm", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.form);
      $("#" + data.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".editUserForm", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("recid"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.form);
      $("#" + data.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("change", "#designation", function () {
  if (this.value == 1) {
    var designation =
      $("#firstname").val() +
      " " +
      $("#middlename").val() +
      " " +
      $("#lastname").val();
    $("#designationPerson").val(designation);
    $("#designationPerson").attr("readonly", true);
  } else {
    $("#designationPerson").val("");
    $("#designationPerson").attr("readonly", false);
  }
});

$(document).on("click", ".resetPassword", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("recid"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.form);
      $("#" + data.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".changeStatus", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("recid"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.form);
      $("#" + data.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".UserPrivileges", function () {
  apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.form);
      $("#" + data.id).modal({
        show: true,
      });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("change", ".btnUserPrivilegesChangeStatus", function () {
  var apiData = {
    url: "/eCIS/controllers/TransactionsController.php",
    method: "POST",
    data: {
      userAction: "changeUserPriviges",
      recordId: $(this).attr("recordId"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#saveNewUser", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        getUsers();
        $("#saveNewUser")[0].reset();
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#saveEditUser", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        getUsers();
        $("#editUserForm").modal("toggle");
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#changeStatusFormSubmit", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        getUsers();
        $("#changeStatus").modal("toggle");
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#resetPasswordFormSubmit", function (e) {
  e.preventDefault();

  if (confirm("Are you sure you want to reset the password?")) {
    var apiData = {
      url: this.action,
      method: this.method,
      data: $(this).serialize(),
      dataType: "json",
    };

    SendRequest(apiData)
      .then(function (data) {
        if (data.status === "success") {
          toast(data.status, data.result);
          getUsers();
          $("#resetPasswordForm").modal("toggle");
        } else {
          toast("error", data.result);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }
});

$(document).on("submit", "#changePasswordForm", function (e) {
  e.preventDefault();

  if (confirm("Are you sure you want to change your password?")) {
    var apiData = {
      url: this.action,
      method: this.method,
      data: $(this).serialize(),
      dataType: "json",
    };

    SendRequest(apiData)
      .then(function (data) {
        if (data.status === "success") {
          $("#changePasswordForm")[0].reset();
          toast(data.status, data.result);
        } else {
          toast("error", data.result);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }
});
function getRepository() {
  console.log("https://github.com/celsolagguijr/eCIS");
}
function programmer() {
  console.log(pName);
  $("#footer").text(pName);
}

$(document).on("click", ".btnAppointment", function () {
  var apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("id"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.result.status === "success") {
        $("#additional-forms").append(data.result.form);
        $("#" + data.result.id).modal({ show: true });
      } else {
        toast("info", data.result.message);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

function loadTable(searchData) {
  $("#listOfRecords").DataTable({
    processing: true,
    serverSide: false,
    deferRender: true,
    bDestroy: true,
    ajax: {
      url: searchData.url,
      method: searchData.method,
      dataType: searchData.dataType,
      data: searchData.data,
    },
    columns: [
      {
        data: function (data) {
          var view =
            "<button type='button' class='btn btn-sm btn-light btnView shadow-sm' id='" +
            data.RECORD_ID +
            "' pageName='viewInformation'> <span class='fa fa-eye text-dark'></span </button>";
          var edit =
            "<button type='button' class='btn btn-sm btn-light btnEdit shadow-sm' id='" +
            data.RECORD_ID +
            "' pageName='editRecord'> <span class='fa fa-edit text-success'></span </button>";
          var trash =
            "<button type='button' class='btn btn-sm btn-light btnDelete shadow-sm' id='" +
            data.RECORD_ID +
            "' pageName='deleteRecord'> <span class='fa fa-trash text-danger'></span </button>";
          var appointment =
            "<button type='button' class='btn btn-sm btn-light btnAppointment shadow-sm' id='" +
            data.RECORD_ID +
            "' pageName='addAppointmentForm'> <span class='fa fa-calendar-check  text-primary'></span </button>";
          return (
            '<div class="btn-group btn-group-sm d-flex" role="group">' +
            view +
            appointment +
            edit +
            trash +
            "</div>"
          );
        },
      },
      {
        data: "ECARD_TYPE",
        name: "ECARD_TYPE",
      },
      {
        data: function (data) {
          return data.ECARD_STATUS === "Pending"
            ? "<div class='badge badge-primary' style='font-size:.8rem;'>" +
                data.ECARD_STATUS +
                ""
            : "<div class='badge badge-success' style='font-size:.8rem;'>" +
                data.ECARD_STATUS +
                "";
        },
        name: "ECARD_STATUS",
      },
      {
        data: "BANK",
        name: "BANK",
      },
      {
        data: function (data) {
          return data.DATE_RELEASED === null ? "" : data.DATE_RELEASED;
        },
        name: "DATE_RELEASED",
      },
      {
        data: "gsisid",
        name: "gsisid",
      },
      {
        data: "LASTNAME",
        name: "LASTNAME",
      },
      {
        data: "FISTNAME",
        name: "FISTNAME",
      },
      {
        data: "MIDDLENAME",
        name: "MIDDLENAME",
      },
      {
        data: "AGENCY",
        name: "AGENCY",
      },
      {
        data: "MEMBERTYPE",
        name: "MEMBERTYPE",
      },
      {
        data: "CARD_REMARKS",
        name: "CARD_REMARKS",
      },
    ],
  });
}

function getUsers() {
  $("#listOfUser").DataTable({
    processing: true,
    serverSide: false,
    deferRender: true,
    bDestroy: true,
    autowidth: false,
    ajax: {
      url: "/eCIS/controllers/TransactionsController.php",
      method: "POST",
      dataType: "json",
      data: {
        userAction: "getUsers",
      },
    },
    columns: [
      {
        data: function (data) {
          var edit =
            "<button type='button' class='btn btn-sm btn-light  shadow-sm editUserForm' recid='" +
            data.id +
            "' pageName='editUser'> <span class='fa fa-edit text-success'></span </button>";
          var lock =
            "<button type='button' class='btn btn-sm btn-light  shadow-sm resetPassword' recid='" +
            data.id +
            "' pageName='resetPassword'> <span class='fa fa-key text-warning'></span </button>";
          var icon =
            data.UserStatus == 0
              ? "<span class='fa fa-unlock text-primary'></span>"
              : "<span class='fa fa-lock text-darker'></span>";
          var status =
            "<button type='button' class='btn btn-sm btn-light  shadow-sm changeStatus' recid='" +
            data.id +
            "' pageName='changeStatus' >" +
            icon +
            "</button>";

          return (
            '<div class="btn-group btn-group-sm d-flex" role="group">' +
            edit +
            lock +
            status +
            "</div>"
          );
        },
      },
      {
        data: "FULLNAME",
        name: "FULLNAME",
      },
      {
        data: "USERNAME",
        name: "USERNAME",
      },
      {
        data: "USERTYPE",
        name: "USERTYPE",
      },
      {
        data: function (data) {
          return data.UserStatus == 1
            ? "<div class='badge badge-primary' style='font-size:1rem'>Active</div>"
            : "<div class='badge badge-danger' style='font-size:1rem'>Locked</div>";
        },
        name: "USERTYPE",
      },
    ],
  });
}

$(document).on("change", "#searchBy", function () {
  if (this.value == "Name") {
    $("#lastName").attr("hidden", false);
    $("#firstName").attr("hidden", false);
    $("#lastName").removeAttr("disabled");
    $("#firstName").removeAttr("disabled");

    $("#BpNo").attr("hidden", true);
    $("#BpNo").attr("disabled", "disabled");

    $("#gsisIdNo").attr("hidden", true);
    $("#gsisIdNo").attr("disabled", "disabled");

    $("#agency").attr("hidden", true);
    $("#agency").attr("disabled", "disabled");
  } else if (this.value == "BpNo") {
    $("#lastName").attr("hidden", true);
    $("#firstName").attr("hidden", true);
    $("#lastName").attr("disabled", "disabled");
    $("#firstName").attr("disabled", "disabled");

    $("#BpNo").attr("hidden", false);
    $("#BpNo").removeAttr("disabled");

    $("#gsisIdNo").attr("hidden", true);
    $("#gsisIdNo").attr("disabled", "disabled");

    $("#agency").attr("hidden", true);
    $("#agency").attr("disabled", "disabled");
  } else if (this.value == "agency") {
    $("#lastName").attr("hidden", true);
    $("#firstName").attr("hidden", true);
    $("#lastName").attr("disabled", "disabled");
    $("#firstName").attr("disabled", "disabled");

    $("#BpNo").attr("hidden", true);
    $("#BpNo").attr("disabled", "disabled");

    $("#gsisIdNo").attr("hidden", true);
    $("#gsisIdNo").attr("disabled", "disabled");

    $("#agency").attr("hidden", false);
    $("#agency").removeAttr("disabled");
  } else {
    $("#lastName").attr("hidden", true);
    $("#firstName").attr("hidden", true);
    $("#lastName").attr("disabled", "disabled");
    $("#firstName").attr("disabled", "disabled");

    $("#BpNo").attr("hidden", true);
    $("#BpNo").attr("disabled", "disabled");

    $("#gsisIdNo").attr("hidden", true);
    $("#gsisIdNo").removeAttr("disabled");

    $("#agency").attr("hidden", true);
    $("#agency").attr("disabled", "disabled");
  }

  $("#lastName").val("");
  $("#firstName").val("");
  $("#BpNo").val("");
  $("#gsisIdNo").val("");
  $("#agency").val("");
});

$(document).on("click", ".downloadBtn", function () {
  window.open(
    "/eCIS/views/pages/downloadFile.php?requestFile=" + $(this).attr("request"),
    "_blank",
  );
});

$(document).on("click", ".btnReportRequest", function () {
  window.open(
    "/eCIS/views/reports/?requestReport=" + $(this).attr("requestReport"),
    "_blank",
  );
});

$(document).on("submit", "#confirmBackupForm", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: "POST",
    data: { userAction: "backupDatabase" },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      var result = "";

      for (var i = 0; i < data.result.length; i++) {
        console.log(data.result[i]);
        result += "<li>" + data.result[i] + "</li>";
      }

      $(".formMessage").html(
        "<p> Filename : " +
          data.fileName +
          '</p><p style="color:red;">Note: Please see check if the database is saved to following directories below :</p> <ul>' +
          result +
          "</ul>",
      );
      $(".modal-footer").html("");
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("change", "#designationBatchRelease", function () {
  if (this.value == 1) {
    $("#receiver").attr("disabled", "disabled");
  } else {
    $("#receiver").removeAttr("disabled");
  }
});

$(document).on("submit", "#saveAppointment", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        $("#addAppointmentForm").modal("toggle");
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".btnAppointmentTab", function () {
  var date = new Date();
  var dateNow =
    date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate();
  getAppointments(dateNow, dateNow);
  document.querySelector("#searchAppointmentByDate").from.value = "";
  document.querySelector("#searchAppointmentByDate").to.value = "";
});

$(document).on("submit", "#searchAppointmentByDate", function (e) {
  e.preventDefault();

  getAppointments(this.from.value, this.to.value);
});

function getAppointments(from, to) {
  $("#listOfAppointments").DataTable({
    processing: true,
    serverSide: false,
    deferRender: true,
    bDestroy: true,
    autowidth: false,
    ajax: {
      url: "/eCIS/controllers/TransactionsController.php",
      method: "POST",
      dataType: "json",
      data: {
        userAction: "appoinments",
        from: from,
        to: to,
      },
    },
    columns: [
      {
        data: function (data) {
          var edit =
            "<button type='button' class='btn btn-sm btn-light editAppointment shadow-sm ' recid='" +
            data.id +
            "' pageName='editAppointment'> <span class='fa fa-edit text-success'></span </button>";
          var del =
            "<button type='button' class='btn btn-sm btn-light deleteAppointment shadow-sm ' recid='" +
            data.id +
            "' pageName='deleteAppointment'> <span class='fa fa-trash text-danger'></span </button>";
          return (
            '<div class="btn-group btn-group-sm d-flex" role="group">' +
            edit +
            del +
            "</div>"
          );
        },
      },
      {
        data: "BPNO",
        name: "BPNO",
      },
      {
        data: "GSISID",
        name: "GSISID",
      },
      {
        data: "FULLNAME",
        name: "FULLNAME",
      },
      {
        data: "AGENCY",
        name: "AGENCY",
      },
      {
        data: "MEMBERSTAT",
        name: "MEMBERSTAT",
      },
      {
        data: "BANK",
        name: "BANK",
      },
      {
        data: "ECARDTYPE",
        name: "ECARDTYPE",
      },
      {
        data: "APPOINTMENTDATE",
        name: "APPOINTMENTDATE",
      },
      {
        data: "APPOINTEDBY",
        name: "APPOINTEDBY",
      },
      {
        data: "DATECREATED",
        name: "DATECREATED",
      },
    ],
  });
}

$(document).on("click", ".editAppointment", function () {
  var apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("recid"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.result.status === "success") {
        $("#additional-forms").append(data.result.form);
        $("#" + data.result.id).modal({ show: true });
      } else {
        toast("danger", data.result.message);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#saveEditAppointment", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        $("#editAppointmentForm").modal("toggle");

        getAppointments(
          document.querySelector("#searchAppointmentByDate").from.value,
          document.querySelector("#searchAppointmentByDate").to.value,
        );
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".deleteAppointment", function () {
  var apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
      id: $(this).attr("recid"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.result.status === "success") {
        $("#additional-forms").append(data.result.form);
        $("#" + data.result.id).modal({ show: true });
      } else {
        toast("danger", data.result.message);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#deleteAppointment", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        $("#deleteAppointmentForm").modal("toggle");
        getAppointments(
          document.querySelector("#searchAppointmentByDate").from.value,
          document.querySelector("#searchAppointmentByDate").to.value,
        );
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".btnRequest", function () {
  var apiData = {
    url: "/eCIS/controllers/FormController.php",
    method: "GET",
    data: {
      form: $(this).attr("pageName"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#additional-forms").append(data.form);
      $("#" + data.id).modal({ show: true });
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("submit", "#saveRequest", function (e) {
  e.preventDefault();

  var apiData = {
    url: this.action,
    method: this.method,
    data: $(this).serialize(),
    dataType: "json",
  };

  var requestedBy =
    this.requestedBy.options[this.requestedBy.selectedIndex].text;
  var remarks = this.remarks.value;

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        notif({ requestedBy: requestedBy, remarks: remarks });
        $("#addRequestForm").modal("toggle");
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

function loadRequest() {
  if (document.querySelector(".table-request")) {
    $.ajax({
      url: "/eCIS/views/pages/requestPage.php",
      method: "GET",
      success: function (data) {
        document.querySelector(".table-request").innerHTML = data;
      },
    });
  }

  if (document.querySelector(".table-guest-request")) {
    $.ajax({
      url: "/eCIS/views/pages/guestRequestPage.php",
      method: "GET",
      success: function (data) {
        document.querySelector(".table-guest-request").innerHTML = data;
      },
    });
  }

  if (document.querySelector(".btnShowRequest")) {
    $.ajax({
      url: "/eCIS/controllers/TransactionsController.php",
      method: "POST",
      dataType: "json",
      data: {
        userAction: "countRequest",
      },
      success: function (data) {
        document.querySelector("#noOfRequest").innerHTML = data;
      },
    });
  }

  return;
}

$(document).on("click", ".btnRequestTab", function () {
  loadRequest();
});

$(document).on("click", ".btnDone", function () {
  var apiData = {
    url: "/eCIS/controllers/TransactionsController.php",
    method: "POST",
    data: {
      userAction: $(this).attr("userAction"),
      recid: $(this).attr("recid"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      if (data.status === "success") {
        toast(data.status, data.result);
        loadRequest();
      } else {
        toast("error", data.result);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).on("click", ".btnShowRequest", function () {
  apiData = {
    url: "/eCIS/controllers/PageController.php",
    method: "GET",
    data: {
      pageName: $(this).attr("pageName"),
    },
    dataType: "json",
  };

  SendRequest(apiData)
    .then(function (data) {
      $("#nabar_contents").html(generateNavigation(data.navigations.result));
      $("#content").html(data.content);
      $("#username_").text(data.user);
      $("#listOfRecords").DataTable({ bDestroy: true });
      setTimeout(function () {
        loadRequest();
      }, 500);
    })
    .catch(function (error) {
      console.log(error);
    });
});

$(document).ready(function () {
  toastr.options.positionClass = "toast-bottom-right";
  toastr.options.progressBar = true;
  toastr.options.timeOut = 20000;
  toastr.options.closeButton = true;

  //   setInterval(function () {
  //     if (
  //       document.querySelector(".table-request") ||
  //       document.querySelector(".table-guest-request") ||
  //       document.querySelector(".btnShowRequest")
  //     ) {
  //       loadRequest();
  //     }
  //   }, 5000);

  onPageLoad();
});

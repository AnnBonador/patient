$(document).ready(function () {
  var table1 = $("#onlinetbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table1.php",
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option"},
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Confirmed") {
            return '<span class="badge badge-success">Confirmed</span>';
          } else if (data == "Pending") {
            return '<span class="badge badge-warning">Pending</span>';
          } else if (data == "Treated") {
            return '<span class="badge badge-primary">Treated</span>';
          } else if (data == "Reschedule") {
            return '<span class="badge badge-secondary">Reschedule</span>';
          } else {
            return '<span class="badge badge-danger">Cancelled</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  $("#onlinetbl tfoot th.search").each(function () {
    var title = $(this).text();
    $(this).html(
      '<input type="text" placeholder="Search ' +
        title +
        '" class="search-input form-control form-control-sm"/>'
    );
  });
});

$(document).ready(function () {
  var table2 = $("#pendingtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Pending",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Pending") {
            return '<span class="badge badge-warning">Pending</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });

  var table3 = $("#oconfirmedtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Confirmed",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Confirmed") {
            return '<span class="badge badge-success">Confirmed</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  var table4 = $("#otreatedtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Treated",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Treated") {
            return '<span class="badge badge-primary">Treated</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  var table5 = $("#ocancelledtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Cancelled",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Cancelled") {
            return '<span class="badge badge-danger">Cancelled</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  var table6 = $("#orescheduletbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Reschedule",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Reschedule") {
            return '<span class="badge badge-secondary">Reschedule</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });

  $(".nav-tabs a").on("shown.bs.tab", function (event) {
    var tabID = $(event.target).attr("data-target");
    if (tabID === "#all") {
      table1.columns.adjust().responsive.recalc();
    }
    if (tabID === "#pending") {
      table2.columns.adjust().responsive.recalc();
    }
    if (tabID === "#confirmed") {
      table3.columns.adjust().responsive.recalc();
    }
    if (tabID === "#treated") {
      table4.columns.adjust().responsive.recalc();
    }
    if (tabID === "#cancelled") {
      table5.columns.adjust().responsive.recalc();
    }
    if (tabID === "#reschedule") {
      table6.columns.adjust().responsive.recalc();
    }
  });

  initializeSelect2(".patient", "Select Patient");
	initializeSelect2(".dentist", "Select Dentist");
	initializeSelect2(".treatment", "Select Treatment");
	initializeSelect2("#edit_reason", "Select Service");
  initializeCalendarDate("#scheddateEdit");

  initializeCalendarDate("#scheddateEdit");

  handleTimeSlotClick(".edit-time-slot", "#selected-time-slotEdit", "slot");

  validateFormSubmission("#edit-appointment", "#selected-time-slotEdit");

	$("#preferredDentistEdit").change(function () {
		const selectedDoctorId = $(this).val();

		$("#scheddateEdit").val("");
    $("#selected-time-slotEdit").val("");
		$("#time-slotsEdit").empty();
		$("#scheddateEdit").off("changeDate");
		$("#scheddateEdit").datepicker("destroy").datepicker({
			autoclose: true,
			startDate: new Date(),
		});

		if (selectedDoctorId) {
			$.ajax({
				url: "online_action.php",
				type: "GET",
				data: {
					dentist: true,
					doctor_id: selectedDoctorId,
				},
				dataType: "json",
				success: function (doctor) {
					// Check if there is an error in the response
					if (doctor.error) {
						// Display a custom error message
						const errorMessage =
							"Sorry, the schedule for the selected doctor is not available. Please choose another doctor or try again later.";
						$("#time-slotsEdit").html(`<div class="col-12 text-danger">${errorMessage}</div>`);
						return; // Exit the function to prevent further execution
					}

					const availableDays = doctor.available_days;
					const disabledDays = [0, 1, 2, 3, 4, 5, 6].filter(
						(day) => !availableDays.includes(["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][day])
					);

					$("#scheddateEdit").datepicker("setDaysOfWeekDisabled", disabledDays);

					$("#scheddateEdit").on("changeDate", function (e) {
						const selectedDate = e.format();

						$.ajax({
							url: "online_action.php",
							type: "GET",
							data: {
								timeslots: true,
								doctor_id: selectedDoctorId,
								date: selectedDate,
							},
							dataType: "json",
							success: function (response) {
								// Check if available_time_slots is an empty array
								if (response.available_time_slots && response.available_time_slots.length > 0) {
									let slotsHtml = '<div class="col-12"><h5>Available Time Slots:</h5></div>';
									response.available_time_slots.forEach((slot) => {
										slotsHtml += ` <button type="button" class="col-md-2 btn btn-outline-primary edit-time-slot" data-slot="${slot}">${slot}</button>`;
									});
									$("#time-slotsEdit").html(slotsHtml);
								} else {
									// Display the custom message for no available time slots
									const noSlotsMessage =
										"Sorry, the time slot for the selected doctor is not available. Please choose another doctor or try again later.";
									$("#time-slotsEdit").html(`<div class="col-12 text-danger">${noSlotsMessage}</div>`);
								}
							},
							error: function (error) {
								console.log("Error fetching time slots:", error);
							},
						});
					});
				},
				error: function (error) {
					console.log("Error fetching doctor schedule:", error);
				},
			});
		}
	});

  const colorBox = document.getElementById("edit_color");

  colorBox.addEventListener(
    "change",
    (event) => {
      const color = event.target.value;
      event.target.style.color = color;
    },
    false
  );

  $("#edit_status").on("change", function () {
    var val = $(this).val();
    if (this.value == "Confirmed") {
      $(".ck").prop("disabled", false);
    } else {
      $(".ck").prop("disabled", true);
      $("#customCheckbox3").prop("checked", false);
    }
  });

  $(document).on("click", ".viewbtn", function () {
    var userid = $(this).data("id");
    $.ajax({
      type: "GET",
      url: "online_action.php",
      data: {
        health_dec: true,
        user_id: userid,
      },
      success: function (response) {
        console.log(response);
        $(".view_form").html(response);
        $("#ViewModal").modal("show");
      },
    });
  });

  $(document).on("click", ".editbtn", function () {
    var schedid = $(this).data("id");

    $.ajax({
      type: "post",
      url: "online_action.php",
      data: {
        checking_editbtn: true,
        app_id: schedid,
      },
      success: function (response) {
        $("#edit_id").val(response["id"]);
        $("#edit_patient_id").val(response["patient_id"]);
        $("#edit_patient").val(response["patient_id"]).trigger("change");
        $("#preferredDentistEdit").val(response["doc_id"]).trigger("change");
        $("#scheddateEdit").val(response["schedule"]); 
        $("#selected-time-slotEdit").val(response["starttime"]);
        loadAvailableTimeSlotsForEdit(response["doc_id"], response["schedule"]);
        var services = response["reason"].split(",");
        $("#edit_reason").val(services).trigger("change");
        $("#edit_status").val(response["status"]);
        $("#edit_color").val(response["bgcolor"]);
        $("#editFollowUp").val(response["follow_up"]);

        $("#editFollowUp").prop("checked", response["follow_up"] == 1);

        $("#EditOnlineAppModal").modal("show");
      },
    });
  });

  $(document).on("click", ".deletebtn", function () {
    var user_id = $(this).data("id");
    $("#delete_id").val(user_id);
    $("#deletemodal").modal("show");
  });

  $("#edit_status").on("change", function () {
    var treated = $(this).val();
    var schedDate = $("#edit_schedule").val();
    var appDate = Date.parse(schedDate);
    var todayDate = new Date().getTime();
    if (treated == "Treated") {
      if (todayDate < appDate) {
        if (
          confirm(
            "The appointment date is not today, are you sure you want to set it to Treated?"
          )
        ) {
        } else {
          this.selectedIndex = 0;
        }
      }
      return false;
    }
  });
});

function loadAvailableTimeSlotsForEdit(doctorId, selectedDate) {
  $.ajax({
    url: "online_action.php", // Endpoint to fetch available time slots
    type: "GET",
    data: {
      timeslots: true,
      doctor_id: doctorId,
      date: selectedDate,
    },
    dataType: "json",
    success: function (response) {
      if (response.available_time_slots && response.available_time_slots.length > 0) {
        let slotsHtml = '<div class="col-12"><h5>Available Time Slots:</h5></div>';
        response.available_time_slots.forEach(function (slot) {
          slotsHtml += `<button type="button" class="col-md-2 btn btn-outline-primary edit-time-slot" data-slot="${slot}">${slot}</button>`;
        });
        $("#time-slotsEdit").html(slotsHtml);
      } else {
        const noSlotsMessage = "Sorry, no available time slots for the selected doctor. Please try again later.";
        $("#time-slotsEdit").html(`<div class="col-12 text-danger">${noSlotsMessage}</div>`);
      }
    },
    error: function (error) {
      console.log("Error fetching time slots:", error);
    },
  });
}
let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
const API_KEY = $("#API_KEY").val();
$(document).ready(function() {
  refreshAntrian();
  $("#next").on("click", function() {
    let layananId = $("#list-antrian")
      .find(":selected")
      .val();
    Swal.fire({
      title: `Lanjut antrian?`,
      text: "Tidak dapat kembali ke antrian sebelumnya",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, lanjut!",
      cancelButtonText: "Tidak"
    }).then(result => {
      if (result.value) {
        nextAntrian(layananId);
      }
    });
  });
  $("#skip").on("click", function() {
    let layananId = $("#list-antrian")
      .find(":selected")
      .val();
    Swal.fire({
      title: `Lewati antrian?`,
      text: "Tidak dapat kembali ke antrian sebelumnya",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, lewati!",
      cancelButtonText: "Tidak"
    }).then(result => {
      if (result.value) {
        skipAntrian(layananId);
      }
    });
  });
  $("#keluar").on("click", function() {
    Swal.fire({
      title: `Keluar loket`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, keluar!",
      cancelButtonText: "Tidak"
    }).then(result => {
      if (result.value) {
        window.location.href = `${baseUrl}petugas/loket/keluar`;
      }
    });
  });

  Echo.channel("queueUpdated").listen("QueueUpdated", e => {
    if (e.message == "New queue. Please update yours") {
      refreshAntrian();
    }
  });
});

function nextAntrian(layananId) {
  $.ajax({
    url: `${baseUrl}api/v1/queue/petugas/next/${layananId}`,
    type: "POST",
    data: {
      nomor_loket : $("#nomor-loket").val(),
      id_petugas: $("#petugas-id").val()
    },
    beforeSend: () => {
      Swal.fire({
        title: "Proses",
        text: "Harap tunggu",
        showConfirmButton: false,
        allowOutsideClick: false
      });
    },
    success: async (res, status, xhr) => {
      if (xhr.status == 200) {
        if (res.message == "Queue for this service is empty") {
          Swal.fire({
            icon: "error",
            title: "Maaf",
            text: "Antrian untuk layanan ini kosong"
          });
        } else {
          $("#current-antrian").html(res.message.nomor_antrian);
          $("#current-antrian-id").val(res.message.id);
          Swal.close();
        }
      }
      refreshAntrian();
    },
    error: async res => {
      console.log(res.responseText);
    }
  });
}

function skipAntrian(layananId) {
  $.ajax({
    url: `${baseUrl}api/v1/queue/petugas/skip/${layananId}`,
    type: "POST",
    data: {
      nomor_loket : $("#nomor-loket").val(),
      id_petugas: $("#petugas-id").val(),
      id_antrian: $("#current-antrian-id").val()
    },
    beforeSend: () => {
      Swal.fire({
        title: "Proses",
        text: "Harap tunggu",
        showConfirmButton: false,
        allowOutsideClick: false
      });
    },
    success: async (res, status, xhr) => {
      if (xhr.status == 200) {
        if (res.message == "Queue for this service is empty") {
          Swal.fire({
            icon: "error",
            title: "Maaf",
            text: "Antrian untuk layanan ini kosong"
          });
        } else {
          $("#current-antrian").html(res.message.nomor_antrian);
          $("#current-antrian-id").val(res.message.id);
          Swal.close();
        }
      }
      refreshAntrian();
    },
    error: async res => {
      console.log(res.responseText);
    }
  });
}

function refreshAntrian() {
  $.ajax({
    url: `${baseUrl}api/v1/queue/petugas`,
    type: "GET",
    beforeSend: () => {
      $("#loader").show();
    },
    success: async (res, status, xhr) => {
      let petugasId = $("#petugas-id").val();
      $("#list-antrian").html("");
      $("#current-antrian").html("-")
      let service = await $.ajax(`${baseUrl}api/v1/service`);
      let currentAntrian = await $.ajax(
        `${baseUrl}api/v1/queue/petugas/${petugasId}`
      );
      if(currentAntrian.message.length > 0){
        $("#current-antrian").html(currentAntrian.message[0].nomor_antrian)
      }
      for (let i = 0; i < service.message.length; i++) {
        for (let j = 0; j < res.message.length; j++) {
          if (res.message[j].id_layanan == service.message[i].id) {
            service.message[i].jumlah++;
          }
        }
      }
      console.log(service.message);
      service.message.forEach(e => {
        if (e.jumlah == 0) {
          $("#list-antrian").append(
            `<option value="${e.id}">${e.nama_layanan} (ANTRIAN KOSONG)</option>`
          );
        } else {
          $("#list-antrian").append(
            `<option value="${e.id}">${e.nama_layanan} (${e.jumlah})</option>`
          );
        }
      });
      $("#current-antrian").html() == "-"
        ? $("#recall-btn").prop("disabled", true)
        : $("#recall-btn").prop("disabled", false);

      $("#loader").hide();
    },
    error: async res => {
      console.log(res.responseText);
    }
  });
}

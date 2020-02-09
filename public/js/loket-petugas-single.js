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
  // Pusher.logToConsole = true;

  // window.Echo = new Echo({
  //   broadcaster: "pusher",
  //   key: "37ebe4c45a5eb5f08639",
  //   cluster: "ap1",
  //   encrypted: true,
  //   logToConsole: true
  // });

  Echo.channel("queueUpdated").listen("QueueUpdated", e => {
    if(e.message == "New queue. Please update yours"){
      refreshAntrian();
    }
  });
});

function nextAntrian(layananId) {
  $.ajax({
    url: `${baseUrl}api/v1/queue/petugas/next/${layananId}`,
    type: "POST",
    data: {
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
    success: async (res, status, xhr) => {
      console.log(res);
      $("#list-antrian").html("");
      if (res.message == "Queue is empty") {
        $("#recall-btn").prop("disabled", true);
        $("#list-antrian").append(
          `<option disabled selected>ANTRIAN KOSONG</option>`
        );
      } else {
        $("#recall-btn").prop("disabled", false);
        $("#list-antrian").html("");
        res.message.forEach(e => {
          $("#list-antrian").append(
            `<option value="${e.id_layanan}">${e.nama_layanan} (${e.jumlah})</option>`
          );
        });
      }
    },
    error: async res => {
      console.log(res.responseText);
    }
  });
}

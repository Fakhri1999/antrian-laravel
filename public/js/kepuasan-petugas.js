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
  getCurrentQueue();
  $(".tombol").on("click", function() {
    let kepuasan = $(this).data("kepuasan");
    updateKepuasan(kepuasan);
  });
  let nomorLoket = $("#nomor_loket").val();
  console.log(nomorLoket);
  Echo.channel(`loket.${nomorLoket}`).listen("LoketQueueUpdated", e => {
    console.log(e.loket)
    if (e.loket.message == "New queue. Please update yours") {
      getCurrentQueue();
    }
  });
});

function getCurrentQueue() {
  let petugasId = $("#petugas_id").val();
  $.ajax({
    url: `${baseUrl}api/v1/queue/petugas/${petugasId}`,
    type: "GET",
    beforeSend: () => {
      $("#loader").show();
    },
    success: async (res, status, xhr) => {
      console.log(res.message);
      if (xhr.status == 200 && res.message.length > 0) {
        $(".rowKepuasan").show();
        $("#nomorAntrian").html(res.message[0].nomor_antrian);
        $("#antrian_id").val(res.message[0].id);
      } else {
        $(".rowKepuasan").hide();
      }
      $("#loader").hide();
    }
  });
}

function updateKepuasan(kepuasan) {
  let antrianId = $("#antrian_id").val();
  $.ajax({
    url: `${baseUrl}api/v1/queue/kepuasan`,
    type: "POST",
    data: {
      auth: API_KEY,
      kepuasan,
      antrianId
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
      console.log(res);
      if (xhr.status == 200) {
        Swal.fire({
          icon: "success",
          title: "Sukses",
          text: "Status kepuasan berhasil disimpan",
          timer: 10000,
          timerProgressBar: true
        });
      }
      getCurrentQueue();
    },
    error: async res => {
      console.log(res.responseText);
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Error saat menyimpan status kepuasan!"
      });
    }
  });
}

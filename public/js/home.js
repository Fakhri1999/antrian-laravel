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
  $(".add-queue").on("click", function() {
    let urutan_layanan = $(this).data("urutan_layanan");
    let id_layanan = $(this).data("id_layanan");
    let day = getCurrentDay();
    $.ajax({
      url: `${baseUrl}api/v1/queue`,
      type: "POST",
      data: {
        urutan_layanan,
        id_layanan,
        auth: API_KEY
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
        if (xhr.status == 201) {
          console.table(res.data);
          let antrian = res.data;
          $("#antrian").html(antrian.nomor_antrian);
          $("#tanggal").html(day);
          $("#jam").html(antrian.jam_pembuatan);
          $(".print").printThis({
            importStyle: true
          });
          // $.post(`${baseUrl}api/v1/queue/print`, {id: res.data.id, auth: API_KEY}, success)
          Swal.fire({
            icon: "success",
            title: "Sukses",
            text: "Antrian berhasil ditambahkan",
            timer: 1000,
            timerProgressBar: true
          });
        }
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Kode autentikasi salah!"
        });
      }
    });
  });
});

function getCurrentDay() {
  let today = new Date();
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
  };
  return today.toLocaleDateString("id-ID", options);
}

// function getCurrentTime() {
//   let today = new Date();
//   let hour = today.getHours();
//   let minute = today.getMinutes();
//   let second = today.getSeconds();
//   hour = checkTime(hour);
//   minute = checkTime(minute);
//   second = checkTime(second);
//   return `${hour}:${minute}:${second}`;
// }

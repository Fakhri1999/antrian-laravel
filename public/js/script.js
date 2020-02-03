let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
$(document).ready(function() {
  $(".add-queue").on("click", function() {
    let type = $(this).data("type");
    $.ajax({
      url: `${baseUrl}api/v1/queue`,
      type: "POST",
      data: {
        type,
        auth: "inikodenya"
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
          Swal.fire({
            icon: "success",
            title: "Sukses",
            text: "Antrian berhasil ditambahkan",
            timer: 1000
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

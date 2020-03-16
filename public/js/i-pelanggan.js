let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
$(document).ready(function () {
  $(".add-queue").on("click", function () {
    let urutan_layanan = $(this).data("urutan_layanan");
    let id_layanan = $(this).data("id_layanan");
    let id_pelanggan = $('#id_pelanggan').val();
    let password_pelanggan = $('#password_pelanggan').val();
    $.ajax({
      url: `${baseUrl}api/antrian/pelanggan`,
      type: "POST",
      data: {
        id: id_pelanggan,
        password: password_pelanggan,
        urutan_layanan,
        id_layanan
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
            text: res.message
          });
        }
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: res.responseJSON.message
        });
      }
    });
  });
});

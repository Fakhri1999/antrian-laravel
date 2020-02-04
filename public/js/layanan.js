let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
const API_KEY = $("#API_KEY").val();
let dataLayanan;
$(document).ready(function() {
  refreshLayanan();
  $("#submitTambahLayanan").on("click", function() {
    let username = $("#layananUseranameAdd").val();
    let name = $("#layananNamaAdd").val();
    let pin = $("#layananPinAdd").val();
    $.ajax({
      url: `${baseUrl}api/v1/service`,
      type: "POST",
      data: {
        username,
        name,
        pin,
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
        console.log(res);
        if (xhr.status == 201) {
          Swal.fire({
            icon: "success",
            title: "Sukses",
            text: "Layanan berhasil ditambahkan"
          });
        }
        $("#addServiceModal").modal("hide");
        $("#layananUseranameAdd").val("");
        $("#layananNamaAdd").val("");
        $("#layananPinAdd").val("");
        refreshLayanan();
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Username telah digunakan!"
        });
      }
    });
  });
  $("#isiTableLayanan").on("click", ".editLayanan", function() {
    let nomer = $(this).data("nomer");
    $("#layananIdEdit").val(dataLayanan[nomer].id);
    $("#layananUseranameEdit").val(dataLayanan[nomer].username);
    $("#layananNamaEdit").val(dataLayanan[nomer].nama);
    $("#layananPinEdit").val(dataLayanan[nomer].pin);
    $("#editServiceModal").modal("show");
  });
  $("#submitEditLayanan").on("click", function() {
    let username = $("#layananUseranameEdit").val();
    let name = $("#layananNamaEdit").val();
    let pin = $("#layananPinEdit").val();
    let id = $("#layananIdEdit").val();
    $.ajax({
      url: `${baseUrl}api/v1/service`,
      type: "PUT",
      data: {
        id,
        username,
        name,
        pin,
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
        if (xhr.status == 200) {
          Swal.fire({
            icon: "success",
            title: "Sukses",
            text: "Layanan berhasil diedit"
          });
        }
        $("#editServiceModal").modal("hide");
        refreshLayanan();
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Username telah digunakan!"
        });
      }
    });
  });
  $("#isiTableLayanan").on("click", ".hapusLayanan", function() {
    let nomer = $(this).data("nomer");
    Swal.fire({
      title: `Hapus Layanan ${dataLayanan[nomer].nama}?`,
      text: "Layanan yang sudah dihapus tidak dapat dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!"
    }).then(result => {
      if (result.value) {
        $.ajax({
          url: `${baseUrl}api/v1/service`,
          type: "DELETE",
          data: {
            id: dataLayanan[nomer].id,
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
            if (xhr.status == 204) {
              Swal.fire({
                icon: "success",
                title: "Sukses",
                text: "Layanan berhasil dihapus"
              });
            }
            refreshLayanan();
          },
          error: async res => {
            console.log(res);
            Swal.fire({
              icon: "error",
              title: "ERROR",
              text: "Terjadi error. Harap menghubungi pihak IT"
            });
          }
        });
      }
    });
  });
});

function refreshLayanan() {
  $.ajax({
    url: `${baseUrl}api/v1/service`,
    type: "GET",
    success: (res, status, xhr) => {
      if (xhr.status == 200) {
        let render = "";
        let count = 1;
        dataLayanan = res.message;
        $("#isiTableLayanan").html("");
        res.message.forEach(e => {
          render += `<tr><td>${count}</td><td>${e.username}</td><td>${e.nama}</td><td>${e.pin}</td>`;
          render +=
            e.status == 0
              ? `<td>Belum Login</td>`
              : `<td>Loket ${e.status}</td>`;
          render += `<td>
          <button type="button" class="btn btn-primary mb-1 editLayanan" style="width: 100%" data-nomer="${count -
            1}">Ubah</button>
          <button type="button" class="btn btn-danger hapusLayanan" style="width: 100%;" data-nomer="${count -
            1}">Hapus</button></td></tr>`;
          count++;
        });
        $("#isiTableLayanan").html(render);
      }
    }
  });
}

let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
const API_KEY = $("#API_KEY").val();
let dataPetugas;
$(document).ready(function() {
  refreshPetugas();
  $("#submitTambahPetugas").on("click", function() {
    let username = $("#petugasUseranameAdd").val();
    let name = $("#petugasNamaAdd").val();
    let pin = $("#petugasPinAdd").val();
    $.ajax({
      url: `${baseUrl}api/v1/employee`,
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
            text: "Petugas berhasil ditambahkan"
          });
        }
        $("#addEmployeeModal").modal("hide");
        $("#petugasUseranameAdd").val("");
        $("#petugasNamaAdd").val("");
        $("#petugasPinAdd").val("");
        refreshPetugas();
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
  $("#isiTablePetugas").on("click", ".editPetugas", function() {
    let nomer = $(this).data("nomer");
    $("#petugasIdEdit").val(dataPetugas[nomer].id);
    $("#petugasUseranameEdit").val(dataPetugas[nomer].username);
    $("#petugasNamaEdit").val(dataPetugas[nomer].nama);
    $("#petugasPinEdit").val(dataPetugas[nomer].pin);
    $("#editEmployeeModal").modal("show");
  });
  $("#submitEditPetugas").on("click", function() {
    let username = $("#petugasUseranameEdit").val();
    let name = $("#petugasNamaEdit").val();
    let pin = $("#petugasPinEdit").val();
    let id = $("#petugasIdEdit").val();
    $.ajax({
      url: `${baseUrl}api/v1/employee`,
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
            text: "Petugas berhasil diedit"
          });
        }
        $("#editEmployeeModal").modal("hide");
        refreshPetugas();
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
  $("#isiTablePetugas").on("click", ".hapusPetugas", function() {
    let nomer = $(this).data("nomer");
    Swal.fire({
      title: `Hapus Petugas ${dataPetugas[nomer].nama}?`,
      text: "Petugas yang sudah dihapus tidak dapat dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Tidak"
    }).then(result => {
      if (result.value) {
        $.ajax({
          url: `${baseUrl}api/v1/employee`,
          type: "DELETE",
          data: {
            id: dataPetugas[nomer].id,
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
                text: "Petugas berhasil dihapus"
              });
            }
            refreshPetugas();
          },
          error: async res => {
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

function refreshPetugas() {
  $.ajax({
    url: `${baseUrl}api/v1/employee`,
    type: "GET",
    beforeSend: () => {
      $("#loader").show();
    },
    success: (res, status, xhr) => {
      if (xhr.status == 200) {
        let render = "";
        let count = 1;
        dataPetugas = res.message;
        $("#isiTablePetugas").html("");
        res.message.forEach(e => {
          render += `<tr><td>${count}</td><td>${e.username}</td><td>${e.nama}</td><td>${e.pin}</td>`;
          render +=
            e.status == 0
              ? `<td>Belum Login</td>`
              : `<td>Loket ${e.status}</td>`;
          render += `<td>
          <button type="button" class="btn btn-primary mb-1 editPetugas" style="width: 100%" data-nomer="${count -
            1}">Ubah</button>
          <button type="button" class="btn btn-danger hapusPetugas" style="width: 100%;" data-nomer="${count -
            1}">Hapus</button></td></tr>`;
          count++;
        });
        $("#isiTablePetugas").html(render);
        $("#loader").hide();
      }
    }
  });
}

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
    let nama = $("#layananNamaAdd").val();
    let estimasi = $("#estimasiWaktuLayananAdd").val();
    console.log(nama);
    $.ajax({
      url: `${baseUrl}api/v1/service`,
      type: "POST",
      data: {
        nama,
        estimasi,
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
        refreshLayanan();
        $("#layananNamaAdd").val("")
      },
      error: async res => {
        console.log(res.responseText);
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Layanan telah ada!"
        });
      }
    });
  });
  $("#isiTableLayanan").on("click", ".editLayanan", function() {
    let nomer = $(this).data("nomer");
    $("#layananIdEdit").val(dataLayanan[nomer].id);
    $("#layananNamaEdit").val(dataLayanan[nomer].nama_layanan);
    $("#estimasiWaktuLayananEdit").val(dataLayanan[nomer].estimasi_waktu);
    $("#editServiceModal").modal("show");
  });
  $("#submitEditLayanan").on("click", function() {
    let nama = $("#layananNamaEdit").val();
    let estimasi = $("#estimasiWaktuLayananEdit").val();
    let id = $("#layananIdEdit").val();
    $.ajax({
      url: `${baseUrl}api/v1/service`,
      type: "PUT",
      data: {
        id,
        nama,
        estimasi,
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
          text: "Nama layanan telah ada!"
        });
      }
    });
  });
  $("#isiTableLayanan").on("click", ".hapusLayanan", function() {
    let nomer = $(this).data("nomer");
    Swal.fire({
      title: `Hapus Layanan ${dataLayanan[nomer].nama_layanan}?`,
      text: "Layanan yang sudah dihapus tidak dapat dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Tidak"
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
  $("#isiTableLayanan").on("click", ".gantiStatusLayanan", function() {
    let nomer = $(this).data("nomer");
    $.ajax({
      url: `${baseUrl}api/v1/service/change-status`,
      type: "PUT",
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
        if (xhr.status == 200) {
          Swal.fire({
            icon: "success",
            title: "Sukses",
            text: "Status layanan berhasil diganti"
          });
        }
        refreshLayanan();
      },
      error: async res => {
        console.log(res);
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Layanan tidak ditemukan"
        });
      }
    });
  });
});

function refreshLayanan() {
  $.ajax({
    url: `${baseUrl}api/v1/service`,
    type: "GET",
    beforeSend: () => {
      $("#loader").show();
    },
    success: (res, status, xhr) => {
      if (xhr.status == 200) {
        let render = "";
        let count = 1;
        dataLayanan = res.message;
        $("#isiTableLayanan").html("");
        res.message.forEach(e => {
          render += `<tr><td>${count}</td><td>${e.nama_layanan}</td>`;
          render += e.status == 0 ? `<td>Nonaktif</td>` : `<td>Aktif</td>`;
          render += `<td>${e.estimasi_waktu}</td>`
          render += `<td>`;
          render +=
            e.status == 0
              ? `<button type="button" class="btn btn-success mb-1 gantiStatusLayanan" style="width: 100%" data-nomer="${count -
                  1}">Aktifkan</button>`
              : `<button type="button" class="btn btn-danger mb-1 gantiStatusLayanan" style="width: 100%" data-nomer="${count -
                  1}">Nonaktifkan</button>`;
          render += `<button type="button" class="btn btn-primary mb-1 editLayanan" style="width: 100%" data-nomer="${count -
            1}">Ubah</button>
          <button type="button" class="btn btn-danger hapusLayanan" style="width: 100%;" data-nomer="${count -
            1}">Hapus</button></td></tr>`;
          count++;
        });
        $("#isiTableLayanan").html(render);
        $("#loader").hide();
      }
    }
  });
}

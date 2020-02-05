let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
const API_KEY = $("#API_KEY").val();
let dataLoket;
$(document).ready(function() {
  refreshLoket();
  $(".resetLoket").on("click", function() {
    Swal.fire({
      title: `Reset Loket?`,
      text: "Proses reset loket tidak dapat dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, reset!",
      cancelButtonText: "Tidak"
    }).then(result => {
      if (result.value) {
        $.ajax({
          url: `${baseUrl}api/v1/counter/reset/all`,
          type: "POST",
          data: {
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
                text: "Loket berhasil direset"
              });
            }
            refreshLoket();
          },
          error: async res => {
            console.log(res.responseText);
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
  $("#submitTambahLoket").on("click", function() {
    let nama = $("#loketNameAdd").val();
    $.ajax({
      url: `${baseUrl}api/v1/counter`,
      type: "POST",
      data: {
        nama,
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
            text: "Loket berhasil ditambahkan"
          });
        }
        $("#addCounterModal").modal("hide");
        $("#loketNameAdd").val("");
        refreshLoket();
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Loket telah ada!"
        });
      }
    });
  });
  $(".rowLoket").on("click", ".keluarkanLoket", function() {
    let nomer = $(this).data("nomer");
    Swal.fire({
      title: `Keluarkan loket ${dataLoket[nomer].nomor_loket}?`,
      text: "Loket yang sudah dikeluarkan tidak dapat dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, keluarkan!",
      cancelButtonText: "Tidak"
    }).then(result => {
      $.ajax({
        url: `${baseUrl}api/v1/counter/reset`,
        type: "POST",
        data: {
          auth: API_KEY,
          id: dataLoket[nomer].id
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
              text: "Loket berhasil dikeluarkan"
            });
          }
          refreshLoket();
        },
        error: async res => {
          Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Loket tidak ditemukan!"
          });
        }
      });
    });
  });
  $(".rowLoket").on("click", ".hapusLoket", function() {
    let nomer = $(this).data("nomer");
    Swal.fire({
      title: `Hapus loket ${dataLoket[nomer].nomor_loket}?`,
      text: "Loket yang sudah dihapus tidak dapat dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Tidak"
    }).then(result => {
      $.ajax({
        url: `${baseUrl}api/v1/counter`,
        type: "DELETE",
        data: {
          auth: API_KEY,
          id: dataLoket[nomer].id
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
              text: "Loket berhasil dihapus"
            });
          }
          refreshLoket();
        },
        error: async res => {
          Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Loket tidak ditemukan!"
          });
        }
      });
    });
  });
});

function refreshLoket() {
  $.ajax({
    url: `${baseUrl}api/v1/counter`,
    type: "GET",
    beforeSend: () => {
      $("#loader").show();
    },
    success: (res, status, xhr) => {
      if (xhr.status == 200) {
        let render = "";
        let count = 1;
        dataLoket = res.message;
        $(".rowLoket").html("");
        res.message.forEach(e => {
          render += `
          <div class="col-lg-4 mb-2">
            <div class="card shadow">
              <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">${e.nomor_loket}</h6>
              </div>
              <div class="card-body">`;
          if (e.status == 0) {
            render += `Status : <b>Nonaktif</b>
                  <button type="button" class="btn btn-danger mb-1 mt-1 hapusLoket" style="width: 100%" data-nomer=${count -
                    1}>Hapus</button>
                </div>
              </div>
            </div>`;
          } else {
            render += `Status : <b>Aktif</b><br>
                Petugas : <b>${e.nama_petugas}</b><br>
                Nomor antrian : <b>${e.nomor_antrian}</b><br>
                Jenis layanan : <b>${e.nama_layanan}</b><br>
                <button type="button" class="btn btn-success mb-1 keluarkanLoket" style="width: 49%" data-nomer=${count -
                  1}>Keluarkan</button>
                <button type="button" class="btn btn-danger mb-1 hapusLoket" style="width: 49%" data-nomer=${count -
                  1}>Hapus</button>
                </div>
              </div>
            </div>`;
          }
          count++;
        });
        $(".rowLoket").html(render);
        $("#loader").hide();
      }
    }
  });
}

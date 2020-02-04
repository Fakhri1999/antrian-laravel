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
      cancelButtonText: "Tidak",
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
});

function refreshLoket() {
  $.ajax({
    url: `${baseUrl}api/v1/counter`,
    type: "GET",
    success: (res, status, xhr) => {
      if (xhr.status == 200) {
        let render = "";
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
                </div>
              </div>
            </div>`;
          } else {
            render += `Status : <b>Aktif</b><br>
                Petugas : <b>${e.nama_petugas}</b><br>
                Nomor antrian : <b>${e.nomor_antrian}</b><br>
                Jenis layanan : <b>${e.nama_layanan}</b>
                </div>
              </div>
            </div>`;
          }
        });
        $(".rowLoket").html(render);
      }
    }
  });
}

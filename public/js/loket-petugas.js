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
$(document).ready(function () {
  refreshLoket();
})

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
        console.log(dataLoket)
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
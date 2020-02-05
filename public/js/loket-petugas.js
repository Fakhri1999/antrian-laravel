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
        dataLoket = res.message;
        console.log(dataLoket)
        $(".rowLoket").html("");
        let petugas_id = $("#petugas_id").val();
        let sudahMasuk;
        res.message.forEach(e => {
          if(e.id_petugas == petugas_id){
            sudahMasuk = true;
          }
        })
        res.message.forEach(e => {
          render += `
          <div class="col-lg-4 mb-2">
            <div class="card shadow">
              <div class="card-header">`
              if(e.id_petugas == petugas_id){
                render += `<h6 class="m-0 font-weight-bold text-warning">${e.nomor_loket} (LOKET ANDA)</h6>`
              } else {
                render += `<h6 class="m-0 font-weight-bold text-primary">${e.nomor_loket}</h6>`
              }
          render += `</div>
              <div class="card-body">`;
          if (e.status == 0) {
            if(!sudahMasuk){
              render += `Status : <b>Nonaktif</b>
                    <a href="${baseUrl}petugas/${e.id}" class="btn btn-primary mb-1 mt-1 masukLoket" style="width: 100%">Masuk</a>
                  </div>
                </div>
              </div>`;
            } else {
              render += `Status : <b>Nonaktif</b>
                  </div>
                </div>
              </div>`;
            }
          } else {
            render += `Status : <b>Aktif</b><br>
                Petugas : <b>${e.nama_petugas}</b><br>
                Nomor antrian : <b>${e.nomor_antrian}</b><br>
                Jenis layanan : <b>${e.nama_layanan}</b><br>
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

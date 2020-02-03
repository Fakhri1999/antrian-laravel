let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
$(document).ready(function () {
  let dataPetugas;
  refreshPetugas();
  $('#submitTambahPetugas').on('click', function () {
    let username = $('#petugasUseranameAdd').val();
    let name = $('#petugasNamaAdd').val();
    let pin = $('#petugasPinAdd').val();
    $.ajax({
      url: `${baseUrl}api/v1/employee`,
      type: "POST",
      data: {
        username,
        name, 
        pin
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
            text: "Petugas berhasil ditambahkan"
          });
        }
        $('#addEmployee').modal('hide');
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Username telah digunakan!"
        });
      }
    })
  });
  $('#submitEditPetugas').on('click', function () {
    let username = $('#petugasUseranameEdit').val();
    let name = $('#petugasNamaEdit').val();
    let pin = $('#petugasPinEdit').val();
    $.ajax({
      url: `${baseUrl}api/v1/employee`,
      type: "PUT",
      data: {
        username,
        name, 
        pin
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
            text: "Petugas berhasil ditambahkan"
          });
        }
        $('#addEmployee').modal('hide');
      },
      error: async res => {
        Swal.fire({
          icon: "error",
          title: "ERROR",
          text: "Username telah digunakan!"
        });
      }
    })
  })
})

function refreshPetugas(){
  $.ajax({
    url: `${baseUrl}api/v1/employee`,
    type: "GET",
    success: (res, status, xhr) => {
      console.log(res.message)
      if(xhr.status == 200){
        let render = "";
        let count = 1;
        dataPetugas = res.message;
        $("#isiTablePpetugas").html('');
        res.message.forEach(e => {
          render += `<tr><td>${count++}</td><td>${e.username}</td><td>${e.nama}</td><td>${e.pin}</td>`
          render += e.status == 0 ? `<td>Belum Login</td>` : `<td>Loket ${e.status}</td>`
          render += `<td> 
          <button type="button" class="btn btn-primary mb-1" style="width: 100%" id="editPetugas" data-id="${count}">Ubah</button>
          <button type="button" class="btn btn-danger" style="width: 100%;" id="hapusPetugas" data-id="${count}">Hapus</button></td></tr>`
        });
        $("#isiTablePpetugas").html(render);
      }
    }
  })
}
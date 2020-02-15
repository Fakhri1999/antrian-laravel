let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
const API_KEY = $("#API_KEY").val();
$(document).ready(async function() {
  refreshLoket();
  let ada = false;
  let time = 0;
  Echo.channel(`display`).listen("DisplayQueueUpdated", async e => {
    if (ada) {
      if (time > 0) {
        time += 3000;
      } else {
        time = 3000;
      }
    }
    let queue = e.queue.antrian;
    // setTimeout(() => {
    //   refreshLoket();
    //   $("#nomor-antrian").html(queue.nomor_antrian);
    //   $("#loket-antrian").html(queue.urutan);
    //   var x = document.getElementById("in-sound");
    //   x.muted = false;
    //   x.play();
    //   responsiveVoice.speak(
    //     `Nomor Antrian ${queue.nomor_antrian} Harap ke Loket nomor ${queue.urutan}.`,
    //     "Indonesian Female",
    //     {
    //       pitch: 1,
    //       rate: 1,
    //       volume: 1,
    //       onstart: () => {
    //         ada = true;
    //       },
    //       onend: () => {
    //         ada = false;
    //         time -= time == 0 ? 0 : 3000;
    //       }
    //     }
    //   );
    // }, time);
    setTimeout(() => {
      refreshLoket();
      $("#nomor-antrian").html(queue.nomor_antrian);
      $("#loket-antrian").html(queue.urutan);
      var x = document.getElementById("in-sound");
      x.muted = false;
      x.play();
    }, time);
    time += await 2500;
    console.log(`time tengah : ${time}`);
    setTimeout(() => {
      responsiveVoice.speak(
        `Nomor Antrian ${queue.nomor_antrian} Harap ke Loket nomor ${queue.urutan}.`,
        "Indonesian Female",
        {
          pitch: 0.8,
          rate: 0.9,
          volume: 1,
          onstart: () => {
            ada = true;
          },
          onend: () => {
            ada = false;
            time -= time == 2500 ? 2500 : 5500;
            console.log(`time sesudah : ${time}`);
          }
        }
      );
    }, time);
    if (!ada && time < 0) {
      time = 0;
    }
  });
});

function refreshLoket() {
  $.ajax({
    url: `${baseUrl}api/v1/counter/active`,
    type: "GET",
    beforeSend: () => {
      $("#loader").show();
    },
    success: async (res, status, xhr) => {
      let render = "";
      $(".rowLoket").html("");
      res.message.forEach(e => {
        render += `<div class="col-4 mb-2">
        <div class="card">
        <div class="card-header header-card-loket">
        ${e.nomor_loket.toUpperCase()}
          </div>
          <div class="card-body">
          <blockquote class="blockquote mb-0 text-center">
              <p>${e.nomor_antrian}</p>
              </blockquote>
          </div>
          </div>
      </div>`;
      });
      $(".rowLoket").html(render);
    }
  });
}

function startTime() {
  let today = new Date();
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
  };

  let hour = today.getHours();
  let minute = today.getMinutes();
  let second = today.getSeconds();
  let day = today.getDay();
  let date = today.getDate();
  let month = today.getMonth();
  let year = today.getFullYear();
  hour = checkTime(hour);
  minute = checkTime(minute);
  second = checkTime(second);
  let render = `${hour}:${minute}:${second} - ${today.toLocaleDateString(
    "id-ID",
    options
  )}`;
  $("#time").html(render);
  let t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  } // add zero in front of numbers < 10
  return i;
}

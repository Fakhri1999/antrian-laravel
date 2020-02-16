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
  let check = await refreshLoket();

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
    refreshLoket();
    setTimeout(() => {
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
            if (time < 0) {
              time = 0;
            }
          }
        }
      );
    }, time);
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
      console.log(res);
      let render = "";
      $(".rowLoket").html("");
      res.message.forEach(e => {
        render += `<div class="loket-row">
        <h1 class="mb-0">
        ${e.nomor_loket.toUpperCase()}
        </h1>
        <h2>
        ${e.nomor_antrian}
        </h2>
      </div>`;
      });
      $(".rowLoket").html(render);
      $(".marquee-vert").marquee('destroy')
      $(".marquee-horz").marquee('destroy')
      $(".marquee-horz").marquee({
        speed: 100,
        gap: 50,
        delayBeforeStart: 0,
        direction: "left",
        duplicated: true,
        pauseOnHover: true
      });
      $(".marquee-vert").marquee({
        direction: "up",
        speed: 50,
        duplicated: true,
        delayBeforeStart: 0
      });
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

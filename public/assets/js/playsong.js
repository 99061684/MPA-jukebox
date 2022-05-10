const Player = document.getElementById('Songplayer');
const Player2 = document.getElementById('Songplayer2');
const playsongbuttons = document.getElementsByClassName('playbuttonSong');

function playsong(button) {
    console.log(button.dataset.songUrl);

    var Regex1 = new RegExp(/embed/gi);
    var Regex2 = new RegExp(/open.spotify.com/gi);

    if(!Regex1.test(button.dataset.songUrl)){
        if (!Regex2.test(button.dataset.songUrl)) {
            let scr = Player2.src.slice(0, Player2.src.lastIndexOf('songs') + "songs".length + 1) + button.dataset.songUrl;
            Player2.src = scr;
            Player2.play();
        } else {
            console.log("spotify");
            Player.src = "https://open.spotify.com/embed/track/" + button.dataset.songUrl.slice(button.dataset.songUrl.lastIndexOf('/') + 1, button.dataset.songUrl.length);
        }
    } else {
        Player.src = button.dataset.songUrl;
    }
}

for (let i = 0; i < playsongbuttons.length; i++) {
    let self = playsongbuttons[i];

    self.addEventListener('click', function (event) {
        // prevent browser's default action
        event.preventDefault();

        playsong(this);
    }, false);
}

// make player play playlist of songs
function playplaylist(playlist) {
    let playlistSongsArray = playlist;
    let playlistSongsArrayLength = playlistSongsArray.length;
    let playlistSongsArrayIndex = 0;
    let playlistSongsArrayCurrent = playlistSongsArray[playlistSongsArrayIndex];
    let playlistSongsArrayCurrentUrl = playlistSongsArrayCurrent.slice(playlistSongsArrayCurrent.lastIndexOf('/') + 1, playlistSongsArrayCurrent.length);

    var Regex1 = new RegExp(/embed/gi);
    var Regex2 = new RegExp(/open.spotify.com/gi);

    if(!Regex1.test(playlistSongsArrayCurrent)){
        if (!Regex2.test(playlistSongsArrayCurrent)) {
            let scr = Player2.src.slice(0, Player2.src.lastIndexOf('songs') + "songs".length + 1) + playlistSongsArrayCurrentUrl;
            Player2.src = scr;
            Player2.play();
        } else {
            console.log("spotify");
            Player.src = "https://open.spotify.com/embed/track/" + playlistSongsArrayCurrentUrl;
        }
    } else {
        Player.src = playlistSongsArrayCurrent;
    }


    // function onPlayerStateChange(event) {
    //     if (event.data == YT.PlayerState.PLAYING && !done) {
    //       setTimeout(stopVideo, 6000);
    //       done = true;
    //     }
    //   }
    // Player.onended = function() {
    //     alert("The audio has ended");
    // };
    // check if player is ended
    // Player.addEventListener('ended', function () {
    //     console.log("ended");
    //     playlistSongsArrayIndex++;
    //     if (playlistSongsArrayIndex >= playlistSongsArrayLength) {
    //         playlistSongsArrayIndex = 0;
    //     }
    //     playlistSongsArrayCurrent = playlistSongsArray[playlistSongsArrayIndex];
    //     playlistSongsArrayCurrentUrl = playlistSongsArrayCurrent.slice(playlistSongsArrayCurrent.lastIndexOf('/') + 1, playlistSongsArrayCurrent.length);

    //     if(!Regex1.test(playlistSongsArrayCurrent)){
    //         if (!Regex2.test(playlistSongsArrayCurrent)) {
    //             let scr = Player2.src.slice(0, Player2.src.lastIndexOf('songs') + "songs".length + 1) + playlistSongsArrayCurrentUrl;
    //             Player2.src = scr;
    //             Player2.play();
    //         } else {
    //             console.log("spotify");
    //             Player.src = "https://open.spotify.com/embed/track/" + playlistSongsArrayCurrentUrl;
    //         }
    //     } else {
    //         Player.src = playlistSongsArrayCurrent;
    //     }
    // }, false);


}

function authenticate() {
    var token = "{{Session::get('spotify_token')}}";
    var refresh_token = "{{Session::get('spotify_refresh_token')}}";
    var expires_in = "{{Session::get('spotify_token_expires_in')}}";
    var now = new Date().getTime();
    var expires_at = now + expires_in * 1000;
    var refresh_expires_at = now + (expires_in - 3600) * 1000;
    var refresh_url = "https://accounts.spotify.com/api/token";
    var refresh_body = "grant_type=refresh_token&refresh_token=" + refresh_token;
    var refresh_headers = {
        "Content-Type": "application/x-www-form-urlencoded",
        "Authorization": "Basic " + btoa("{{$spotify_client_id}}:{{$spotify_client_secret}}")
    };
    var refresh_options = {
        method: "POST",
        headers: refresh_headers,
        body: refresh_body
    };
    var token_url = "https://accounts.spotify.com/api/token";
    var token_body = "grant_type=client_credentials";
    var token_headers = {
        "Content-Type": "application/x-www-form-urlencoded",
        "Authorization": "Basic " + btoa("{{$spotify_client_id}}:{{$spotify_client_secret}}")
    };
    var token_options = {
        method: "POST",
        headers: token_headers,
        body: token_body
    };

    var token_response = fetch(token_url, token_options);
    var token_json = token_response.then(function (response) {
        return response.json();
    });
    token_json.then(function (json) {
        token = json.access_token;
        expires_at = new Date().getTime() + json.expires_in * 1000;
        refresh_expires_at = new Date().getTime() + (json.expires_in - 3600) * 1000;
    });
    var refresh_interval = setInterval(function () {
        if (new Date().getTime() > refresh_expires_at) {
            var refresh_response = fetch(refresh_url, refresh_options);
            var refresh_json = refresh_response.then(function (response) {
                return response.json();
            });
            refresh_json.then(function (json) {
                token = json.access_token;
                expires_at = new Date().getTime() + json.expires_in * 1000;
                refresh_expires_at = new Date().getTime() + (json.expires_in - 3600) * 1000;
            });
        }
    }, 1000);
}

authenticate();

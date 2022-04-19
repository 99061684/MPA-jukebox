const Player = document.getElementById('Songplayer');
const Player2 = document.getElementById('Songplayer2');
const playsongbuttons = document.getElementsByClassName('playbuttonSong');
// const playsongbuttons2 = document.getElementsByClassName('playbuttonSong2');

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

// function playsong2(button) {
//     console.log(button.dataset.songUrl);
//     Player2.src = button.dataset.songUrl;
//     Player2.play();
// }

for (let i = 0; i < playsongbuttons.length; i++) {
    let self = playsongbuttons[i];

    self.addEventListener('click', function (event) {
        // prevent browser's default action
        event.preventDefault();

        playsong(this);
    }, false);
}

// for (let i = 0; i < playsongbuttons2.length; i++) {
//     let self = playsongbuttons2[i];

//     self.addEventListener('click', function (event) {
//         // prevent browser's default action
//         event.preventDefault();

//         playsong2(this);
//     }, false);
// }


// var player = new Spotify.Player({
//     name: 'Jukebox',
//     getOAuthToken: function(callback) {
//         callback('{{ $token }}');
//     }
// });

// // Error handling
// player.on('initialization_error', function(e) {
//     console.error(e);
// });
// player.on('authentication_error', function(e) {
//     console.error(e);
// });
// player.on('account_error', function(e) {
//     console.error(e);
// });
// player.on('playback_error', function(e) {
//     console.error(e);
// });

// // Playback status updates
// player.on('player_state_changed', function(state) {
//     console.log(state);
// });

// // Ready
// player.on('ready', function(data) {
//     console.log('Ready with Device ID', data.device_id);

//     player.play({
//         device_id: data.device_id,
//         uris: ['spotify:track:3XVozq1aeqsJwpXrEZrDJ9']
//     });
// });

// // Connect to the player!
// player.connect('{{ $player_id }}');


// authenticate spotify api
// var client_id = '{{ $spotify_client_id }}';
// var redirect_uri = '{{ $redirect_uri }}';

// const SPACE_DELIMETER = '%20';
// const SPOTIFY_AUTOHORIZE_URL = 'https://accounts.spotify.com/authorize';
// const SCOPES = ['user-read-private', 'user-read-email'];
// const SCOPES_URL_PARAM = SCOPES.join(SPACE_DELIMETER);

// // var stateKey = 'spotify_auth_state';
// var state = generateRandomString(16);
// // var scopes = 'user-read-private user-read-email';

// function createSpotify_Autorization_URL() {
//     var url = SPOTIFY_AUTOHORIZE_URL;
//     url += '?response_type=token';
//     url += '&client_id=' + encodeURIComponent(client_id);
//     url += '&scope=' + encodeURIComponent(SCOPES_URL_PARAM);
//     url += '&response_type=token';
//     url += '&show_dialog=true';
//     url += '&redirect_uri=' + encodeURIComponent(redirect_uri);
//     url += '&state=' + encodeURIComponent(state);
//     return url;
// }

// function authenticate() {
//     var url = createSpotify_Autorization_URL();
//     window.location = url;
// }

// //get token from url
// function getHashParams() {
//     var hashParams = {};
//     var e, r = /([^&;=]+)=?([^&;]*)/g,
//         q = window.location.hash.substring(1);
//     while (e = r.exec(q)) {
//         hashParams[e[1]] = decodeURIComponent(e[2]);
//     }
//     return hashParams;
// }

// //generate random string
// function generateRandomString(length) {
//     var text = '';
//     var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

//     for (var i = 0; i < length; i++) {
//         text += possible.charAt(Math.floor(Math.random() * possible.length));
//     }
//     return text;
// }

// authenticate();

// var params = {
//     client_id: client_id,
//     response_type: 'token',
//     redirect_uri: redirect_uri,
//     scope: scopes,
//     state: state
// };

// var url = 'https://accounts.spotify.com/authorize?' + $.param(params);

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

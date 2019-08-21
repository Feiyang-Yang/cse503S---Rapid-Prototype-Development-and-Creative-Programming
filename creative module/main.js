// import{showAlert, isEmpty} from 'validation.js';
const fetchJsonp = require('fetch-jsonp')
//import validation and showAlert
//get searchform element
const searchForm = document.querySelector("#search-form");
//submit search form
searchForm.addEventListener("submit", fetchMusic);
//fetch music data from apple music API
function fetchMusic(e) {
    console.log("here");
    e.preventDefault();
    const searchText = document.querySelector("#search-text").value;
    if(isEmpty(searchText)){
        showAlert("please search something",'warning');
        return;
    }
    const fetchUrl = `https://itunes.apple.com/search?term=${searchText}`;
    fetchJsonp(fetchUrl)
        .then(res => res.json())
        .then(data => showMusic(data.results))
        .catch(err => console.log(err));
}
//show each music in card
function showMusic(musics) {
    console.log("show");
    const results = document.querySelector('#results');
    //check if music data is empty
    if(musics.length ===0){
        showAlert('Nothing Found!','danger');
        return;
    }
    //clear first
    results.innerHTML = '';
    //loop through musics
    for (let i = 0; i < musics.length; i++) {
        const music = musics[i];
        if (music.kind !== 'song') {
            continue;
        }
        const div = document.createElement('div');
        div.classList.add('card');
        div.innerHTML = `
        <img class="card-img-top" src=${music.artworkUrl100} alt="Album Image">
        <div class="card-body">
          <h5 class="card-title">${music.trackName}</h5>
          <p class="card-text">${music.artistName}</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">${music.collectionName}</li>
          <li class="list-group-item">${music.primaryGenreName} · ${music.releaseDate.split('-', 1)}</li>
          <li class="list-group-item">
          Sample: <br>
          <audio src =${music.previewUrl} controls='controls'></aduio>
          </li>
        </ul>
        <div class="card-body">
          <a href=${music.trackViewUrl} class="card-link">Show in Apple Music</a>
        </div>'
        `;
        results.appendChild(div);
    }
}
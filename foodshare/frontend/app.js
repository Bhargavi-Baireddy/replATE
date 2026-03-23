const API = "http://localhost/foodshare/backend/api";

let map = L.map('map').setView([16.5, 80.6], 8);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: "© OpenStreetMap"
}).addTo(map);

// LOGIN
async function login() {
  const res = await fetch(API + "/auth.php?action=login", {
    method: "POST",
    body: JSON.stringify({
      email: email.value,
      password: password.value
    })
  });

  const data = await res.json();

  if (data.success) {
    localStorage.setItem("user", JSON.stringify(data.user));
    alert("Login success");
  } else {
    alert("Invalid login");
  }
}

// DONATE
async function donate() {
  let user = JSON.parse(localStorage.getItem("user"));

  await fetch(API + "/donations.php", {
    method: "POST",
    body: JSON.stringify({
      food: food.value,
      location: location.value,
      quantity: quantity.value,
      lat: 16.5,
      lng: 80.6,
      user_id: user.id
    })
  });

  loadDonations();
}

// LOAD DONATIONS
async function loadDonations() {
  const res = await fetch(API + "/donations.php");
  const data = await res.json();

  let list = document.getElementById("list");
  list.innerHTML = "";

  data.forEach(d => {

    let div = document.createElement("div");
    div.className = "card";

    div.innerHTML = `
      <h3>${d.food}</h3>
      <p>${d.location}</p>
      <p>${d.quantity}</p>
      <button onclick="claim(${d.id})">Claim</button>
    `;

    list.appendChild(div);

    if (d.lat && d.lng) {
      L.marker([d.lat, d.lng]).addTo(map)
        .bindPopup(d.food);
    }
  });
}

// CLAIM
async function claim(id) {
  let user = JSON.parse(localStorage.getItem("user"));

  await fetch(API + "/claims.php", {
    method: "POST",
    body: JSON.stringify({
      donation_id: id,
      user_id: user.id
    })
  });

  alert("Claimed!");
}

loadDonations();
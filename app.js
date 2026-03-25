// ═══════════════════════════════════════════
//  replATE — Shared Utilities (app.js)
// ═══════════════════════════════════════════

// ── TOAST ──
function showToast(msg, type = '') {
  const t = document.getElementById('toast');
  const m = document.getElementById('toast-msg');
  if (!t || !m) return;
  m.textContent = msg;
  t.className = 'toast ' + type;
  setTimeout(() => t.classList.add('show'), 50);
  setTimeout(() => t.classList.remove('show'), 3200);
}

// ── MODAL ──
let _modalCb = null;
function showModal(title, body, cb) {
  document.getElementById('modal-title').textContent = title;
  document.getElementById('modal-body').textContent = body;
  document.getElementById('modal').classList.add('open');
  _modalCb = cb;
  document.getElementById('modal-confirm').onclick = () => { closeModal(); if (_modalCb) _modalCb(); };
}
function closeModal() { document.getElementById('modal').classList.remove('open'); }

// ── NOTIFICATIONS ──
function toggleNotif(id) {
  document.querySelectorAll('.notif-dropdown').forEach(d => {
    if (d.id !== id) d.classList.remove('open');
  });
  document.getElementById(id).classList.toggle('open');
}
function markAllRead(id) {
  document.querySelectorAll('#' + id + ' .notif-dot').forEach(d => d.classList.add('read'));
  const badge = document.querySelector('[onclick*="' + id + '"] .notif-badge');
  if (badge) badge.style.display = 'none';
  showToast('All notifications marked as read ✓');
}
document.addEventListener('click', e => {
  if (!e.target.closest('.notif-wrap')) {
    document.querySelectorAll('.notif-dropdown').forEach(d => d.classList.remove('open'));
  }
});

// ── LOGOUT ──
function logout() {
  showToast('Signing out…');
  setTimeout(() => { window.location.href = 'index.html'; }, 800);
}

// ── POST DONATION MODAL ──
function openPostModal() { document.getElementById('post-modal').classList.add('open'); }
function closePostModal() { document.getElementById('post-modal').classList.remove('open'); }
// Donor donations storage
let donorDonations = JSON.parse(localStorage.getItem('donorDonations')) || [];

function saveDonorDonations() {
  localStorage.setItem('donorDonations', JSON.stringify(donorDonations));
}

function renderDonations(containerId = 'donor-dash-cards') {
  const container = document.getElementById(containerId);
  if (!container) return;
  
  const dynamicContainer = document.getElementById('dynamic-donations') || container;
  
  // Clear previous dynamic cards
  const existingDynamic = dynamicContainer.querySelectorAll('.donation-card[data-id]');
  existingDynamic.forEach(card => card.remove());
  
  // Add new dynamic cards
  donorDonations.forEach(donation => {
    const card = createDonationCard(donation);
    dynamicContainer.appendChild(card);
  });
}

function createDonationCard(donation) {
  const div = document.createElement('div');
  div.className = 'donation-card';
  div.dataset.status = donation.status || 'active';
  div.dataset.id = donation.id;
  div.innerHTML = `
    <div class="dc-header">
      <div style="position:relative;width:100%;height:160px;background:linear-gradient(135deg,#f8f9fa,#e9ecef);border-radius:10px 10px 0 0;display:flex;align-items:center;justify-content:center;font-size:48px;color:#adb5bd;">
        ${getFoodEmoji(donation.category || 'Other')}
      </div>
      <div style="position:absolute;bottom:8px;right:8px;background:rgba(0,0,0,0.7);color:white;padding:2px 8px;border-radius:12px;font-size:11px;">📍 ${donation.location || 'Nearby'}</div>
      <div class="dc-food" style="position:absolute;top:8px;left:12px;background:rgba(255,255,255,0.9);padding:4px 12px;border-radius:20px;font-weight:700;">${donation.foodName}</div>
      <span class="badge ${donation.status || 'active'}" style="position:absolute;top:8px;right:12px;">${donation.status || 'active'}</span>
    </div>
    <div class="dc-meta">
      <div class="dc-meta-row"><i class="fas fa-utensils"></i> ${donation.quantity}</div>
      <div class="dc-meta-row"><i class="fas fa-clock"></i> Expires ${donation.expiresBy}</div>
      <div class="dc-meta-row"><i class="fas fa-map-marker-alt"></i> ${donation.location}</div>
    </div>
    <div class="dc-progress">
      <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--text-2)">
        <span>Claimed</span><span>0 / ${donation.quantity}</span>
      </div>
      <div class="dc-progress-bar">
        <div class="dc-progress-fill" style="width:0%"></div>
      </div>
    </div>
    <div class="dc-actions">
      <button class="dc-btn" onclick="viewDonation('${donation.foodName}')"><i class="fas fa-eye"></i> View</button>
      <button class="dc-btn" onclick="editDonation('${donation.foodName}')"><i class="fas fa-pen"></i> Edit</button>
      <button class="dc-btn primary" onclick="deleteDonation('${donation.id}')"><i class="fas fa-trash"></i> Delete</button>
    </div>
  `;
  return div;
}

function getFoodEmoji(category) {
  const emojis = {
    'Cooked Meals': '🍛',
    'Bakery': '🥐',
    'Groceries': '🥦',
    'Beverages': '🥤',
    'Other': '🍽️'
  };
  return emojis[category] || '🍽️';
}

function submitDonation() {
  const formData = {
    id: Date.now().toString(),
    foodName: document.querySelector('.pd-modal .pd-input[placeholder*="Food Name"]').value.trim() || 'Untitled Donation',
    description: document.querySelector('.pd-modal textarea.pd-input').value.trim(),
    quantity: document.querySelector('.pd-modal .pd-input[placeholder*="Quantity"]').value.trim() || 'Unknown',
    expiresBy: document.querySelector('.pd-modal input[type="time"]').value || '18:00',
    location: document.querySelector('.pd-modal .pd-input[placeholder*="Pickup Location"]').value.trim() || 'Current Location',
    category: document.querySelector('.pd-modal select.pd-input').value,
    contact: document.querySelector('.pd-modal .pd-input[placeholder*="Contact"]').value.trim(),
    status: 'active',
    postedAt: new Date().toISOString()
  };

  if (!formData.foodName || !formData.quantity || !formData.location) {
    showToast('Please fill required fields (Food Name, Quantity, Location)', 'error');
    return;
  }

  donorDonations.unshift(formData);
  saveDonorDonations();
  closePostModal();
  
  // Clear form
  document.querySelectorAll('.pd-modal .pd-input, .pd-modal textarea').forEach(input => input.value = '');
  
  // Update UI
  renderDonations();
  showToast(`"${formData.foodName}" posted successfully! 🎉`, 'success');
}

// ── FOOD ACTIONS ──
function claimFood(name) {
  showModal('Claim Food Donation', `Claim "${name}"? A volunteer will be assigned for pickup.`, () => {
    showToast(`"${name}" claimed! 🎉`, 'success');
  });
}

function deleteDonation(idOrName) {
  let donationToDelete;
  if (typeof idOrName === 'string' && idOrName.includes('-')) {
    // ID format
    donationToDelete = donorDonations.find(d => d.id === idOrName);
  } else {
    // Name fallback (existing hardcoded cards)
    donationToDelete = { foodName: idOrName };
  }
  
  showModal('Delete Donation', `Delete "${donationToDelete.foodName || idOrName}"? This cannot be undone.`, () => {
    if (typeof idOrName === 'string' && idOrName.includes('-')) {
      donorDonations = donorDonations.filter(d => d.id !== idOrName);
      saveDonorDonations();
      renderDonations();
    }
    const name = donationToDelete.foodName || idOrName;
    showToast(`"${name}" deleted`, '');
    // Remove dynamic card if exists
    const card = document.querySelector(`[data-id="${idOrName}"]`);
    if (card) card.remove();
  });
}

// Load donations on page load (donor dashboard specific)
if (window.location.pathname.includes('dashboard-donor.html')) {
  document.addEventListener('DOMContentLoaded', () => {
    renderDonations();
  });
}
function viewDonation(name) { showToast(`Viewing: ${name}`, ''); }
function editDonation(name) { showToast(`Editing: ${name}`, ''); }
function deleteDonation(name) {
  showModal('Delete Donation', `Delete "${name}"? This cannot be undone.`, () => {
    showToast(`"${name}" deleted`, '');
  });
}
function markDelivered(btn) {
  showModal('Mark as Delivered', 'Confirm that the food has been delivered to the recipient.', () => {
    btn.closest('.pickup-card').style.opacity = '.5';
    btn.innerHTML = '✅ Delivered!';
    btn.disabled = true;
    showToast('Delivery confirmed! Great work! 🌟', 'success');
  });
}
function acceptPickup(btn) {
  showModal('Accept Pickup', 'Accept this pickup assignment?', () => {
    btn.closest('.pickup-card').remove();
    showToast('Pickup accepted! Head to the location.', 'success');
  });
}

// ── CHAT HELPERS ──
function openChat(el, name, color, initial) {
  document.querySelectorAll('.chat-item').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  const nameEl = document.getElementById('chat-name');
  const av = document.getElementById('chat-av');
  if (nameEl) nameEl.textContent = name;
  if (av) { av.textContent = initial; av.style.background = color; }
}

function sendMsg(inputId, msgsId) {
  const inp = document.getElementById(inputId);
  const val = inp.value.trim();
  if (!val) return;
  const msgs = document.getElementById(msgsId);
  const div = document.createElement('div');
  div.className = 'msg-bubble sent fade-in';
  div.innerHTML = val + '<span class="msg-time">Just now</span>';
  msgs.appendChild(div);
  msgs.scrollTop = msgs.scrollHeight;
  inp.value = '';
  setTimeout(() => {
    const reply = document.createElement('div');
    reply.className = 'msg-bubble received fade-in';
    reply.innerHTML = 'Got it! Thanks for the update. 👍<span class="msg-time">Just now</span>';
    msgs.appendChild(reply);
    msgs.scrollTop = msgs.scrollHeight;
  }, 1200);
}

// ── CHART GRADIENT ──
function orangeGrad(ctx) {
  const g = ctx.createLinearGradient(0, 0, 0, 200);
  g.addColorStop(0, 'rgba(255,107,53,.35)');
  g.addColorStop(1, 'rgba(255,107,53,0)');
  return g;
}

// ── MAP VIEW TOGGLE ──
function toggleMapView(view) {
  const foodView = document.getElementById('map-food-view');
  const volView = document.getElementById('map-vol-view');
  const foodBtn = document.getElementById('map-food-btn');
  const volBtn = document.getElementById('map-vol-btn');
  if (view === 'food') {
    if(foodView) foodView.style.display = 'block';
    if(volView) volView.style.display = 'none';
    if(foodBtn) foodBtn.classList.add('active');
    if(volBtn) volBtn.classList.remove('active');
  } else {
    if(foodView) foodView.style.display = 'none';
    if(volView) volView.style.display = 'block';
    if(volBtn) volBtn.classList.add('active');
    if(foodBtn) foodBtn.classList.remove('active');
  }
}

// ── DONATION FILTERS ──
function filterDonations(el, status) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.donation-card').forEach(card => {
    const cs = card.dataset.status;
    card.style.display = (status === 'all' || cs === status) ? 'block' : 'none';
  });
}

// ── VOLUNTEER PICKUP TAB ──
function switchTab(el, tabId) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  ['vol-mypickups', 'vol-available'].forEach(id => {
    const el2 = document.getElementById(id);
    if (el2) el2.style.display = (id === tabId) ? 'block' : 'none';
  });
}
function showToasts() {
    const toast = document.createElement("div");
    toast.innerText = "Donated Successfully";

    toast.style.position = "fixed";
    toast.style.top = "20px";          // ✅ top
    toast.style.right = "20px";        // ✅ right side
    toast.style.backgroundColor = "#28a745"; // green
    toast.style.color = "white";
    toast.style.padding = "12px 24px";
    toast.style.borderRadius = "6px";
    toast.style.fontWeight = "bold";
    toast.style.boxShadow = "0 2px 10px rgba(0,0,0,0.2)";
    toast.style.zIndex = "9999";       // ✅ stays above all content

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000); // ✅ 3 seconds
}
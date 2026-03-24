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
function submitDonation() {
  closePostModal();
  showToast('Donation posted successfully! 🎉', 'success');
}

// ── FOOD ACTIONS ──
function claimFood(name) {
  showModal('Claim Food Donation', `Claim "${name}"? A volunteer will be assigned for pickup.`, () => {
    showToast(`"${name}" claimed! 🎉`, 'success');
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

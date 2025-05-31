<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Payment • BPay</title>
  <style>
    /* reset & base */
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:Arial,sans-serif;background:#f4f6fa;color:#333;padding-bottom:80px}
    a{text-decoration:none;color:inherit}
    /* header */
    .app-header{background:#fff;text-align:center;padding:16px 0;box-shadow:0 1px 4px rgba(0,0,0,0.1);margin-bottom:16px}
    .app-logo{height:40px}
    /* flash */
    .flash{margin:0 16px 16px;padding:12px;border-radius:8px;font-size:14px;text-align:center}
    .flash.success{background:#e6ffed;color:#237804}
    .flash.error  {background:#ffe6e6;color:#a8071a}
    /* stats */
    .stats-row{display:flex;gap:12px;padding:0 16px 16px}
    .stat-card{flex:1;background:#fff;padding:12px;text-align:center;border-radius:12px;box-shadow:0 2px 6px rgba(0,0,0,0.05)}
    .stat-card .label{font-size:14px;color:#777}
    .stat-card .value{font-size:24px;color:#237804}
    /* profiles */
    .profiles{background:#fff;margin:0 16px 16px;border-radius:12px;box-shadow:0 2px 6px rgba(0,0,0,0.05)}
    .profiles h2{padding:12px 16px;font-size:16px;border-bottom:1px solid #eee}
    .profile-item{display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-bottom:1px solid #f0f0f0;cursor:pointer}
    .profile-item:last-child{border-bottom:none}
    .profile-type{font-weight:bold}
    .profile-detail{color:#555;font-size:13px}
    .profile-actions img{width:20px;height:20px}
    .btn-add{width:100%;padding:12px;background:#3366FF;color:#fff;border:none;border-radius:0 0 12px 12px;cursor:pointer;font-size:14px}
    /* modal */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:10}
    .modal{background:#fff;padding:16px;border-radius:12px;width:90%;max-width:360px}
    .modal h3{margin-bottom:12px;font-size:18px;text-align:center}
    .modal .radio-group{display:flex;gap:16px;margin-bottom:12px;justify-content:center}
    .modal form input,.modal form select{width:100%;padding:8px;margin-bottom:8px;border:1px solid #ccc;border-radius:4px;font-size:14px}
    .modal .actions{display:flex;gap:8px;margin-top:8px}
    .modal .actions button{flex:1;padding:8px;border:none;font-size:14px;border-radius:4px;cursor:pointer}
    .modal .actions .primary{background:#3366FF;color:#fff}
    .modal .actions .secondary{background:#eee;color:#333}
    #match-error{display:none;font-size:13px;color:#a8071a;margin-top:-4px;margin-bottom:8px;text-align:center}
    /* withdraw form */
    .exchange-card{background:#fff;margin:0 16px 16px;padding:16px;border-radius:12px;box-shadow:0 2px 6px rgba(0,0,0,0.05)}
    .exchange-card h2{margin-bottom:12px;font-size:16px;font-weight:bold}
    .exchange-card .error{margin-bottom:12px;color:#a8071a;font-size:14px;text-align:center}
    .input-group{background:#f9f9f9;padding:8px;border-radius:8px;display:flex;align-items:center;margin-bottom:8px}
    .input-group select,.input-group input{border:none;background:transparent;outline:none;flex:1;font-size:14px}
    .input-group .icon{margin-right:8px;font-weight:bold}
    .btn-submit{width:100%;padding:12px;background:#3366FF;color:#fff;border:none;border-radius:8px;font-size:16px;cursor:pointer}
    .btn-submit:disabled{background:#ccc;cursor:not-allowed}
    /* history */
    .history-container{padding:0 16px 80px}
    .tx-card{display:grid;grid-template-columns:1fr auto;gap:8px;background:#fff;padding:12px 16px;margin-bottom:8px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.05)}
    .tx-date{font-size:12px;color:#777}
    .tx-type{font-size:14px;font-weight:bold;text-transform:capitalize}
    .tx-detail{font-size:13px;color:#555}
    .tx-amount{font-size:16px;color:#237804;text-align:right}
    .tx-status{font-size:12px;font-weight:bold;padding:4px 8px;border-radius:8px;text-transform:capitalize;text-align:center}
    .tx-status.pending{background:#fff7e6;color:#a65a00}
    .tx-status.approved{background:#e6ffed;color:#237804}
    .tx-status.rejected{background:#ffe6e6;color:#a8071a}
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="app-header">
    <a href="home.php"><img src="images/logo.png" alt="XPay" class="app-logo"></a>
  </header>

  <!-- FLASH -->
  
  <!-- STATS -->
  <section class="stats-row">
    <div class="stat-card">
      <p class="label">Available INR</p>
      <p class="value" id="stat-available">0.00 INR</p>
    </div>
    <div class="stat-card">
      <p class="label">Available USDT</p>
      <p class="value" id="stat-unavailable">0.00 USDT</p>
    </div>
  </section>

  <!-- YOUR METHODS -->
  <section class="profiles">
    <h2>Your Payment Methods</h2>
          <div style="padding:12px;color:#777;">No methods added yet.</div>
        <button id="btn-add" class="btn-add">+ Add Payment Method</button>
  </section>

  <!-- ADD / EDIT MODAL -->
  <div class="modal-overlay" id="modal-add">
    <div class="modal">
      <h3 id="modal-add-title">Add Payment Method</h3>
      <form id="frm-add" method="POST">
        <input type="hidden" name="action" value="add_profile" id="add-action">
        <input type="hidden" name="profile_id" id="add-profile-id">
        <div class="radio-group">
          <label><input type="radio" name="type" value="UPI" checked> UPI</label>
          <label><input type="radio" name="type" value="BANK"> Bank</label>
        </div>
        <div id="grp-upi">
          <input type="text" name="upi_address" placeholder="UPI Address" required>
        </div>
        <div id="grp-bank" style="display:none">
          <input type="text" name="account_name"           placeholder="Account Name">
          <input type="text" name="account_number"         placeholder="Account Number">
          <input type="text" name="confirm_account_number" placeholder="Confirm Account Number">
          <div id="match-error">Account numbers must match.</div>
          <input type="text" name="ifsc_code"              placeholder="IFSC Code">
          <input type="text" name="phone_number"           placeholder="Phone Number">
          <input type="email" name="email_address"         placeholder="Email Address">
        </div>
        <div class="actions">
          <button type="submit" class="primary" id="add-submit" disabled>Add</button>
          <button type="button"  class="secondary" id="add-cancel">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- DETAIL / EDIT / REMOVE MODAL -->
  <div class="modal-overlay" id="modal-detail">
    <div class="modal">
      <h3>Payment Method Details</h3>
      <div id="detail-content" style="margin-bottom:12px;font-size:14px;color:#555"></div>
      <form method="POST">
        <input type="hidden" name="action" value="remove_profile">
        <input type="hidden" name="profile_id" id="detail-pid">
        <div class="actions">
          <button type="button" class="secondary" id="detail-edit">Edit</button>
          <button type="submit" class="primary">Remove</button>
          <button type="button" class="secondary" id="detail-close">Close</button>
        </div>
      </form>
    </div>
  </div>

  

  <!-- WITHDRAWAL HISTORY -->
  <section class="history-container">
    <h2>Withdrawal History</h2>
    <div id="transactions-list"></div>
  </section>

  <!-- bottom_nav.php -->
<style>
    /* --- Bottom Nav --- */
    .bottom-nav {
        position: fixed;
        bottom: 0; 
        left: 0; 
        right: 0;
        background: #fff;
        display: flex;
        justify-content: space-around;
        padding: 8px 0;
        box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
    }
    .bottom-nav a {
        flex: 1;
        text-align: center;
        color: #333;
        font-size: 12px;
    }
    .bottom-nav a.active { 
        color: #3366ff; 
    }
    .bottom-nav img { 
        height: 24px; 
        display: block; 
        margin: 0 auto 4px; 
    }
</style>

<div class="bottom-nav">
    <a href="home.php" class="active">
        <img src="https://img.icons8.com/sf-black-filled/64/228BE6/home.png" alt="Home">
        <span>Home</span>
    </a>
    <a href="transaction_history.php">
        <img src="https://img.icons8.com/external-sbts2018-lineal-color-sbts2018/58/228BE6/external-add-money-ecommerce-basic-1-sbts2018-lineal-color-sbts2018.png" alt="Transaction">
        <span>Transaction</span>
    </a>
    <a href="payment.php">
        <img src="https://img.icons8.com/external-kmg-design-glyph-kmg-design/32/228BE6/external-withdraw-finance-2-kmg-design-glyph-kmg-design.png" alt="Payment">
        <span>Payment</span>
    </a>
    <a href="profile.php">
        <img src="https://img.icons8.com/ios-glyphs/30/228BE6/user--v1.png" alt="Me">
        <span>Me</span>
    </a>
</div>

  <script>
    const $ = s=>document.querySelector(s),
          $$=s=>document.querySelectorAll(s);

    // — Add/Edit Modal Logic —
    const modalAdd      = $('#modal-add'),
          addTitle      = $('#modal-add-title'),
          addForm       = $('#frm-add'),
          addAction     = $('#add-action'),
          addProfileId  = $('#add-profile-id'),
          btnAdd        = $('#btn-add'),
          btnCancel     = $('#add-cancel'),
          radios        = $$('[name="type"]'),
          grpUpi        = $('#grp-upi'),
          grpBank       = $('#grp-bank'),
          upiFld        = grpUpi.querySelector('input'),
          acctFld       = grpBank.querySelector('[name="account_name"]'),
          numFld        = grpBank.querySelector('[name="account_number"]'),
          cnfFld        = grpBank.querySelector('[name="confirm_account_number"]'),
          ifscFld       = grpBank.querySelector('[name="ifsc_code"]'),
          phoneFld      = grpBank.querySelector('[name="phone_number"]'),
          emailFld      = grpBank.querySelector('[name="email_address"]'),
          matchError    = $('#match-error'),
          addSubmitBtn  = $('#add-submit');

    // NEW helper: keep required/disabled in sync
    function syncValidationFlags(){
      const showUPI  = grpUpi.style.display==='block';
      const showBank = grpBank.style.display==='block';

      upiFld.required = showUPI;
      upiFld.disabled = !showUPI;

      [acctFld,numFld,cnfFld,ifscFld,phoneFld,emailFld].forEach(f=>{
        f.required = showBank && ['account_name','account_number','confirm_account_number','ifsc_code'].includes(f.name);
        f.disabled = !showBank;
      });
    }

    function checkMatch(){
      if(grpBank.style.display==='block'){
        if(numFld.value && cnfFld.value && numFld.value===cnfFld.value){
          matchError.style.display='none';
          addSubmitBtn.disabled=false;
        } else {
          matchError.style.display='block';
          addSubmitBtn.disabled=true;
        }
      } else {
        addSubmitBtn.disabled = !(upiFld.value.trim().length>0);
      }
    }

    function openAdd(isNew, p=null){
      modalAdd.style.display='flex';
      addForm.reset();
      matchError.style.display='none';
      addSubmitBtn.disabled=true;

      if(isNew){
        addTitle.textContent='Add Payment Method';
        addAction.value='add_profile';
        grpUpi.style.display='block';
        grpBank.style.display='none';
      } else {
        addTitle.textContent='Edit Payment Method';
        addAction.value='edit_profile';
        addProfileId.value=p.id;
        radios.forEach(r=> r.checked = (r.value===p.type));
        if(p.type==='UPI'){
          grpUpi.style.display='block';
          grpBank.style.display='none';
          upiFld.value=p.upi_address;
        } else {
          grpUpi.style.display='none';
          grpBank.style.display='block';
          acctFld.value   = p.account_name;
          numFld.value    = p.account_number;
          cnfFld.value    = p.account_number;
          ifscFld.value   = p.ifsc_code;
          phoneFld.value  = p.phone_number;
          emailFld.value  = p.email_address;
        }
      }

      // **CRUCIAL** sync after show/hide
      syncValidationFlags();
      checkMatch();
    }

    btnAdd.onclick    = ()=> openAdd(true);
    btnCancel.onclick = ()=> modalAdd.style.display='none';

    radios.forEach(r=> r.addEventListener('change', ()=>{
      const isUPI = $('input[name="type"]:checked').value==='UPI';
      grpUpi.style.display  = isUPI?'block':'none';
      grpBank.style.display = isUPI?'none':'block';
      syncValidationFlags();
      checkMatch();
    }));

    [upiFld,numFld,cnfFld].forEach(f=>f.addEventListener('input',checkMatch));

    // — Detail Modal Logic —
    const modalDetail    = $('#modal-detail'),
          detailCnt      = $('#detail-content'),
          detailPid      = $('#detail-pid'),
          btnDetailClose = $('#detail-close'),
          btnDetailEdit  = $('#detail-edit');
    let currentProfile = null;
    function openDetailModal(p){
      currentProfile = p;
      let html = '';
      if(p.type==='BANK'){
        html += `<p><strong>Account Name:</strong> ${p.account_name}</p>`;
        html += `<p><strong>Account Number:</strong> ${p.account_number}</p>`;
        html += `<p><strong>IFSC Code:</strong> ${p.ifsc_code}</p>`;
        if(p.phone_number) html+=`<p><strong>Phone:</strong> ${p.phone_number}</p>`;
        if(p.email_address)html+=`<p><strong>Email:</strong> ${p.email_address}</p>`;
      } else {
        html += `<p><strong>UPI Address:</strong> ${p.upi_address}</p>`;
      }
      detailCnt.innerHTML=html;
      detailPid.value=p.id;
      modalDetail.style.display='flex';
    }
    btnDetailClose.onclick = ()=> modalDetail.style.display='none';
    btnDetailEdit.onclick  = ()=>{
      modalDetail.style.display='none';
      openAdd(false, currentProfile);
    };

    // — History & Stats Polling (unchanged) —
   let history = [];

function renderHistory() {
  const ct = $('#transactions-list');
  ct.innerHTML = '';
  
  if (!history.length) {
    ct.innerHTML = '<div style="padding:12px;color:#777">No withdrawals yet.</div>';
    return;
  }

  history.forEach(tx => {
    const d = document.createElement('div');
    d.className = 'tx-card';
    d.innerHTML = `
      <div>
        <div class="tx-date">${tx.created_at}</div>
        <div class="tx-type">Withdrawal</div>
        <div class="tx-detail">${tx.detail || ''}</div>
      </div>
      <div>
        <div class="tx-amount">${parseFloat(tx.amount).toFixed(2)} INR</div>
        <div class="tx-status ${tx.status}">${tx.status}</div>
      </div>`;
    ct.appendChild(d);
  });
}

    async function poll(){
      try {
        let s = await fetch('payment.php?ajax_stats=1').then(r=>r.json());
        $('#stat-available').textContent   = s.available.toFixed(2) + ' INR';
        $('#stat-unavailable').textContent = s.unavailable.toFixed(2) + ' USDT';
        history = await fetch('payment.php?ajax_history=1').then(r=>r.json());
        renderHistory();
      }catch(e){console.error(e)}
    }
    renderHistory();
    setInterval(poll,5000);

    // — Withdraw Form Validation (unchanged) —
    const frmW = $('#frm-withdraw');
    if(frmW){
      frmW.addEventListener('submit',e=>{
        e.preventDefault();
        const errDiv=$('#withdraw-error'),
              sel  =$('#sel-method').value,
              amt  =parseFloat($('#inp-amount').value),
              avail =parseFloat($('#stat-available').textContent);
        let msg='';
        if(!sel)           msg='Please select a payment method.';
        else if(!amt)      msg='Please enter an amount.';
        else if(amt<1)     msg='Amount must be at least 1.';
        else if(amt>avail) msg=`Cannot exceed available (${avail.toFixed(2)}).`;
        if(msg){
          errDiv.textContent=msg;
          errDiv.style.display='block';
        } else frmW.submit();
      });
      $('#inp-amount').addEventListener('input',()=>$('#withdraw-error').style.display='none');
      $('#sel-method').addEventListener('change', ()=>$('#withdraw-error').style.display='none');
    }
  </script>
</body>
</html>

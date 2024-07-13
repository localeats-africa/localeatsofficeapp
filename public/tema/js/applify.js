window.addEventListener('load', () => {

    Init();
    



    
})
function Init() {
    
    ToastOPT();
    LoadParticles();
    Register();
    Login();
    Logout();
    SetUser();
    Vendors();
    AddVendor();
    VendorMeta();
    GetMeta()
    UpdateMeta();
    Platforms();
    Chowdeck();
    Glovo();
    Reports();
    GenerateInvoice();
    ShowInvoice();
    
   

}

function ToastOPT() {
  let x = (toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-bottom-left",
    preventDuplicates: true,
    showDuration: "5000",
    hideDuration: "1000",
    timeOut: "10000",
    extendedTimeOut: "0",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
  });
  return x;
}
function ParticlesJSON() {
    const particle = {
      "number": {
        value: 147,
        density: {
          enable: true,
          value_area: 866.4828672705786,
        },
      },
      color: { value: "#d7fcea" },
      shape: {
        type: "circle",
        stroke: { " width": 6, color: "#ed5c5c" },
        polygon: { nb_sides: 5 },
        image: { src: "img/github.svg", width: 100, height: 100 },
      },
      opacity: {
        value: 0.26389444222311087,
        random: true,
        anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false },
      },
      size: {
        value: 11.995201919232311,
        random: true,
        anim: { enable: false, speed: 40, size_min: 0.1, sync: false },
      },
      line_linked: {
        enable: false,
        distance: 500,
        color: "#ffffff",
        opacity: 0.4,
        width: 2,
      },
      move: {
        enable: true,
        speed: 6,
        direction: "bottom",
        random: false,
        straight: false,
        out_mode: "out",
        bounce: false,
        attract: { enable: false, rotateX: 600, rotateY: 1200 },
      },
    };
    return particle;
}
function Register() {
    const rel = document.querySelector('[rel="register"]');
    if (!rel) return;
    const reg = document.querySelector('.reg');
    const btn_reg = document.querySelector('.regb');
    const msg = document.querySelector('.reg-err');
    const api = "../applify/api.php";
    btn_reg.addEventListener('click', (e) => {
        let form = new FormData(reg);
        let err = '';
        let err_count = 0;
        // console.log(form.get('fullname'));
        for (let frm of form.entries()) {
            let v = frm[1];
            console.log(v);
            if (v == '') {
                err_count++;
                err = 'All fields are required.';
            }
        }
        msg.textContent = err;
        msg.classList.add("d-none");
        if (err_count > 0) {
            msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
            msg.classList.add("alert-danger");
            msg.classList.remove('d-none');
        }
        if (err_count == 0) {
            btn_reg.innerHTML = `<i class="fa-solid fa-spin fa-spinner"></i> Processing`;
            btn_reg.disabled = true; 
            form.append('query', 'register');
            fetch(api, {
                method: 'POST',
                body: form
            }).then(response => response.text())
                .then(data => {
                    console.log(data);
                    if (data == 0) {
                        err = "Registered Successfully!";
                        msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-primary"></i>' + err;
                        msg.classList.remove("alert-danger");
                        msg.classList.add("alert-info");
                        reg.reset();
                        setTimeout(() => {
                            location.replace('login');
                        }, 3000);
                    }
                    if (data == 1) {
                        err = "All fields are required.";
                        msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                         msg.classList.add("alert-danger");
                    }
                    if (data == 2) {
                        err = "Invalid email address.";
                        msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                         msg.classList.add("alert-danger");
                    }
                    if (data == 3) {
                        err = "Password must be at least 8 characters.";
                        msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                         msg.classList.add("alert-danger");
                    }
                    if (data == 4) {
                        err = "Passwords do not match.";
                        msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                         msg.classList.add("alert-danger");
                    }
                    if (data == 5) {
                        err = "User already exists.";
                        msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                         msg.classList.add("alert-danger");
                    }
                    msg.classList.remove("d-none");
                    btn_reg.innerHTML = `Register`;
                    btn_reg.disabled = false; 
            })
        }
    })
}
function Login() {
    const rel = document.querySelector('[rel="login"]');
    if (!rel) return;
    const login = document.querySelector(".log");
    const btn_log = document.querySelector(".logb");
    const msg = document.querySelector(".log-err");
    const lt = document.querySelector(".lt");
    let today = new moment().format('LL');
    lt.textContent = today + '.';
    localStorage.removeItem("leats");
    btn_log.addEventListener('click', () => {
        let form = new FormData(login);
        let err = "";
        let err_count = 0;
        for (let frm of form.entries()) {
            let value = frm[1];
            if (value == '') {
                err_count = 1;
                err = 'Provide your credentials.';
            }
        }
        msg.textContent = err;
        msg.classList.add("d-none");    
        if (err_count > 0) {
            msg.innerHTML = '<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
            msg.classList.add("alert-danger");
            msg.classList.remove("d-none");
        }
        if (err_count == 0) {
            form.append('query', 'login');
            const api = '../applify/api.php';
            btn_log.innerHTML = `<i class="fa-solid fa-spin fa-spinner"></i> Processing`; 
            btn_log.disabled = true;
            fetch(api, {
                method: 'POST',
                body: form
            }).then(response => response.json())
                .then((json) => {
                    console.log(json);
                    let auth = json.status;
                    if (auth == 0) {
                        err = "Approved! Access granted.";
                        msg.innerHTML ='<i class="fa-solid fa-shield fs-16 pe-10 text-primary"></i>' + err;
                        msg.classList.remove("alert-danger");
                        msg.classList.add("alert-info");
                        localStorage.setItem("leats", json.role);
                        setTimeout(() => {
                            location.replace("../dashboard");
                        }, 3000);
                    }
                    if (auth == 1) {
                        err = "Invalid User ID.";
                        msg.innerHTML ='<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                        msg.classList.add("alert-danger");
                    }
                    if (auth == 2) {
                        err = "Authentication failed.";
                        msg.innerHTML ='<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                        msg.classList.add("alert-danger");
                    }
                    if (auth == 3) {
                        err = "Authorization Failed.";
                        msg.innerHTML ='<i class="fa-solid fa-shield fs-16 pe-10 text-danger"></i>' + err;
                        msg.classList.add("alert-danger");
                    }
                    msg.classList.remove("d-none");
                    btn_log.innerHTML = `Login`;
                    btn_log.disabled = false;
            })
        } 
    })
}
function Logout() {
    const logout = document.querySelectorAll(".logout");
    Array.from(logout).forEach((log) => {
        log.addEventListener('click', () => {
            localStorage.removeItem("leats");
            location.replace('index');  
        })
    })
}
function SetUser() {
    const rel = document.querySelector('[rel="dashboard"]');
    if (!rel) return;
    const leat_user = document.querySelector('.u-name');
    const leat_email = document.querySelector('.u-email');
    const leat_role = document.querySelector('.u-role');
    const url = 'applify/api.php';
    let form = new FormData();
    form.append('query', 'get-user');
    fetch(url, {
        method: 'POST',
        body: form
    }).then((response) => response.json())
        .then(json => {
            console.log(json);
            const name = CapWords(json.name);
            const email = json.email;
            const role = UserRole(json.role);
            // let today = new moment().format('LLL');
            leat_user.textContent = name;
            leat_role.textContent = role;
            // leat_email.textContent = email;
    })
}
function Vendors() {
    const rel = document.querySelector('[rel="vendors"]');
    if (!rel) return;
    const leats = localStorage.getItem('leats');
    const btnAdd = document.querySelector('[role="new-vendor"]');
    let lt = _rw();
    btnAdd.classList.add(lt);
    // if (leats < 300) {
    //     btnAdd.disabled = true;
    // } 
    btnAdd.addEventListener('click', () => {
        location.href = 'new-vendor';
    });
    let url = 'applify/api.php';
    let form = new FormData();
    form.append('query', 'all-vendors');
    fetch(url, {
        method: 'POST',
        body: form
    }).then((response) => response.json())
        .then((data) => {
            let sn = 1;
            if (!data) return;
            data.forEach((d) => {
                d.sn = sn++;
                let vin = d.vin;
                // let auth = Police(leats);
                d.actions = `
                <i class="btn btn-xs mdi mdi-view-dashboard text-primary lv ${_rw()} fs-2" vin=${vin}></i>
                <i class="btn btn-xs mdi mdi-view-dashboard-edit text-yellow le ${_rm()} fs-2" vin=${vin}></i>
                <i class="btn btn-xs mdi mdi-file-chart text-brown lr fs-2" vin=${vin}></i>`;
                if (d.status < 200) {
                    d.status = `<a href="javascript:void(0)" class="text-danger" ><i class="mdi mdi-shield-check fs-3"></i></a>`;
                } else {
                    d.status = `<a href="javascript:void(0)" class="text-brown" ><i class="fa mdi mdi-shield-check fs-3"></i></a>`
                }
                if (d.chowdeck > 0) {
                    d.chowdeck = `<a href="javascript:void(0)" class="text-brown" ><i class="mdi mdi-check-circle fs-3"></i> <span class="d-none">0</span></a>`;
                } 
                if (d.glovo > 0) {
                    d.glovo = `<a href="javascript:void(0)" class="text-brown" ><i class="mdi mdi-check-circle fs-3"></i><span class="d-none">0</span></a>`;
                }
                if (d.eden > 0) {
                    d.eden = `<a href="javascript:void(0)" class="text-brown" ><i class="mdi mdi-check-circle fs-3"></i><span class="d-none">0</span></a>`;
                } 
                if (d.take > 0) {
                    d.take = `<a href="javascript:void(0)" class="text-brown" ><i class="mdi mdi-check-circle fs-3"></i><span class="d-none">0</span></a>`;
                } 
            })
            console.log(data);
            const vends = document.querySelector('#vends');
            let dt = $('#vends').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'responsive': true,
                'autoWidth': false,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', className: 'dt-actions' },
                    { extend: 'pdf', className: 'dt-actions' },
                    { extend: 'print', className: 'dt-actions' }
                ],
                columns: [
                    { data: "sn"},
                    { data: "vendor"},
                    { data: "store" },
                    { data: "location" },
                    { data: "chowdeck" },
                    { data: "glovo" },
                    { data: "eden" },
                    { data: "take" },
                    { data: "actions" },
                ],
                'data': data,
            });
            vends.addEventListener('click', (e) => {
                let target = e.target;
                if (target.classList.contains('lv')) {
                    let vin = target.getAttribute('vin');
                    // location.href = `vendor?leat=${vin}`;
                    sessionStorage.setItem('vin', vin);
                    location.href = `vendor`;
                    // alert(vin);
                    
                }
                if (target.classList.contains('le')) {
                    let vin = target.getAttribute('vin');
                    sessionStorage.setItem('vin', vin);
                    location.href = `update`;
                }
                if (target.classList.contains('lr')) {
                    let vin = target.getAttribute('vin');
                    target.classList.add('fa-bounce');
                    target.disabled = true;
                    const url = 'applify/api.php';
                    let form = new FormData();
                    form.append('query', 'verify_invoice');
                    form.append('vin', vin);
                    fetch(url, {
                        method: 'POST',
                        body: form
                    }).then(response => response.text())
                        .then(data => {
                            console.log(data);
                            if (data == 200) {
                                sessionStorage.setItem('invoice', vin);
                                location.href = 'invoice';
                            } else {
                                toastr.error(`No report found for vendor.`, 'Info: No report');
                            }
                            target.classList.remove('fa-bounce');
                            target.disabled = true;
                    })
                }
            })
    })
}
// function NewVendor() {
//     const rel = document.querySelector('[rel="new-vendor"]');
//     if (!rel) return;
//     const addv = document.querySelector('.v-add');
//     let frm = document.querySelector('.vfa');
//     addv.addEventListener('click', () => {
//         addv.innerHTML = `<i class="fa-solid fa-cloud-arrow-up fa-bounce me-2"></i> Processing!`;
//         // addv.disabled = true;
//         let form = new FormData(frm); 
//         form.append('query', 'new-vendor')
//         let url = 'applify/api.php';
//         fetch(url, {
//             method: 'POST',
//             body: form
//         }).then((response) => response.json())
//             .then((json) => {
//                 console.log(json);
//                 let status = json.status;
//                 if (status == 200) {
//                     toastr.success(
//                       "Access was denied for this operation.",
//                       "No Authorization!"
//                     );
//                 }
//                  addv.innerHTML = `<i class="fa-solid fa-cloud-arrow-up me-2"></i> Add Vendor`;
//                  addv.disabled = false;
//         })
//     })
// }
function AddVendor() {
    const rel = document.querySelector('[rel="add-vendor"]');
    if (!rel) return;
    const btn_next = document.querySelector(".actions a[href$='#next']");
    const btn_prev = document.querySelector(".actions a[href$='#previous']");
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "none",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit",
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex === 0 && Step1() != 100) {
                return false;
            }
            console.log(currentIndex)
            return true;
        },
        // get onStepChanging() {
        //     return this._onStepChanging;
        // },
        // set onStepChanging(value) {
        //     this._onStepChanging = value;
        // },
        onFinished: function (event, currentIndex) {
            AddVendorWizard();
            // toastr.info(`Vendor added`, `Success!`);

        },
    });
}
function VendorMeta() {
    const rel = document.querySelector('[rel="vendor-meta"]');
    if (!rel) return;
    let param = sessionStorage.getItem('vin');
    if (!param) location.replace('vendors');
    const meta = document.querySelector('.meta');
    const update = document.querySelector('[role="update"]');
    const sub = document.querySelector('.meta-sub');
    update.addEventListener('click', (e) => {
        location.href = `update`;
    })
    let form = new FormData();
    form.append('query', 'vendor-meta');
    form.append('param', param);
    let url = 'applify/api.php';
    fetch(url, {
        method: 'POST',
        body: form
    }).then(response => response.json())
        .then(json => {
            console.log(json);
            let v = `<i class="mdi mdi-shield-account fs-5 text-red"></i><span class="text-brown mx-5">Vendor Identification Number - ${json.vin}</span>`;
            let c = '';
            let g = '';
            let e = '';
            let t = '';
            if (json.chowdeck != '') {
                c = `<span class="text-brown mx-5"> ~</span>`+json.chowdeck_cir+`%`;
            }
            if (json.glovo != '') {
                g = `<span class="text-brown mx-5"> ~</span>`+json.glovo_cir+`%`;
            }
            if (json.eden != '') {
                e = `<span class="text-brown mx-5"> ~</span>`+json.eden_cir+`%`;
            }
            if (json.take != '') {
                t = `<span class="text-brown mx-5"> ~</span>`+json.take_cir+`%`;
            }
            let body = `
            <tr><td class="col-3 fw-bold">Vendor's Name:</td><td class="col-9">${json.name}</td></tr>
            <tr><td class="col-3 fw-bold">Gender:</td><td>${json.gender.charAt(0).toUpperCase() + json.gender.slice(1)}</td></tr>
            <tr><td class="col-3 fw-bold">Phone:</td><td>${json.phone}</td></tr>
            <tr><td class="col-3 fw-bold">Email:</td><td>${json.email}</td></tr>
            <tr><td class="col-3 fw-bold">Store:</td><td>${json.store}</td></tr>
            <tr><td class="col-3 fw-bold">Location:</td><td>${json.address}</td></tr>
            <tr><td class="col-3 fw-bold">Chowdeck:</td><td>${json.chowdeck} <span class="mx-3 text-red">${c}</span></td></tr>
            <tr><td class="col-3 fw-bold">Glovo:</td><td>${json.glovo} <span class="mx-30 text-red">${g}</span></td></tr>
            <tr><td class="col-3 fw-bold">Eden Life:</td><td>${json.eden} <span class="mx-30 text-red">${e}</span></td></tr>
            <tr><td class="col-3 fw-bold">Take:</td><td>${json.take} <span class="mx-30 text-red">${t}</span></td></tr>
            <tr><td class="col-3 fw-bold">Manager:</td><td>${json.account_manager}</td></tr>
            <tr><td class="col-3 fw-bold">Bank:</td><td>${json.bank}</td></tr>
            <tr><td class="col-3 fw-bold">Account Number:</td><td>${json.account}</td></tr>
            `;
            sub.innerHTML = v;
            meta.innerHTML = body;
    })
}
function GetMeta() {
    const rel = document.querySelector('[rel="vendor-update"]');
    if (!rel) return;
    let param = sessionStorage.getItem('vin');
    if (!param) location.replace('vendors');
    const sub = document.querySelector('.meta-sub');
    let vendor = document.querySelector('[name="v-name"]');
    let phone = document.querySelector('[name="v-phone"]');
    let email = document.querySelector('[name="v-email"]');
    let chowdeck = document.querySelector('[name="v-chowdeck"]');
    let glovo = document.querySelector('[name="v-glovo"]');
    let eden = document.querySelector('[name="v-eden"]');
    let take = document.querySelector('[name="v-localeat"]');
    let chow_cir = document.querySelector('[name="v-chowdeck-cir"]');
    let glovo_cir = document.querySelector('[name="v-glovo-cir"]');
    let eden_cir = document.querySelector('[name="v-eden-cir"]');
    let take_cir = document.querySelector('[name="v-localeat-cir"]');
    let bank = document.querySelector('[name="v-bank"]');
    let account = document.querySelector('[name="v-bank-number"]');
    let manager = document.querySelector('[name="v-manager"]');
    let form = new FormData();
    form.append('query', 'get-meta');
    form.append('param', param);
    let url = 'applify/api.php';
    fetch(url, {
        method: 'POST',
        body: form
    }).then(response => response.json())
        .then(json => {
            console.log(json);
            if (json.err > 0) {
                location.replace('vendors');
            } else {
                let data = json.data;
                let v = `<i class="mdi mdi-shield-account fs-5 text-red"></i><span class="text-brown mx-5">Vendor Identification Number - ${data.vin}</span>`;
                vendor.value = data.name;
                phone.value = data.phone;
                email.value = data.email;
                chowdeck.value = data.chowdeck;
                glovo.value = data.glovo;
                eden.value = data.eden;
                take.value = data.take;
                chow_cir.value = data.chowdeck_cir;
                glovo_cir.value = data.glovo_cir;
                eden_cir.value = data.eden_cir;
                take_cir.value = data.take_cir;
                bank.value = data.bank;
                account.value = data.account;
                manager.value = data.account_manager;
                sub.innerHTML = v;
            }
            
            
    })
}
function UpdateMeta() {
    const rel = document.querySelector('[rel="vendor-update"]');
    if (!rel) return;
    let meta = document.querySelector('.meta-u');
    const update = document.querySelector('[role="update-meta"]');
    const del = document.querySelector('[role="del-meta"]');    
    update.addEventListener('click', (e) => {
        let param = sessionStorage.getItem('vin');
        if (!param) location.replace('vendors');
        let form = new FormData(meta);
        let vendor = form.get('v-name');
        let phone = form.get('v-phone');
        let bank = form.get('v-bank');
        let bank_number = form.get('v-bank-number');
        let manager = form.get('v-manager');
        if ((vendor == '') || (phone == '') || (bank == '') || (bank_number == '') || (manager == '')) {
            toastr.error('Fields marked as (*) are required.', 'Error: Empty Fields.');
        } else {
            update.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Processing`;
            update.disabled = true;
            let url = 'applify/api.php';
            form.append('query', 'update-meta')
            form.append('param', param);
            fetch(url, {
                method: 'POST',
                body: form
            }).then((response) => response.text())
                .then((data) => {
                    console.log(data);
                    if (data == 100) {
                        toastr.error(`Vendor's data was not updated.`, `Error: Un-authorized request.`);
                    }
                    if (data == 200) {
                        toastr.error(`Fields marked (*) are required.`, `Error: Empty fields.`);
                    }
                    if (data == 300) {
                        toastr.error(`Vendor's data was not updated.`, `Error: Connection failed.`,);
                    }
                    if (data == 400) {
                        location.replace('vendors');
                    }
                    update.innerHTML = `Update`;
                    update.disabled = false;  
            })
        }
    })
    del.addEventListener('click', (e) => {
        let param = sessionStorage.getItem('vin');
        if (!param) return;
        del.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Processing`;
        del.disabled = true;
        const url = 'applify/api.php';
        let form = new FormData();
        form.append('query', 'del-vendor');
        form.append('param', param);
        fetch(url, {
            method: 'POST',
            body: form
        }).then((response) => response.text())
            .then((data) => {
                del.innerHTML = `Delete`;
                del.disabled = false;
                console.log(data);
                if (data == 100) {
                    toastr.errro(`Vendor was not deleted.`, `Error: Server.`);
                }
                if (data == 200) {
                    toastr.errro(`Vendor was not deleted.`, `Error: Operation denied`);
                }
                if (data == 400) {
                    location.replace('vendors');
                }
            })
    })   
}

function Platforms(){
    const rel = document.querySelector('[rel="platforms"]');
    if (!rel) return;
    const chow = document.querySelector('.p-chow');
    const glovo = document.querySelector('.p-glovo');
    const eden = document.querySelector('.p-eden');
    const take = document.querySelector('.p-take');
    chow.addEventListener('click', (e) => {
        e.preventDefault();
        location.href = 'chowdeck';
    })
    glovo.addEventListener('click', (e) => {
        e.preventDefault();
        location.href = 'glovo';
    })
    eden.addEventListener('click', (e) => {
        e.preventDefault();
        toastr.error(`This platform is not available at the moment.`, `Server: Offline.`);
        
    })
    take.addEventListener('click', (e) => {
        e.preventDefault();
        toastr.error(`This platform is not available at the moment.`, `Server: Offline.`);
    })
}
function Chowdeck() {
    const rel = document.querySelector('[rel=chowdeck');
    if (!rel) return;
    const cv = document.querySelector('.cv');
    const cod = document.querySelector('.cod');
    const query = document.querySelector('.query');
    const upload = document.querySelector('[role="upload"]');    
    const url = 'applify/api.php';
    let form = new FormData();
    form.append('query', 'c-vendors');
    upload.disabled = true;
    fetch(url, {
        method: 'POST',
        body: form
    }).then(response => response.json())
        .then(json => {
            console.log(json);
            let sn = 0;
            json.forEach((j) => {
                sn++;
                let sid = j.chowdeck;
                let store = j.store;
                let sloc = j.address;
                let info = `<span>${sn}. ${store}: ${sloc}</span>`;
                let option = `<option class="text-brown g-hover" value="${sid}">${info}</option>`;
                cv.innerHTML += option;
            })
        })
    query.addEventListener('click', () => {
        let vendor = cv.value;
        let order = cod.value;
        let err = 0;
        let form = new FormData();
        console.log(vendor);
        if (vendor == '#') {
            err = 1;
            toastr.error('No vendor specified for chowdeck.', 'Error: No Vendor');
        }else if (order == '') {
            err = 2;
            toastr.error('Provide Order ID(s) for selected vendor.', 'Error: No Order ID');
        }
        if (err == 0) {
            form.append('vendor', vendor);
            form.append('order', order);
            form.append('query', 'q-chow');
            fetch(url, {
                method: 'POST',
                body: form
            }).then(response => response.json())
                .then(data => {
                    console.log(data);
            })
        }
        
    })
    
}
function Glovo() {
    const rel = document.querySelector('[rel="glovo"]');
    if (!rel) return;
    const gs = document.querySelector('.gs');
    const gv = document.querySelector('.gv');
    const upload = document.querySelector('[role="upload"]');
    const select = document.querySelector('[name="gv"]');
    const url = 'applify/api.php';
    let form = new FormData();
    form.append('query', 'g-vendors');
    upload.disabled = true;
    fetch(url, {
        method: 'POST',
        body: form
    }).then(response => response.json())
        .then(json => {
            console.log(json);
            let sn = 0;
            json.forEach(j => {
                sn++;
                // let vin = j.vin;
                let sid = j.glovo;
                let store = j.store;
                let sloc = j.address;
                let info = `<span>${sn}. ${store}: ${sloc}</span>`;
                let option = `<option class="text-brown g-hover" value="${sid}">${info}</option>`;
                select.innerHTML += option;
            })
    })
    gs.addEventListener('change', () => {
        if (gs.files.length > 0) {
            const file = gs.files[0];
            let ft = file.type;
            if (ft != 'text/csv') {
                toastr.error(`Please select a valid csv file for Glovo.`, `Error: Invalid file type`);
            } else {
                let form = new FormData();
                form.append('query', 'guid');
                form.append('csv', file);
                fetch(url, {
                    method: 'POST',
                    body: form
                }).then((response) => response.json())
                .then((json) => {
                    console.log(json);
                    let rows = json.rows;
                    let errors = json.errors;
                    if (errors.length > 0) {
                        let err = '';
                        errors.forEach((e) => {
                            err += `"${e}"` + `, `;
                        })
                        toastr.error(`Mismatch found on: ${err}.`, `Error: Column mismatch.`)
                    } else if ((rows) && (rows.length == 0)) {
                        toastr.error('No rows found in file', 'Error: Empty file.');
                    }  
                    if((rows) && (rows.length > 0)){
                        let sn = 1;
                        rows.forEach((j) => {
                            j.sn = sn++;
                        })
                        if ($.fn.DataTable.isDataTable('#gt')) {
                            $('#gt').DataTable().clear().destroy();
                        }
                        let dt = new $('#gt').DataTable({
                            'paging'      : true,
                            'lengthChange': true,
                            'searching'   : true,
                            'ordering'    : true,
                            'info'        : true,
                            'responsive': true,
                            'autoWidth': false,
                            dom: 'Bfrtip',
                            buttons: [
                                // { extend: 'copy', className: 'dt-actions' },
                                // { extend: 'csv', className: 'dt-actions' },
                                { extend: 'excel', className: 'dt-actions' },
                                { extend: 'pdf', className: 'dt-actions' },
                                { extend: 'print', className: 'dt-actions' }
                            ],
                            columns: [
                                { data: "sn"},
                                { data: "code"},
                                { data: "description" },
                                { data: "amount" },
                                { data: "glovo_fee" },
                                { data: "total" },
                                { data: "creation_time" },
                            ],
                            'data': rows,
                        });
                        upload.disabled = false;
                    }
                    upload.addEventListener('click', () => {
                        let vendor = gv.value;
                        let net = 0;
                        if (vendor == '#') {
                            net++;
                            toastr.error(`Please select a glovo vendor.`, `Error: No Vendor`);
                        }
                        if (rows.length < 0) {
                            net++;
                            toastr.error(`No record found to be updated.`, `Error: Empty Record`);
                        }
                        if (net == 0) {
                            const body = {
                                vendor: vendor,
                                rows: rows
                            }
                            upload.innerHTML = `Reporting... <i class="fa fa-spinner fa-spin"></i>`
                            upload.disabled = true;
                            const url = 'applify/api.php';
                            let form = new FormData();
                            let json = JSON.stringify(body);
                            form.append('body', json);
                            form.append('query', 'glovo_report');
                            fetch(url, {
                                method: 'POST',
                                body: form,
                            }).then((response) => response.json())
                                .then((data) => {
                                    upload.disabled = false;
                                    upload.innerHTML = `Report`;
                                    console.log(data);
                                    if (data.status == 100) {
                                        toastr.error(`No report was found.`, `Error!`)
                                    }
                                    if (data.status == 300) {
                                        toastr.error(`${data.record} records were not updated.`, `Info: Duplicates`)
                                    }
                                    if (data.status == 400) {
                                        toastr.success(`Report was updated successfully.`, `Success!`)
                                    }
                            })
                        }
                    })
                })
            }
        } else {
            toastr.error(`Please select a valid csv file for Glovo.`, `Error: No file selected.`);
        }
    })
}

function Reports() {
    const rel = document.querySelector('[rel="reports"]');
    if (!rel) return;
    const range = document.querySelector('#reservation');
    const go = document.querySelector('.go-range');
    let initialRange = InitialRange();
    console.log(initialRange);
    range.value = initialRange;
    let form = new FormData();
    form.append('query', 'report-r');
    form.append('range', initialRange);
    MakeReport(form);
    go.addEventListener('click', () => {
        let date = range.value;
        let form = new FormData();
        form.append('query', 'report-r');
        form.append('range', date);
        MakeReport(form);
    })    
}
function GenerateInvoice() {
    const rel = document.querySelector('[rel="invoice"]');
    if (!rel) return;
    if (!sessionStorage.getItem('invoice')) {
        toastr.error(`No vendor provided. Please select a vendor.`, `Error: Vendor not found`);
        setTimeout(() => {
            location.replace('vendors');
        }, 3500);
    }
    const gen = document.querySelector('[role="giv"]');
    let vin = sessionStorage.getItem('invoice');
    const url = 'applify/api.php';
    const store = document.querySelector('[name="store"]');
    const address = document.querySelector('[name="location"]');
    const manager = document.querySelector('[name="name"]');
    const start = document.querySelector('[name="start"]');
    const fin = document.querySelector('[name="fin"]');
    const max = new Date().toISOString().split('T')[0];
    start.max = max;
    fin.max = max;
    let form = new FormData();
    form.append('query', 'set-report');
    form.append('vin', vin);
    gen.disabled = true;
    fetch(url, {
        method: 'POST',
        body: form
    }).then(response => response.json())
        .then(json => {
            console.log(json);
            if (json) {
                store.value = json.store;
                address.value = json.address;
                manager.value = json.name
                gen.disabled = false;
            }
        })
    gen.addEventListener('click', () => {
        let range1 = start.value;
        let range2 = fin.value;
        if (range1.length && range2.length) {
            gen.disabled = true;
            let form = new FormData();
            form.append('query', 'make-invoice');
            form.append('start', range1);
            form.append('fin', range2);
            form.append('vin', vin);
            fetch(url, {
                method: 'POST',
                body: form
            }).then((response) => response.text())
                .then(data => {
                    console.log(data);
                    if (data = 100) {
                        toastr.error(`No reports were found for this date range.`, `Error: No report`);
                    }
                    if (data = 200) {
                        location.replace('localeats-invoice');
                    }
                    gen.disabled = false;
            })
        } else {
            toastr.error(`Please select a date range to generate.`, `Error: Invalid date range`);
        }
    })
}

function ShowInvoice() {
    const rel = document.querySelector('[rel="receipt"]');
    if (!rel) return;
    const url = 'applify/api.php';
    const today = document.querySelector('.today');
    const store = document.querySelector('.store');
    const address = document.querySelector('.address');
    const phone = document.querySelector('.phone');
    const email = document.querySelector('.email');
    const vin = document.querySelector('.vin');
    const name = document.querySelector('.name');
    const date = document.querySelector('.date');
    const manager = document.querySelector('.manager');
    const items = document.querySelector('.items');
    const tcir = document.querySelector('.tcir');
    const gross = document.querySelector('.gross');
    const net = document.querySelector('.net');
    let form = new FormData();
    form.append('query', 'shi');
    fetch(url, {
        method: 'POST',
        body: form
    }).then((response) => response.json())
        .then(json => {
            console.log(json);
            today.textContent = moment().format('ll');
            let vendor = json.vendor;
            let data = json.data;
            let status = json.status;
            if (status == 100) {
                location.replace('vendors');
            }
            store.textContent = vendor.store;
            address.textContent = vendor.address;
            phone.textContent = vendor.phone;
            email.textContent = vendor.email;
            vin.textContent = vendor.vin;
            name.textContent = vendor.name;
            // date.textContent = vendor.date;
            manager.textContent = vendor.account_manager;
            let sn = 0;
            let rows = '';
            let value = 0;
            let g = 0;
            let n = 0;
            let c = 0;
            data.forEach(row => {
                row.sn = ++sn;
                let items = `<tr>
				  <td>${row.sn}</td>
				  <td>${row.order_id}</td>
				  <td>${row.item}</td>
				  <td class="text-end">${row.partner}</td>
				  <td class="text-end">${row.amount}</td>
				  <td class="text-end">${row.cir}</td>
				  <td class="text-end">${row.value}</td>
				  <td class="text-end">${row.date}</td>
				</tr>`;
                rows += items;
                value += row.value
                g += parseInt(row.amount);
                n += parseInt(row.value)
                c += parseInt(row.cir);
            });
            items.innerHTML = rows;
            gross.textContent = '₦'+ g;
            net.textContent = '₦' + n;
            tcir.textContent = '₦'+ c;
    })
}


// UTILITIES
function CapWords(str) {
  let words = str.split(" ");
  for (let i = 0; i < words.length; i++) {
    words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
  }
  return words.join(" ");
}
function UserRole(role) {
    if (role == 100) {
        location.replace('index');
    }
    if (role == 200) {
        return 'Representative';
    }
    if (role == 300) {
        return 'Administrator';
    }
    if (role == 400) {
        return 'Manager';
    }
    // if(role == )
}
function LoadParticles() {
    const p = document.querySelector("#particles-js");
    if (!p) return;
    let json = ParticlesJSON();
    console.log(json);
    particlesJS.load("particles-js", "../js/particles.json", function () {
      console.log("callback - particles.js config loaded");
    });
}
function validateEmail(email) {
    // Regular expression for validating email addresses
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Test the email against the regular expression
    return emailRegex.test(email);
}
function validatePhone(phoneNumber) {
    // Regular expression for validating a 10-digit phone number
    var phoneRegex = /^\d{7,15}$/;
    // Test the phone number against the regular expression
    return phoneRegex.test(phoneNumber);
}
function Step1() {
    let kyc = document.querySelector('.vendor-kyc');
    let form = new FormData(kyc);
    let name = form.get('v-name');
    let gender = form.get('v-gender');
    let phone = form.get('v-phone');
    let email = form.get('v-email');
    let store = form.get('v-store');
    let location = form.get('v-location');
    let err = 100;
    if (name.trim() == '' && gender == '' && phone == '' && store == '' && location == '') {
        err = 101;
    } else
    if (name.trim() == '') {
        err = 102;
    }
    if (gender == '') {
        err = 103;
    }
    if (phone == '') {
        err = 104;
    } else if (!validatePhone(phone)) {
        err = 105;
    }
    if (email != '' && !validateEmail(email)) {
        err = 106;
    }
    if (store == '') {
        err = 107;
    }
    if (location == '') {
        err = 108;
    }
    console.log(err);
    if (err == 101 || err == 102 || err == 103 || err == 104 || err == 107 || err == 108) {
        toastr.error('Please fill out all required fields.', 'Error: Personal Information!');
    }
    if (err == 105) {
        toastr.error(`Please provide a valid phone number.`, 'Error: Personal Information!');
    }
    if (err == 106) {
         toastr.error(`Please provide a valid email address.`, 'Error: Personal Information!');
    }
    return err;
}
function AddVendorWizard() {
    let kyc = document.querySelector('.vendor-kyc');
    let form = new FormData(kyc);
    let url = 'applify/api.php';
    form.append('query', 'add-vendor');
    fetch(url, {
        method: 'POST',
        body: form
    }).then(request => request.json())
        .then(data => {
            console.log(data);
            if (data.status === 100) {
                toastr.error(`Vendor was not added.`, 'Error: No Authorization!');
            }
            if (data.status === 200) {
                toastr.error(`All fields marked (*) are required.`, 'Error: Personal Information!');
            }
            if (data.status === 300) {
                toastr.error(`No platform registered for vendor.`, 'Error: Platform Information!');
            }
            if (data.status === 500) {
                toastr.info(`Vendor was added successfully.`, 'Success: Vendor Added!');
                setTimeout(() => {
                    location.replace('vendors');
                }, 4000);
            }
    })
}
function InitialRange() {
    let today = moment();
    let oneYearAgo = moment().subtract(1, 'years');
    let formattedToday = today.format('MM/DD/YYYY');
    let formattedOneYearAgo = oneYearAgo.format('MM/DD/YYYY');
    let dateRange = `${formattedOneYearAgo} - ${formattedToday}`;
    return dateRange;
}

function MakeReport(form) {
    const url = 'applify/api.php';
    const rel = document.querySelector('#reports');
    fetch(url, {
        method: 'POST',
        body: form
    }).then(response => response.json())
        .then(json => {
            console.log(json);
            let sn = 0;
            json.forEach((j) => {
                j.sn = ++sn;
                let record = j.id;
                let order = j.order_id;
                let date = moment(j.date).format('lll');
                j.date = date;
                j.action = `<i class="btn btn-xs mdi mdi-delete text-red dr ${_rw()} fs-2" vin=${record} order=${order}></i>`;
            })

            if ($.fn.DataTable.isDataTable('#reports')) {
                $('#reports').DataTable().destroy();
            }
            let dt = new $('#reports').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'responsive': true,
                'autoWidth': false,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', className: 'dt-actions' },
                    { extend: 'pdf', className: 'dt-actions' },
                    { extend: 'print', className: 'dt-actions' }
                ],
                columns: [
                    { data: "sn" },
                    { data: "order_id" },
                    { data: "item" },
                    { data: "total" },
                    { data: "partner" },
                    { data: "fee" },
                    { data: "cir" },
                    { data: "value" },
                    { data: "date" },
                    { data: "action" },
                ],
                'data': json,
            });
            rel.addEventListener('click', (e) => {
                let target = e.target;
                if (target.classList.contains('dr')) {
                    let vin = target.getAttribute('vin');
                    let order = target.getAttribute('order');
                    swal({   
                    title: "Are you sure?",   
                    text: `${order}: You will not be able to undo this operation!`,   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Yes, delete it!",   
                    closeOnConfirm: false 
                    }, function () {  
                        let form = new FormData();
                        form.append('query', 'report-d');
                        form.append('order', order);
                        fetch(url, {
                            method: 'POST',
                            body: form
                        }).then(response => response.text())
                            .then(data => {
                                console.log(data);
                                if (data == 200) {
                                    let index = 0;
                                    json.forEach((j) => {
                                        if (j.order_id == order) {
                                            index = json.indexOf(j);
                                        }
                                    })
                                    if (index > -1) {
                                        json = json.slice(0, index).concat(json.slice(index + 1));
                                        dt.clear().rows.add(json).draw();
                                    }
                                    swal("Deleted!", "Order has been deleted permanently.", "success");
                                } else {
                                    toastr.error(`Report failed to delete.`, `Error: ${order}`)
                                }
                        })
                });
                }
            })
        });
}
 

function _ro() {
    let leat = localStorage.getItem('leats');
    if (leat == 200) {
        return 'no-leats';
    }
    return leat;
}
function _rw() {
    let leat = localStorage.getItem('leats');
    if (leat < 300) {
        return 'no-leats';
    }
    return leat;
}
function _rm() {
    let leat = localStorage.getItem('leats');
    if (leat < 400) {
        return 'no-leats';
    }
    return leat;
}
function GetURLParam(param) {
    const url = window.location.href;
    const urlObj = new URL(url);
    const params = new URLSearchParams(urlObj.search);
    return params.get(param);
}
function csvToJson(csv) {
    const lines = csv.split('\n');
    const result = [];
    const headers = lines[0].split(',');

    for (let i = 1; i < lines.length; i++) {
        const obj = {};
        const currentline = lines[i].split(',');

        if (currentline.length === headers.length) {
            for (let j = 0; j < headers.length; j++) {
                obj[headers[j].trim()] = currentline[j].trim();
            }
            result.push(obj);
        }
    }

    return result;
}


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>FitLife Center - Sistema</title>
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-light: #dbeafe;
      --bg: #0f172a;
      --card-bg: #0b1120;
      --text-main: #e5e7eb;
      --text-muted: #9ca3af;
      --border-soft: #1f2937;
      --danger: #ef4444;
      --success: #22c55e;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      margin: 0;
      padding: 0;
      background: radial-gradient(circle at top, #1d4ed8 0, #020617 55%);
      color: var(--text-main);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .app-wrapper {
      width: 100%;
      max-width: 1100px;
      margin: 24px;
    }

    h1, h2, h3 {
      margin: 0 0 10px 0;
      font-weight: 600;
    }

    h1 {
      font-size: 26px;
    }

    h2 {
      font-size: 20px;
    }

    h3 {
      font-size: 16px;
    }

    .card {
      background: rgba(15,23,42,0.95);
      border-radius: 14px;
      border: 1px solid rgba(148,163,184,0.25);
      padding: 18px 20px;
      box-shadow: 0 18px 40px rgba(15,23,42,0.9);
      backdrop-filter: blur(10px);
    }

    .card + .card {
      margin-top: 16px;
    }

    .hidden { display: none; }

    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 12px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-circle {
      width: 32px;
      height: 32px;
      border-radius: 999px;
      background: linear-gradient(145deg, #38bdf8, #2563eb);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 16px;
      font-weight: 700;
      box-shadow: 0 0 18px rgba(37,99,235,0.7);
    }

    .brand-title {
      display: flex;
      flex-direction: column;
    }

    .brand-title span:first-child {
      font-size: 16px;
      font-weight: 600;
    }

    .brand-title span:last-child {
      font-size: 11px;
      color: var(--text-muted);
    }

    .user-info {
      font-size: 13px;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .pill {
      padding: 3px 8px;
      border-radius: 999px;
      background: rgba(37,99,235,0.14);
      color: #bfdbfe;
      font-size: 11px;
      border: 1px solid rgba(37,99,235,0.5);
    }

    .btn {
      border: none;
      border-radius: 999px;
      padding: 7px 14px;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.18s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      box-shadow: 0 10px 25px rgba(37,99,235,0.45);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 30px rgba(37,99,235,0.6);
    }

    .btn-outline {
      background: transparent;
      color: var(--text-main);
      border: 1px solid var(--border-soft);
    }

    .btn-outline:hover {
      background: rgba(15,23,42,0.8);
    }

    .btn-danger {
      background: rgba(239,68,68,0.12);
      color: #fecaca;
      border: 1px solid rgba(248,113,113,0.45);
    }

    .btn-danger:hover {
      background: rgba(239,68,68,0.22);
    }

    .btn-small {
      padding: 4px 10px;
      font-size: 11px;
    }

    .btn:disabled {
      opacity: 0.35;
      cursor: not-allowed;
      box-shadow: none;
      transform: none;
    }

    input, select {
      margin: 3px 0 8px 0;
      padding: 7px 10px;
      width: 260px;
      border-radius: 9px;
      border: 1px solid var(--border-soft);
      background: #020617;
      color: var(--text-main);
      font-size: 13px;
      outline: none;
      transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }

    input:focus, select:focus {
      border-color: #60a5fa;
      box-shadow: 0 0 0 1px rgba(96,165,250,0.7);
      background: #020617;
    }

    label {
      font-size: 12px;
      color: var(--text-muted);
    }

    .error {
      color: #fecaca;
      font-size: 12px;
      margin-top: 4px;
    }

    .ok {
      color: #bbf7d0;
      font-size: 12px;
      margin-top: 4px;
    }

    .menu {
      margin-top: 10px;
      margin-bottom: 6px;
      border-radius: 999px;
      background: rgba(15,23,42,0.9);
      display: inline-flex;
      padding: 4px;
      border: 1px solid rgba(148,163,184,0.35);
    }

    .menu button {
      padding: 7px 14px;
      border-radius: 999px;
      border: none;
      background: transparent;
      color: var(--text-muted);
      font-size: 13px;
      cursor: pointer;
      transition: all 0.18s ease;
    }

    .menu button:hover {
      background: rgba(15,23,42,0.9);
      color: var(--text-main);
    }

    .menu button.active {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      box-shadow: 0 10px 25px rgba(37,99,235,0.5);
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 10px;
      background: rgba(15,23,42,0.85);
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid rgba(31,41,55,0.9);
    }

    thead {
      background: linear-gradient(135deg, rgba(37,99,235,0.9), rgba(30,64,175,0.9));
    }

    th, td {
      padding: 8px 10px;
      font-size: 12px;
    }

    th {
      text-align: left;
      color: #e5e7eb;
      border-bottom: 1px solid rgba(15,23,42,0.3);
      position: sticky;
      top: 0;
      z-index: 1;
    }

    tbody tr:nth-child(odd) {
      background: rgba(15,23,42,0.9);
    }

    tbody tr:nth-child(even) {
      background: rgba(15,23,42,0.6);
    }

    tbody tr:hover {
      background: rgba(30,64,175,0.45);
    }

    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 999px;
      font-size: 11px;
    }

    .badge-activa {
      background: rgba(34,197,94,0.16);
      color: #bbf7d0;
      border: 1px solid rgba(34,197,94,0.55);
    }

    .badge-suspendida {
      background: rgba(234,179,8,0.16);
      color: #fef9c3;
      border: 1px solid rgba(234,179,8,0.55);
    }

    .badge-vencida {
      background: rgba(248,113,113,0.16);
      color: #fecaca;
      border: 1px solid rgba(248,113,113,0.55);
    }

    .badge-cancelada {
      background: rgba(148,163,184,0.16);
      color: #e5e7eb;
      border: 1px solid rgba(148,163,184,0.5);
    }

    .section-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
    }

    .section-subtitle {
      font-size: 12px;
      color: var(--text-muted);
    }

    .login-hint {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 6px;
    }
  </style>
</head>
<body>
<div class="app-wrapper">
  <div class="card">
    <div class="header">
      <div class="brand">
        <div class="logo-circle">F</div>
        <div class="brand-title">
          <span>FitLife Center</span>
          <span>Módulo de Membresías</span>
        </div>
      </div>
      <div class="user-info">
        <span id="infoUser" class="hidden">
          <span>Sesión:</span>
          <span class="pill"><span id="lblUser"></span> · <span id="lblRol"></span></span>
        </span>
        <button class="btn btn-outline btn-small hidden" id="btnLogout" onclick="logout()">Salir</button>
      </div>
    </div>

    <!-- ============== LOGIN ============== -->
    <div id="login-box">
      <h2>Iniciar sesión</h2>
      <p class="section-subtitle">Use alguno de los usuarios de prueba o uno creado por el administrador.</p>
      <input type="text" id="username" placeholder="Usuario">
      <br>
      <input type="password" id="password" placeholder="Contraseña">
      <br>
      <button class="btn btn-primary" onclick="login()">Ingresar</button>
      <p id="login-error" class="error"></p>
      <p class="login-hint">
        Según el rol podrá: recepcionista (crear/listar), supervisor (modificar activas o suspendidas),
        administrador (cancelar, reactivar y administrar usuarios/auditoría).
      </p>
    </div>

    <div id="app" class="hidden">
      <!-- MENÚ PRINCIPAL -->
      <div class="menu">
        <button id="menu-membresias" onclick="showSection('membresias')">Membresías</button>
        <button id="menu-usuarios" onclick="showSection('usuarios')">Usuarios</button>
        <button id="menu-auditoria" onclick="showSection('auditoria')">Auditoría</button>
      </div>

      <!-- =================== SECCIÓN MEMBRESÍAS =================== -->
      <div id="section-membresias">
        <div class="section-title">
          <div>
            <h2>Módulo de Membresías</h2>
            <p class="section-subtitle">
              Gestión de membresías con validaciones, auditoría y control por roles.
            </p>
          </div>
          <button id="btnCrear" class="btn btn-primary btn-small" onclick="toggleFormCrear()">
            + Crear membresía
          </button>
        </div>

        <div id="form-crear" class="hidden card" style="margin-top:10px; background:rgba(15,23,42,0.9);">
          <h3>Nueva membresía</h3>
          <p class="section-subtitle">Campos obligatorios y validaciones en backend (código único, fechas, monto, teléfono).</p>

          <input id="codigo" placeholder="Código de membresía"><br>
          <input id="nombre_cliente" placeholder="Nombre del cliente"><br>

          <label>Tipo de membresía</label><br>
          <select id="tipo">
            <option value="mensual">Mensual</option>
            <option value="trimestral">Trimestral</option>
            <option value="anual">Anual</option>
          </select><br>

          <label>Fecha inicio</label><br>
          <input type="date" id="fecha_inicio"><br>

          <label>Fecha vencimiento</label><br>
          <input type="date" id="fecha_vencimiento"><br>

          <input id="monto_pagado" placeholder="Monto pagado" type="number" step="0.01"><br>
          <input id="metodo_pago" placeholder="Método de pago"><br>
          <input id="telefono" placeholder="Teléfono de contacto"><br>

          <button class="btn btn-primary btn-small" onclick="crearMembresia()">Guardar</button>
          <button class="btn btn-outline btn-small" type="button" onclick="toggleFormCrear()">Cancelar</button>
          <p id="crear-msg" class="error"></p>
        </div>

        <h3 style="margin-top:16px;">Listado de membresías</h3>
        <table id="tbl">
          <thead>
          <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Inicio</th>
            <th>Vence</th>
            <th>Estado</th>
            <th>Días restantes</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- =================== SECCIÓN USUARIOS (SOLO ADMIN) =================== -->
      <div id="section-usuarios" class="hidden">
        <div class="section-title">
          <div>
            <h2>Gestión de usuarios</h2>
            <p class="section-subtitle">
              Solo el administrador puede crear usuarios y asignar roles.
            </p>
          </div>
        </div>

        <div class="card" style="background:rgba(15,23,42,0.9);">
          <h3>Crear usuario</h3>
          <input id="u_username" placeholder="Nombre de usuario"><br>
          <input id="u_password" type="password" placeholder="Contraseña"><br>

          <label>Rol</label><br>
          <select id="u_rol">
            <option value="recepcionista">Recepcionista</option>
            <option value="supervisor">Supervisor</option>
            <option value="administrador">Administrador</option>
          </select><br>

          <button class="btn btn-primary btn-small" onclick="crearUsuario()">Crear usuario</button>
          <p id="u_msg" class="error"></p>
        </div>

        <h3 style="margin-top:16px;">Usuarios existentes</h3>
        <table id="tblUsuarios">
          <thead>
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Rol</th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- =================== SECCIÓN AUDITORÍA (SOLO ADMIN) =================== -->
      <div id="section-auditoria" class="hidden">
        <div class="section-title">
          <div>
            <h2>Auditoría de acciones</h2>
            <p class="section-subtitle">
              Registro de quién hizo qué y cuándo (creación, modificación, cancelación, reactivación).
            </p>
          </div>
        </div>

        <table id="tblAuditoria">
          <thead>
          <tr>
            <th>ID</th>
            <th>Fecha/Hora</th>
            <th>Usuario</th>
            <th>Membresía</th>
            <th>Acción</th>
            <th>Detalle</th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<script>
let rolActual = null;
let usernameActual = null;

/* ============= LOGIN / LOGOUT ============= */

function login() {
  const data = {
    username: document.getElementById('username').value,
    password: document.getElementById('password').value
  };

  fetch('login.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(r => {
    if (!r.ok) throw r;
    return r.json();
  })
  .then(res => {
    rolActual = res.rol;
    usernameActual = res.username || data.username;

    document.getElementById('lblUser').innerText = usernameActual;
    document.getElementById('lblRol').innerText = rolActual;
    document.getElementById('infoUser').classList.remove('hidden');
    document.getElementById('btnLogout').classList.remove('hidden');

    document.getElementById('login-box').classList.add('hidden');
    document.getElementById('app').classList.remove('hidden');

    ajustarUIporRol();
    showSection('membresias');  // sección por defecto
    cargarMembresias();
    if (rolActual === 'administrador') {
      cargarUsuarios();
      cargarAuditoria();
    }
  })
  .catch(async err => {
    let msg = 'Error de login';
    try { const j = await err.json(); msg = j.error || msg; } catch(e){}
    document.getElementById('login-error').innerText = msg;
  });
}

function logout() {
  fetch('logout.php')
    .then(() => location.reload());
}

/* ============= MENÚ Y VISIBILIDAD POR ROL ============= */

function ajustarUIporRol() {
  const btnCrear = document.getElementById('btnCrear');
  const menuUsuarios = document.getElementById('menu-usuarios');
  const menuAuditoria = document.getElementById('menu-auditoria');

  // Crear membresía: SOLO RECEPCIONISTA
  btnCrear.disabled = (rolActual !== 'recepcionista');

  // Menú Usuarios y Auditoría solo para ADMIN
  if (rolActual === 'administrador') {
    menuUsuarios.style.display = 'inline-block';
    menuAuditoria.style.display = 'inline-block';
  } else {
    menuUsuarios.style.display = 'none';
    menuAuditoria.style.display = 'none';
  }
}

function showSection(section) {
  // Ocultar todas
  document.getElementById('section-membresias').classList.add('hidden');
  document.getElementById('section-usuarios').classList.add('hidden');
  document.getElementById('section-auditoria').classList.add('hidden');

  // Quitar active del menú
  document.getElementById('menu-membresias').classList.remove('active');
  document.getElementById('menu-usuarios').classList.remove('active');
  document.getElementById('menu-auditoria').classList.remove('active');

  // Mostrar la elegida
  if (section === 'membresias') {
    document.getElementById('section-membresias').classList.remove('hidden');
    document.getElementById('menu-membresias').classList.add('active');
    cargarMembresias();
  } else if (section === 'usuarios' && rolActual === 'administrador') {
    document.getElementById('section-usuarios').classList.remove('hidden');
    document.getElementById('menu-usuarios').classList.add('active');
    cargarUsuarios();
  } else if (section === 'auditoria' && rolActual === 'administrador') {
    document.getElementById('section-auditoria').classList.remove('hidden');
    document.getElementById('menu-auditoria').classList.add('active');
    cargarAuditoria();
  } else {
    // fallback a membresías si no tiene permiso
    document.getElementById('section-membresias').classList.remove('hidden');
    document.getElementById('menu-membresias').classList.add('active');
  }
}

/* ============= MEMBRESÍAS ============= */

function toggleFormCrear() {
  document.getElementById('form-crear').classList.toggle('hidden');
}

function crearMembresia() {
  const data = {
    codigo: document.getElementById('codigo').value,
    nombre_cliente: document.getElementById('nombre_cliente').value,
    tipo: document.getElementById('tipo').value,
    fecha_inicio: document.getElementById('fecha_inicio').value,
    fecha_vencimiento: document.getElementById('fecha_vencimiento').value,
    monto_pagado: document.getElementById('monto_pagado').value,
    metodo_pago: document.getElementById('metodo_pago').value,
    telefono: document.getElementById('telefono').value
  };

  fetch('membresias.php?action=create', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(r => {
    if (!r.ok) throw r;
    return r.json();
  })
  .then(res => {
    document.getElementById('crear-msg').classList.remove('error');
    document.getElementById('crear-msg').classList.add('ok');
    document.getElementById('crear-msg').innerText = 'Membresía creada correctamente';

    document.getElementById('form-crear').classList.add('hidden');
    cargarMembresias();
  })
  .catch(async err => {
    let msg = 'Error al crear';
    try { const j = await err.json(); msg = j.error || msg; } catch(e){}
    document.getElementById('crear-msg').classList.remove('ok');
    document.getElementById('crear-msg').classList.add('error');
    document.getElementById('crear-msg').innerText = msg;
  });
}

function cargarMembresias() {
  fetch('membresias.php?action=list')
    .then(r => r.json())
    .then(data => {
      const tbody = document.querySelector('#tbl tbody');
      tbody.innerHTML = '';
      data.forEach(m => {
        const tr = document.createElement('tr');

        const puedeEditar = (
          rolActual === 'supervisor' &&
          (m.estado === 'activa' || m.estado === 'suspendida')
        );
        const puedeCancelar = (rolActual === 'administrador' && m.estado !== 'cancelada');
        const puedeReactivar = (rolActual === 'administrador' && m.estado === 'suspendida');

        let badgeClass = 'badge-activa';
        if (m.estado === 'suspendida') badgeClass = 'badge-suspendida';
        else if (m.estado === 'vencida') badgeClass = 'badge-vencida';
        else if (m.estado === 'cancelada') badgeClass = 'badge-cancelada';

        tr.innerHTML = `
          <td>${m.codigo}</td>
          <td>${m.nombre_cliente}</td>
          <td>${m.tipo}</td>
          <td>${m.fecha_inicio}</td>
          <td>${m.fecha_vencimiento}</td>
          <td><span class="badge ${badgeClass}">${m.estado}</span></td>
          <td>${m.dias_restantes}</td>
          <td>
            <button class="btn btn-outline btn-small" ${puedeEditar ? '' : 'disabled'}
              onclick="editarMembresia(${m.id}, '${m.nombre_cliente}', '${m.tipo}', '${m.fecha_inicio}', '${m.fecha_vencimiento}', ${m.monto_pagado}, '${m.metodo_pago}', '${m.telefono}')">
              Editar
            </button>
            <button class="btn btn-danger btn-small" ${puedeCancelar ? '' : 'disabled'}
              onclick="cancelar(${m.id})">
              Cancelar
            </button>
            <button class="btn btn-primary btn-small" ${puedeReactivar ? '' : 'disabled'}
              onclick="reactivar(${m.id})">
              Reactivar
            </button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    });
}

// Para simplificar, al editar usamos prompt()
let editRowId = null;

function editarMembresia(id, nombre, tipo, inicio, venc, monto, metodo, tel) {
    if (rolActual !== 'supervisor') return;

    // Cancelar si ya hay una fila en edición
    if (editRowId !== null) {
        alert("Primero guarda o cancela la edición anterior.");
        return;
    }
    editRowId = id;

    const row = [...document.querySelectorAll('#tbl tbody tr')]
        .find(tr => tr.children[0].innerText === id.toString() || tr.innerHTML.includes(`(${id},`));

    if (!row) return;

    row.dataset.originalHTML = row.innerHTML;

    row.innerHTML = `
        <td>${id}</td>
        <td><input id="edit_nombre" value="${nombre}"></td>
        <td>${tipo}</td>
        <td>${inicio}</td>
        <td>${venc}</td>
        <td>${row.children[5].innerHTML}</td>
        <td>${row.children[6].innerText}</td>
        <td>
            <input id="edit_monto" type="number" value="${monto}" step="0.01" style="width:90px;">
            <input id="edit_tel" value="${tel}" style="width:110px;">
            <button class="btn btn-primary btn-small" onclick="guardarEdicion(${id}, '${tipo}', '${inicio}', '${venc}', '${metodo}')">Guardar</button>
            <button class="btn btn-outline btn-small" onclick="cancelarEdicion(${id})">Cancelar</button>
        </td>
    `;
}

function cancelarEdicion(id) {
    const row = [...document.querySelectorAll('#tbl tbody tr')].find(tr => tr.dataset.originalHTML);
    if (!row) return;

    row.innerHTML = row.dataset.originalHTML;
    delete row.dataset.originalHTML;
    editRowId = null;
}

function guardarEdicion(id, tipo, inicio, venc, metodo) {
    const nuevoNombre = document.getElementById("edit_nombre").value;
    const nuevoMonto = parseFloat(document.getElementById("edit_monto").value);
    const nuevoTel = document.getElementById("edit_tel").value;

    const data = {
        id: id,
        nombre_cliente: nuevoNombre,
        tipo: tipo,
        fecha_inicio: inicio,
        fecha_vencimiento: venc,
        monto_pagado: nuevoMonto,
        metodo_pago: metodo,
        telefono: nuevoTel
    };

    fetch('membresias.php?action=update', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(r => {
        if (!r.ok) throw r;
        return r.json();
    })
    .then(() => {
        editRowId = null;
        cargarMembresias();
    })
    .catch(async err => {
        let msg = 'Error al guardar cambios';
        try { const j = await err.json(); msg = j.error || msg; } catch(e){}
        alert(msg);
    });
}

function cancelar(id) {
  fetch('membresias.php?action=cancel', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({id})
  })
  .then(r => {
    if (!r.ok) throw r;
    return r.json();
  })
  .then(() => {
    cargarMembresias();
  })
  .catch(async err => {
    let msg = 'Error al cancelar';
    try { const j = await err.json(); msg = j.error || msg; } catch(e){}
    alert(msg);
  });
}

function reactivar(id) {
  fetch('membresias.php?action=reactivate', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({id})
  })
  .then(r => {
    if (!r.ok) throw r;
    return r.json();
  })
  .then(() => {
    cargarMembresias();
  })
  .catch(async err => {
    let msg = 'Error al reactivar';
    try { const j = await err.json(); msg = j.error || msg; } catch(e){}
    alert(msg);
  });
}

/* ============= USUARIOS (SOLO ADMIN) ============= */

function cargarUsuarios() {
  fetch('usuarios.php?action=list')
    .then(r => {
      if (!r.ok) throw r;
      return r.json();
    })
    .then(data => {
      const tbody = document.querySelector('#tblUsuarios tbody');
      tbody.innerHTML = '';
      data.forEach(u => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${u.id}</td>
          <td>${u.username}</td>
          <td>${u.rol}</td>
        `;
        tbody.appendChild(tr);
      });
    })
    .catch(async err => {
      let msg = 'Error al cargar usuarios';
      try { const j = await err.json(); msg = j.error || msg; } catch(e){}
      document.getElementById('u_msg').innerText = msg;
    });
}

function crearUsuario() {
  const data = {
    username: document.getElementById('u_username').value,
    password: document.getElementById('u_password').value,
    rol: document.getElementById('u_rol').value
  };

  fetch('usuarios.php?action=create', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(r => {
    if (!r.ok) throw r;
    return r.json();
  })
  .then(res => {
    document.getElementById('u_msg').classList.remove('error');
    document.getElementById('u_msg').classList.add('ok');
    document.getElementById('u_msg').innerText = 'Usuario creado correctamente';
    document.getElementById('u_username').value = '';
    document.getElementById('u_password').value = '';
    cargarUsuarios();
  })
  .catch(async err => {
    let msg = 'Error al crear usuario';
    try { const j = await err.json(); msg = j.error || msg; } catch(e){}
    document.getElementById('u_msg').classList.remove('ok');
    document.getElementById('u_msg').classList.add('error');
    document.getElementById('u_msg').innerText = msg;
  });
}

/* ============= AUDITORÍA (SOLO ADMIN) ============= */

function cargarAuditoria() {
  fetch('auditoria.php?action=list')
    .then(r => {
      if (!r.ok) throw r;
      return r.json();
    })
    .then(data => {
      const tbody = document.querySelector('#tblAuditoria tbody');
      tbody.innerHTML = '';
      data.forEach(a => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${a.id}</td>
          <td>${a.creado_en}</td>
          <td>${a.usuario || ''}</td>
          <td>${a.codigo_membresia || ''}</td>
          <td>${a.accion}</td>
          <td>${a.detalle || ''}</td>
        `;
        tbody.appendChild(tr);
      });
    })
    .catch(async err => {
      let msg = 'Error al cargar auditoría';
      console.error(err);
      alert(msg);
    });
}
</script>
</body>
</html>

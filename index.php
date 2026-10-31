<?php
// Força o navegador a não fazer cache desta página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <title>Minhas Finanças</title>
  <link rel="icon" type="image/png" href="assets/img/favicon.ico?v=<?php echo time(); ?>">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* --- VARIÁVEIS IOS --- */
    :root {
      --theme-color: #007AFF;
      /* Cor que vai mudar com o JS */
      --ios-bg: #F2F2F7;
      --ios-card: rgba(255, 255, 255, 0.85);
      --ios-text: #000000;
      --ios-text-sec: #8E8E93;
      --ios-blue: var(--theme-color);
      /* Agora ele puxa do tema! */
      --ios-red: #FF3B30;
      --ios-green: #34C759;
      --ios-orange: #FF9500;
      --ios-purple: #AF52DE;
      --ios-divider: #C6C6C8;
      --radius: 20px;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
      background: linear-gradient(180deg, #EAF4FF 0%, #F1F9FF 40%, #E7F3FF 100%);
      color: var(--ios-text);
      height: 100vh;
      overflow: hidden;
    }

    .hidden {
      display: none !important;
    }

    .w-full {
      width: 100%;
    }

    /* --- BOTOES GERAIS --- */
    .btn {
      border: none;
      padding: 14px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: opacity 0.2s;
    }

    .btn:active {
      opacity: 0.7;
    }

    .btn-primary {
      background: var(--theme-color);
      color: white;
      padding: 12px 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      transition: transform 0.14s ease, box-shadow 0.14s ease, opacity 0.12s;
    }

    .btn-primary:active {
      transform: translateY(1px) scale(0.998);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
      background: rgba(255, 59, 48, 0.1);
      color: var(--ios-red);
      margin-top: 15px;
    }

    .btn-fab {
      position: fixed;
      bottom: 30px;
      right: 24px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: var(--ios-blue);
      color: white;
      box-shadow: 0 4px 15px rgba(0, 122, 255, 0.4);
      z-index: 50;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* --- LOGIN VIEW (NOVO ESTILO) --- */
    .login-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      width: 100vw;
      background-color: #f4f7f9;
      background-image:
        radial-gradient(circle at 0% 0%, rgba(0, 122, 255, 0.08) 0px, transparent 40%),
        radial-gradient(circle at 100% 100%, rgba(175, 82, 222, 0.05) 0px, transparent 40%);
      overflow-y: auto;
      overflow-x: hidden;
      z-index: 1;
    }

    .login-container {
      display: flex;
      width: 100%;
      max-width: 1200px;
      height: 100vh;
      z-index: 2;
    }

    .login-left {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
      color: #1a1c1e;
    }

    .brand-content {
      max-width: 400px;
      animation: slideInLeft 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .brand-logo {
      max-width: 290px;
      margin-bottom: 25px;
      object-fit: contain;
      filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.1));
    }

    .login-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .glass-panel {
      width: 100%;
      max-width: 420px;
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(24px) saturate(150%);
      -webkit-backdrop-filter: blur(24px) saturate(150%);
      border: 1px solid rgba(255, 255, 255, 0.9);
      border-radius: 24px;
      padding: 50px 40px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
      color: #333;
      animation: slideInRight 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .login-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .login-header h2 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 8px;
      color: #1a1c1e;
    }

    .glass-panel .form-group {
      margin-bottom: 1rem;
      text-align: left;
    }

    .glass-panel label {
      display: block;
      color: #555;
      font-size: 0.85rem;
      margin-bottom: 6px;
      font-weight: 600;
    }

    .glass-panel .input-icon-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .glass-panel .input-icon-wrapper>.material-icons-round {
      position: absolute;
      left: 12px;
      color: #888;
      pointer-events: none;
    }

    .glass-panel input {
      width: 100%;
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid #d1d5db;
      color: #333;
      border-radius: 12px;
      height: 50px;
      padding: 10px 12px 10px 42px;
      font-size: 0.95rem;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
      outline: none;
      transition: all 0.2s;
    }

    .glass-panel input:focus {
      background: #ffffff;
      border-color: var(--theme-color);
      box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
    }

    .glass-panel .login-btn {
      height: 54px;
      font-size: 1.1rem;
      border-radius: 14px;
      background: var(--theme-color);
      color: white;
      border: none;
      box-shadow: 0 8px 15px -5px var(--theme-color);
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .glass-panel .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 20px -5px var(--theme-color);
    }

    .login-footer {
      text-align: center;
      margin-top: 40px;
      font-size: 0.75rem;
      color: #888;
      letter-spacing: 1px;
    }

    .login-footer span {
      font-size: 0.65rem;
      opacity: 0.8;
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-40px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(40px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* RESPONSIVO MOBILE - LOGIN */
    @media (max-width: 768px) {
      .login-wrapper {
        align-items: flex-start;
      }

      .login-container {
        flex-direction: column;
        height: auto;
        min-height: 100vh;
        padding: 20px 0;
      }

      .login-left {
        flex: none;
        padding: 5px 20px 10px 20px;
        display: flex;
        justify-content: center;
      }

      .brand-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        text-align: left;
        gap: 20px;
      }

      .brand-logo {
        max-width: 250px;
        margin-bottom: 0;
      }

      .login-right {
        padding: 10px 20px 50px 20px;
        align-items: flex-start;
      }

      .glass-panel {
        padding: 40px 25px;
      }
    }

    /* --- ESTILOS GERAIS DE INPUTS E TOGGLES (RECUPERADOS) --- */
    .input-group {
      margin-bottom: 16px;
      text-align: left;
    }

    .input-ios {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid rgba(10, 30, 60, 0.06);
      background: rgba(255, 255, 255, 0.9);
      border-radius: 12px;
      font-size: 15px;
      outline: none;
      transition: box-shadow 160ms, transform 160ms, border-color 160ms;
      box-shadow: inset 0 -1px 0 rgba(10, 30, 60, 0.03);
    }

    .input-ios:focus {
      background: rgba(255, 255, 255, 1);
      border-color: var(--theme-color);
      box-shadow: 0 6px 18px rgba(2, 54, 108, 0.06);
      transform: translateY(-1px);
    }

    /* Estilo dos botões de ligar/desligar (Toggles) */
    #modalSettings .sheet-card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
    }

    input[type="checkbox"]+span {
      background-color: #E5E5EA;
    }

    input[type="checkbox"]:checked+span {
      background-color: var(--theme-color);
    }

    input[type="checkbox"]+span::after {
      content: '';
      position: absolute;
      left: 4px;
      top: 4px;
      width: 22px;
      height: 22px;
      background: white;
      border-radius: 50%;
      transition: transform 0.24s;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    input[type="checkbox"]:checked+span::after {
      transform: translateX(20px);
    }

    /* --- NOVO DARK MODE PREMIUM --- */
    body.dark-mode {
      --ios-bg: #000000;
      --ios-card: #1C1C1E;
      --ios-text: #FFFFFF;
      --ios-text-sec: #EBEBF599;
      --ios-divider: #38383A;
      background: #000000;
    }

    body.dark-mode .sheet-card,
    body.dark-mode .ios-alert-box,
    body.dark-mode .toast,
    body.dark-mode .sidebar {
      background: #1C1C1E !important;
      border: 1px solid #38383A;
      color: #FFFFFF;
    }

    body.dark-mode .input-ios,
    body.dark-mode select {
      background: #2C2C2E !important;
      color: #FFFFFF !important;
      border: 1px solid #38383A !important;
    }

    body.dark-mode .input-ios::placeholder {
      color: #8E8E93;
    }

    body.dark-mode .app-header {
      background: rgba(28, 28, 30, 0.85) !important;
      border-bottom: 1px solid #38383A;
    }

    body.dark-mode .filter-bar {
      background: #000000 !important;
      border-bottom: 1px solid #38383A;
    }

    body.dark-mode .t-item {
      border-bottom: 1px solid #38383A;
    }

    body.dark-mode .settings-header {
      background: #2C2C2E;
      color: #FFF;
      border-color: #38383A;
    }

    body.dark-mode #modalSettings input[type="checkbox"]+span {
      background-color: #38383A;
    }

    body.dark-mode .type-opt {
      border-color: #38383A;
    }

    body.dark-mode .nav-link {
      color: #FFFFFF;
    }

    /* Ajustes específicos do novo login no Dark Mode */
    body.dark-mode .login-wrapper {
      background-color: #000;
      background-image: none;
    }

    body.dark-mode .login-left {
      color: #fff;
    }

    body.dark-mode .glass-panel {
      background: rgba(28, 28, 30, 0.75);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #fff;
      box-shadow: none;
    }

    body.dark-mode .login-header h2 {
      color: #fff;
    }

    body.dark-mode .glass-panel label {
      color: #aaa;
    }

    body.dark-mode .glass-panel input {
      background: #1C1C1E;
      border-color: #38383A;
      color: #fff;
    }

    body.dark-mode .glass-panel input:focus {
      background: #000;
      border-color: var(--theme-color);
    }

    /* --- APP VIEW --- */
    #appView {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .app-header {
      padding: 12px 18px;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.85));
      backdrop-filter: blur(8px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 10;
    }

    .month-control {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .icon-btn {
      padding: 8px;
      border-radius: 50%;
      background: transparent;
      border: none;
      cursor: pointer;
      color: var(--ios-blue);
    }

    .icon-btn:active {
      background: rgba(0, 0, 0, 0.05);
    }

    .scroll-area {
      flex: 1;
      overflow-y: auto;
      padding: 20px;
      padding-bottom: 100px;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 24px;
    }

    .glass-card {
      background: var(--ios-card);
      backdrop-filter: blur(12px);
      border-radius: var(--radius);
      padding: 16px;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 100px;
    }

    .card-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 8px;
      color: white;
    }

    .lbl {
      font-size: 0.8rem;
      color: var(--ios-text-sec);
      font-weight: 500;
    }

    .val {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--ios-text);
      letter-spacing: -0.5px;
      margin: 4px 0;
    }

    .prev {
      font-size: 0.75rem;
      color: var(--ios-text-sec);
    }

    .c-green .card-icon {
      background: var(--ios-green);
    }

    .c-green .val {
      color: var(--ios-green);
    }

    .c-red .card-icon {
      background: var(--ios-red);
    }

    .c-red .val {
      color: var(--ios-red);
    }

    .c-blue .card-icon {
      background: var(--ios-blue);
    }

    .c-blue .val {
      color: var(--ios-blue);
    }

    .c-purple .card-icon {
      background: var(--ios-purple);
    }

    .c-purple .val {
      color: var(--ios-purple);
    }

    .list-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
      padding: 0 4px;
    }

    .list-header h3 {
      font-size: 1.2rem;
      font-weight: 700;
    }

    .list-container {
      background: var(--ios-card);
      border-radius: var(--radius);
      padding: 0 16px;
      box-shadow: var(--shadow);
    }

    .t-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 0;
      border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    }

    .t-item:last-child {
      border-bottom: none;
    }

    .t-ico {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 14px;
      font-size: 20px;
      color: white;
      flex-shrink: 0;
    }

    .t-details {
      flex: 1;
    }

    .t-cat {
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--ios-text-sec);
    }

    .t-desc {
      font-size: 1rem;
      font-weight: 500;
      color: var(--ios-text);
      margin-top: 2px;
    }

    .t-right {
      text-align: right;
    }

    .t-amount {
      font-size: 1rem;
      font-weight: 700;
      display: block;
    }

    .t-meta {
      font-size: 0.75rem;
      color: var(--ios-text-sec);
      margin-top: 2px;
      display: block;
    }

    .badge-diff {
      display: inline-block;
      padding: 2px 6px;
      border-radius: 6px;
      font-size: 0.7rem;
      font-weight: 700;
      margin-left: 4px;
    }

    .bg-bad {
      background: rgba(255, 59, 48, 0.15);
      color: var(--ios-red);
    }

    .bg-good {
      background: rgba(52, 199, 89, 0.15);
      color: var(--ios-green);
    }

    /* --- SIDEBAR --- */
    .sidebar-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(3px);
      z-index: 100;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 280px;
      background: linear-gradient(180deg, #FFFFFF, #F7FBFF);
      z-index: 101;
      transform: translateX(-100%);
      transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      padding: 18px 16px;
      display: flex;
      flex-direction: column;
    }

    .sidebar.active {
      transform: translateX(0);
    }

    .sidebar-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }

    .sb-profile {
      margin-bottom: 40px;
    }

    .sb-title {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--ios-blue);
      margin-bottom: 5px;
    }

    .sb-user {
      color: var(--ios-text-sec);
      font-size: 0.9rem;
    }

    .nav-link {
      padding: 12px 16px;
      margin-bottom: 8px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--ios-text);
      text-decoration: none;
      font-weight: 500;
      transition: background 0.2s;
    }

    .nav-link.active {
      background: rgba(0, 122, 255, 0.1);
      color: var(--ios-blue);
    }

    .nav-link.logout {
      color: var(--ios-red);
      margin-top: auto;
    }

    /* --- MODAL FORM --- */
    .modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.18);
      z-index: 200;
      display: flex;
      align-items: flex-end;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.22s;
    }

    .modal-backdrop.active {
      opacity: 1;
      pointer-events: auto;
    }

    .sheet-card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.92));
      width: 100%;
      height: 100%;
      max-height: none;
      border-radius: 12px 12px 0 0;
      padding: 12px 16px;
      transform: translateY(100%);
      transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
      overflow-y: auto;
      padding-bottom: 28px;
    }

    .modal-backdrop.active .sheet-card {
      transform: translateY(0);
    }

    .type-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
      margin-bottom: 20px;
    }

    .type-opt {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      padding: 10px 4px;
      border: 1px solid #E5E5EA;
      border-radius: 12px;
      cursor: pointer;
    }

    .type-opt span {
      font-size: 0.7rem;
      font-weight: 600;
      color: var(--ios-text-sec);
    }

    .type-opt.selected {
      background: rgba(0, 122, 255, 0.05);
      border-color: var(--ios-blue);
    }

    .type-opt.selected span {
      color: var(--ios-blue);
    }

    /* --- EFEITO CORTINA (SUMMARY) --- */
    .summary-wrapper {
      background: var(--ios-bg);
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .summary-wrapper.open {
      max-height: 85vh;
      overflow-y: auto;
      opacity: 1;
      padding-bottom: 20px;
    }

    .summary-content {
      padding: 20px 20px 0 20px;
    }

    .toggle-summary-btn {
      transition: transform 0.3s;
    }

    .toggle-summary-btn.rotate {
      transform: rotate(180deg);
    }

    /* --- ABAS DE FILTRO (TABS) --- */
    .filter-bar {
      display: flex;
      justify-content: space-between;
      padding: 10px 20px;
      background: var(--ios-bg);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      flex-shrink: 0;
      z-index: 5;
    }

    .filter-btn {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 8px;
      margin: 0 4px;
      border-radius: 12px;
      border: none;
      background: transparent;
      color: var(--ios-text-sec);
      font-size: 0.75rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-btn span {
      font-size: 24px;
      margin-bottom: 4px;
    }

    .filter-btn.active {
      background: var(--ios-card);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      color: var(--ios-blue);
    }

    .filter-btn.active.f-ent {
      color: var(--ios-green);
    }

    .filter-btn.active.f-fix {
      color: var(--ios-orange);
    }

    .filter-btn.active.f-var {
      color: var(--ios-red);
    }

    .filter-btn.active.f-inv {
      color: var(--ios-purple);
    }

    /* --- TOAST & CUSTOM ALERT --- */
    .toast {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%) translateY(-100px);
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      padding: 12px 24px;
      border-radius: 50px;
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 100000 !important;
      pointer-events: auto;
      transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .toast.show {
      transform: translateX(-50%) translateY(0);
    }

    .toast-icon {
      font-size: 20px;
    }

    .toast.success .toast-icon {
      color: var(--ios-green);
    }

    .toast.error .toast-icon {
      color: var(--ios-red);
    }

    .toast-msg {
      font-size: 0.9rem;
      font-weight: 500;
    }

    /* Settings list */
    .settings-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
      padding: 6px 4px;
    }

    .settings-item {
      background: transparent;
      border-radius: 12px;
      overflow: hidden;
    }

    .settings-header {
      width: 100%;
      padding: 12px 10px;
      border-radius: 12px;
      background: var(--ios-card);
      border: 1px solid rgba(0, 0, 0, 0.04);
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-weight: 600;
      cursor: pointer;
      gap: 10px;
      color: var(--ios-text);
    }

    .settings-header .material-icons-round {
      color: var(--ios-text-sec);
    }

    .settings-item.open .settings-header {
      background: linear-gradient(90deg, rgba(0, 122, 255, 0.06), rgba(255, 255, 255, 0.02));
    }

    .settings-item .settings-body {
      background: transparent;
      padding-top: 8px;
    }

    .settings-item .settings-body .input-ios {
      margin-top: 6px;
    }

    .settings-item .material-icons-round.rotate {
      transform: rotate(180deg);
      transition: transform 0.18s ease;
    }

    /* Custom Confirm Modal */
    .ios-alert-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(2px);
      z-index: 2000;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .ios-alert-box {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      width: 270px;
      border-radius: 14px;
      text-align: center;
      overflow: hidden;
    }

    .alert-content {
      padding: 20px;
    }

    .alert-title {
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 5px;
    }

    .alert-msg {
      font-size: 0.85rem;
      color: var(--ios-text-sec);
    }

    .alert-actions {
      display: flex;
      border-top: 1px solid rgba(60, 60, 67, 0.29);
    }

    .alert-btn {
      flex: 1;
      padding: 12px;
      border: none;
      background: transparent;
      font-size: 1rem;
      cursor: pointer;
      color: var(--ios-blue);
    }

    .alert-btn:first-child {
      border-right: 1px solid rgba(60, 60, 67, 0.29);
      font-weight: 400;
    }

    .alert-btn:last-child {
      font-weight: 600;
    }

    /* Toggle Switch Style */
    #inputRecurring:checked+span {
      background-color: var(--ios-green);
    }

    #inputRecurring:checked+span span {
      transform: translateX(20px);
    }

    /* LOADER */
    .loader-overlay {
      position: fixed;
      inset: 0;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(5px);
      z-index: 3000;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .spinner {
      width: 30px;
      height: 30px;
      border: 3px solid #E5E5EA;
      border-top-color: var(--ios-blue);
      border-radius: 50%;
      animation: spin 0.8s infinite linear;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* --- ESTILOS DO FILTRO DE BANCOS --- */
    .bank-filter-wrapper {
      display: flex;
      overflow-x: auto;
      gap: 10px;
      padding: 12px 20px 0 20px;
      background: var(--ios-bg);
      white-space: nowrap;
    }

    .bank-filter-wrapper::-webkit-scrollbar {
      display: none;
      /* Esconde a barra de rolagem */
    }

    .bank-chip {
      padding: 8px 16px;
      border-radius: 20px;
      border: 1px solid var(--ios-divider);
      background: var(--ios-card);
      color: var(--ios-text-sec);
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }

    .bank-chip.active {
      background: var(--theme-color);
      color: white;
      border-color: var(--theme-color);
      box-shadow: 0 4px 10px rgba(0, 122, 255, 0.3);
    }
  </style>

</head>

<body>

  <div id="loader" class="loader-overlay hidden">
    <div class="spinner"></div>
  </div>

  <div id="toast" class="toast">
    <span class="material-icons-round toast-icon" id="toastIcon">check_circle</span>
    <span class="toast-msg" id="toastMsg">Mensagem aqui</span>
  </div>

  <div id="customAlert" class="ios-alert-overlay hidden">
    <div class="ios-alert-box">
      <div class="alert-content">
        <div class="alert-title" id="alertTitle">Atenção</div>
        <div class="alert-msg" id="alertMsg">Deseja realmente excluir?</div>
      </div>
      <div class="alert-actions">
        <button class="alert-btn" onclick="closeCustomAlert()">Não</button>
        <button class="alert-btn" id="alertConfirmBtn">Sim</button>
      </div>
    </div>
  </div>

  <div id="loginView" class="login-wrapper">
    <div class="login-container">

      <!-- Lado Esquerdo - Branding -->
      <div class="login-left">
        <div class="brand-content">
          <img src="assets/img/logo.png?v=<?php echo time(); ?>" alt="Minhas Finanças Logo" class="brand-logo">
        </div>
      </div>

      <!-- Lado Direito - Formulário -->
      <div class="login-right">
        <div class="glass-panel">
          <div class="login-header">
            <h2>Acessar Finanças</h2>
          </div>

          <form id="loginForm">
            <div class="form-group">
              <label for="email">E-mail</label>
              <div class="input-icon-wrapper">
                <span class="material-icons-round">mail</span>
                <input type="email" id="email" placeholder="seu@email.com" required>
              </div>
            </div>

            <div class="form-group" style="margin-bottom: 30px;">
              <label for="password">Senha</label>
              <div class="input-icon-wrapper">
                <span class="material-icons-round">lock</span>
                <input type="password" id="password" placeholder="••••••••" required style="padding-right: 40px;">
                <!-- Botão de mostrar senha integrado -->
                <button type="button" id="btnTogglePass" title="Mostrar senha"
                  style="position:absolute; right:12px; top:50%; transform:translateY(-50%); border:none; background:transparent; cursor:pointer; color:#888;">
                  <span class="material-icons-round">visibility</span>
                </button>
              </div>
            </div>

            <button type="submit" class="btn w-full login-btn">
              <span class="material-icons-round" style="font-size: 20px; margin-right: 4px;">login</span> Entrar
            </button>
          </form>

          <div class="login-footer">
            Minhas Finanças &copy; 2026<br>
            <span>POWERED BY TCASTROCNA</span>
          </div>

        </div>
      </div>

    </div>
  </div>

  <div id="appView" class="hidden">

    <div class="app-header">
      <button class="icon-btn" onclick="toggleSidebar()">
        <span class="material-icons-round">menu</span>
      </button>
      <button class="icon-btn" id="btnPrivacy" onclick="togglePrivacyMode()">
        <span class="material-icons-round">visibility</span>
      </button>
      <div class="month-control">
        <button class="icon-btn" onclick="changeMonth(-1)"><span
            class="material-icons-round">chevron_left</span></button>
        <span id="displayMonth">Janeiro</span>
        <button class="icon-btn" onclick="changeMonth(1)"><span
            class="material-icons-round">chevron_right</span></button>
      </div>

      <button class="icon-btn toggle-summary-btn" id="btnToggleSummary" onclick="toggleSummary()">
        <span class="material-icons-round">dashboard</span>
      </button>
    </div>

    <div id="bankFilterContainer" class="bank-filter-wrapper"></div>

    <div id="summaryCurtain" class="summary-wrapper">
      <div class="summary-content">
        <div class="summary-grid">
          <div class="glass-card c-green">
            <div class="card-icon"><span class="material-icons-round">arrow_upward</span></div>
            <div>
              <div class="lbl">Entradas</div>
              <div class="val" id="valEntradas">R$ 0,00</div>
              <div class="prev" id="prevEntradas">Prev: R$ 0,00</div>
            </div>
          </div>

          <div class="glass-card c-red">
            <div class="card-icon"><span class="material-icons-round">arrow_downward</span></div>
            <div>
              <div class="lbl">Saídas</div>
              <div class="val" id="valSaidas">R$ 0,00</div>
              <div class="prev" id="prevSaidas">Prev: R$ 0,00</div>
            </div>
          </div>

          <div class="glass-card c-blue">
            <div class="card-icon"><span class="material-icons-round">account_balance_wallet</span></div>
            <div>
              <div class="lbl">Sobra</div>
              <div class="val" id="valSaldo">R$ 0,00</div>
              <div class="prev" id="prevSaldo">Prev: R$ 0,00</div>
            </div>
          </div>

          <div class="glass-card c-purple">
            <div class="card-icon"><span class="material-icons-round">trending_up</span></div>
            <div>
              <div class="lbl">Investido</div>
              <div class="val" id="valInvest">R$ 0,00</div>
              <div class="prev" id="prevInvest">Prev: R$ 0,00</div>
            </div>
          </div>
        </div>
        <div id="insightsContainer" style="margin-bottom: 24px; display: flex; flex-direction: column; gap: 16px;">

          <!-- Dica de Saúde Financeira -->
          <div id="saudeFinanceiraBox" class="hidden"
            style="background: rgba(0,122,255,0.1); border: 1px solid var(--theme-color); padding: 15px; border-radius: 12px; display: flex; gap: 10px; align-items: center;">
            <span class="material-icons-round"
              style="color: var(--theme-color); font-size: 28px;">tips_and_updates</span>
            <div style="flex: 1;">
              <div style="font-weight: 700; font-size: 0.9rem; color: var(--ios-text);">Saúde Financeira</div>
              <div id="saudeFinanceiraMsg" style="font-size: 0.8rem; color: var(--ios-text-sec);">Analisando...</div>
            </div>
          </div>

          <!-- Gráfico de Despesas (Donut) -->
          <div class="glass-card" style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
              <h3 style="font-size: 1rem; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                <span class="material-icons-round" style="color: var(--ios-red);">pie_chart</span> Para onde foi?
              </h3>
              <button onclick="openLegendas()"
                style="background: none; border: none; color: var(--theme-color); font-weight: 600; font-size: 0.8rem; cursor: pointer;">Ver
                Detalhes</button>
            </div>

            <p id="insightText" style="font-size: 0.8rem; color: var(--ios-text-sec); margin-bottom: 15px;">Analisando
              seus gastos...</p>
            <div style="position: relative; height: 180px; width: 100%; display: flex; justify-content: center;">
              <canvas id="chartCategorias"></canvas>
            </div>
          </div>

          <!-- Gráfico Anual (Barras Scrollável no Mobile) -->
          <div class="glass-card" style="padding: 20px 0;">
            <div style="padding: 0 20px;">
              <h3
                style="font-size: 1rem; font-weight: 700; margin-bottom: 5px; display: flex; align-items: center; justify-content: space-between;">
                <span style="display: flex; align-items: center; gap: 6px;">
                  <span class="material-icons-round" style="color: var(--theme-color);">bar_chart</span> Balanço Anual
                </span>
                <span class="material-icons-round"
                  style="color: var(--ios-text-sec); font-size: 16px;">swipe_left</span>
              </h3>
              <p style="font-size: 0.75rem; color: var(--ios-text-sec); margin-bottom: 15px;">Arraste para os lados para
                ver os meses.</p>
            </div>

            <!-- Esta div com overflow-x auto cria o efeito de arrastar no celular -->
            <div style="overflow-x: auto; padding: 0 20px; padding-bottom: 10px;">
              <div style="position: relative; height: 220px; width: 550px;">
                <!-- Largura fixa força o scroll no mobile -->
                <canvas id="chartAnual"></canvas>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="filter-bar">
      <button class="filter-btn f-ent active" onclick="setFilter('entrada', this)">
        <span class="material-icons-round">arrow_upward</span> Entradas
      </button>
      <button class="filter-btn f-fix" onclick="setFilter('fixo', this)">
        <span class="material-icons-round">home</span> Fixos
      </button>
      <button class="filter-btn f-var" onclick="setFilter('variavel', this)">
        <span class="material-icons-round">shopping_cart</span> Variável
      </button>
      <button class="filter-btn f-inv" onclick="setFilter('investimento', this)">
        <span class="material-icons-round">trending_up</span> Invest
      </button>
    </div>

    <div class="scroll-area" style="padding-top: 10px;">

      <div class="list-header" style="padding: 0 4px; justify-content: flex-end;">
        <span style="font-size:0.8rem; color:#8E8E93;" id="countItems">0 itens</span>
      </div>

      <div class="list-container">
        <div id="transactionsList"></div>
      </div>
    </div>

    <button class="btn-fab" onclick="openModalNew()">
      <span class="material-icons-round" style="font-size: 28px;">add</span>
    </button>
  </div>

  <div id="modalOverlay" class="modal-backdrop" onclick="if(event.target === this) closeModal()">
    <div class="sheet-card">

      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h3 style="font-size:1.8rem; font-weight: 700; color: var(--ios-text);" id="modalTitle">Novo</h3>

        <button type="button" onclick="closeModal()"
          style="background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--ios-text-sec);">
          <span class="material-icons-round">close</span>
        </button>
      </div>

      <form id="addForm">
        <input type="hidden" id="editId">
        <input type="hidden" id="inputType">

        <div class="type-grid">
          <!-- Seletor de tipo de lançamento -->
          <div class="type-opt" onclick="setType('entrada', this)">
            <span class="material-icons-round" style="color:var(--ios-green)">arrow_upward</span>
            <span>Entrada</span>
          </div>
          <div class="type-opt" onclick="setType('fixo', this)">
            <span class="material-icons-round" style="color:var(--ios-orange)">home</span>
            <span>Fixo</span>
          </div>
          <div class="type-opt" onclick="setType('variavel', this)">
            <span class="material-icons-round" style="color:var(--ios-red)">shopping_cart</span>
            <span>Variável</span>
          </div>
          <div class="type-opt" onclick="setType('investimento', this)">
            <span class="material-icons-round" style="color:var(--ios-purple)">trending_up</span>
            <span>Invest</span>
          </div>
        </div>
        <!-- Seletor de Banco -->
        <div class="input-group" style="position: relative;">
          <select id="inputInstituicao" class="input-ios" required
            style="appearance: none; -webkit-appearance: none; background: transparent;">
            <option value="OUTROS" selected>OUTROS</option>
          </select>
          <span class="material-icons-round"
            style="position: absolute; right: 16px; top: 16px; pointer-events: none; color: var(--ios-blue);">account_balance</span>
        </div>

        <div class="input-group" style="position: relative;">
          <select id="inputCat" class="input-ios" required
            style="appearance: none; -webkit-appearance: none; background: transparent;">
            <option value="" disabled selected>Selecione a Categoria</option>
          </select>
          <span class="material-icons-round"
            style="position: absolute; right: 16px; top: 16px; pointer-events: none; color: var(--ios-blue);">expand_more</span>
        </div>

        <div class="input-group">
          <input type="text" id="inputDesc" class="input-ios" placeholder="Descrição (Ex: COMPRAS NO EXTRA)" required
            style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()">
        </div>

        <div id="divInstallments" class="input-group hidden"
          style="display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: end;">
          <div>
            <label
              style="font-size:0.75rem; color:#8E8E93; margin-left:4px; line-height: 1.2; display: block; margin-bottom: 4px;">
              Parcelas (1x = Único), para mais digite o número de parcelas e informe o total, as parcelas serão
              divididas pelo numero de parcelas , se necessário ajustar clique em gerenciar
            </label>
            <input type="number" id="inputInstallments" class="input-ios" value="1" min="1" inputmode="numeric"
              oninput="toggleManageBtn()">
          </div>
          <button type="button" id="btnManageInst" class="btn hidden"
            style="background: rgba(0,122,255,0.1); color: var(--ios-blue); height: 52px; padding: 0 20px;"
            onclick="openInstallmentManager()">
            Gerenciar
          </button>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom:16px;">
          <div>
            <label style="font-size:0.75rem; color:#8E8E93; margin-left:4px;">Previsto</label>
            <input type="text" id="inputValPrev" class="input-ios" placeholder="0,00" required inputmode="numeric">
          </div>
          <div>
            <label style="font-size:0.75rem; color:#8E8E93; margin-left:4px;">Realizado</label>
            <input type="text" id="inputValReal" class="input-ios" placeholder="0,00" inputmode="numeric">
          </div>
        </div>

        <div id="divRecurring" class="input-group hidden">
          <div
            style="display: flex; align-items: center; justify-content: space-between; background: var(--ios-card); padding: 12px; border: 1px solid #E5E5EA; border-radius: 12px;">
            <span style="font-weight: 500; color: var(--ios-text);">Lançamento recorrente ?</span>

            <label style="position: relative; display: inline-block; width: 50px; height: 30px; cursor: pointer;">
              <input type="checkbox" id="inputRecurring" onchange="toggleRecurring()"
                style="opacity: 0; width: 0; height: 0;">
              <span
                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;">
                <span
                  style="position: absolute; content: ''; height: 22px; width: 22px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%;"
                  id="toggleKnob"></span>
              </span>
            </label>

          </div>
          <div style="font-size: 0.75rem; color: var(--ios-text-sec); margin-top: 6px; margin-left: 4px;">
            Valor que deve ser pago todo mês - será criado 12 registros, ou seja, de 1 ano.
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom:12px;">
          <div class="input-group">
            <label style="font-size:0.75rem; color:#8E8E93; margin-left:4px;">Vencimento</label>
            <input type="date" id="inputDate" class="input-ios" required>
          </div>
          <div class="input-group">
            <label style="font-size:0.75rem; color:#8E8E93; margin-left:4px;">Data Pago</label>
            <input type="date" id="inputPaidDate" class="input-ios" placeholder="Data em que foi pago">
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-full">Salvar</button>
        <button type="button" id="btnDelete" class="btn btn-danger w-full hidden" onclick="askDelete()">Excluir
          Lançamento</button>
      </form>
    </div>
  </div>

  <div id="modalInstallments" class="modal-backdrop" style="z-index: 250;">
    <div class="sheet-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h3 style="font-size:1.5rem; font-weight: 700;">Parcelamento</h3>
        <button type="button" onclick="closeInstallmentManager()"
          style="background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
          <span class="material-icons-round" style="color: var(--ios-text-sec);">close</span>
        </button>
      </div>

      <div
        style="background: var(--ios-card); padding: 10px; border-radius: 12px; margin-bottom: 8px; font-size: 0.9rem; color: var(--ios-text-sec);">
        Confira abaixo as datas e valores calculados. O valor total inserido foi dividido pelo número de parcelas.
      </div>

      <div id="installmentsContainer" style="display: flex; flex-direction: column; gap: 12px;">
      </div>

      <div style="margin-top: 30px;">
        <button type="button" class="btn btn-primary w-full" onclick="closeInstallmentManager()">Confirmar e
          Voltar</button>
      </div>
    </div>
  </div>

  <div id="modalRecorrencias" class="modal-backdrop" style="z-index: 150;">
    <div class="sheet-card" style="height: 90%; border-radius: 20px 20px 0 0; display: flex; flex-direction: column;">
      <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-shrink: 0;">
        <h3 style="font-size:1.5rem; font-weight: 700;">Assinaturas e Parcelas</h3>
        <button type="button" onclick="closeRecorrencias()"
          style="background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
          <span class="material-icons-round" style="color: var(--ios-text-sec);">close</span>
        </button>
      </div>
      <div class="list-container" id="recorrenciasList" style="flex: 1; overflow-y: auto;">
      </div>
    </div>
  </div>

  <div id="modalRecorrenciasDetalhe" class="modal-backdrop" style="z-index: 250;">
    <div class="sheet-card" style="height: 80%; border-radius: 20px 20px 0 0; display: flex; flex-direction: column;">
      <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-shrink: 0;">
        <h3 style="font-size:1.2rem; font-weight: 700;" id="detalheRecorrenciaTitle">Detalhes</h3>
        <button type="button" onclick="closeRecorrenciasDetalhe()"
          style="background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
          <span class="material-icons-round" style="color: var(--ios-text-sec);">close</span>
        </button>
      </div>
      <div class="list-container" id="recorrenciasDetalheList"
        style="box-shadow: none; padding: 0; flex: 1; overflow-y: auto;">
      </div>
    </div>
  </div>

  <!-- Settings Modal -->
  <div id="modalSettings" class="modal-backdrop" style="z-index: 250;">
    <div class="sheet-card" style="height: 70%; border-radius: 20px 20px 0 0; display: flex; flex-direction: column;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
        <h3 style="font-size:1.5rem; font-weight:700;">Configurações</h3>
        <button type="button" onclick="closeSettings()"
          style="background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
          <span class="material-icons-round" style="color: var(--ios-text-sec);">close</span>
        </button>
      </div>

      <div style="flex:1; overflow-y:auto;">
        <div class="settings-list">
          <div class="settings-item">
            <button class="settings-header" onclick="toggleSettingsSection('tema')">
              <span style="display:flex; align-items:center; gap:10px;"><span
                  class="material-icons-round">brightness_6</span>Tema</span>
              <span class="material-icons-round">expand_more</span>
            </button>
            <div class="settings-body" id="section-tema" style="display:none; padding:12px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom: 20px;">
                <div>
                  <div style="font-weight:700;">Tema escuro</div>
                  <div style="font-size:0.85rem; color:var(--ios-text-sec);">Ativa o modo escuro no app</div>
                </div>
                <label style="position: relative; display: inline-block; width: 50px; height: 30px; cursor: pointer;">
                  <input type="checkbox" id="cfgDarkMode" style="opacity: 0; width: 0; height: 0;"
                    onchange="applyDarkMode(this.checked)">
                  <span
                    style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; transition: .4s; border-radius: 34px;"></span>
                </label>
              </div>

              <!-- PALETA DE CORES -->
              <div style="border-top: 1px solid var(--ios-divider); padding-top: 15px;">
                <div style="font-weight:700; margin-bottom:12px;">Cor de Destaque</div>
                <div id="colorPickerContainer" style="display: flex; gap: 12px; flex-wrap: wrap;">
                  <!-- Bolinhas geradas via JS -->
                </div>
              </div>
            </div>
          </div>

          <!-- Contas Bancárias -->
          <div class="settings-item">
            <button class="settings-header" onclick="toggleSettingsSection('contas')">
              <span style="display:flex; align-items:center; gap:10px;"><span
                  class="material-icons-round">account_balance</span>Contas Bancárias</span>
              <span class="material-icons-round">expand_more</span>
            </button>
            <div class="settings-body" id="section-contas" style="display:none; padding:12px;">

              <div style="margin-bottom:15px; position:relative;">
                <div style="font-weight:700; margin-bottom:6px;">Adicionar Conta</div>
                <input type="text" id="cfgSearchBank" class="input-ios" placeholder="Buscar banco (Ex: CAIXA, INTER...)"
                  onkeyup="filterBankSearch()">

                <!-- Resultados da busca -->
                <div id="bankSearchResults"
                  style="max-height:180px; overflow-y:auto; background:var(--ios-card); border-radius:12px; margin-top:5px; border:1px solid var(--ios-divider); display:none; position: absolute; width: 100%; z-index: 50; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                </div>
              </div>

              <div>
                <div style="font-weight:700; margin-bottom:8px;">Minhas Contas Ativas</div>
                <div id="cfgMyBanks" style="display:flex; flex-wrap:wrap; gap:8px;">
                  <!-- Será preenchido via JS -->
                </div>
              </div>
            </div>
          </div>

          <div class="settings-item">
            <button class="settings-header" onclick="toggleSettingsSection('dados')">
              <span style="display:flex; align-items:center; gap:10px;"><span
                  class="material-icons-round">person</span>Dados</span>
              <span class="material-icons-round">expand_more</span>
            </button>
            <div class="settings-body" id="section-dados" style="display:none; padding:12px;">
              <div style="padding-bottom:8px;">
                <div style="font-weight:700; margin-bottom:6px;">Nome</div><input id="cfgNome" class="input-ios"
                  placeholder="Seu nome">
              </div>
              <div>
                <div style="font-weight:700; margin-bottom:6px;">Email</div><input id="cfgEmail" class="input-ios"
                  placeholder="seu@email.com">
              </div>
            </div>
          </div>

          <div class="settings-item">
            <button class="settings-header" onclick="toggleSettingsSection('seguranca')">
              <span style="display:flex; align-items:center; gap:10px;"><span
                  class="material-icons-round">lock</span>Segurança</span>
              <span class="material-icons-round">expand_more</span>
            </button>
            <div class="settings-body" id="section-seguranca" style="display:none; padding:12px;">
              <div style="padding-bottom:8px;">
                <div style="font-weight:700; margin-bottom:6px;">Senha atual</div><input id="cfgCurrentPass"
                  type="password" class="input-ios" placeholder="Senha atual">
              </div>
              <div style="padding-bottom:8px;">
                <div style="font-weight:700; margin-bottom:6px;">Nova senha</div><input id="cfgNewPass" type="password"
                  class="input-ios" placeholder="Nova senha">
              </div>
              <div>
                <div style="font-weight:700; margin-bottom:6px;">Confirmar nova senha</div><input id="cfgConfirmPass"
                  type="password" class="input-ios" placeholder="Confirmar nova senha">
              </div>
            </div>
          </div>

          <div class="settings-item">
            <button class="settings-header" onclick="toggleSettingsSection('sobre')">
              <span style="display:flex; align-items:center; gap:10px;"><span
                  class="material-icons-round">info</span>Sobre</span>
              <span class="material-icons-round">expand_more</span>
            </button>
            <div class="settings-body" id="section-sobre" style="display:none; padding:12px;">
              <div style="font-size:0.9rem; color:var(--ios-text-sec);">Minhas Finanças — v1.0<br>powered by tcastrocna.
              </div>
            </div>
          </div>

        </div>
      </div>

      <div style="padding:12px;">
        <button id="btnSaveSettings" class="btn btn-primary w-full">Salvar</button>
      </div>
    </div>
  </div>

  <!-- Modal Legendas do Gráfico -->
  <div id="modalLegendas" class="modal-backdrop" onclick="if(event.target === this) closeLegendas()">
    <div class="sheet-card"
      style="height: auto; max-height: 60%; border-radius: 20px 20px 0 0; display: flex; flex-direction: column;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-shrink: 0;">
        <h3 style="font-size:1.2rem; font-weight:700;">Detalhes de Gastos</h3>
        <button type="button" onclick="closeLegendas()"
          style="background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
          <span class="material-icons-round" style="color: var(--ios-text-sec);">close</span>
        </button>
      </div>
      <div id="legendasList" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;">
        <!-- Injetado pelo JS -->
      </div>
    </div>
  </div>

  <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
  <div class="sidebar">
    <div class="sb-profile">
      <div class="sb-title">Minhas Finanças</div>
      <div class="sb-user">Olá, <span id="userNameDisplay">...</span></div>
    </div>

    <a href="#" class="nav-link active" onclick="toggleSidebar()">
      <span class="material-icons-round">dashboard</span> Início
    </a>

    <a href="#" class="nav-link" onclick="openRecorrencias()">
      <span class="material-icons-round">event_repeat</span> Assinaturas / Parcelas
    </a>

    <a href="#" class="nav-link" onclick="openConfig()">
      <span class="material-icons-round">settings</span> Configurar
    </a>

    <a href="#" class="nav-link logout" onclick="logout()">
      <span class="material-icons-round">logout</span> Sair da Conta
    </a>
  </div>

  <!--- SCRIPT JAVASCRIPT REESCRITO PARA USAR A API EM PHP --->
  <script>
    // --- ESTADO ---
    let authToken = localStorage.getItem('financasToken');
    let currentDate = new Date();
    let allData = [];
    let activeFilter = 'entrada';
    let pendingInstallments = [];
    let currentGroups = {};
    let chartCatInstance = null;
    let chartAnualInstance = null;
    let currentDonutData = [];

    let selectedThemeColor = '#007AFF'; // Azul Padrão
    const systemColors = [
      { name: 'Azul Mac', hex: '#007AFF' },
      { name: 'Índigo', hex: '#5856D6' },
      { name: 'Roxo', hex: '#AF52DE' },
      { name: 'Rosa', hex: '#FF2D55' },
      { name: 'Laranja', hex: '#FF9500' },
      { name: 'Teal (Ciano)', hex: '#5AC8FA' },
      { name: 'Cinza Grafite', hex: '#8E8E93' },
      { name: 'Preto Onyx', hex: '#1C1B1F' }
    ];

    const CATEGORIAS = {
      'entrada': ['Salário', 'Extra', 'Reembolso', 'Pagamento Empréstimo', 'Outros'],
      'fixo': ['Aluguel/Condomínio', 'Educação', 'Saúde', 'Energia', 'Água', 'Internet', 'Assinaturas', 'Seguros', 'Outros'],
      'variavel': ['Mercado', 'Restaurante/Ifood', 'Combustível', 'Uber/Transporte', 'Lazer', 'Farmácia', 'Manutenção', 'Presentes', 'Saúde', 'Cartão de Crédito', 'Outros'],
      'investimento': ['Reserva Emergência', 'CDB/Renda Fixa', 'Ações/FIIs', 'Poupança', 'Cripto', 'Outros']
    };

    const INSTITUICOES_PDF = ["BRADESCO", "BANCO C6", "ITAU", "BTG PACTUAL/BANCO PAN", "MERCADO PAGO IP", "PICPAY", "SANTANDER", "BB", "PAGSEGURO", "INTER", "CAIXA ECONÔMICA FEDERAL", "NEON PAGAMENTOS IP", "NU PAGAMENTOS", "CLOUDWALK IP", "99PAY IP", "MW IP", "BANCO RIBEIRÃO PRETO", "PARATI CFI", "MT IP", "LECCA", "BANCO DIGIMAIS", "ASTRO IP", "BANCO BARI", "FACTA S.A. CFI", "CLARO PAY IP", "BRB", "SENFFNET IP", "COBUCCIO SCFI", "VOLKSWAGEN", "MÊNTORE IP", "DLOCAL BRASIL", "EBANX IP", "BULLLA IP", "MERCANTIL DO BRASIL", "PINE", "SAFRA", "BS2", "AGIBANK", "PORTO SEGURO", "BCO DO EST. DO PA S.A.", "BCO INBURSA S.A.", "BANCO AFINZ BM", "SOFISA", "BMG", "EFI S.A. IP", "BCO DO EST. DE SE S.A.", "NOVO BCO CONTINENTAL", "PEFISA S.A.", "DM SCFI", "CREFISA", "HONDA", "BANESTES", "VOTORANTIM", "BCO DAYCOVAL", "ORIGINAL", "STONE IP", "PARANÁ BANCO", "ASAAS GESTAO FINANCEIRA", "BANRISUL", "CELCOIN IP", "OMNI", "GENIAL", "CREDSYSTEM IP", "BCO CSF S.A.", "RECARGAPAY IP", "XP", "MAREE IP", "WISE BRASIL CC", "REALIZE SCFI", "DOCK IP"];

    let userContas = [];
    let activeBankFilter = 'ALL';

    const views = { login: document.getElementById('loginView'), app: document.getElementById('appView') };
    const modal = { overlay: document.getElementById('modalOverlay') };
    const loader = document.getElementById('loader');

    // --- HELPER PARA FAZER REQUISIÇÕES AO PHP (API) ---
    async function apiCall(action, payload = {}) {
      try {
        const response = await fetch('backend/api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: action, payload: payload, token: authToken })
        });

        const data = await response.json();

        if (data.expired) {
          localStorage.removeItem('financasToken');
          authToken = null;
          showView('login');
          showToast("Sessão expirada. Faça login novamente.", "error");
          throw new Error('Sessão expirada');
        }

        return data;
      } catch (error) {
        console.error('API Error:', error);
        throw error;
      }
    }

    // --- INIT ---
    document.addEventListener('DOMContentLoaded', () => {
      // 1. CARREGA AS CORES IMEDIATAMENTE (Sem piscar a tela)
      const savedTheme = localStorage.getItem('financasTheme');
      if (savedTheme) {
        try {
          const config = JSON.parse(savedTheme);
          applyDarkMode(config.modo_dark === 'true');
          applyThemeColor(config.cor_tema || '#007AFF');

          // Carrega a lista de bancos
          userContas = config.contas || [];

          renderBankFilterUI();           // Desenha as opções de bancos no Dashboard
          updateTransactionFormBanks();   // Atualiza os bancos no Formulário de Novo Lançamento

        } catch (e) { }
      }

      if (authToken) checkAuth();
      else showView('login');

      const btnToggle = document.getElementById('btnTogglePass');
      if (btnToggle) btnToggle.addEventListener('click', () => {
        const pwd = document.getElementById('password');
        const ico = btnToggle.querySelector('span');
        if (pwd.type === 'password') { pwd.type = 'text'; ico.innerText = 'visibility_off'; }
        else { pwd.type = 'password'; ico.innerText = 'visibility'; }
      });

      const valPrevEl = document.getElementById('inputValPrev');
      const valRealEl = document.getElementById('inputValReal');
      if (valPrevEl) valPrevEl.addEventListener('input', onCurrencyInput);
      if (valRealEl) valRealEl.addEventListener('input', onCurrencyInput);
    });

    function onCurrencyInput(e) {
      const el = e.target;
      const digits = String(el.value).replace(/\D/g, '');
      if (!digits) { el.value = ''; return; }
      const intPart = digits.length > 2 ? digits.slice(0, -2) : '0';
      const cents = digits.slice(-2).padStart(2, '0');
      const num = Number(intPart + '.' + cents);
      el.value = formatCurrencyNoSymbol(num);
      el.dataset.raw = num.toFixed(2);
    }

    function parseBRLToNumber(str) {
      if (str === undefined || str === null || str === '') return 0;
      if (typeof str === 'number') return str;

      let s = String(str).trim();
      if (!s) return 0;

      // Se o número NÃO tiver vírgula, significa que ele veio do banco de dados 
      // no formato americano (ex: "202.26"). Basta converter direto.
      if (!s.includes(',')) {
        const n = parseFloat(s);
        return isNaN(n) ? 0 : n;
      }

      // Se tiver vírgula, é o formato digitado pelo usuário na tela (ex: "1.202,26")
      s = s.replace(/R\$/g, '').replace(/\s/g, ''); // Remove R$ e espaços
      s = s.replace(/\./g, '').replace(/,/g, '.');   // Tira os pontos e troca vírgula por ponto
      const n = parseFloat(s);

      return isNaN(n) ? 0 : n;
    }

    function formatCurrencyNoSymbol(v) {
      try {
        return Number(v).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      } catch (e) { return v; }
    }

    // --- AUTH ---
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      toggleLoader(true);

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      try {
        const res = await apiCall('loginUser', { email: email, senha: password });
        if (res.success) {
          authToken = res.token;
          localStorage.setItem('financasToken', authToken);
          localStorage.setItem('financasTheme', JSON.stringify(res.user.app_config || res.data.app_config));
          document.getElementById('userNameDisplay').innerText = res.user.nome;

          try {
            // Verifica o Dark Mode e Tema
            const isDark = (res.user.app_config && res.user.app_config.modo_dark === 'true');
            applyDarkMode(isDark);

            const corSalva = (res.user.app_config && res.user.app_config.cor_tema) ? res.user.app_config.cor_tema : '#007AFF';
            applyThemeColor(corSalva);

            // [NOVO] Garante que puxa os bancos na hora que faz o login num dispositivo novo
            userContas = (res.user.app_config && res.user.app_config.contas) ? res.user.app_config.contas : [];
            renderBankFilterUI();
            updateTransactionFormBanks();

          } catch (e) { }

          loadData();
          showToast('Login realizado com sucesso', 'success');
        } else {
          showToast(res.message, 'error');
        }
      } catch (err) {
        showToast("Erro de comunicação com o servidor", "error");
      } finally {
        toggleLoader(false);
      }
    });

    async function checkAuth() {
      // 1. Sincroniza as configurações (Bancos, Tema, Nome) do servidor toda vez que o app abre
      try {
        const res = await apiCall('getUserSetup');
        if (res.success) {
          const config = res.data.app_config || {};

          // Atualiza a memória local para a próxima vez que a tela piscar
          localStorage.setItem('financasTheme', JSON.stringify(config));
          document.getElementById('userNameDisplay').innerText = res.data.nome || '';

          // Atualiza as variáveis do app com os dados fresquinhos do banco de dados
          userContas = config.contas || [];
          applyDarkMode(config.modo_dark === 'true');
          applyThemeColor(config.cor_tema || '#007AFF');

          // Desenha a barra de bancos e o seletor
          renderBankFilterUI();
          updateTransactionFormBanks();
        }
      } catch (e) {
        console.error("Erro ao sincronizar configurações com o servidor.");
      }

      // 2. Só então carrega os lançamentos financeiros
      loadData();
    }

    async function logout() {
      toggleSidebar();
      toggleLoader(true);

      try {
        await apiCall('logoutUser');
      } catch (e) { }

      localStorage.removeItem('financasToken');
      authToken = null;
      allData = [];

      toggleLoader(false);
      document.getElementById('loginForm').reset();
      showView('login');
      showToast('Você saiu da conta', 'success');
    }

    // --- SETTINGS ---
    async function openConfig() {
      toggleSidebar();
      toggleLoader(true);
      try {
        const res = await apiCall('getUserSetup');
        if (res.success) {
          const d = res.data;
          document.getElementById('cfgNome').value = d.nome || '';
          document.getElementById('cfgEmail').value = d.email || '';
          document.getElementById('cfgCurrentPass').value = '';
          document.getElementById('cfgNewPass').value = '';
          document.getElementById('cfgConfirmPass').value = '';

          // Carrega as configs
          const isDark = (d.app_config && d.app_config.modo_dark === 'true');
          document.getElementById('cfgDarkMode').checked = isDark;

          selectedThemeColor = (d.app_config && d.app_config.cor_tema) ? d.app_config.cor_tema : '#007AFF';
          renderColorPicker(); // Desenha as bolinhas

          ['tema', 'dados', 'seguranca', 'sobre'].forEach(k => {
            const b = document.getElementById('section-' + k);
            if (b) b.style.display = 'none';
          });
          document.getElementById('modalSettings').classList.add('active');
        } else {
          showToast(res.message || 'Erro ao carregar', 'error');
        }
      } catch (e) {
        showToast("Erro ao carregar", "error");
      } finally {
        toggleLoader(false);
      }
    }

    // Desenha as bolinhas de cor
    function renderColorPicker() {
      const container = document.getElementById('colorPickerContainer');
      container.innerHTML = systemColors.map(c => `
          <div onclick="selectSystemColor('${c.hex}')" title="${c.name}" style="
              width: 38px; height: 38px; border-radius: 50%; background-color: ${c.hex}; 
              cursor: pointer; display: flex; align-items: center; justify-content: center;
              border: 3px solid ${selectedThemeColor === c.hex ? (document.body.classList.contains('dark-mode') ? '#FFF' : '#1D1D1F') : 'transparent'};
              transition: transform 0.2s;
          ">
              ${selectedThemeColor === c.hex ? '<span class="material-icons-round" style="color:white; font-size: 20px;">check</span>' : ''}
          </div>
      `).join('');
    }

    // Quando clica na bolinha
    function selectSystemColor(hex) {
      selectedThemeColor = hex;
      applyThemeColor(hex);
      renderColorPicker();
    }

    // Aplica a cor no CSS do navegador em tempo real
    function applyThemeColor(hex) {
      document.documentElement.style.setProperty('--theme-color', hex);
    }

    function closeSettings() { document.getElementById('modalSettings').classList.remove('active'); }

    document.getElementById('btnSaveSettings').addEventListener('click', async () => {
      const nome = document.getElementById('cfgNome').value;
      const email = document.getElementById('cfgEmail').value;
      const currentPassword = document.getElementById('cfgCurrentPass').value;
      const newPassword = document.getElementById('cfgNewPass').value;
      const confirmPass = document.getElementById('cfgConfirmPass').value;
      const modo_dark = document.getElementById('cfgDarkMode').checked;

      if (newPassword && newPassword !== confirmPass) return showToast('As senhas não conferem', 'error');

      // Envia 'contas: userContas' no payload para salvar no banco
      const payload = { nome, email, currentPassword, newPassword, modo_dark, cor_tema: selectedThemeColor, contas: userContas };
      toggleLoader(true);

      try {
        const res = await apiCall('saveUserSetup', payload);
        if (res.success) {
          document.getElementById('userNameDisplay').innerText = res.data.nome || nome;
          applyDarkMode(res.data.app_config.modo_dark === 'true');
          applyThemeColor(res.data.app_config.cor_tema);

          // Atualiza a interface
          updateTransactionFormBanks();
          renderBankFilterUI();

          closeSettings();
          showToast('Configurações salvas', 'success');
        } else {
          showToast(res.message || 'Erro ao salvar', 'error');
        }
      } catch (e) {
        showToast("Erro de comunicação", "error");
      } finally {
        toggleLoader(false);
      }
    });

    function applyDarkMode(enabled) {
      if (enabled) document.body.classList.add('dark-mode');
      else document.body.classList.remove('dark-mode');
    }

    function toggleSettingsSection(key) {
      const body = document.getElementById('section-' + key);
      if (!body) return;
      const item = body.closest('.settings-item');
      const chevron = item ? item.querySelector('.settings-header .material-icons-round:last-child') : null;
      const isOpen = item && item.classList.contains('open');
      if (isOpen) {
        if (item) item.classList.remove('open');
        body.style.display = 'none';
        if (chevron) chevron.classList.remove('rotate');
      } else {
        if (item) item.classList.add('open');
        body.style.display = 'block';
        if (chevron) chevron.classList.add('rotate');
      }
    }


    // --- DATA HANDLING ---
    async function loadData() {
      toggleLoader(true);
      try {
        const res = await apiCall('getLancamentos');
        if (res.success) {
          allData = res.data;
          showView('app');
          renderDashboard();
        } else {
          showToast(res.message, "error");
        }
      } catch (error) {
        // Erro global tratado dentro do apiCall (sessão expirada etc)
      } finally {
        toggleLoader(false);
      }
    }

    function renderDashboard() {
      const y = currentDate.getFullYear();
      const m = currentDate.getMonth();
      const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

      document.getElementById('displayMonth').innerText = `${monthNames[m]} ${y}`;

      // 1. CÁLCULO DA SOBRA (SALDO ACUMULADO) DE TODOS OS MESES ANTERIORES
      let saldoAnterior = 0;
      allData.forEach(item => {
        // [NOVO] FILTRO DE BANCO: Ignora itens se o filtro não for 'ALL' ou o banco atual
        const itemInst = item.instituicao || 'OUTROS';
        if (activeBankFilter !== 'ALL' && itemInst !== activeBankFilter) return;

        // Pega o ano e mês do item
        const itemDate = new Date(item.data + 'T00:00:00');
        const itemY = itemDate.getFullYear();
        const itemM = itemDate.getMonth();

        // Se o item for mais antigo que o mês/ano que estamos olhando agora...
        if (itemY < y || (itemY === y && itemM < m)) {
          const valR = parseFloat(item.valorReal || 0);
          if (item.tipo === 'entrada') {
            saldoAnterior += valR;
          } else {
            saldoAnterior -= valR; // Saídas e investimentos diminuem a sobra
          }
        }
      });

      // 2. SEPARAR OS DADOS APENAS DO MÊS ATUAL
      const monthData = allData.filter(item => {
        // [NOVO] FILTRO DE BANCO PARA O MÊS ATUAL
        const itemInst = item.instituicao || 'OUTROS';
        if (activeBankFilter !== 'ALL' && itemInst !== activeBankFilter) return false;

        const parts = item.data.split('-');
        return parseInt(parts[0]) === y && (parseInt(parts[1]) - 1) === m;
      });

      let t = { entR: 0, entP: 0, saiR: 0, saiP: 0, invR: 0, invP: 0 };

      // Se sobrou dinheiro, nós injetamos na matemática das "Entradas" do mês atual
      if (saldoAnterior > 0) {
        t.entR += saldoAnterior;
        t.entP += saldoAnterior;
      }

      // Soma os lançamentos do mês atual
      monthData.forEach(item => {
        const valR = parseFloat(item.valorReal || 0);
        const valP = parseFloat(item.valorPrevisto || 0);
        if (item.tipo === 'entrada') { t.entR += valR; t.entP += valP; }
        else if (item.tipo === 'investimento') { t.invR += valR; t.invP += valP; }
        else { t.saiR += valR; t.saiP += valP; }
      });

      updateCard('valEntradas', 'prevEntradas', t.entR, t.entP);
      updateCard('valSaidas', 'prevSaidas', t.saiR, t.saiP);
      updateCard('valInvest', 'prevInvest', t.invR, t.invP);
      updateCard('valSaldo', 'prevSaldo', t.entR - t.saiR - t.invR, t.entP - t.saiP - t.invP);

      // 3. RENDERIZAR A LISTA
      const listData = monthData.filter(item => item.tipo === activeFilter);
      const listContainer = document.getElementById('transactionsList');
      listContainer.innerHTML = '';

      if (activeFilter === 'entrada' && saldoAnterior > 0) {
        const divSobra = document.createElement('div');
        divSobra.className = 't-item';
        divSobra.innerHTML = `
          <div class="t-ico" style="background: var(--theme-color);">
            <span class="material-icons-round">account_balance</span>
          </div>
          <div class="t-details">
            <div class="t-cat" style="color: var(--theme-color);">Automático</div>
            <div class="t-desc">Sobra dos Meses Anteriores</div>
          </div>
          <div class="t-right">
            <div class="t-amount" style="color: var(--theme-color);">+ ${formatMoney(saldoAnterior)}</div>
            <div class="t-meta">Saldo Acumulado</div>
          </div>
        `;
        listContainer.appendChild(divSobra);
      }

      // Mensagem de vazio (se não houver itens E não houver saldo anterior) - MANTIDO INTACTO
      if (listData.length === 0 && !(activeFilter === 'entrada' && saldoAnterior > 0)) {
        let msg = "Nenhum item nesta aba.";
        if (activeFilter === 'entrada') msg = "Nenhuma entrada neste mês.";
        if (activeFilter === 'fixo') msg = "Nenhum gasto fixo neste mês.";
        if (activeFilter === 'variavel') msg = "Nenhum gasto variável neste mês.";
        listContainer.innerHTML = `<div style="padding:40px; text-align:center; color:#8E8E93;">${msg}</div>`;
      }

      listData.forEach(item => {
        const valR = parseFloat(item.valorReal || 0);
        const valP = parseFloat(item.valorPrevisto || 0);

        const div = document.createElement('div');
        div.className = 't-item';
        div.onclick = () => openModalEdit(item);

        let colorClass = 'var(--ios-text)';
        let bgIcon = '#999';
        let iconName = 'help';

        if (item.tipo === 'entrada') { bgIcon = 'var(--ios-green)'; iconName = 'arrow_upward'; colorClass = 'var(--ios-green)'; }
        if (item.tipo === 'fixo') { bgIcon = 'var(--ios-orange)'; iconName = 'home'; }
        if (item.tipo === 'variavel') { bgIcon = 'var(--ios-red)'; iconName = 'shopping_cart'; }
        if (item.tipo === 'investimento') { bgIcon = 'var(--ios-purple)'; iconName = 'trending_up'; colorClass = 'var(--ios-purple)'; }

        let badgeHtml = '';
        if (valR > 0) {
          const diff = valR - valP;
          if (Math.abs(diff) > 0.01) {
            const isBad = item.tipo === 'entrada' ? (diff < 0) : (diff > 0);
            const badgeClass = isBad ? 'bg-bad' : 'bg-good';
            const signal = diff > 0 ? '+' : '';
            badgeHtml = `<span class="badge-diff ${badgeClass}">${signal}${Math.round(diff)}</span>`;
          }
        }

        const displayVal = valR > 0 ? valR : valP;
        const statusText = valR > 0 ? formatDateBr(item.data) : `<span style="color:#FF9500">Pendente</span> • ${formatDateBr(item.data)}`;

        // [NOVO] Adiciona uma TAG visual com o nome do banco se estiver na Visão Geral (ALL)
        const itemInst = item.instituicao || 'OUTROS';
        const tagBancoHtml = activeBankFilter === 'ALL' ? `<span style="background: rgba(0,0,0,0.06); padding: 2px 6px; border-radius: 4px; font-size: 0.6rem; color: var(--ios-text-sec); margin-right: 4px;">${itemInst}</span>` : '';

        div.innerHTML = `
          <div class="t-ico" style="background:${bgIcon}">
            <span class="material-icons-round">${iconName}</span>
          </div>
          <div class="t-details">
            <div class="t-cat">${tagBancoHtml}${item.categoria || item.tipo}</div>
            <div class="t-desc">${item.descricao}</div>
          </div>
          <div class="t-right">
            <div class="t-amount" style="color:${colorClass}">${item.tipo === 'entrada' ? '+' : '-'} ${formatMoney(displayVal)}</div>
            <div class="t-meta">${statusText} ${badgeHtml}</div>
          </div>
        `;
        listContainer.appendChild(div);
      });

      // Conta itens normais + a sobra (se houver)
      const count = listData.length + (activeFilter === 'entrada' && saldoAnterior > 0 ? 1 : 0);
      document.getElementById('countItems').innerText = `${count} itens`;
      renderCharts(monthData, y);

    }

    // --- INTELIGÊNCIA DOS GRÁFICOS ---
    // --- INTELIGÊNCIA DOS GRÁFICOS E SAÚDE FINANCEIRA ---
    function renderCharts(monthData, currentYear) {
      const isDark = document.body.classList.contains('dark-mode');
      const textColor = isDark ? '#EBEBF599' : '#8E8E93';
      const gridColor = isDark ? '#38383A' : '#E5E5EA';

      Chart.defaults.color = textColor;
      Chart.defaults.font.family = "'Inter', sans-serif";

      // ==========================================
      // 1. GRÁFICO DE CATEGORIAS E SAÚDE FINANCEIRA
      // ==========================================
      let totalRenda = 0;
      let totalGastoFixo = 0;
      let totalGastoVariavel = 0;

      let catMap = {};
      let totalGastoGeral = 0;

      monthData.forEach(i => {
        let v = parseFloat(i.valorReal) > 0 ? parseFloat(i.valorReal) : parseFloat(i.valorPrevisto);

        if (i.tipo === 'entrada') totalRenda += v;
        if (i.tipo === 'fixo') totalGastoFixo += v;
        if (i.tipo === 'variavel') totalGastoVariavel += v;

        if (i.tipo === 'fixo' || i.tipo === 'variavel') {
          let cat = (i.categoria && i.categoria.trim() !== '') ? i.categoria : 'Outros';
          catMap[cat] = (catMap[cat] || 0) + v;
          totalGastoGeral += v;
        }
      });

      // --- DICA DE SAÚDE FINANCEIRA (Regra 50-30-20) ---
      const boxSaude = document.getElementById('saudeFinanceiraBox');
      const msgSaude = document.getElementById('saudeFinanceiraMsg');

      if (totalRenda > 0) {
        let pctFixo = (totalGastoFixo / totalRenda) * 100;
        if (pctFixo > 60) {
          boxSaude.style.background = 'rgba(255, 59, 48, 0.1)';
          boxSaude.style.borderColor = 'var(--ios-red)';
          boxSaude.querySelector('.material-icons-round').style.color = 'var(--ios-red)';
          boxSaude.querySelector('.material-icons-round').innerText = 'warning';
          msgSaude.innerText = `Cuidado! Seus gastos fixos comprometem ${pctFixo.toFixed(0)}% da sua renda. O ideal é manter abaixo de 50%.`;
        } else if (totalGastoGeral < totalRenda) {
          boxSaude.style.background = 'rgba(52, 199, 89, 0.1)';
          boxSaude.style.borderColor = 'var(--ios-green)';
          boxSaude.querySelector('.material-icons-round').style.color = 'var(--ios-green)';
          boxSaude.querySelector('.material-icons-round').innerText = 'verified';
          msgSaude.innerText = `Parabéns! Suas finanças estão sob controle. Você gastou menos do que ganhou neste mês.`;
        } else {
          boxSaude.style.background = 'rgba(255, 149, 0, 0.1)';
          boxSaude.style.borderColor = 'var(--ios-orange)';
          boxSaude.querySelector('.material-icons-round').style.color = 'var(--ios-orange)';
          boxSaude.querySelector('.material-icons-round').innerText = 'info';
          msgSaude.innerText = `Você gastou mais do que sua renda atual neste mês. Revise os gastos variáveis!`;
        }
        boxSaude.classList.remove('hidden');
      } else {
        boxSaude.classList.add('hidden');
      }

      // Ordena as categorias por quem gastou mais
      let sortedCats = Object.keys(catMap).map(k => ({ name: k, value: catMap[k] })).sort((a, b) => b.value - a.value);

      const insightEl = document.getElementById('insightText');
      if (sortedCats.length > 0) {
        let percent = ((sortedCats[0].value / totalGastoGeral) * 100).toFixed(0);
        insightEl.innerHTML = `💡 <strong>${percent}%</strong> dos seus gastos foram com <strong>${sortedCats[0].name.toUpperCase()}</strong>.`;
      } else {
        insightEl.innerHTML = `Nenhum gasto registrado neste mês ainda.`;
      }

      const catLabels = sortedCats.map(c => c.name);
      const catData = sortedCats.map(c => c.value);
      const bgColors = ['#FF3B30', '#FF9500', '#FFCC00', '#34C759', '#5AC8FA', '#007AFF', '#5856D6', '#AF52DE', '#FF2D55', '#8E8E93'];

      // Salva globalmente para o Modal de Legendas
      currentDonutData = sortedCats.map((c, i) => ({
        name: c.name,
        value: c.value,
        color: bgColors[i % bgColors.length],
        percent: ((c.value / totalGastoGeral) * 100).toFixed(1)
      }));

      if (chartCatInstance) chartCatInstance.destroy();

      const ctxCat = document.getElementById('chartCategorias').getContext('2d');
      chartCatInstance = new Chart(ctxCat, {
        type: 'doughnut',
        data: {
          labels: catLabels.length > 0 ? catLabels : ['Sem Gastos'],
          datasets: [{
            data: catData.length > 0 ? catData : [1],
            backgroundColor: catData.length > 0 ? bgColors : [gridColor],
            borderWidth: isDark ? 2 : 3,
            borderColor: isDark ? '#1C1C1E' : '#FFFFFF',
            cutout: '70%'
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function (context) {
                  if (catData.length === 0) return ' Sem dados';
                  return ' ' + formatMoney(context.raw);
                }
              }
            }
          }
        }
      });

      // ==========================================
      // 2. GRÁFICO ANUAL (BARRAS)
      // ==========================================
      let inData = Array(12).fill(0);
      let outData = Array(12).fill(0);

      allData.forEach(item => {
        let d = new Date(item.data + 'T00:00:00');
        if (d.getFullYear() === currentYear) {
          let m = d.getMonth();
          let v = parseFloat(item.valorReal) > 0 ? parseFloat(item.valorReal) : parseFloat(item.valorPrevisto);
          if (item.tipo === 'entrada') inData[m] += v;
          if (item.tipo === 'fixo' || item.tipo === 'variavel') outData[m] += v;
        }
      });

      if (chartAnualInstance) chartAnualInstance.destroy();

      const ctxAnual = document.getElementById('chartAnual').getContext('2d');
      chartAnualInstance = new Chart(ctxAnual, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
          datasets: [
            { label: 'Receitas', data: inData, backgroundColor: '#34C759', borderRadius: 4 },
            { label: 'Despesas', data: outData, backgroundColor: '#FF3B30', borderRadius: 4 }
          ]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true } },
            tooltip: { callbacks: { label: function (context) { return ' ' + formatMoney(context.raw); } } }
          },
          scales: {
            x: { grid: { display: false } },
            y: { border: { display: false }, grid: { color: gridColor } }
          }
        }
      });
    }

    // Modal de Legendas
    function openLegendas() {
      const container = document.getElementById('legendasList');
      if (currentDonutData.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: var(--ios-text-sec); padding: 20px;">Nenhum gasto este mês.</p>';
      } else {
        container.innerHTML = currentDonutData.map(item => `
          <div style="display: flex; align-items: center; justify-content: space-between; background: var(--ios-card); padding: 12px; border-radius: 10px; border: 1px solid var(--ios-divider);">
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 16px; height: 16px; border-radius: 50%; background-color: ${item.color};"></div>
              <div style="font-weight: 600; font-size: 0.9rem; color: var(--ios-text);">${item.name}</div>
            </div>
            <div style="text-align: right;">
              <div style="font-weight: 700; font-size: 0.95rem;">${formatMoney(item.value)}</div>
              <div style="font-size: 0.75rem; color: var(--ios-text-sec);">${item.percent}% do total</div>
            </div>
          </div>
        `).join('');
      }
      document.getElementById('modalLegendas').classList.add('active');
    }

    function closeLegendas() {
      document.getElementById('modalLegendas').classList.remove('active');
    }

    // --- FUNÇÕES DE CONTROLE DE BANCOS ---
    function renderBankFilterUI() {
      const container = document.getElementById('bankFilterContainer');
      if (!container) return;
      let html = `<button class="bank-chip ${activeBankFilter === 'ALL' ? 'active' : ''}" onclick="setBankFilter('ALL')">Visão Geral</button>`;

      userContas.forEach(b => {
        html += `<button class="bank-chip ${activeBankFilter === b ? 'active' : ''}" onclick="setBankFilter('${b}')">${b}</button>`;
      });
      html += `<button class="bank-chip ${activeBankFilter === 'OUTROS' ? 'active' : ''}" onclick="setBankFilter('OUTROS')">OUTROS</button>`;
      container.innerHTML = html;
    }

    function setBankFilter(bank) {
      activeBankFilter = bank;
      renderBankFilterUI();
      renderDashboard();
    }

    function updateTransactionFormBanks() {
      const sel = document.getElementById('inputInstituicao');
      if (!sel) return;
      sel.innerHTML = '<option value="OUTROS" selected>OUTROS</option>';
      userContas.forEach(b => {
        const opt = document.createElement('option');
        opt.value = b;
        opt.innerText = b;
        sel.appendChild(opt);
      });
    }

    function filterBankSearch() {
      const q = document.getElementById('cfgSearchBank').value.toLowerCase();
      const res = document.getElementById('bankSearchResults');
      if (!q) { res.style.display = 'none'; return; }

      const matches = INSTITUICOES_PDF.filter(b => b.toLowerCase().includes(q));
      if (matches.length === 0) {
        res.innerHTML = '<div style="padding:12px; color:var(--ios-text-sec); font-size:0.85rem;">Nenhum encontrado</div>';
      } else {
        res.innerHTML = matches.map(b => `<div onclick="addBankToUser('${b}')" style="padding:12px; border-bottom:1px solid var(--ios-divider); cursor:pointer; font-size:0.85rem; color:var(--ios-text); font-weight:600;">${b}</div>`).join('');
      }
      res.style.display = 'block';
    }

    function addBankToUser(bank) {
      if (!userContas.includes(bank)) {
        userContas.push(bank);
        renderUserBanks();
      }
      document.getElementById('cfgSearchBank').value = '';
      document.getElementById('bankSearchResults').style.display = 'none';
    }

    function removeBankFromUser(bank) {
      userContas = userContas.filter(b => b !== bank);
      renderUserBanks();
    }

    function renderUserBanks() {
      const container = document.getElementById('cfgMyBanks');
      if (!container) return;
      container.innerHTML = userContas.map(b => `
          <div style="background:var(--theme-color); color:white; padding:6px 12px; border-radius:16px; font-size:0.75rem; display:flex; align-items:center; gap:6px; font-weight:600;">
              ${b} <span class="material-icons-round" style="font-size:16px; cursor:pointer;" onclick="removeBankFromUser('${b}')">close</span>
          </div>
      `).join('');
    }

    // --- CONTROLES DE UI ---
    function toggleSummary() {
      const el = document.getElementById('summaryCurtain');
      const btn = document.getElementById('btnToggleSummary');
      const icon = btn.querySelector('span');
      el.classList.toggle('open');
      if (el.classList.contains('open')) { icon.innerText = 'keyboard_arrow_up'; }
      else { icon.innerText = 'dashboard'; }
    }

    function setFilter(type, btnElement) {
      activeFilter = type;
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btnElement.classList.add('active');
      renderDashboard();
    }

    function updateCard(idVal, idPrev, val, prev) {
      document.getElementById(idVal).innerText = formatMoney(val);
      document.getElementById(idPrev).innerText = `Prev: ${formatMoney(prev)}`;
    }

    function updateCategoryOptions(type, selectedValue = null) {
      const select = document.getElementById('inputCat');
      select.innerHTML = '<option value="" disabled selected>Selecione a Categoria</option>';
      const options = CATEGORIAS[type] || [];
      options.forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat;
        opt.innerText = String(cat).toUpperCase();
        if (selectedValue && cat === selectedValue) { opt.selected = true; }
        select.appendChild(opt);
      });
    }

    // --- FORMULARIO ---
    function toggleManageBtn() {
      const n = parseInt(document.getElementById('inputInstallments').value);
      const btn = document.getElementById('btnManageInst');
      if (n > 1) btn.classList.remove('hidden'); else btn.classList.add('hidden');
      checkRealValueLock();
    }

    function openInstallmentManager() {
      const n = parseInt(document.getElementById('inputInstallments').value);
      if (n < 2) return;
      const totalVal = parseBRLToNumber(document.getElementById('inputValPrev').value) || 0;
      const baseDateStr = document.getElementById('inputDate').value;
      const baseDesc = document.getElementById('inputDesc').value;

      if (!totalVal || !baseDateStr) return showToast("Preencha valor e data primeiro", "error");

      if (pendingInstallments.length === 0 || pendingInstallments.length !== n) {
        pendingInstallments = [];
        const baseVal = totalVal / n;
        const [y, m, d] = baseDateStr.split('-').map(Number);

        for (let i = 0; i < n; i++) {
          let newDate = new Date(y, (m - 1) + i, d);
          const isoDate = newDate.toISOString().split('T')[0];
          pendingInstallments.push({
            id_temp: i,
            descricao: `${baseDesc} (${i + 1}/${n})`,
            valor: baseVal.toFixed(2),
            data: isoDate
          });
        }
      }
      renderInstallmentList();
      document.getElementById('modalInstallments').classList.add('active');
    }

    function renderInstallmentList() {
      const container = document.getElementById('installmentsContainer');
      container.innerHTML = '';
      pendingInstallments.forEach((inst, index) => {
        const row = document.createElement('div');
        row.style.cssText = "background: var(--ios-card); padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.04); display: grid; gap: 8px;";
        row.innerHTML = `
          <div style="font-weight:600; font-size: 0.9rem; color: var(--ios-blue);">Parcela ${index + 1}</div>
          <input type="text" class="input-ios" value="${inst.descricao}" onchange="updateInstData(${index}, 'descricao', this.value)" placeholder="Descrição">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <input type="date" class="input-ios" value="${inst.data}" onchange="updateInstData(${index}, 'data', this.value)">
            <input type="text" class="input-ios inst-valor" value="${(inst.valor ? (Number(inst.valor)).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '')}" onchange="updateInstData(${index}, 'valor', this.value)" oninput="maskInstCurrency(this)">
          </div>
        `;
        container.appendChild(row);
      });
    }

    function updateInstData(index, field, value) {
      if (field === 'valor') {
        const n = parseBRLToNumber(value || pendingInstallments[index].valor || '0');
        pendingInstallments[index][field] = n.toFixed(2);
      } else {
        pendingInstallments[index][field] = value;
      }
    }

    function maskInstCurrency(el) {
      const v = el.value || '';
      const digits = String(v).replace(/\D/g, '');
      if (!digits) { el.value = ''; return; }
      const intPart = digits.length > 2 ? digits.slice(0, -2) : '0';
      const cents = digits.slice(-2).padStart(2, '0');
      const num = Number(intPart + '.' + cents);
      el.value = formatCurrencyNoSymbol(num);
    }

    function closeInstallmentManager() { document.getElementById('modalInstallments').classList.remove('active'); }
    function toggleRecurring() { checkRealValueLock(); }

    function checkRealValueLock() {
      const type = document.getElementById('inputType').value;
      const n = parseInt(document.getElementById('inputInstallments').value);
      const isRecurrent = document.getElementById('inputRecurring').checked;
      const inputReal = document.getElementById('inputValReal');

      const shouldBlock = (type === 'variavel' && n > 1) || (type !== 'variavel' && isRecurrent);

      if (shouldBlock) {
        inputReal.value = "";
        inputReal.disabled = true;
        inputReal.style.backgroundColor = "#E5E5EA";
        inputReal.placeholder = "---";
      } else {
        inputReal.disabled = false;
        inputReal.style.backgroundColor = "var(--ios-card)";
        inputReal.placeholder = "0,00";
      }
    }

    function setType(type, element) {
      document.getElementById('inputType').value = type;
      document.querySelectorAll('.type-opt').forEach(el => el.classList.remove('selected'));
      element.classList.add('selected');
      updateCategoryOptions(type);

      document.getElementById('inputInstallments').value = "1";
      document.getElementById('inputRecurring').checked = false;

      const divInst = document.getElementById('divInstallments');
      const divRec = document.getElementById('divRecurring');

      if (type === 'variavel') {
        divInst.classList.remove('hidden'); divInst.style.display = 'grid';
        divRec.classList.add('hidden');
      } else {
        divInst.classList.add('hidden'); divInst.style.display = 'none';
        divRec.classList.remove('hidden');
      }
      checkRealValueLock();
      toggleManageBtn();
    }

    function openModalNew() {
      document.getElementById('modalTitle').innerText = "Novo";
      document.getElementById('addForm').reset();
      document.getElementById('editId').value = "";

      document.querySelector('.type-grid').style.display = 'grid';
      document.getElementById('inputCat').disabled = false;
      document.getElementById('inputDesc').disabled = false;
      document.getElementById('inputValPrev').disabled = false;
      document.getElementById('btnDelete').classList.add('hidden');

      document.getElementById('inputInstallments').value = "1";
      document.getElementById('inputRecurring').checked = false;
      pendingInstallments = [];

      const opts = document.querySelectorAll('.type-opt');
      setType('entrada', opts[0]);

      document.getElementById('inputPaidDate').value = '';
      document.getElementById('inputPaidDate').disabled = false;
      const dateEl = document.getElementById('inputDate');
      dateEl.disabled = false;
      dateEl.style.backgroundColor = "var(--ios-card)";

      const today = new Date();
      let defaultDate = new Date(currentDate.getTime());
      if (defaultDate.getMonth() === today.getMonth() && defaultDate.getFullYear() === today.getFullYear()) {
        defaultDate = today;
      } else { defaultDate.setDate(1); }
      document.getElementById('inputDate').valueAsDate = defaultDate;

      modal.overlay.classList.add('active');
    }

    function openModalEdit(item) {
      document.getElementById('modalTitle').innerText = "Editar";
      document.getElementById('editId').value = item.id;
      document.getElementById('inputType').value = item.tipo;

      updateCategoryOptions(item.tipo, item.categoria);
      try { document.getElementById('inputCat').value = item.categoria || ''; } catch (e) { }

      document.getElementById('inputDesc').value = item.descricao;
      document.getElementById('inputValPrev').value = item.valorPrevisto ? formatCurrencyNoSymbol(parseBRLToNumber(item.valorPrevisto)) : '';
      document.getElementById('inputValPrev').dataset.raw = item.valorPrevisto || '';
      document.getElementById('inputValReal').value = item.valorReal ? formatCurrencyNoSymbol(parseBRLToNumber(item.valorReal)) : '';
      document.getElementById('inputValReal').dataset.raw = item.valorReal || '';
      document.getElementById('inputDate').value = item.data;
      document.getElementById('inputPaidDate').value = item.dataPago || '';

      // [NOVO] Define a instituição cadastrada ou 'OUTROS'
      document.getElementById('inputInstituicao').value = item.instituicao || 'OUTROS';

      document.querySelector('.type-grid').style.display = 'none';
      document.getElementById('divInstallments').classList.add('hidden');
      document.getElementById('divInstallments').style.display = 'none';
      document.getElementById('divRecurring').classList.add('hidden');

      document.getElementById('inputCat').disabled = true;
      document.getElementById('inputDesc').disabled = true;
      document.getElementById('inputValPrev').disabled = true;
      document.getElementById('inputDate').disabled = true;

      const inputReal = document.getElementById('inputValReal');
      inputReal.disabled = false;
      inputReal.style.backgroundColor = "#F2F2F7";
      inputReal.placeholder = "0,00";

      document.getElementById('btnDelete').classList.remove('hidden');
      modal.overlay.classList.add('active');
    }

    function closeModal() { modal.overlay.classList.remove('active'); }

    document.getElementById('addForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const type = document.getElementById('inputType').value;
      const cat = document.getElementById('inputCat').value;
      const desc = document.getElementById('inputDesc').value;
      const valPrev = document.getElementById('inputValPrev').value;
      const dateInput = document.getElementById('inputDate').value;
      const numInstallments = parseInt(document.getElementById('inputInstallments').value);
      const isRecurring = document.getElementById('inputRecurring').checked;
      const isVariable = (type === 'variavel');
      const groupId = Date.now().toString(36) + Math.random().toString(36).substr(2);

      // [NOVO] Captura a instituição selecionada
      const instituicaoVal = document.getElementById('inputInstituicao').value;

      let payload = null;

      if (isVariable && numInstallments > 1 && !document.getElementById('editId').value) {
        if (pendingInstallments.length === 0) {
          openInstallmentManager();
          closeInstallmentManager();
        }
        const paidDateVal = document.getElementById('inputPaidDate').value;
        payload = pendingInstallments.map(inst => {
          return {
            id: null, tipo: type, categoria: cat, descricao: inst.descricao.toUpperCase(),
            valorPrevisto: Number(inst.valor).toFixed(2), valorReal: "", data: inst.data,
            dataPago: paidDateVal || undefined, groupId: groupId, recurrenceType: 'parcelado',
            instituicao: instituicaoVal // [NOVO]
          };
        });
      } else if (!isVariable && isRecurring && !document.getElementById('editId').value) {
        const [y, m, d] = dateInput.split('-').map(Number);
        const recurrenceList = [];
        for (let i = 0; i < 12; i++) {
          let newDate = new Date(y, (m - 1) + i, d);
          const isoDate = newDate.toISOString().split('T')[0];
          recurrenceList.push({
            id: null, tipo: type, categoria: cat, descricao: desc,
            valorPrevisto: parseBRLToNumber(valPrev).toFixed(2), valorReal: "", data: isoDate,
            dataPago: document.getElementById('inputPaidDate').value || undefined, groupId: groupId, recurrenceType: 'recorrente',
            instituicao: instituicaoVal // [NOVO]
          });
        }
        payload = recurrenceList;
      } else {
        if (dateInput) {
          const [yInput, mInput, dInput] = dateInput.split('-').map(Number);
          const viewMonth = currentDate.getMonth() + 1;
          const viewYear = currentDate.getFullYear();
          if (mInput !== viewMonth || yInput !== viewYear) {
            return showToast(`A data deve ser dentro de ${viewMonth}/${viewYear}`, "error");
          }
        }

        const editIdValue = document.getElementById('editId').value;
        let existingGroupId = null, existingRecType = null, finalCategoria = cat;

        if (editIdValue) {
          const originalItem = allData.find(i => i.id === editIdValue);
          if (originalItem) {
            existingGroupId = originalItem.groupId;
            existingRecType = originalItem.recurrenceType;
            if (!finalCategoria || finalCategoria === '') finalCategoria = originalItem.categoria;
          }
        }

        payload = {
          id: editIdValue || null, tipo: type, categoria: finalCategoria, descricao: desc,
          valorPrevisto: parseBRLToNumber(valPrev).toFixed(2),
          valorReal: parseBRLToNumber(document.getElementById('inputValReal').value).toFixed(2),
          data: dateInput, dataPago: document.getElementById('inputPaidDate').value || undefined,
          groupId: existingGroupId, recurrenceType: existingRecType,
          instituicao: instituicaoVal // [NOVO]
        };
      }

      toggleLoader(true);

      try {
        const res = await apiCall('salvarLancamento', { dados: payload });
        if (res.success) {
          closeModal();
          loadData();
          showToast("Salvo com sucesso!", "success");
          pendingInstallments = [];
        } else {
          showToast(res.message || "Erro ao salvar", "error");
        }
      } catch (err) {
        showToast("Erro de conexão", "error");
      } finally {
        toggleLoader(false);
      }
    });

    function openRecorrencias() {
      toggleSidebar();
      renderRecorrenciasList();
      document.getElementById('modalRecorrencias').classList.add('active');
    }

    function closeRecorrencias() { document.getElementById('modalRecorrencias').classList.remove('active'); }

    function renderRecorrenciasList() {
      const container = document.getElementById('recorrenciasList');
      container.innerHTML = '';
      currentGroups = {};

      const recurringItems = allData.filter(item => item.groupId);
      if (recurringItems.length === 0) {
        container.innerHTML = `<div style="padding:40px; text-align:center; color:#8E8E93;">Nenhum registro encontrado.</div>`;
        return;
      }

      recurringItems.forEach(item => {
        if (!currentGroups[item.groupId]) {
          let descLimpa = item.descricao.replace(/\s\(\d+\/\d+\)$/, '');
          currentGroups[item.groupId] = {
            id: item.groupId, descricao: descLimpa,
            tipo: item.recurrenceType || (item.tipo === 'variavel' ? 'parcelado' : 'recorrente'),
            categoria: item.categoria, baseTipo: item.tipo, items: [], totalPago: 0, totalPrevisto: 0
          };
        }
        currentGroups[item.groupId].items.push(item);
        currentGroups[item.groupId].totalPrevisto += parseFloat(item.valorPrevisto || 0);
        currentGroups[item.groupId].totalPago += parseFloat(item.valorReal || 0);
      });

      Object.values(currentGroups).forEach(group => {
        group.items.sort((a, b) => new Date(a.data) - new Date(b.data));
        const div = document.createElement('div');
        div.className = 't-item';
        div.style.cursor = 'pointer';
        div.onclick = () => openRecorrenciasDetalhe(group.id);

        const isEntrada = group.baseTipo === 'entrada';
        const sign = isEntrada ? '+' : '-';
        const colorClass = isEntrada ? 'var(--ios-green)' : 'var(--ios-red)';
        let bgIcon = isEntrada ? 'var(--ios-green)' : (group.tipo === 'parcelado' ? 'var(--ios-red)' : 'var(--ios-orange)');
        let iconName = group.tipo === 'parcelado' ? 'credit_card' : 'autorenew';

        const pagas = group.items.filter(i => parseFloat(i.valorReal || 0) > 0).length;
        const total = group.items.length;
        const badgeText = isEntrada ? 'RECEITA' : 'DESPESA';
        const badgeBg = isEntrada ? 'rgba(52, 199, 89, 0.15)' : 'rgba(255, 59, 48, 0.15)';

        div.innerHTML = `
          <div class="t-ico" style="background:${bgIcon}">
            <span class="material-icons-round">${iconName}</span>
          </div>
          <div class="t-details">
            <div class="t-cat">
              <span style="background:${badgeBg}; color:${colorClass}; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; margin-right: 4px; font-weight: 700;">${badgeText}</span>
              ${group.tipo.toUpperCase()} • ${group.categoria}
            </div>
            <div class="t-desc">${group.descricao}</div>
          </div>
          <div class="t-right">
            <div class="t-amount" style="color:var(--ios-text); font-size:0.9rem;">${pagas}/${total} pagas</div>
            <div class="t-meta" style="color:${colorClass}; font-weight:600;">${sign} ${formatMoney(group.totalPrevisto)}</div>
          </div>
        `;
        container.appendChild(div);
      });
    }

    function openRecorrenciasDetalhe(groupId) {
      const group = currentGroups[groupId];
      if (!group) return;

      document.getElementById('detalheRecorrenciaTitle').innerText = group.descricao;
      const container = document.getElementById('recorrenciasDetalheList');
      container.innerHTML = '';

      const isEntrada = group.baseTipo === 'entrada';
      const sign = isEntrada ? '+' : '-';
      const colorClass = isEntrada ? 'var(--ios-green)' : 'var(--ios-red)';

      // 1. Renderiza as parcelas
      group.items.forEach((item, index) => {
        const valR = parseFloat(item.valorReal || 0);
        const valP = parseFloat(item.valorPrevisto || 0);
        const isPago = valR > 0;

        const displayVal = isPago ? valR : valP;
        const statusText = isPago ? `<span style="color:var(--ios-green)">Pago</span>` : `<span style="color:var(--ios-orange)">Pendente</span>`;

        const div = document.createElement('div');
        div.className = 't-item';
        // Deixa a parcela com visual clicável
        div.style.cursor = 'pointer';
        div.style.padding = '12px 8px';
        div.style.borderRadius = '8px';
        div.onmouseover = () => div.style.backgroundColor = 'var(--ios-bg)';
        div.onmouseout = () => div.style.backgroundColor = 'transparent';

        // Evento de clique: Fecha os modais de lista e abre a edição daquela parcela
        div.onclick = () => {
          closeRecorrenciasDetalhe();
          closeRecorrencias();
          openModalEdit(item);
        };

        div.innerHTML = `
          <div class="t-details">
            <div class="t-desc" style="font-size: 0.9rem;">Parcela ${index + 1}</div>
            <div class="t-meta">${formatDateBr(item.data)}</div>
          </div>
          <div class="t-right">
            <div class="t-amount" style="font-size: 0.95rem; color:${colorClass};">${sign} ${formatMoney(displayVal)}</div>
            <div class="t-meta">${statusText}</div>
          </div>
        `;
        container.appendChild(div);
      });

      // 2. Adiciona o botão de Cancelar Pendentes (Se houver parcelas pendentes)
      const pendingCount = group.items.filter(i => parseFloat(i.valorReal || 0) === 0).length;

      if (pendingCount > 0) {
        const btnDiv = document.createElement('div');
        btnDiv.style.marginTop = '24px';
        btnDiv.style.paddingBottom = '30px';
        btnDiv.innerHTML = `
              <button class="btn btn-danger w-full" onclick="askDeleteGroup('${groupId}')" style="background: rgba(255, 59, 48, 0.15);">
                  <span class="material-icons-round">delete_sweep</span> Cancelar ${pendingCount} Pendentes
              </button>
              <div style="font-size: 0.75rem; color: var(--ios-text-sec); text-align: center; margin-top: 8px;">
                  As parcelas já pagas serão mantidas no histórico financeiro.
              </div>
          `;
        container.appendChild(btnDiv);
      }

      document.getElementById('modalRecorrenciasDetalhe').classList.add('active');
    }


    function closeRecorrenciasDetalhe() { document.getElementById('modalRecorrenciasDetalhe').classList.remove('active'); }

    // --- CUSTOM ALERTS & TOASTS ---
    function askDelete() {
      document.getElementById('customAlert').classList.remove('hidden');
      document.getElementById('alertTitle').innerText = "Atenção";
      document.getElementById('alertMsg').innerText = "Deseja realmente excluir?";
      document.getElementById('alertConfirmBtn').onclick = function () { confirmDelete(); }
    }

    function askDeleteGroup(groupId) {
      document.getElementById('customAlert').classList.remove('hidden');
      document.getElementById('alertTitle').innerText = "Cancelar Assinatura";
      document.getElementById('alertMsg').innerText = "Deseja cancelar todas as parcelas futuras? As já pagas serão mantidas intactas.";
      document.getElementById('alertConfirmBtn').onclick = function () { confirmDeleteGroup(groupId); }
    }

    function closeCustomAlert() { document.getElementById('customAlert').classList.add('hidden'); }

    async function confirmDelete() {
      closeCustomAlert();
      const id = document.getElementById('editId').value;
      if (!id) return;

      toggleLoader(true);
      try {
        const res = await apiCall('excluirLancamento', { id: id });
        if (res.success) {
          closeModal();
          loadData();
          showToast("Item excluído.", "success");
        } else {
          showToast(res.message, "error");
        }
      } catch (err) {
        showToast("Erro ao excluir", "error");
      } finally {
        toggleLoader(false);
      }
    }

    async function confirmDeleteGroup(groupId) {
      closeCustomAlert();
      toggleLoader(true);
      try {
        const res = await apiCall('excluirGrupoPendente', { groupId: groupId });
        if (res.success) {
          closeRecorrenciasDetalhe();
          await loadData(); // Recarrega os dados do banco
          openRecorrencias(); // Reabre a lista atualizada
          showToast("Parcelas futuras canceladas.", "success");
        } else {
          showToast(res.message, "error");
        }
      } catch (err) {
        showToast("Erro ao cancelar grupo", "error");
      } finally {
        toggleLoader(false);
      }
    }

    function showToast(msg, type) {
      const t = document.getElementById('toast');
      const ico = document.getElementById('toastIcon');
      document.getElementById('toastMsg').innerText = msg;

      t.className = 'toast';
      t.classList.add(type);
      ico.innerText = type === 'success' ? 'check_circle' : 'error';

      requestAnimationFrame(() => {
        t.classList.add('show');
        setTimeout(() => { t.classList.remove('show'); }, 3000);
      });
    }

    // --- VIEW UTILS ---
    function changeMonth(delta) { currentDate.setMonth(currentDate.getMonth() + delta); renderDashboard(); }
    function toggleSidebar() { document.querySelector('.sidebar').classList.toggle('active'); document.querySelector('.sidebar-overlay').classList.toggle('active'); }
    function showView(name) {
      views.login.classList.add('hidden'); views.app.classList.add('hidden');
      if (name === 'login') views.login.classList.remove('hidden');
      if (name === 'app') views.app.classList.remove('hidden');
    }

    function toggleLoader(show) { show ? loader.classList.remove('hidden') : loader.classList.add('hidden'); }

    // MODO PRIVACIDADE (OCULTAR SALDOS)
    // SEMPRE inicia como TRUE (Oculto) toda vez que abrir ou recarregar o app.
    let privacyMode = true;

    // Assim que a tela carregar, já garante que o ícone do botão seja o olhinho riscado
    document.addEventListener('DOMContentLoaded', () => {
      const btnP = document.getElementById('btnPrivacy');
      if (btnP) btnP.innerHTML = '<span class="material-icons-round">visibility_off</span>';
    });

    // A função de formatar dinheiro agora obedece cegamente a variável
    function formatMoney(v) {
      if (privacyMode) {
        return 'R$ •••••'; // Esconde os valores
      }
      return v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    // Função que é chamada quando clica no botão do olho
    function togglePrivacyMode() {
      privacyMode = !privacyMode; // Inverte (se tava oculto, mostra. Se tava mostrando, oculta)

      const btn = document.getElementById('btnPrivacy');
      if (privacyMode) {
        btn.innerHTML = '<span class="material-icons-round">visibility_off</span>';
      } else {
        btn.innerHTML = '<span class="material-icons-round">visibility</span>';
      }

      // Manda o app redesenhar os números instantaneamente na tela
      renderDashboard();

      if (document.getElementById('modalRecorrencias').classList.contains('active')) {
        renderRecorrenciasList();
      }
    }

    function formatDateBr(iso) { const p = iso.split('-'); return `${p[2]}/${p[1]}`; }

  </script>
</body>

</html>
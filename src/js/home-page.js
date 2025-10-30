(function () {
  var modal = document.getElementById('welcome-modal');
  var backdrop = document.getElementById('welcome-modal-backdrop');
  if (!modal || !backdrop) return;

  function showModal() {
    modal.classList.remove('opacity-0', 'pointer-events-none');
    requestAnimationFrame(function () {
      backdrop.classList.remove('opacity-0');
      backdrop.classList.add('opacity-100');
      var dialog = modal.querySelector('[role="dialog"]');
      if (dialog) {
        dialog.classList.remove('scale-95', 'opacity-0');
        dialog.classList.add('scale-100', 'opacity-100');
        dialog.focus();
      }
    });
  }

  function hideModal() {
    backdrop.classList.remove('opacity-100');
    backdrop.classList.add('opacity-0');
    var dialog = modal.querySelector('[role="dialog"]');
    if (dialog) {
      dialog.classList.remove('scale-100', 'opacity-100');
      dialog.classList.add('scale-95', 'opacity-0');
    }
    setTimeout(function () { modal.classList.add('opacity-0', 'pointer-events-none'); }, 200);
  }

  showModal();
  try { sessionStorage.setItem('welcomeShown', '1'); } catch (e) {}

  backdrop.addEventListener('click', hideModal);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') hideModal(); });
})();
